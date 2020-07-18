<?php
/**
 *  @file       pages/scheda/scheda.inc.php
 *  
 *  @brief      Modulo principale della scheda del personaggio
 *  
 *  @version    5.6.0
 *  @date       16/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details    Modulo principale, e forse in futuro unico per la scheda del personaggio 
 *  
 *  @details    Cartella con i template della pagina della scheda
 *  @see        themes/advanced/template/scheda    
 *  
 *  @details    Cartella con le funzioni per il personaggio
 *  @see        system/inc/functions/personaggio
 *  
 *  @todo       finire la pagina e ottimizzarla 
 */     
    
    //include il set di funzioni del personaggio
    require \functions\file('personaggio');
    
    $_REQUEST['pg'] = ucfirst(trim($_REQUEST['pg']));
	
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
        
        //recupera i dati base del pg
        $dati = \pg\dati($_REQUEST['pg']);
         
        //SE IL PG RISULTA ESILIATO
        if($dati['esilio'] > strftime('%Y-%m-%d')) {

            //forza l'operaizone su esiliato
            $op = 'default';
            $view = 'pg_esiliato';
        
        }
        
        //ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
        switch(strtoupper($view)) {
    
			//incremento skill
			case 'ADDSKILL' :
			
				//SE IL PG È IL PG DEL GIOCATORE RICHIEDENTE
				//O SE HO I PERMESSI DI MASTER O SUPERIORE
				if( \pg\mio($_REQUEST['pg']) === true 
					|| $_SESSION['permessi'] >= GAMEMASTER) {
						
					//esegue le procedure per l'incremento delle skill
					\pg\skill\add($_REQUEST['pg'],$_REQUEST['what']);
				
				}
				
				//imposta la view da utilizzare dopo l'operaizone
				$view = 'stats';
			
			break;
			
			//decremento skill
			case 'SUBKILL' :
			
				// SE HO I PERMESSI DI MASTER O SUPERIORE				
				if($_SESSION['permessi'] >= GAMEMASTER) {
						
					//esegue le procedure per la diminuizione delle skill
					\pg\skill\sub($_REQUEST['pg'],$_REQUEST['what']);
				
				}
				
				$view = 'stats';
			
			break;			
			
			default :
            
            break;
        
        }       
        
        //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
        switch(strtoupper($view)) {
    
            //pg esiliato
            case 'PG_ESILIATO' :
            
                //SE SI HANNO I PERMESSI DI MASTER O SUPERIORE
                if($_SESSION['permessi'] > GAMEMASTER) {
                    
                    //visualizza il template per la gestione dell'esilio
                    $TAG['template'] = 'scheda/gestione_esilio';
                
                //SE SI È UN UTENTE NORMALE
                } else {
                    
                    //visualizza il template per il pg esiliato
                    $TAG['template'] = 'scheda/pg_esiliato';
                    
                }
            
            break;
            
            //pagina principale delle skill
            case 'STATS' :
  				
				//dati base del pg
				$TAG['page']['pg'] = $dati;				
				
				$TAG['page']['section']['skill'] = ($PARAMETERS['mode']['skillsystem'] == 'ON') ? true : false;
				$TAG['page']['section']['stat'] = ($PARAMETERS['mode']['statssystem'] == 'ON') ? true : false;
				
				
				//se è attivato il sistema di skill
				if($PARAMETERS['mode']['skillsystem'] == 'ON') {
					
					//dati riguardanti l'esperienza spesa
					$TAG['page']['pg']['esperienza_spesa'] = \pg\px\spesi($_REQUEST['pg']);                
					$TAG['page']['pg']['esperienza_rimasta'] = $dati['esperienza'] - $TAG['page']['pg']['esperienza_spesa'];
					
					//dati delle skill
					$TAG['page']['skill'] = \pg\skill\lista($_REQUEST['pg'],$dati['id_razza'],$TAG['page']['pg']['esperienza_rimasta']);

					//nomi delle statistiche
					$TAG['page']['stats'] = $PARAMETERS['names']['stats'];
					array_pop($TAG['page']['stats']);
					
					//imposta il template da visualizzare
					$TAG['template'] = 'scheda/stat';
					
				}
            
            break;
            
            //pagina del background del personaggio
            case 'STORIA' :
            
                //ASSEGNA I DATI ALLE VARIABILI PER IL TEMPLATE
                //dati base del pg                
                $TAG['page']['pg'] = $dati;
                
                //filtra i dati in base alla modalità di visualizzazione scelta del campo (BBCode/HTML)
                $TAG['page']['pg']['affetti'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
                    ? gdrcd_bbcoder(gdrcd_filter_out($dati['affetti'])) 
                    : gdrcd_html_filter($dati['affetti']);  

                //imposta il template da visualizzare                
                $TAG['template'] = 'scheda/storia';                 
            
            break;
            
            //visualizzaizone della pagina di default della scheda
            default :
            
                $dati['url_media'] = gdrcd_filter('fullurl',$dati['url_media']);
                $TAG['page']['pg'] = $dati;

                 //filtra i dati in base alla modalità di visualizzazione scelta del campo (BBCode/HTML)
                $TAG['page']['pg']['descrizione'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
                    ? gdrcd_bbcoder(gdrcd_filter_out($dati['descrizione'])) 
                    : gdrcd_html_filter($dati['descrizione']);
                
                //filtra i dati in base alla modalità di visualizzazione scelta del campo (BBCode/HTML)                
                $TAG['page']['pg']['abbigliamento'] = ($PARAMETERS['mode']['user_bbcode'] == 'ON') 
                    ? gdrcd_bbcoder(gdrcd_filter_out($dati['abbigliamento'])) 
                    : gdrcd_html_filter($dati['abbigliamento']);                
                
                //semplifica la variabile di visualizzazione o meno dell'audio in scheda
                $TAG['page']['audio'] = ($PARAMETERS['mode']['allow_audio'] == 'ON' && ! $_SESSION['blocca_media'])
                    ? true 
                    : false;
                
                //imposta il template da visualizzare                 
                $TAG['template'] = 'scheda/index';
            
            break;  
        
        }
    
    }
    
    //CARICA IL TEMPLATE RICHIESTO
    require \template\file($TAG['template']);   
    
    