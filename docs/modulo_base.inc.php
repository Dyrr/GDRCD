<?php
    
	//include il set di funzioni per il modulo richiesto
	//esempio: 
	require \functions\file('personaggio');
		
	//imposta l'op e la view
	$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
	$view = $op;
	
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
	switch(strtoupper($view)) {

		default :
		
			$view = 'test';
		
		break;
	
	}		
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA		
	switch(strtoupper($view)) {

		case 'TEST' :
		
			$TAG['template'] = 'scheda/base';
		
		break;
	
	}
	
	//richiama il template da visualizzare
	//esempio :
	require \template\file($TAG['template']);