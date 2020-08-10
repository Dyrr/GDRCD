<?php
	//include il set di funzioni per la mappa
	//require_once \functions\file('mappa');
	
	//imposta l'op e la view
	$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
	$view = $op;

	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
	switch(strtoupper($op)) {



	}
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
	switch(strtoupper($view)) {

		case 'DETAILS' :
		
			//SE IL PG SI TROVA IN UNA MAPPA
			if($_SESSION['luogo'] == -1) {
				
				//recupera i dati della mappa
				$TAG['page']['dati'] == \mappa\mappaDati($_SESSION['mappa']);
			
			//SE IL PG SI TROVA IN UNA LOCAIZONE
			} else {
				
				//recupera i deti della locaizone
				$TAG['page']['dati'] == \mappa\luogoDati($_SESSION['luogo']);				
				
			}
			
			//imposta il template da caricare
			$TAG['template'] = 'mappa/dettagli';
		
		
		break;
		
		default :
		
			//imposta il template da caricare
			$TAG['template'] = 'mappa/info_location';		
		
		break;


	}
	
    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']); 	