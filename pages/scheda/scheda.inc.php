<?php
    
	//include il set di funzioni del personaggio
	require \functions\file('personaggio');
	
	//controlla la validità del personaggio richiesto
	$check = \pg\check($_REQUEST['pg']);

	//SE IL PERSONAGGIO NON ESISTE O NON È STATO INDICATO
	if(isset($check['errors'])) {
		
		//imposta l'elenco degli errori
		$TAG['page']['errors'] = $check['errors'];
		
		//richiama il template degli errori
		$TAG['template'] = 'errors';
		
	//SE IL PERSONAGGIO ESISTE
	} else {
		
		//imposta l'op e la view
		$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
		$view = $op;
		
		$dati = \pg\dati($_REQUEST['pg']);
		
		
		if($dati['esilio'] > strftime('%Y-%m-%d')) {

			$op = 'pg_esiliato';
		
		}
		
		
		//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
		switch(strtoupper($view)) {
	
			case 'PG_ESILIATO' :
			
				$view = $op;
			
			break;
			
			default :
			
			break;
		
		}		
		
		//ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA		
		switch(strtoupper($view)) {
	
			case 'PG_ESILIATO' :
			
				if($_SESSION['permessi'] > GAMEMASTER) {
					
					$TAG['template'] = 'scheda/gestione_esilio';
				
				} else {
					
					$TAG['template'] = 'scheda/pg_esiliato';
					
				}
			
			break;
			
			case 'SKILL' :
			
				$TAG['page']['pg'] = $dati;
				$TAG['page']['skill'] = \pg\skill\lista($_REQUEST['pg'],$dati['id_razza']);
			
				$TAG['template'] = 'scheda/skill';					
			
			break;
			
			
			case 'STORIA' :
			
				$TAG['page']['pg'] = $dati;
				
				$TAG['page']['pg']['affetti'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
					? gdrcd_bbcoder(gdrcd_filter_out($dati['affetti'])) 
					: gdrcd_html_filter($dati['affetti']);	

				$TAG['template'] = 'scheda/storia';					
			
			break;
			
			default :
			
				$dati['url_media'] = gdrcd_filter('fullurl',$dati['url_media']);
				$TAG['page']['pg'] = $dati;

				$TAG['page']['pg']['descrizione'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
					? gdrcd_bbcoder(gdrcd_filter_out($dati['descrizione'])) 
					: gdrcd_html_filter($dati['descrizione']);
				
				$TAG['page']['pg']['abbigliamento'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
					? gdrcd_bbcoder(gdrcd_filter_out($dati['abbigliamento'])) 
					: gdrcd_html_filter($dati['abbigliamento']);				
				
				$TAG['page']['audio'] = ($PARAMETERS['mode']['allow_audio'] == 'ON' && ! $_SESSION['blocca_media'])
					? true 
					: false;
				
				
				$TAG['template'] = 'scheda/index';
			
			break;	
		
		}
	
	}
	
	require \template\file($TAG['template']);	
	
	