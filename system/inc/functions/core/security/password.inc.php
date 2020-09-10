<?php
/**
 *  @file       system/functions/core/security/password.inc.php
 *  
 *  @brief      Set di funzioni la gestione delle password
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    
    /**
     *  @namespace  security::password
     *  @brief      <b>Risorse per le password</b>
     */   
    namespace security\password {
        
        /**
         *  @brief Genera l'hash di una password
         *  
         *  @param [in] $string <b>(string)</b> la password di ci eseguire l'hash
         *  @param [in] $algo <b>(int)</b> l'algoritmo di crittografia
         *  @param [in] $options <b>(string)</b> le opzioni per l'algoritmo di crittografia
         *  
         *  @return <b>(string)</b> l'hash della password
         *  
         *  @details La funzione crittografa in modalità unidirezionale una stringa e poi la converte in base 64
         */     
        function hash($string,$algo=null,$options=null)
        {
            
            //recupero dei valori delle opzioni per la crittografia
            $encritp = $GLOBALS['PARAMETERS']['encritp'];
            
            //imposta l'algoritmo di crittografia
            $algo = isset($algo) ? $algo : $encritp['algorithm'];
            $options = isset($options) ? $options : $encritp['options'];
            
            
            //crea l'hash
            if($options === null) {
                
                $hash = password_hash ($string,$algo);              
            
            } else {
            
                $hash = password_hash ($string,$algo,$options);
                
            }
                
            $hash = base64_encode($hash);
            
            //rrestituisce l'hash crittografato
            return $hash;
        
        }       
        
        /**
         *  @brief Verifica la correttezza di una password 
         *  
         *  @param [in] $pass <b>(string)</b> La password da convertire
         *  @param [in] $stored <b>(string)</b> L'hash da controllare
         *  
         *  @return <b>(bool)</b> true se la pass è corretta, false se non lo 6
         *  
         *  @details La funzione verifica la corrispondenze fra la stringa salvata e la pass inviata
         */     
        function verify($pass, $stored) {
            
            $stored = base64_decode($stored);
            
            return password_verify ($pass,$stored);
            
        }
        
        /**
         *  @brief Controllo della forza di una pass
         *  
         *  @param [in] $str <b>(string)</b> La password da verificare
         *  @return <b>(type)</b> Return description
         *  
         *  @details La funzione controlla che la stringa contenga almeno 8 caratteri di cui almeno:<br 7>
         *  1 lettera maiuscola, una minuscola, un numero, un carattere speciale, e che sia di almeno 8 caratteri
         */     
        function strenght($str)
        {
            
            //trasforma la stringa in un array di lettere
            $arr1 = str_split($str);
            
            //inizializza le variabili di controllo
            $pass['maiuscole'] = 0;
            $pass['minuscole'] = 0;
            $pass['numeri'] = 0;
            $pass['caratteri'] = 0;
            $pass['text'] = '';
            
            //CICLA L'ARRAY DELLE LETTERE DELLA STRINGA
            foreach($arr1 as $v) {
                
                //SE IL TIPO DI CARATTERE È UN SIMBOLO
                if(ctype_punct($v)) {
                    
                    //aumenta il contatore dei simboli
                    ++$pass['caratteri'];
                    
                }
                
                //SE IL TIPO DI CARATTERE È UNA LETTERA MINUSCOLA       
                if(ctype_lower($v)) {
                    
                    //aumenta il contatore delle minuscole                  
                    ++$pass['minuscole'];
                    
                }
                
                //SE IL TIPO DI CARATTERE È UNA LETTERA MAIUSCOLA               
                if(ctype_upper ($v)) {
                    
                    //aumenta il contatore delle maiuscole                  
                    ++$pass['maiuscole'];
                    
                }
                
                //SE IL TIPO DI CARATTERE È UN NUMERO                   
                if(ctype_digit ($v)) {
                    
                    //aumenta il contatore dei numeri                   
                    ++$pass['numeri'];
                    
                }
                
                //ripristina la stringa
                $pass['text'] .= $v;
            
            }
            
            //determina la lunghezza della stringa
            $pass['lunghezza'] = mb_strlen($str);
            
            //SE LA STRINGA PRESENTA TUTTI I PARAMETRI RICHIESTI
            if($pass['lunghezza'] <= 8 
                && $pass['caratteri'] >= 1 
                && $pass['minuscole'] >= 1 
                && $pass['maiuscole'] >= 1 
                && $pass['numeri'] >= 1) {

                //viene segnata come valida
                $standard_pass = true;
                
            //SE LA STRINGA NON PRESENTA TUTTI I PARAMETRI RICHIESTI            
            } else { 
                
                //viene segnata come non valida
                $standard_pass = false;
                
            }
            
            //restituisce i dati
            return $standard_pass;
        
        }
        
        /**
         *  @brief Crea una stringa casuale
         *  
         *  @param [in] $lenght <b>(int)</b> la lunghezza della stringa
         *  @param [in] $type <b>(array)</b> l'array contenente i tipi di caratteri da usare per la stringa
         *  
         *  @return <b>(str)</b> la stringa generata
         */     
        function randomString($lenght,$type=array(0,1,2,3))
        {
            
            //definisce la variabile per evitare notice.
            $str = '';
            
            //imposta i vari gruppi di caratteri da cui attingere per la stringa casuale
            $pass[0] = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';
            $pass[2] = 'abcdefghijklmnopqrstuvwxyz';
            $pass[1] = '0123456789';
            $pass[3] = '@#*%!_-';
            
            //CICLA GLI ELEMENTI DELL'ARRAY CON GRUPPI DEI CARATTERI
            for( $i = 0; $i <= 3; $i++) {
                
                //SE IL GRUPPO NON È TRA QUELLI SELEZIONATI
                if(in_array($i,$type) === false) {
                    
                    //elimina il gruppo dall'array
                    unset($pass[$i]);
            
                }
            
            }

            //reindicizza le chiavi dell'array
            $pass = array_values($pass);

            //GENERA UN CICLO IN BASE AL NUMERO DI CARATTERI RICHIESTO PER LA STRINGA
            for( $i = 1; $i <= $lenght; $i++) {
                
                //Sceglie casualmente il gruppo di caratteri da cui attingere
                $temp = mt_rand(0,count($pass) -1);
                //calcola il massimale del generatore casuale in base agli elementi del gruppo
                $temp2 = mb_strlen($pass[$temp]) - 1;
                //seleziona un carattere casuale dal gruppo
                $temp3 = mt_rand(0,$temp2);
                $tempX = str_split($pass[$temp]);
                //accoda alla stringa il carattere selezionato

                $str .= $tempX{$temp3};
                
                //aggiorna l'array contenente la composizione della stringa
                $temp4[$temp] = @$temp4[$temp] + 1;
                
            }
            
            $gen['pass'] = $str;
            
            //restituisce l'array creato
            return $gen['pass'];
        
        }

        /**
         *  @brief Genera una password con determinati requisiti standard
         *  
         *  @param [in] $lenght <b>(int)</b> la lunghezza della stringa
         *  @param [in] $type <b>(array)</b> l'array contenente i tipi di caratteri da usare per la stringa
         *  
         *  @return <b>(str)</b> la stringa generata
         */             
        function generate($lenght=8,$type=array(0,1,2,3)){
            
            $check_pass = false;
            while($check_pass === false) {
                
                $pass = \security\password\randomString($lenght,$type);
                $check_pass= \security\password\strenght($pass);
                
                
            }
            
            return $pass['pass'];
            
        }
        
    }