<?php
/**
 *  @file       system/inc/functions/core/security/crypt.inc.php
 *  
 *  @brief      Set di funzioni per il monitoragigo e sicurezza della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    
    /**
     *  @namespace  defcon
     *  @brief      <b>Risorse per crittografia dei dati della land</b>
     */   
    namespace security\crypt {
        
        /**
         *  @brief Anonimizza un dato
         *  
         *  @param [in] $data <b>(string)</b> il dato da anonimizzare
         *  @param [in] $mode <b>(string)</b> il modo con cui anonimizzarlo
         *  
         *  @return <b>(string)</b> il dato anonimizzato
         *  
         *  @details La funzione prende ed anonimizza il dato passato alla funzione stessa in base al tipo di nonimizzaizone 
         *  scelta:
         *  - <b>none</b>: nessuna anonimizzazione;
         *  - <b>crypt</b>: crittografia bidirezionale;
         *  - <b>hash</b>: crittografia unidirezionale;
         *  - <b>ip_last</b>: maschera l'ultimo gruppo di cifre o dati per l'ip;
         */     
        function anonimize($data,$mode='hash')
        {
            
            //recupera il set di opzioni di configurazione per la crittografia
            $PARAMETERS['encritp'] = $GLOBALS['PARAMETERS']['encritp'];
            
            //SELEZIONA IL SET DI OPERAIZONI DA ESEGUIRE IN BASE ALLA MODALITÀ SELEZIONATA
            switch(strtoupper($mode))
            {
                
                //nessuna anonimizzaizone
                case 'NONE' :
                
                    //mantiene il dato
                    $enc_data = $data;
                    
                break;
                
                //crittografia bidirezionale
                case 'CRYPT' :
                
                    //converte il dato
                    $enc_data = \security\crypt\encrypt($data);
                
                break;
                
                //crittografia unidirezionale
                case 'HASH' :
                
                    //converte il dato in hash tramite l'algoritmo scelto
                    $enc_data = hash($PARAMETERS['encritp']['hash'],$data);             
                
                break;
                
                //ultimo gruppo dati
                case 'IP_LAST' :
                
                    //controlla il separatore dei gruppi dell'ip
                    $pos = strpos($data,'.');
                    
                    //SE È UN IPV4
                    if($pos !== false) {
                    
                        //imposta il carattere per le operazionei
                        $char = '.';
                        
                    //SE È UN IPV6                  
                    } else {
                        
                        //imposta il carattere per le operazionei                       
                        $char = ':';
                        
                    }
                    
                    //separa i pezzi dell'ip
                    $temp = explode($char,$data);
                    
                    //recupera l'indice dell'ultimo gruppo
                    $last = count($temp) - 1;
                    
                    //sostituisce l'ultimo gruppo dell'ip con xxx
                    $temp[$last] = 'xxx';
                    
                    //ricompone l'ip
                    $enc_data = implode($char,$temp);

                break;
                
            }
            
            //restituisce i dati
            return $enc_data;
            
        }
        
        /**
         *  @brief      Crittografa i dati
         *  
         *  @param [in] <b>(string)</b> $data i dati da crittografare 
         *  @param [in] <b>(string)</b> $key la chiave di crittografia
         *  @param [in] <b>(string)</b> $iv il vettore di inizializzazione
         *  
         *  @return     <b>(string)</b> i dati crittografati
         *  
         *  @details    Il metodo esegue la crittografia dei dati in maniera bidirezionale rendendoli recuperabili in 
         *  futuro.
         *  
         *  @details <b>Esempio:</b>
         */         
        function encrypt($data, $key=null, $iv = null) {    
            
            //recupera il set di opzioni di configurazione per la crittografia
            $PARAMETERS['encritp'] = $GLOBALS['PARAMETERS']['encritp'];
            
            //imposta la chiave di crittografia
            $key = isset($key) ? $key : $PARAMETERS['encritp']['key'];
            
            //SE NON È STATO PASSATO UN VETTORE DI INIZIALIZZAZIONE
            if (!$iv) {
                
                //calcola la lunghezza del vettore di inizializzazione
                $iv_lenght = openssl_cipher_iv_length($PARAMETERS['encritp']['mode']);
        
                //calcola il vettore di inizializzazione
                $iv = openssl_random_pseudo_bytes($iv_lenght);
                        
            }
            
            //esegue la crittografia dei dati
            $encryptedMessage = openssl_encrypt($data, $PARAMETERS['encritp']['mode'], $key, OPENSSL_RAW_DATA, $iv);

            //restituisce i dati concatenati al vettore diinizializzazione salvati in base64 per compatibilità nal db
            return base64_encode($iv . $encryptedMessage);
        
        }

        /**
         *  @brief      Decrittografa i dati
         *  
         *  @param [in] <b>(string)</b> $data i dati da crittografare 
         *  @param [in] <b>(string)</b> $key la chiave di crittografia
         *  
         *  @return     <b>(string)</b> i dati decrittografati
         *  
         *  @details    Il metodo recupera i dati crittografati in precedenza rendendoli disponibili in chiaro
         *  
         *  @details <b>Esempio:</b>
         */         
        function decrypt($string, $key=null) {
            
            //recupera il set di opzioni di configurazione per la crittografia
            $PARAMETERS['encritp'] = $GLOBALS['PARAMETERS']['encritp'];         
            
            //imposta la chiave di crittografia
            $key = isset($key) ? $key : $PARAMETERS['encritp']['key'];
            //recupera i dati dal formato base64
            $raw = base64_decode($string);
            //calcola la lunghezza del vettore di inizializzazione
            $iv_lenght = openssl_cipher_iv_length($PARAMETERS['encritp']['mode']);
            //recupera il vettore di inizializzazione
            $iv = substr($raw, 0, $iv_lenght);
            //recupera i dati crittografati
            $data = substr($raw, $iv_lenght);
            //restituisce i dati in chiaro
            return openssl_decrypt($data, $PARAMETERS['encritp']['mode'], $key, OPENSSL_RAW_DATA, $iv);
        
        }       
        
    }