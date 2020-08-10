<?php
	//include il set di funzioni per la mappa
	\functions\load('mappa');
		

	//genera l'elenco delle mappe e locaizoni
	$TAG['page']['locazioni'] = \mappa\lista();
    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file('main/link_menu'); 