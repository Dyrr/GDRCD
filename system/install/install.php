<?php
/**
 *  @file system/install/install/index.php
 *  
 *  @brief File con la procedura d'installazione
 *  
 *  @version 5.6.0
 *  @date    dyrr/dyrr/dyrr
 *  
 *  @author  Davide 'Dyrr' Grandi
 *  
 *  @details Il file contiene la procedura con le fasi per l'installazione del CMS al primo accesso per istruzioni 
 *  dettagliate riguardo alla procedura leggere il manuale d'istruzioni della land
 */
		
	// nego l'accesso diretto al file
	defined('GDRCD') OR exit('Non è permesso accesso diretto al file ' . __FILE__);		
	
    //imposta l'op e la view
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;

	//carica il set di funzioni necessarie all'installazione
	\functions\load('core/install');    
	
	//carica il template del layout della pagina
	\template\load('home/install/layout',$TAG);	
	
	//Eseguo la connessione al database
    $test_conn = \gdrcd\db\connectTest(
        $PARAMETERS['database']['username'],
        $PARAMETERS['database']['password'],
        $PARAMETERS['database']['url'],
        $PARAMETERS['database']['database_name'],
        $PARAMETERS['database']['collation']
    );	
	
	//SE IL TEST DELLA CONNESSIONE È FUNZIONANTE
	if($test_conn === true) {
	
		//effettua la connesione al database
		$db = \gdrcd\db\connect(
			$PARAMETERS['database']['username'],
			$PARAMETERS['database']['password'],
			$PARAMETERS['database']['url'],
			$PARAMETERS['database']['database_name'],
			$PARAMETERS['database']['collation']
		);

	}
	
	\install\dbCheck();	
	
	//ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
    switch(strtoupper($op)) {

        //Operazioni per l'inserimento dei dati dell'utenza di gestione
		case 'FASE_4' :
		
			//controlla i requisiti di sistema
			$requisiti = \install\requisiti();
			
			//SE IL SISTEMA HA TUTTI I PREREQUISITI	
			if($requisiti['all'] === true) {
			
				//SE IL TEST DELLA CONNESSIONE È FUNZIONANTE
				if($test_conn === true) {
				
					//caricamento delle funzioni per la registrazione del personaggio
					\functions\load('registrazione');
					
					//Crea l'account di gestione con i dati delezionati
					\registrazione\insertSuperuser($_REQUEST);
					
					//imposta come completa la registrazione
					\install\complete();
					
					//view con il riepilogo delle operazioni di installazione
					$view = 'fase_4';					
					
				} else {
				
					//view per l'inserimento dei dati della connessione al database
					$view = 'fase_2';
					
				}
				
			} else {
				
				//view con la pagina dei prerequisiti dell'open source
				$view = 'fase_1';
			
			}		
		
		break;
		
		//operazioni per l'inserimento dei dati della connessione al database
		case 'FASE_3' :
		
			$requisiti = \install\requisiti();
			
			//SE IL SISTEMA HA TUTTI I PREREQUISITI			
			if($requisiti['all'] === true) {
				
				//SE LA CONNESSIONE È STATA GIA REGISTRATA
				//E IL DATABASE INSTALLATO
				//E LA CONNESSIONE È VALIDA
				if(   $PARAMETERS['install']['conn'] === true 
				   && $PARAMETERS['install']['db']   === true 
				   && $test_conn                     === true) {				
				
						//view per l'inserimento dei dati dell'utenza di gestione
						$view = 'fase_3';				 
				 
				//SE NON SUSSISTONO LE CONDIZIONI PRECEDENTI
				} else {
					
					//prova una connesisone al database con i parametri inviati al form
					$test = \gdrcd\db\connectTest(
						$_REQUEST['user'],
						$_REQUEST['pass'],
						$_REQUEST['host'],
						$_REQUEST['database'],
						$PARAMETERS['database']['collation']
					);
				
					//SE LA CONNESSIONE DI TEST È UNA CONNESSIONE VALIDA
					if($test === true) {
						
						//crea la connessione al database
						\install\connConf($_REQUEST);
						
						//importa il database
						//\install\dbImport();
						
						//view per l'inserimento dei dati dell'utenza di gestione
						$view = 'fase_3';					
						
					} else {
					
						//view per l'inserimento dei dati della connessione al database
						$view = 'fase_2';
						
					}
					
				}
				
			//SE IL SISTEMA NON HA TUTTI I PREREQUISITI				
			} else {
				
				//view con la pagina dei prerequisiti dell'open source
				$view = 'fase_1';
			
			}		
		
		break;
		
		case 'FASE_2' :
		
			$requisiti = \install\requisiti();
			
			//SE IL SISTEMA HA TUTTI I PREREQUISITI
			if($requisiti['all'] === true) {
				
				//SE LA CONNESSIONE È STATA GIA REGISTRATA
				//E IL DATABASE INSTALLATO
				//E LA CONNESSIONE È VALIDA
				if(   $PARAMETERS['install']['conn'] === true 
				   && $PARAMETERS['install']['db']   === true 
				   && $test_conn                     === true) {
				
					//view per l'inserimento dei dati dell'utenza di gestione
					$view = 'fase_3';
						
				//SE NON SUSSISTONO I REQUISITI PRECEDENTI
				} else {
					
					//view per l'inserimento dei dati della connessione al database
					$view = 'fase_2';					
				
				}
			
			//SE IL SISTEMA NON HA TUTTI I PREREQUISITI
			} else {
				
				//view con la pagina dei prerequisiti dell'open source
				$view = 'fase_1';
			
			}
		
		break;
		
		
		default :
        
        
		
		break;

    }
    
    //OPERAZIONI COMUNIPER LA VIEW
    
    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
    switch(strtoupper($view)) {
        
        //view con il riepilogo delle operazioni di installazione 
		case 'FASE_4' :
		
			$TAG['template'] = 'home/install/fase_4';
		
		break;          

		//view per l'inserimento dei dati dell'utenza di gestione
		case 'FASE_3' :
		
			$TAG['template'] = 'home/install/fase_3';
		
		break;       
		
		//view per l'inserimento dei dati della connessione al database
		case 'FASE_2' :
		
			//seleziona il template da caricare
			$TAG['template'] = 'home/install/fase_2';
		
		break;
		
		//view con la pagina dei prerequisiti dell'open source
		case 'FASE_1' :
		default :
					
			//recupera i dati sulla versione del CMS
			$TAG['page']['version'] = $PARAMETERS['version'];
			//recupera i dati sui prerequisiti del CMS
			$TAG['page']['requisiti'] = \install\requisiti();

			//seleziona il template da caricare
			$TAG['template'] = 'home/install/fase_1';		
		
		break;
    
    }
	exit();
		
    
	
	


	\template\start('content');
	//carica il template da visualizzare
	\template\load($TAG['template'],$TAG); 
	\template\end('content');	    
	
	//stampa a video la pagina
    \template\render($OUT,$TAG);
	//pulizia variabili
    unset($MESSAGE);
    unset($PARAMETERS);	
	