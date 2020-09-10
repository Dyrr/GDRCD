<?php 
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;	
	
	//carica il set di funzioni per i presenti
	\functions\load('presenti');
	
	switch(strtoupper($op)) {
		
		//modifica dello stato di disponibilità
		case 'DISPONIBILE' :
		
			\presenti\disponibile($_SESSION['login'],$_REQUEST['dispo']);
		
		break;
		
		//modifica dello stato di invisibilità
		case 'INVISIBILITY' :
		
			\presenti\invisibility($_SESSION['login']);
		
		break;

		//operazioni di default
		default :
		
			\presenti\update($_SESSION['login']);
			
		break;
	
	}
	
	switch(strtoupper($view)) {
		
		default :
	
			$TAG['page']['entrati']['lista'] = \presenti\entrati();
			$TAG['page']['usciti']['lista'] = \presenti\usciti();
			$TAG['page']['inluogo']['lista'] = \presenti\inLuogo($_SESSION['mappa'],$_SESSION['luogo']);
	
			$TAG['template'] = 'presenti/index';
			
		break;
		
	}
	
    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']);