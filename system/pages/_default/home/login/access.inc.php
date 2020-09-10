<?php
/**
 *  @file       login.php
 *  
 *  @brief      File per la procedura del login del pg
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    
    //imposta l'op e la view
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;

    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
    switch(strtoupper($op)) {

        //procedura di login
        case 'LOGIN' :
        
            $login = false;
            
            \functions\load('core/access');

            /*Leggo i dati del form di login*/
            $login1 = gdrcd_filter('get', $_POST['login1']);
            $pass1 = gdrcd_filter('get', $_POST['pass1']);

            /** * Fix per il funzionamento in locale dell'engine
             * @author Blancks
             */
            switch($_SERVER['REMOTE_ADDR']) {
                case '::1':
                case '127.0.0.1':
                    $host = 'localhost';
                    break;
                default:
                    $host = gethostbyaddr($_SERVER['REMOTE_ADDR']);
                    break;
            }

            //controlla se l'IP del pc da cui si logga è stato messo in blacklist
            $blacklisted = \access\isBlacklisted($_SERVER['REMOTE_ADDR']);

            //SE L'IP È NELLA BLACKLIST
            if($blacklisted === true ) {

                //prepara i dati per l'inserimento dell'evento nei log
                $dati_log = array(
                    'interessato' => ucfirst(trim($_POST['login1'])),
                    'autore' => '3', 
                    'categoria' => LOGIN, 
                    'codice' => BLOCKED, 
                    'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                );
                
                //inserisce il dettaglio dell'errore
                $TAG['page']['errors'][] = array(
                    'code' => BLOCKED, 
                    'testo' => $MESSAGE['error'][LOGIN][BLOCKED]
                );      
                
            
            //SE L'IP NON È NELLA BLACKLIST 
            } else {

                //formatta il nome del login secondo lo standar del sistema
                $login1 = ucwords(strtolower(trim($login1)));
                
                //controlla l'esistenza del pg
                $check = \access\pgExists($_REQUEST['login1']);
            
                //SE IL PG NON ESISTE
                if($check === false) {
                    
                    //prepara i dati per l'inserimento dell'evento nei log
                    $dati_log = array(
                        'interessato' => ucfirst(trim($_POST['login1'])),
                        'autore' => '3', 
                        'categoria' => LOGIN, 
                        'codice' => PG_NOT_EXISTS, 
                        'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                    );
                    
                    //inserisce il dettaglio dell'errore
                    $TAG['page']['errors'][] = array(
                        'code' => PG_NOT_EXISTS, 
                        'testo' => $MESSAGE['error'][LOGIN][PG_NOT_EXISTS]
                    );              
                
                //SE IL PG ESISTE
                } else {
                    
                    //controlla la corrispondenza della password
                    $checkPass = \security\password\verify($_REQUEST['pass1'], $check['pass']);
                    
                    //SE È STATA SBAGLIATA LA PASSWORD
                    if($checkPass === false) {
                        
                        //prepara i dati per l'inserimento dell'evento nei log
                        $dati_log = array(
                            'interessato' => ucfirst(trim($_POST['login1'])),
                            'autore' => '3', 
                            'categoria' => LOGIN, 
                            'codice' => WRONG_PASSWORD, 
                            'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                        );
                        
                        //inserisce il dettaglio dell'errore
                        $TAG['page']['errors'][] = array(
                            'code' => WRONG_PASSWORD, 
                            'testo' => $MESSAGE['error'][LOGIN][WRONG_PASSWORD]
                        );              
                        
                        /// @todo aggiungere un controllo per il numero di tentativi errati di login
                        
                    //SE LA PASSWORD È CORRETTA
                    } else {
                        
                        //carica il set di funzioni base del personaggio
                        \functions\load('land/personaggio/pg');         
                        \functions\load('land/personaggio/soldi');         
                    
                        //recupera i deti del pg
                        $dati = \pg\dati($check['nome']);           
                        
                        //SE IL PG RISULTA LOGGATO 
                        //O SE SONO PASSATI MENO DI 2 MINUTI DA UN LOGOUT ERRARO
                        if(   strtotime($dati['ora_entrata']) > strtotime($dati['ora_uscita']) 
                           && strtotime($dati['ultimo_refresh']) + 120 >= time()) {
                               
                            //prepara i dati per l'inserimento dell'evento nei log
                            $dati_log = array(
                                'interessato' => ucfirst(trim($_POST['login1'])),
                                'autore' => '3', 
                                'categoria' => LOGIN, 
                                'codice' => ALREADY_LOGGED, 
                                'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                            );

                            
                            //inserisce il dettaglio dell'errore
                            $TAG['page']['errors'][] = array(
                                'code' => ALREADY_LOGGED, 
                                'testo' => $MESSAGE['error'][LOGIN][ALREADY_LOGGED]
                            );
                        
                        //SE IL PG HA SLOGGATO CORRETTAMENTE O NON È ANCORA LOGGATO
                        } else {
                        
                            //SE IL PG È BANNATO
                            if(strtotime($dati['esilio']) > time()) {
                                
                                //prepara i dati per l'inserimento dell'evento nei log
                                $dati_log = array(
                                    'interessato' => $dati['idpg'],
                                    'autore' => '3', 
                                    'categoria' => LOGIN, 
                                    'codice' => IS_EXILED, 
                                    'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                                );                  
                            
                                //inserisce il dettaglio dell'errore
                                $TAG['page']['errors'][] = array(
                                    'code' => IS_EXILED, 
                                    'testo' => $MESSAGE['error'][LOGIN][IS_EXILED]
                                );                      
                            
                            //SE FINALMENTE È TUTTO OK
                            } else {
                            
                                $login = true;
                                
                                //prepara i dati per l'inserimento dell'evento nei log
                                $dati_log = array(
                                    'interessato' => $dati['idpg'],
                                    'autore' => '3', 
                                    'categoria' => LOGIN, 
                                    'codice' => LOGIN_OK, 
                                    'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                                );
                                
                                //controlla e aggiorna l'elenco doppi per ip
                                \access\doppi_ip(
                                    \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],
                                    $PARAMETERS['encritp']['ip']),$dati['idpg']
                                );
                                
                                //SE ESISTE IL COOCKIE DI CONTROLLO 
                                //E SE L'ID DEL PG NEL COOCKIE DI CONTROLLO È DIVERSO DA QUELLO DEL PG ATTUALE
                                if(   isset($_COOKIE['lastlogin']) === true 
                                   && \access\coockieGet() != $dati['idpg']) {

                                    //aggiorna l'elenco dei doppi per coockie
                                    \access\doppi_coockie(
                                        $dati['idpg'],
                                        \access\coockieGet(),
                                        \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$PARAMETERS['encritp']['ip'])
                                    );
                                
                                }
                                
                                //aggiorna il coockie di controllo
                                \access\coockieSet($dati['idpg']);
                                
                                //imposta le variabili di sesisone
                                $_SESSION['login'] = $dati['nome'];
                                $_SESSION['id'] = $dati['idpg'];
                                $_SESSION['cognome'] = $dati['cognome'];
                                $_SESSION['permessi'] = $dati['permessi'];
                                $_SESSION['sesso'] = $dati['sesso'];
                                $_SESSION['blocca_media'] = $dati['blocca_media'];
                                $_SESSION['ultima_uscita'] = $dati['ora_uscita'];
                                $_SESSION['razza'] = ($dati['sesso'] == 'f') ? $dati['sing_f'] : $dati['sing_m'];
                                $_SESSION['img_razza'] = $dati['url_img_razza'];
                                $_SESSION['id_razza'] = $dati['id_razza'];
                                $_SESSION['posizione'] = $dati['posizione'];
                                $_SESSION['mappa'] = (empty($dati['ultima_mappa']) === true) ? 1 : $dati['ultima_mappa'];
                                $_SESSION['luogo'] = (empty($dati['ultimo_luogo']) === true) ? -1 :  $_SESSION['luogo'] = $dati['ultimo_luogo'];
                                $_SESSION['tag'] = "";
                                $_SESSION['last_message'] = 0;
                                $_SESSION['last_istant_message'] = $dati['ultimo_messaggio'];       
                            
                                //SE IL PG HA DEI RUOLO NELLE GILDE
                                if($dati['gilde'] !== false) {
                                    
                                    //CICLA L'ELENCO DELLE GILDE
                                    foreach($dati['gilde'] as $v) {
                                        
                                        //imposta le variabili di sesisone
                                        $_SESSION['gilda'] .= ',*'.$v['id_gilda'].'*';
                                        $_SESSION['img_gilda'] .= $v['ruolo_urlimg'].',';                   
                                    
                                    }
                                    
                                }
                                
                                //SE È STATO IMPOSTATO LO STIPENDIO AUTOMATICO
                                if($PARAMETERS['settings']['auto_salary'] = 'ON') {
                                    
                                    $stipendio = \pg\soldi\stipendioSet($_SESSION['id']);
                                    
                                }
                                
                                //inserisce l'evento nel log
                                \log\insert($dati_log);                     
                                
                                //inserisce 
                                \access\presenti($_SESSION['id']);
                                

                                
                            }
                            
                        }
                        
                    }
                    
                }
                
            }
            
            //inserisce l'evento nel log
            \log\insert($dati_log);
        
        break;
        
        //procedura di logout
        case 'LOGOUT' :
        
            \functions\load('core/access');

            \access\logout($_SESSION['id']);
        
        break;
        
        default :
        
        break;

    }
    
    //OPERAZIONI COMUNIPER LA VIEW
    
    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
    switch(strtoupper($view)) {
        
        case 'LOGIN' :
        
            //SE CI SONO ERRORI IN FASE DI LOGIN
            if($login === false) {
            
                //seleziona il template da visualizzare
                $TAG['template'] = 'errors';

                \template\load('home/login/layout',$TAG);           
                
                \template\start('content');
                //carica il template da visualizzare
                \template\load($TAG['template'],$TAG); 
                \template\end('content');           
            
            //SE NON CI SONO ERRORI IN FASE DI LOGIN            
            } else {
                
                //effettua il redirect all'interno della land
                \access\redirect();
                exit();             
                
            }
        
        break;
        
        //procedura di logout
        case 'LOGOUT' :
        
            $TAG['template'] = 'home/login/logout'; 
        
            //carica il template da visualizzare
            \template\load($TAG['template'],$TAG);              
            
            session_unset();
            session_destroy();          
        
        break;      
        
        //form di login
        default :

            $TAG['template'] = 'home/login/form';
        
            //carica il template da visualizzare
            \template\load($TAG['template'],$TAG);      
        
        break;
    
    }
    
