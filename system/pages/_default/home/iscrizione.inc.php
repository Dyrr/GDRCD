<?php
/**
 *  @file       pages/home/iscrizione.onc.php
 *  
 *  @brief      pagina di registrazione del personaggio
 *  
 *  @version    5.6.0
 *  @date       14/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 */ 
    
    //include il set di funzioni per la registrazione del personaggio
    require ROOT . '/system/inc/functions/registrazione.inc.php';

    //inizializza l'array degli errori di registrazione
    $TAG['page']['errors'] = array();

    $op = isset($_REQUEST['fase']) ? $_REQUEST['fase'] : 'default';
    $view = 'default';

    $TAG['page']['pg_stat'] = $PARAMETERS['names']['stats'];
    array_pop($TAG['page']['pg_stat']);     

    //IMPOSTA IL SET DI OPERAZIONI DA ESEGUIRE IN INGRESSO
    switch($op) {

        //INSERIMENTO MODIFICA DATI DEL PERSONAGGIO
        case 1 :

            //imposta la view specifica per quella fase
            $view = 'compilazione';

        break;

        //CONFERMA DATI DEL PERSONAGGIO
        case 2 :
        //REGISTRAZIONE DATI DEL PERSONAGGIO
        case 3 :

            $ok = true;

            //esegue il controllo della validità della mail
            $controllo_mail = \registrazione\controlloMail($_REQUEST['email']);
            
            //SE IL CONTROLLO GENERA ERRORI
            if($controllo_mail['ok'] === false) {
                
                //imposta gli errori ad on
                $ok = false;

                //cicla l'elenco degli errori
                foreach($controllo_mail['errors'] as $v) {
                
                    //aggiunge gli errori all'elenco
                    array_push($TAG['page']['errors'],$v);
                    
                }
            
            }

            //esegue il controllo della somma dei punti delle statistiche del pg
            $controllo_nome = \registrazione\controlloNome($_REQUEST['nome']);
            
            //SE IL CONTROLLO GENERA ERRORI
            if($controllo_nome['ok'] === false) {

                //imposta gli errori ad on
                $ok = false;

                //cicla l'elenco degli errori
                foreach($controllo_nome['errors'] as $v) {

                    //aggiunge gli errori all'elenco
                    array_push($TAG['page']['errors'],$v);

                }

            }

            //esegue il controllo della somma dei punti delle statistiche del pg
            $controllo_punti = \registrazione\controlloPunti();

            //SE IL CONTROLLO GENERA ERRORI
            if($controllo_punti['ok'] === false) {

                //imposta gli errori ad on
                $ok = false;

                //cicla l'elenco degli errori
                foreach($controllo_punti['errors'] as $v) {
                
                    //aggiunge gli errori all'elenco
                    array_push($TAG['page']['errors'],$v);
                    
                }

            }

            //SE CI SONO ERRORI IN FASE DI REGISTRAIZONE
            if ($ok == false) {

                //imposta la view specifica per quella fase
                $view = 'errori';

            //SE NON CI SONO ERRORI IN FASE DI REGISTRAIZONE            
            } else {

                //SE SI È NELLA FASE DI CONFERMA DEI DATI DEL PERSONAGGIO
                if($op == 2) {

                    //imposta la view specifica per quella fase
                    $view = 'conferma';

                }

                //SE SI È NELLA FASE DI REGISTRAZIONE DEL PERSONAGGIO
                if($op == 3) {

                    //genera la pass criptata;
                    $pass = \security\password\generate();


                    /** * Se deve scattare l'avviso di cambio password fin dall'iscrizione non segno cambiamenti
                     * @author Blancks
                     */
                    $lastpasschange_field = "";
                    $lastpasschange_value = "";

                    /** * Se NON deve scattare l'avviso di cambio password fin dall'iscrizione aggiorno la data di ultimo cambio ad ora
                     * @author Blancks
                     */
                    if (   $PARAMETERS['mode']['alert_password_change'] == 'ON' 
                        && $PARAMETERS['settings']['alert_password_change']['alert_from_signup'] == 'OFF') {

                        $lastpasschange_field = ", ultimo_cambiopass";
                        $lastpasschange_value = ", NOW()";

                    }

                    //inserisce il dati del 
                    $query = "INSERT INTO personaggio 
                                 (nome, 
                                 cognome, 
                                 pass, 
                                 data_iscrizione, 
                                 email, 
                                 sesso, 
                                 id_razza, 
                                 car0, 
                                 car1, 
                                 car2, 
                                 car3, 
                                 car4, 
                                 car5, 
                                 salute, 
                                 salute_max, 
                                 soldi, 
                                 esperienza $lastpasschange_field) 
                             VALUES 
                                 ('" . trim(gdrcd_capital_letter(gdrcd_filter('in', $_POST['nome']))) . "', 
                                 '" . trim(gdrcd_filter('in', $_POST['cognome'])) . "', 
                                 '" . \security\password\hash($pass) . "', 
                                 NOW(), 
                                 '" . gdrcd_filter('in', $_POST['email']) . "', 
                                 '" . gdrcd_filter('in', $_POST['genere']) . "', 
                                 " . gdrcd_filter('num', $_POST['razza']) . ", 
                                 " . gdrcd_filter('num', $_POST['car0']) . ", 
                                 " . gdrcd_filter('num', $_POST['car1']) . ", 
                                 " . gdrcd_filter('num', $_POST['car2']) . ", 
                                 " . gdrcd_filter('num', $_POST['car3']) . ", 
                                 " . gdrcd_filter('num', $_POST['car4']) . ", 
                                 " . gdrcd_filter('num', $_POST['car5']) . ", 
                                 " . gdrcd_filter('num', $PARAMETERS['settings']['max_hp']) . ", 
                                 " . gdrcd_filter('num', $PARAMETERS['settings']['max_hp']) . ", 
                                 " . gdrcd_filter('num',  $PARAMETERS['settings']['first_money']) . ", 
                                 " . gdrcd_filter('num',  $PARAMETERS['settings']['first_px']) . " $lastpasschange_value)";
                    //gdrcd_query($query);

                    //inserisce il messagigo di benvenuto
                    $query = "INSERT INTO messaggi 
                                 (mittente, 
                                 destinatario, 
                                 spedito, 
                                 testo) 
                             VALUES 
                                 ('" . gdrcd_filter('out',$PARAMETERS['info']['webmaster_name']) . "', 
                                 '" . gdrcd_filter('get',$_POST['nome']) . "', NOW(), 
                                 '" . gdrcd_filter('out',$MESSAGE['register']['welcome']['message'][4]) . "')";
                    //gdrcd_query($query);

                    //SE È ATTIVATO L'INVIO DELLA MAIL DI CONFERMA
                    if ($PARAMETERS['mode']['emailconfirmation'] == 'ON') {

                        //prepara il testo della mail
                        $text = $MESSAGE['register']['welcome']['message'][0] . ' ' . $PARAMETERS['info']['site_name'] . "\n\n " . $MESSAGE['register']['welcome']['message'][1] . "\n     " . $MESSAGE['register']['welcome']['message'][2] . "\n\n    " . $MESSAGE['register']['welcome']['message']['user'] . ' ' . gdrcd_filter('get',
                                $_POST['nome']) . "\n" . $MESSAGE['register']['welcome']['message']['pass'] . ' ' . $pass . "\n\n    " . $PARAMETERS['info']['webmaster_name'];

                        //prepara l'oggetto della mail
                        $subject = $PARAMETERS['info']['site_name'] . ' - Registrazione di ' . gdrcd_filter('get',
                                $_POST['nome']) . ' ' . gdrcd_filter('get', $_POST['cognome']);

                        //spedisce la mail con i dati della registrazione
                        //mail(gdrcd_filter('get', $_POST['email']), $subject, $text,
                            //'From: ' . gdrcd_filter('out', $PARAMETERS['info']['webmaster_email']));

                    }                   
                                        
                    //imposta la view specifica per quella fase
                    $view = 'registra';
                    
                }               
            
            }       
        
        break;
    
    }
    
    //IMPOSTA IL SET DI OPERAZIONI DA EFFETTUARE IN BASE ALLA VIEW
    switch(strtoupper($view)) {
        
        //ACCETTAZIONE DEL DISCLAIMER DELLA LAND
        default :
        
            //carica il template della view
            require \template\file('home/registrazione/fase_0');
            
        break;          
        
        //INSERIMENTO / MODIFICA DATI DEL PERSONAGGIO
        case 'COMPILAZIONE' :
        
            //recupera i dati delle razze
            $query = "SELECT 
                         id_razza, 
                         nome_razza 
                     FROM razza 
                     WHERE 
                         iscrizione=1 
                     ORDER BY 
                         nome_razza";
            $result = gdrcd_query($query,'result');
            while ($row = gdrcd_query($result, 'fetch')) {
                
                $TAG['page']['razze'][] = $row;
            
            }
            gdrcd_query($result,'free');
                
            //carica il template della view
            require \template\file('home/registrazione/fase_1');        
        
        break;      
        
        //CONFERMA DEI DATI DEL PERSONAGGIO
        case 'CONFERMA' :
        
            //recupera il genere del personaggio
            $r_gen = ($_REQUEST['genere'] == 'm') ? 'm' : 'f';        
                    
            //recupera i dati della razza
            $query = "SELECT 
                         sing_" . gdrcd_filter_in($r_gen) . " AS nome_razza 
                     FROM razza 
                     WHERE 
                         id_razza = " . (0 + gdrcd_filter_num($_REQUEST['razza'])) . " 
                     LIMIT 1";
            $razza = gdrcd_query($query);
        
            //carica il template della view
            require \template\file('home/registrazione/fase_2');        
        
        break;
        
        //REGISTRAZIONE DEL PERSONAGGIO
        case 'REGISTRA' :
            
            //carica il template della view
            require \template\file('home/registrazione/fase_3');        
        
        break;
        
        //PAGINA DEGLI ERRORI DELLA REGISTRAZIONE
        case 'ERRORI' :
        
            //carica il template della view
            require \template\file('home/registrazione/errore');        
        
        break;
    
    }