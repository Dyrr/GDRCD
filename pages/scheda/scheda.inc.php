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
            case 'SKILL' :
            
                //ASSEGNA I DATI ALLE VARIABILI PER IL TEMPLATE
                //dati base del pg
                $TAG['page']['pg'] = $dati;
                //dati delle skill
                $TAG['page']['skill'] = \pg\skill\lista($_REQUEST['pg'],$dati['id_razza']);
            
                //imposta il template da visualizzare
                $TAG['template'] = 'scheda/skill';                  
            
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
    
    