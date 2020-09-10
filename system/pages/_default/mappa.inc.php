<?php
/**
 *  @file       pages/scheda/scheda.inc.php
 *  
 *  @brief      Modulo per la mappa di gioco
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details   Modulo per la mappa e l'elenco delle locazioni di gioco disponibile in vari formati 
 */ 	
	
	
	
	//include il set di funzioni per la mappa
	\functions\load('mappa');
	
	//imposta l'op e la view
	$op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
	$view = $op;

	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
	switch(strtoupper($op)) {



	}
	
	
	//OPERAZIONI COMUNIPER LA VIEW
	
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
	switch(strtoupper($view)) {
		
		default :
		
			$TAG['page']['mappa'] = \mappa\mappa($_REQUEST['map_id']);
			$TAG['page']['mappa']['locazioni'] = \mappa\locazioni($_REQUEST['map_id']);
		
			$TAG['template'] = 'mappa/mappa_grafica';
		
		break;
	
	
	}
	

    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']);	