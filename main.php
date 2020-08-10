<?php
/**
 *  @file       main.php
 *  
 *  @brief      Entry point principale dell'interno della land
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @todo       sistemare le azioni di spostamento in mappa e chat
 *  
 *  @see        includes/required.inc.php
 */     
    define('ROOT', __DIR__);

    //Includo i parametri, la configurazione, la lingua e le funzioni
    require_once ROOT . '/system/inc/required.php';
	
	gdrcd_controllo_sessione();
	
	//SE ESISTE LA FUNZIONE PER IL LOG DI ACCESSO ALLE PAGINE
	//il controllo dell'esistenza della funzione è stato messo non essendo ancora sicuro se introdurre DefCon in questa 
	//release
	if(function_exists('\defcon\logAccess') === true) {	
	
		//inserisce i dati nel log di accesso elle pagine
		\defcon\logAccess($_SESSION['login']);
		
	}
    
	//definizione del modulo da caricare
    $strInnerPage = "";

    //SE È AVVENUTO UNO SPOSTAMENTO IN UNA MAPPA
    if(isset($_REQUEST['map_id'])) {
    
        //aggiorna la variabile di sesisone della mappa
        $_SESSION['mappa'] = gdrcd_filter_num($_REQUEST['map_id']);
        
        //aggiorna la posizione del personagigo nel database
        $query = "UPDATE personaggio 
                 SET 
                     ultima_mappa = " . gdrcd_filter_num($_SESSION['mappa']) . ", 
                     ultimo_luogo = -1 
                 WHERE 
                     nome = '". gdrcd_filter_in($_SESSION['login']) . "' 
                 LIMIT 1";
		gdrcd_query($query);
    
    }

    //SE È STATO INDICATO UN MODULO
    if(isset($_REQUEST['page'])) {
    

        $strInnerPage = $_REQUEST['page'];

    //SE INVECE È STATA INDICATA UNA CHAT
    }  elseif (   isset($_REQUEST['dir']) 
               && is_numeric($_REQUEST['dir'])) {
    
        //SE LA STANZA HA UN ID VALIDO
            /** @todo inserire un controllo che controlli se la chat esiste oltre a quello dell'id valido **/
        if($_REQUEST['dir'] >= 0) {
            
            //imposta il modulo da caricare
            $strInnerPage = 'frame_chat';
    
        //SE LA STANZA NON HA UN ID VALIDO
        } else {
        
            //imposta il modulo da caricare
            $strInnerPage = 'mappaclick';
            
            $_REQUEST['id_map'] = $_SESSION['mappa'];
        
        }

        //aggiorna la posizione del personagigo nel database
        $query = "UPDATE personaggio 
                 SET 
                     ultimo_luogo = " . gdrcd_filter_num($_REQUEST['dir']) . " 
                 WHERE 
                     nome = '" . gdrcd_filter_in($_SESSION['login']) . "' 
                 LIMIT 1";
        gdrcd_query($query);


    //SE NON È STATO INDICATO NULLA NELLA QUERYSTRING
    } else {
    
        //imposta il modulo da caricare
        $strInnerPage = 'mappaclick';
        $_REQUEST['id_map'] = $_SESSION['mappa'];
    
    }
    
    //SE IL PG È ESILIATO
    if(gdrcd_controllo_esilio($_SESSION['login']) === true) {
        
        //resetta la sesisone
        session_destroy();
    
    //SE IL PG È AUTORIZZATO ALL'ACCESSO IN LAND
    } else {
        
        //SE LA PAGINA NON È STATA RICHIESTA TRAMITE CHIAMATA AJAX
        if(\template\is_ajax() === false) {
        
            //richiama il template del layout
            require \template\file('main/layout');
        
        }
        
        //richiama il template del contenuto
        template\start('content');
        require_once modulo\file($strInnerPage);        
        template\end('content');

    }
	
	//SE ESISTE LA FUNZIONE PER IL LOG DELLE QUERY
	//il controllo dell'esistenza della funzione è stato messo non essendo ancora sicuro se introdurre DefCon in questa 
	//release
	if(function_exists('\defcon\logQuery') === true) {	
		
		\defcon\logQuery($_SESSION['login']);
		
	}
	
    //pulizia variabili
    unset($DEFCON);
	unset($MESSAGE);
    unset($PARAMETERS);

    //stampa a video la pagina
    \template\render($OUT); 