<?php
	session_start();	

if( ! empty($_SESSION['login'])) {
    /** * Aggiornamento della posizione nella mappa del pg
     * @author Blancks
     */
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
	
	$dont_check = true;
    $check_for_update = false;

	//include il file con la dichiaraizone delle costanti
	require_once ROOT . '/includes/constant_values.inc.php';
    //include il file di configurazione del GDRCD
	require_once ROOT . '/config.inc.php';	
	//include il file del vocabolario
	require_once ROOT . '/vocabulary/' . $PARAMETERS['languages']['set'] . '.vocabulary.php';
	//include il file con le funzioni del GDRCD
	require_once ROOT . '/includes/functions.inc.php';
    //include il plugin di default per il bbcode
	require_once ROOT . '/plugins/bbdecoder/bbdecoder.php';
	//include il preprocessore dei css
	require_once ROOT . '/plugins/csscrush/CssCrush.php';
	
	$object_name = 'options';
	//opzioni per il processore dei css
	$settings= array(
		'minify' => false,
		'output_dir' =>  'themes/' . $PARAMETERS['themes']['current_theme'] . '/css',
		'versioning' => true,
	);	
	//imposta le opzioni per il processore dei css		
	csscrush_set($object_name,$settings);	
	
	//Eseguo la connessione al database
	$handleDBConnection = gdrcd_connect();
	
	require template\file('_base');