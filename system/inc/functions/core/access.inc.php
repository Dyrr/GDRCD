<?php
/**
 *  @file       system/inc/functions/core/access.inc.php
 *  
 *  @brief      Set di funzioni per il login e logout  in land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    
    /**
     *  @namespace  access
     *  @brief      <b>Risorse l'accesso in land</b>
     */     
    namespace access {

        /**
         *  @brief Controllo blacklist ip
         *  
         *  @param [in] $ip <b>(string)</b> l'IP da controllare
         *  
         *  @return <b>(bool)</b> il valore di verifica per l'IP richiesto
         */     
        function isBlacklisted($ip)
        {
            
            //recupera se l'IP richiesto è presente nella blacklist degli IP
            $query = "SELECT 
                         * 
                     FROM blacklist 
                     WHERE 
                             ip = ? 
                         AND granted = 0";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $ip
            );          
            $result = \gdrcd\db\stmt($query,$param);

            //SE L'IP NON È IN LISTA
            if($result['info']['num_rows'] == 0) {
                
                //imposta esito negativo
                $blacklisted = false;
                
            //SE L'IP È IN LISTA
            } else {
            
                //imposta esito positibo
                $blacklisted = true;

            }
            
            //restituisce l'esito
            return  $blacklisted;
            
        }
        
        /**
         *  @brief Controllo e recupero dati preeliminari del personaggio
         *  
         *  @param [in] $pg <b>(string)</b> il nome del personaggio
         *  
         *  @return <b>(array)</b> array contenente i dati del personagigo recuperati
         *  
         *  @details La funzione recupera se il pg richiesto esiste e in caso positivo recupera il nome dle pg e la password
         */     
        function pgExists($pg)
        {
            
            //recupera i dati del personaggio
            $query = "SELECT 
                         nome, 
                         pass 
                     FROM personaggio 
                     WHERE 
                         nome = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            $result = \gdrcd\db\stmt($query,$param);

            //SE IL PG RICHIESTO NON ESISTE
            if($result['info']['num_rows'] == 0) {
                
                //imposta i dati a false
                $data = false;              
                
            //SE IL PG RICHIESTO ESISTE         
            } else {
            
                //imposta i dati con i valori recuperati
                $data = $result['data'][0];
            }
            
            //restituisce i dati
            return  $data;
            
        }

        /**
         *  @brief Controllo e aggiornamento elenco doppi per ip
         *  
         *  @param [in] $ip <b>(string)</b> l'IP da controllare
         *  @param [in] $id <b>(int)</b> l'ID univoco del pg
         *  
         *  @details La funzione controlla i doppi per il pg selezionato in base all'ip di ingresso attuale e in caso di 
         *  nuovi doppi liinserisce in elenco. Nel caso invece di vecchi doppi agigorna invece il numero di ingressi e 
         *  la data di ultimo ingresso
         */     
        function doppi_ip($ip,$id)
        {
            
            //recupera l'elenco dei personaggi che hanno loggato con successo dall'IP richiesto
            $query = "SELECT DISTINCT 
                         nome_interessato 
                     FROM log 
                     WHERE 
                             codice_evento = 10002 
                         AND descrizione_evento = ? 
                     ORDER BY 
                         descrizione_evento";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $ip
            );          
            $result = \gdrcd\db\stmt($query,$param);

            //SE NON CI SONO LOGIN DALL'IP SELEIZONATO
            if($result['info']['num_rows'] == 0) {
                
                //imposta il controllo doppi a false
                $doppi_ip = false;              
                
            //SE CI SONO LOGIN DALL'IP SELEIZONATO          
            } else {
            
                //CICLA L'ELENCO DEI DATI RECUPERATI
                foreach($result['data'] as $v) {
                    
                    //SE IL'ID DEL PG È DIVERSO DA QUELLO ATTUALE
                    if((int)$v['nome_interessato'] != $id) {
                    
                        //aggiorna l'elenco dei doppi
                        $doppi_ip[] = (int)$v['nome_interessato'];
                        
                    }
                    
                }

            }

            //SE CI SONO POTENZIALI DOPPI
            if($doppi_ip !== false) { 
            
                //CICLA L'ELENCO DEI DOPPI
                foreach($doppi_ip as $v) {

                    //aggiorna l'elenco dei doppi
                    $query = "INSERT INTO personaggio_doppi 
                                 (
                                     idpg, 
                                     iddoppio, 
                                     idautore, 
                                     idtipo, 
                                     ip, 
                                     note, 
                                     first_data, 
                                     last_data 
                                 ) 
                             VALUES 
                                 (
                                     ?, 
                                     ?, 
                                     3, 
                                     1, 
                                     ?, 
                                     ?, 
                                     NOW(),
                                     NOW()
                                 ) 
                             ON DUPLICATE KEY UPDATE numero = numero";
                    $param = array();
                    $param[] = array(                   
                        'type'  => PARAM_INT,
                        'value' => $id
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_INT,
                        'value' => $v
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_STR,
                        'value' => $ip
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_STR,
                        'value' => ''
                    );          
                    $result = \gdrcd\db\stmt($query,$param);                                 
                    
                    $query = "INSERT INTO personaggio_doppi 
                                 (
                                     idpg, 
                                     iddoppio, 
                                     idautore, 
                                     idtipo, 
                                     ip, 
                                     note, 
                                     first_data, 
                                     last_data 
                                 ) 
                             VALUES 
                                 (
                                     ?, 
                                     ?, 
                                     3, 
                                     1, 
                                     ?, 
                                     ?, 
                                     NOW(), 
                                     NOW()
                                 ) 
                             ON DUPLICATE KEY UPDATE
                                 numero = numero + 1, 
                                 last_data = NOW()";
                    $param = array();
                    $param[] = array(                   
                        'type'  => PARAM_INT,
                        'value' => $v
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_INT,
                        'value' => $id
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_STR,
                        'value' => $ip
                    );          
                    $param[] = array(                   
                        'type'  => PARAM_STR,
                        'value' => ''
                    );          
                    $result = \gdrcd\db\stmt($query,$param);
            
                }
                
            }

        }
        
        /**
         *  @brief Controllo e aggiornamento elenco doppi tramite coockie
         *  
         *  @param [in] $id <b>(int)</b> l'ID univoco del pg
         *  @param [in] $iddoppio <b>(int)</b> l'ID univoco del doppio
         *  @param [in] $ip <b>(string)</b> l'IP da controllare  
         *  
         *  @details La funzione controlla i doppi per il pg tramite il coockie di controllo
         */         
        function doppi_coockie($idpg,$iddoppio,$ip)
        {

            //aggiorna l'elenco dei doppi
            $query = "INSERT INTO personaggio_doppi 
                         (
                             idpg, 
                             iddoppio, 
                             idautore, 
                             idtipo, 
                             ip, 
                             note, 
                             first_data, 
                             last_data 
                         ) 
                     VALUES 
                         (
                             ?, 
                             ?, 
                             3, 
                             2, 
                             ?, 
                             ?, 
                             NOW(),
                             NOW()
                         ) 
                     ON DUPLICATE KEY UPDATE numero = numero";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $iddoppio
            );          
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $ip
            );          
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => ''
            );          
            $result = \gdrcd\db\stmt($query,$param);                                 
            
            $query = "INSERT INTO personaggio_doppi 
                         (
                             idpg, 
                             iddoppio, 
                             idautore, 
                             idtipo, 
                             ip, 
                             note, 
                             first_data, 
                             last_data 
                         ) 
                     VALUES 
                         (
                             ?, 
                             ?, 
                             3, 
                             1, 
                             ?, 
                             ?, 
                             NOW(), 
                             NOW()
                         ) 
                     ON DUPLICATE KEY UPDATE
                         numero = numero + 1, 
                         last_data = NOW()";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $iddoppio
            );          
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $ip
            );          
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => ''
            );          
            $result = \gdrcd\db\stmt($query,$param);

        }       
        
        /**
         *  @brief Impostazione del coockie di controllo
         *  
         *  @param [in] $idpg <b>(int)</b> l'ID univoco del pg
         *  
         *  @detailsLa funzione imposta un valore di controllo mascherato per poi salvare il coockie con i dati
         */     
        function coockieSet($idpg)
        {
            
            //genera il salt casuale di sinistra
            $string_l = \security\password\randomString(random_int(4,8));
            //genera il salt casuale di destra          
            $string_r = \security\password\randomString(random_int(4,8));
            //genera i dati da inserire nel coockie
            $string_c = $string_l . '|' . $idpg . '|' . $string_r;
            
            //crittografa il dato
            $string_c = \security\crypt\encrypt($string_c);

            //imposta il coockie di controllo
            setcookie('lastlogin', $string_c, 0, '', '', 0, true);          
            
        }
        
        /**
         *  @brief Recupero dati coockie di controllo
         *  
         *  @return <b>(int)</b> i dati contenuti nella stringa del coockie
         *  
         *  @details La funzione recupera i dati del coockie di controllo ed estrapolo
         */     
        function coockieGet()
        {
            
            //decripta i dati selezionati
            $string_c = \security\crypt\decrypt($_COOKIE['lastlogin']); 
            //separa i dati randomici da quelli effettivi
            $temp = explode('|',$string_c);
            //recupera i dati
            $string_c = $temp[1];
            
            //restituisce i dati
            return $string_c;
            
        }
        
        /**
         *  @brief Aggiornamento dei presenti in land
         *  
         *  @param [in] $idpg <b>(string)</b> l'ID univoco del pg
         *  
         *  @details La funzione agigorna l'elenco dei rpesenti in land in base alle impostazioni
         */     
        function presenti($idpg)
        {
            
            //recupera le impostazioni
            $PARAMETERS['mode']['log_back_location'] = $GLOBALS['PARAMETERS']['mode']['log_back_location'];
            
            //SE LE IMPOSTAZIONI PREVEDONO L'INGRESSO NELL'ULTIMA LOCAIZONE
            if($PARAMETERS['mode']['log_back_location'] == 'OFF') {
                
                //imposta la variabile di sesisone
                $_SESSION['luogo'] = '-1';
                
                //imposta la query di agigornamento
                $query = "UPDATE personaggio 
                         SET 
                            ora_entrata = NOW(), 
                            ultimo_luogo='-1', 
                            ultimo_refresh = NOW(), 
                            last_ip = ?,  
                            is_invisible = 0 
                         WHERE 
                            idpg =  ? 
                         LIMIT 1";

            //SE LE IMPOSTAZIONI NON PREVEDONO L'INGRESSO NELL'ULTIMA LOCAIZONE         
            } else {

                //imposta la query di agigornamento
                $query = "UPDATE personaggio 
                         SET 
                            ora_entrata = NOW(), 
                            ultimo_refresh = NOW(), 
                            last_ip = ?,  
                            is_invisible = 0 
                         WHERE 
                            igpg = ? 
                         LIMIT 1";
            
            }           
            
            //aggiorna i dati
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $param[] = array(                   
                'type'  => PARAM_STR,
                'value' => $_SERVER['REMOTE_ADDR']
            );          
            
            $result = \gdrcd\db\stmt($query,$param);            
       
        }
        
        /**
         *  @brief Redirect all'ingresso
         *  
         *  @details La funzione esegue il redirect alla pagina di ingresso in base alle impostazioni
         */     
        function redirect()
        {
            
            //recupera le impostaizoni
            $PARAMETERS['mode']['log_back_location'] = $GLOBALS['PARAMETERS']['mode']['log_back_location'];
            
            //SE LE IMPOSTAZIONI PREVEDONO L'INGRESSO NELL'ULTIMA LOCAIZONE         
            if($PARAMETERS['mode']['log_back_location'] == 'OFF') {
                
                //imposta la variabile di sessione
                $_SESSION['luogo'] = '-1';


                //Redirigo alla pagina del gioco
                header('Location: main.php?page=mappa&map_id=' . $_SESSION['mappa'], true);
            
            } else {

                //Redirigo alla pagina del gioco
                header('Location: main.php?dir=' . $_SESSION['luogo'], true);
            
            }           
            
        }
        
        /**
         *  @brief Logout del personaggio 
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del personaggio
         *  
         *  @details La funzione esegue l'aggiornamento della data di uscita del personaggio
         */     
        function logout($idpg)
        {
            
            $query = "UPDATE 
                        personaggio 
                     SET 
                        ora_uscita = NOW() 
                     WHERE 
                        idpg = ? 
                     LIMIT 1";
            //aggiorna i dati
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            
            $result = \gdrcd\db\stmt($query,$param);            
        
        }
    
    }  