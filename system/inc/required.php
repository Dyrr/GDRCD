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

    // Comunthe only sad thing is that being switch i attract few peopleùica a PHP che invieremo stringhe UTF-8 al browser
    mb_http_output('UTF-8');    

    header('Content-Type:text/html; charset=UTF-8');    
    
    //refuso da spostare o eliminare
    $dont_check = true;
    $check_for_update = false;

    //include il file con la dichiaraizone delle costanti
    require_once ROOT . '/system/inc/constant_values.inc.php';
    //include il file di configurazione del GDRCD
    require_once ROOT . '/system/config/config.inc.php';  
    //include il file del vocabolario
    require_once ROOT . '/vocabulary/' . $PARAMETERS['languages']['set'] . '.vocabulary.php';
    //include il file con le funzioni del GDRCD
    require_once ROOT . '/system/inc/functions/_core.inc.php';
    //include il plugin di default per il bbcode
    
    //INCLUSIONE DI UN AUTOLOADER STANDARD QUALORA QUALCUNO VOLESSE CIMENTARSI NELL'USO DELLA PROGRAMMAZIONE AD OGGETTI
    /// [autoloader_example]        
    //include l'autoloader
    require_once(ROOT . '/system/lib/dlight/core/autoloader/Autoloader.php');
    //istanzia l'autoloader
    $autoloader = new \dlight\core\autoloader\Autoloader();
    
    //aggiunge i path in cui cercare le risorse
    $autoloader->addPath(ROOT . '/system/lib/');
    
    //aggiunge nell'array degli autori che sfruttano la classe phpbrowscap
    $autoloader->addVendor('gdrcd'); 
    $autoloader->addVendor('erusev'); 

	
	/// [autoloader_example]        
    
    //INCLUSIONE DI UNA CLASSE CONTENITORE UTILE PER L'INIEZIONE DELLE DIPENDENZE SE QUALCUNO VOLESSE CIMENTARSI NELL'USO 
    //DELLA PROGRAMMAZIONE AD OGGETTI
    //avvia la classe contenitore
    \gdrcd\core\gdrcd::getInstance();
    //imposta un alias più comodo per il contenitore delle classi
    $gdrcd = \gdrcd\core\gdrcd::$class;     
    
    require_once ROOT . '/system/lib/bbdecoder/bbdecoder.php';
    //include il preprocessore dei css
    require_once ROOT . '/system/lib/csscrush/CssCrush.php';
    
    //opzioni per il processore dei css
    $settings= array(
        'minify' => true,
        'output_dir' =>  ROOT . '/themes/' . $PARAMETERS['themes']['current_theme'] . '/css',
        'versioning' => true,
		'formatter' => 'block'
    );  
    //imposta le opzioni per il processore dei css      
    csscrush_set('options',$settings);  
    
    //include il template base
    require template\file('_base');
	
	//se esiste il file di installazione e quindi il cms non è ancora stato installato
	if($PARAMETERS['install']['complete'] === false) {

		//include il file di installazione
		require(ROOT . '/system/install/install.php');
		//arresta lo script corrente
		exit();
	
	}

    //Eseguo la connessione al database
    $db = \gdrcd\db\connect(
        $PARAMETERS['database']['username'],
        $PARAMETERS['database']['password'],
        $PARAMETERS['database']['url'],
        $PARAMETERS['database']['database_name'],
        $PARAMETERS['database']['collation']
    );	