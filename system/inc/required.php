<?php
/**
 *  @file       includes/required.inc.php
 *  
 *  @brief      file con gli elementi comuni richiesti dal GDRCD
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @todo       sistemare alcuni refusi della vechcia versione
 */     
    
    session_start();    

    //SE IL PG È LOGGATO
    if( ! empty($_SESSION['login'])) {
    
        //Aggiornamento della posizione nella mappa del pg
        if(isset($_REQUEST['map_id']) && is_numeric($_REQUEST['map_id'])) {
            
            $_SESSION['luogo'] = -1;
            $_SESSION['mappa'] = $_REQUEST['map_id'];
        
        }

        if(isset($_REQUEST['dir']) && is_numeric($_REQUEST['dir'])) {
            
            $_SESSION['luogo'] = $_REQUEST['dir'];
        
        }
    
    }   
    
    // Comunica a PHP che useremo stringhe UTF-8 fino alla fine dello script
    mb_internal_encoding('UTF-8');

    // Comunica a PHP che invieremo stringhe UTF-8 al browser
    mb_http_output('UTF-8');    

    header('Content-Type:text/html; charset=UTF-8');    
    
    //refuso da spostare o eliminare
    $dont_check = true;
    $check_for_update = false;

    //include il file con la dichiaraizone delle costanti
    require_once ROOT . '/includes/constant_values.inc.php';
    //include il file di configurazione del GDRCD
    require_once ROOT . '/system/config/config.inc.php';  
    //include il file del vocabolario
    require_once ROOT . '/vocabulary/' . $PARAMETERS['languages']['set'] . '.vocabulary.php';
    //include il file con le funzioni del GDRCD
    require_once ROOT . '/includes/functions.inc.php';
    //include il plugin di default per il bbcode
    require_once ROOT . '/system/lib/bbdecoder/bbdecoder.php';
    //include il preprocessore dei css
    require_once ROOT . '/system/lib/csscrush/CssCrush.php';
    
    //opzioni per il processore dei css
    $settings= array(
        'minify' => false,
        'output_dir' =>  ROOT . '/themes/' . $PARAMETERS['themes']['current_theme'] . '/css',
        'versioning' => true,
    );  
    //imposta le opzioni per il processore dei css      
    csscrush_set('options',$settings);  
    
    //Eseguo la connessione al database
    //$handleDBConnection = gdrcd_connect();
	$db = \gdrcd\db\connect(
		$PARAMETERS['database']['username'],
		$PARAMETERS['database']['password'],
		$PARAMETERS['database']['url'],
		$PARAMETERS['database']['database_name'],
		$PARAMETERS['database']['collation']
	);
    
    //include il template base
    require template\file('_base');