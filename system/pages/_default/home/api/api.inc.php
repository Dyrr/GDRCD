<?php
/**
 *  @file       login.php
 *  
 *  @brief      File per la procedura del login del pg
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
    
    //imposta l'op e la view
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;

    \functions\load('core/api');
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
    switch(strtoupper($op)) {

 
		
		default :
        
        break;

    }
    
    //OPERAZIONI COMUNIPER LA VIEW
    
    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
    switch(strtoupper($view)) {
		
		case 'DBSTRUCTURE' :
		
			if(   isset($_SESSION['id']) 
			   && $_SESSION['permessi'] >= SUPERUSER) {
			

				\functions\load('core/install'); 
				$TAG['page'] = \install\dbStructure();
				
			} else {
				   
				\functions\load('core/install'); 
				$TAG['page'] = \install\dbStructure();				
				//$TAG['page'] = 'Furbacchione!!!';
				   
			}
 
			
		
		
		break;
		
		case 'VERSION' : 

			$TAG['page']['version'] = $PARAMETERS['version'];
			$TAG['page']['requisiti'] = \api\requisiti();
		
		break;
		
		default :
		

			$TAG['page']['intro'] = "Pagina di default delle API del GDRCD 5.6";
			$TAG['page']['comandi'][] = array(
				'operazione' => 'pg',
				'parametri' => array(
					0 => array(
						'parametro' => 'nome',
						'tipo' => 'string',
						'descrizione' => 'nome del personaggio di cui si vogliono vedere i dati'
					),
					1 => array(
						'parametro' => 'key',
						'tipo' => 'string',
						'descrizione' => 'Chiave delle api utilizzata dal personaggio'
					),
					2 => array(
						'parametro' => 'format',
						'tipo' => 'string',
						'valori' => 'json (default),html',
						'opzionale' => 'si',
						'descrizione' => 'Formato in cui restituire i dati'
					),
				
				),
				
				'esempio' => 'api.php?op=pg&nome=Dyrr&key=ahf24y2',
				'descrizione' => 'Questo comando delle api restituisce i dati del pg scelto per la chiave selezionata. In base alla chiave selezionata per lo stesso pg potrebbero essere disponibili diverse categorie di dati'
			
			);
			$TAG['page']['comandi'][] = array(
				'operazione' => 'version',
				'esempio' => 'api.php?op=version',
				'descrizione' => 'Questo comando delle api restituisce la versione dell\'Open Source installata assieme ad altri dati'
			
			);		
		break;
    
	}

	\template\mode('json');