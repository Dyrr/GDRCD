<?php
/**
 *  @file       pages/gestione/locazioni.inc.php
 *  
 *  @brief      Modulo vuoto da cui partire
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details   Modulo vuoto da usare come base per crearne di nuovi
 */     
    
    \functions\load('gestione\mappa');
	
	//imposta l'op e la view
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;

    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
    switch(strtoupper($op)) {

        case 'NEW_SAVE' :
			
			$_REQUEST['id'] = \gestione\locazioni\insert($_REQUEST);
			$view = 'edit';
		
		break;      

       case 'EDIT_SAVE' :
			
			\gestione\locazioni\update($_REQUEST);
			$view = 'edit';
		
		break;
		
		
		default :
        
        break;

    }
    
    //OPERAZIONI COMUNIPER LA VIEW
    
    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
    switch(strtoupper($view)) {
        
        case 'NEW' :
		
			\functions\load('lista');
			//include il set di funzioni per la mappa
			\functions\load('mappa');
			
			$TAG['page']['mape'] = \gestione\locazioni\mappe();		
			$TAG['page']['liste']['pg'] = \lista\pg();
			$TAG['page']['liste']['gilde'] = \lista\gilde();
			$TAG['page']['liste']['mappe'] = \gestione\locazioni\mappe();			
			
			$TAG['page']['mappa']['locazioni'] = \mappa\locazioni($TAG['page']['locazione']['id_mappa']);
			
			$TAG['page']['op'] = 'new';
			$TAG['template'] = 'gestione/locazioni/new_edit';		
		
		
		break;        
		
		case 'EDIT' :
		
			\functions\load('lista');
			//include il set di funzioni per la mappa
			\functions\load('mappa');
			
			$TAG['page']['locazione'] = \gestione\locazioni\dati($_REQUEST['id']);		
			$TAG['page']['mape'] = \gestione\locazioni\mappe();		
			$TAG['page']['liste']['pg'] = \lista\pg();
			$TAG['page']['liste']['gilde'] = \lista\gilde();
			$TAG['page']['liste']['mappe'] = \gestione\locazioni\mappe();			
			
			$TAG['page']['mappa']['locazioni'] = \mappa\locazioni($TAG['page']['locazione']['id_mappa']);
			
			$TAG['page']['op'] = 'edit';
			$TAG['template'] = 'gestione/locazioni/new_edit';		
		
		
		break;
		
		case 'DELETE' :
		
			\functions\load('lista');
			//include il set di funzioni per la mappa
			\functions\load('mappa');
			
			$TAG['page']['locazione'] = \gestione\locazioni\dati($_REQUEST['id']);		
			$TAG['page']['mape'] = \gestione\locazioni\mappe();		
			$TAG['page']['liste']['pg'] = \lista\pg();
			$TAG['page']['liste']['gilde'] = \lista\gilde();
			$TAG['page']['liste']['mappe'] = \gestione\locazioni\mappe();			
			
			$TAG['page']['mappa']['locazioni'] = \mappa\locazioni($TAG['page']['locazione']['id_mappa']);
			
			$TAG['page']['op'] = 'delete';
			$TAG['template'] = 'gestione/locazioni/new_edit';		
		
		
		break;		
		
        default :
        
                //Determinazione pagina (paginazione)
                $pagebegin = (int) gdrcd_filter('get', $_REQUEST['offset']) * $PARAMETERS['settings']['records_per_page'];
                $pageend = $PARAMETERS['settings']['records_per_page'];
                //Conteggio record totali
                $record_globale = gdrcd_query("SELECT COUNT(*) FROM mappa");
                $totaleresults = $record_globale['COUNT(*)'];
                //Lettura record
                $result = gdrcd_query("SELECT mappa.id, mappa.nome, mappa_click.nome AS mappa_click FROM mappa LEFT JOIN mappa_click ON mappa.id_mappa=mappa_click.id_click ORDER BY mappa.nome LIMIT ".$pagebegin.", ".$pageend."", 'result');
                $numresults = gdrcd_query($result, 'num_rows');        
		
				if($totaleresults > $PARAMETERS['settings']['records_per_page']) {
					
					$TAG['page']['pagination']['status'] = true;
				
				} else {
					
					$TAG['page']['pagination']['status'] = false;
					
				}
				
				$TAG['page']['pagination']['numero'] = floor($totaleresults / $PARAMETERS['settings']['records_per_page']);
				$TAT['page']['pagination']['url'] = 'main.php?page=gestione__luoghi';
				
				
				$TAG['page']['locazioni'] = \gestione\locazioni\lista($pagebegin,$pageend);
				$TAG['template'] = 'gestione/locazioni/index';
		break;
    
    }

    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']);