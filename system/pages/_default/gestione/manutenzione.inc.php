<?php
/**
 *  @file       pages/gestione/manutenzione.inc.php
 *  
 *  @brief      pagina con le operazioni di manutenzione della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi

 */     
    
    //SE SI HANNO I PERMESSI DI SUPERUSER O MAGGIORI
	if($_SESSION['permessi'] > MODERATOR +32) {
	
		\functions\load('gestione/manutenzione');
		
		//imposta l'op e la view
		$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
		$view = $op;

		//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
		switch(strtoupper($op)) {

			case 'OLD_LOG' :
			
				$righe = \gestione\manutenzione\old_log($_REQUEST['mesi']);
				
				$TAG['page']['completed'][]['testo'] = $righe . ' log eliminati';
				
				$view = 'report';
			
			break;
			
			case 'OLD_CHAT' :
			
				$righe = \gestione\manutenzione\old_chat($_REQUEST['mesi']);
				
				$TAG['page']['completed'][]['testo'] = $righe . ' post in chat eliminati';

				
				$view = 'report';
			
			break;			
			
			
			default :
			
			break;

		}
		
		//OPERAZIONI COMUNIPER LA VIEW
		
		//ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
		switch(strtoupper($view)) {
			
			case 'REPORT' :
			
				$TAG['page']['link_back'][] = array(
					'url' => 'main.php?page=gestione__manutenzione',
					'testo' => 'Torna alla gestione manutenzione'
				
				);				
				
				$TAG['template'] = 'report';
			
			break;
			
			default :
					
				$TAG['template'] = 'gestione/manutenzione';
			
			break;
		
		}
		
    //SE NON SI HANNO I PERMESSI DI SUPERUSER O MAGGIORI	
	} else {
		
		$ip = \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$GLOBALS['PARAMETERS']['encritp']['ip']);
		$file = str_replace('\\','/',__FILE__);
		$root = str_replace('\\','/',ROOT);
		
		$file = str_replace($root,'',$file);

		
		$text = "l'utente [pg=" . $_SESSION['id'] . "]" . $_SESSION['login'] . "[/pg] ha tentato l'accesso alla pagine " 
			  . "[b]" . $file . "[/b] alle ore [b]" . date('d/m/Y H:i:s') . "[/b][admin] dall'IP:[b]" 
			  . $ip . "[/b][/admin]";
		


		//prepara i dati per l'inserimento dell'evento nei log
		$dati_log = array(
			'interessato' => ucfirst(trim($_POST['login1'])),
			'autore' => '3', 
			'categoria' => SECURITY, 
			'codice' => UNAUTHORIZED, 
			'txt' => \security\crypt\anonimize($_SERVER['REMOTE_ADDR'],$GLOBALS['PARAMETERS']['encritp']['ip'])
		);
		//inserisce l'evento nel log
		//\log\insert($dati_log);		
		
		
		//inserisce il dettaglio dell'errore
		$TAG['page']['errors'][] = array(
			'code' => UNAUTHORIZED, 
			'testo' => $MESSAGE['error'][SECURITY][UNAUTHORIZED]
		);	
		$TAG['page']['errors'][] = array(
			'code' => LACK_OF_PERMISSION, 
			'testo' => $MESSAGE['error'][SECURITY][LACK_OF_PERMISSION]
		);	
		$TAG['page']['link_back'][] = array(
			'url' => 'main.php?page=gestione',
			'testo' => 'Torna alla gestione'
		
		);

		$TAG['template'] = 'errors/403';		
	
	}

    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']);
