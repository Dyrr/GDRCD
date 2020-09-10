<?php
/**
 *  @file       system/functions/core/security/defcon.inc.php
 *  
 *  @brief      Set di funzioni per il monitoragigo e sicurezza della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details    Il file contiene il set di funzioni usato da DefCon il gestore integrato per il controllo e la sicurezza 
 *  della land introdotto in questa versione.
 *  
 *  @todo       organizzare un po' meglio il recupero del livello di DefCon
 */     
    
    /**
     *  @namespace  security::defcon
     *  @brief      <b>Risorse per la sicurezza della land</b>
     */   
    namespace security\defcon {
        
        /**
         *  @brief Recupera il livello di DefCon del pg
         *  
         *  @param [in] $pg <b>(string)</b> il nome del pg interessato
         *  
         *  @return <b>(int)</b> il livello di DefCon del pg
         *  
         *  @details La funzione recupera il livello di DefCon del pg, che rappresenta il livello di monitoraggio a cui 
         *  si vuole sottoporre il pg, vuoi perchè si tratti di un acocunt speciale come un account di test, vuoi per 
         *  qualsiasi altro motivo. <br />
         *  Il livello di sicurezza va da un livello 5 (status normale), fino a 1 il livello di massimo monitoraggio
         */     
        function pgLevelGet($pg)
        {
            
            //recupera i dati del livello di sicurezza del pg
            $query = "SELECT 
                        defcon 
                     FROM personaggio 
                     WHERE 
                         nome = ?  
                     LIMIT 0,1";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => ucfirst(trim($pg))
            );
            $result = \gdrcd\db\stmt($query,$param,false);
                
            //aggiorna il valore della variabile di sesisone contenente il livello di DefCon del pg.
            $_SESSION['defcon_pg'] = $result['data'][0]['defcon'];
            
            //restituisce il livello di sicurezza del pg
            return $result['data'][0]['defcon'];
            
        }
        
        /**
         *  @brief Imposta il livello di DefCon del pg
         *  
         *  @param [in] $pg <b>(string)</b> il nome del pg interessato
         *  @param [in] $defcon <b>(int)</b> il livello di DefCon da impostare
         */     
        function pgLevelSet($pg,$defcon)
        {
            
            $query = "UPDATE personaggio 
                     SET 
                         defcon = ? 
                     WHERE 
                         nome = ?";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => ucfirst(trim($pg))
            );
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $defcon
            );
            $result = \gdrcd\db\stmt($query,$param,false);                       
            
        }
        
        /**
         *  @brief Log delle pagine visitate
         *  
         *  @param [in] $pg <b>(string)</b il nome del pg interessato
         *  
         *  @details La funzione salva in un file di testo a scadenza giornaliera e impostato per essere accessibile 
         *  solo dal server i dati della pagina a cui il pg ha avuto accesso
         */     
        function logAccess($pg)
        {

            //recupera il livello attuale di monitoragigo del pg
            $defconLevel = \security\defcon\pgLevelGet($pg);
            
            //SE IL LIVELLO DI MONITORAGGIO È PIÙ ALTO DEL NORMALE
            if($defconLevel < 5) {
                
                //SE LA PAGINA NON È QUELLA DEI PRESENTI
                //per evitare che ad ogni richiamo ciclico si generi un evento nel log
                if($_REQUEST['page'] != 'presenti') {
                
                    //genera il nome del file
                    $file_name = ROOT . '/system/data/log/defcon/' . date('Y_m_d') . '_' . strtolower($pg) . '_access.log';
                    //genera il testo del file
                    $txt = '[' . $pg . '] - [' . date('d/m/Y H:i:s') . '] - [' . $_SERVER['REQUEST_METHOD'] . '] - [' 
                    . http_response_code() . '] - [' . $_SERVER['REQUEST_URI'] . '] - [' . json_encode($_POST) . ']'; 
                    
                    //Append eil testo nel file
                    file_put_contents($file_name, $txt. "\n", FILE_APPEND | LOCK_EX);
                    //imposte i permessi di accesso al file
                    chmod($file_name, 0600);

                }
            
            }
            
        }
        
        /**
         *  @brief Controlli monitoraggi delle query
         *  
         *  @param [in] $query <b>(string)</b> la query da venire monitorata o meno
         *  
         *  @details La funzione controlla se la query eseguita deve essere monitorata o meno in base al livello di 
         *  monitoraggio impostato per il pg. 
         */     
        function controlQuery($query)
        {
            
            //recipera il tipo di aizone eseguita dalla query
            $action = strtoupper(\gdrcd\db\action($query));
            //imposta la query come non da salvare
            $save_query = false;
            
            //SE IL LIVELLO DI DEFCON DEL PG È DEFINITO
            if(isset($_SESSION['defcon_pg'])) {
			
				//SE IL LIVELLO DI DEFCON DEL PG È INFERIORE A 5 E LA QUERY NON È UNA QUERY DI SELECT				
				if($_SESSION['defcon_pg'] < 5 && $action != 'SELECT') {
					
					//imposta la query come da monitorare
					$save_query = true;
					
				}
				
				// se il livello di DefCon è uguale o inferiore a 3
				if($_SESSION['defcon_pg'] <= 3) {
					
					//imposta la query come da monitorare
					$save_query = true;                     
				
				}
				
			}
            
            //SE LA QUERY È DA MONITORARE
            if($save_query === true) {  
                
                //genera i dati di esecuzione della funzione
                $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 10);
                //inizializza il testo da salvare
                $text = '';
                //normalizza il separatore delle directory per ROOT
                $tmpROOT = str_replace("\\","/",ROOT);
                
                //CICLA L'ELENCO DELLE FUNZIONI ESEGUITE
                foreach($backtrace as $v) { 
                
                    //formatta il percorso del file
                    $v['file'] = str_replace("\\","/",$v['file']);
                    $v['file'] = str_replace($tmpROOT,"",$v['file']);
                    //crea il testo del file
                    $text .= "[FILE:" . $v['file'] . '] - [FUNCTION:' . $v['function'] . '] - [LINE:' . $v['line'] . ']' . "\n";

                }
                //aggiunge i dati della funzione specifica che ha triggerato l'esecuzione della query
                $backtrace[1]['file'] = str_replace("\\","/",$backtrace[1]['file']);
                $text .= "[FILE:" . str_replace($tmpROOT,"",$backtrace[1]['file']) . '] - [FUNCTION:'; 
                $text .= $backtrace[1]['function'] . '] - [LINE:' . $backtrace[1]['line'] . ']' . "\n";
                $text .= '[QUERY:' . $query . ']';           
                //aggiunge i dati del testo ad una variabile globale.
                $GLOBALS['DEFCON']['query'][] = $text;
                
            }       
            
        }
        
        /**
         *  @brief Log delle query eseguite
         *  
         *  @param [in] $pg <b>(string)</b> il nome del pg interessato
         *  
         *  @details La funzione salva in un file di testo a scadenza giornaliera e impostato per essere accessibile 
         *  solo dal server le query eseguite
         */     
        function logQuery($pg)
        {

            $defconLevel = pgLevelGet($pg);
            if($defconLevel < 5) {

                
                if($_REQUEST['page'] != 'presenti') {
                
                    $file_name = ROOT . '/system/data/log/defcon/' . date('Y_m_d') . '_' . strtolower($pg) . '_query.log';
                    if(count($GLOBALS['DEFCON']['query']) > 0) {
                    
                        foreach($GLOBALS['DEFCON']['query'] as $v) {
                            
                            $txt = $txt . $v . "\n";
                            
                        }
                        
                        file_put_contents($file_name, $txt, FILE_APPEND | LOCK_EX);
                        chmod($file_name, 0600);
                        
                    }

                }
            
            }
            
        }

        function report()
        {
            
            
        }
        
    }