<?php
/**
 *  @file       system/functions/db.inc.php
 *  
 *  @brief      Set di funzioni l'interrogazione del database
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details    Il file contiene il set di funzioni usato per l'interrogazione del database
 */     
    
    /**
     *  @namespace  defcon
     *  @brief      <b>Risorse per la sicurezza della land</b>
     */
	namespace gdrcd\db {
        
        //definisce le costanti per i parametri
        define('PARAM_STR','s');
        define('PARAM_INT','i');
        
        /**
         *  @brief Connessione al database MySQL
         *  
         *  @param [in] $username <b>(string)</b> nome utente per la connessione al server MySQL
         *  @param [in] $password <b>(string)</b> password per la connesisone al server MySQL
         *  @param [in] $host <b>(string)</b> l'host del server MySQL
         *  @param [in] $database <b>(string)</b> il nome del database a cui connettersi
         *  @param [in] $collation <b>(string)</b> il set di caratteri da usare per la connesisone al database
         *  
         *  @return <b>(object/bool)</b> oggetto della connessione al database o false in caso di errore
         */     
        function connect(
            $username,
            $password,
            $host,
            $database,
            $collation)
        {

            //inizializza la connessione al database
            $connection = mysqli_connect($host, $username, $password, $database);

            //imposta il set di caratteri per la connesione
            mysqli_set_charset($connection, $collation);

            //SE CI SONO ERRORI NELLA CONNESSIONE
            if($connection === false) {
                    
                //arresta lo script inviando il messaggio di errore
                die(\gdrcd\db\error(mysqli_connect_errno() . ': ' . mysqli_connect_error()));
            
            }
            return $connection;
        }       
        
        /**
         *  @brief Messaggi di errore di MySQLi
         *  
         *  @param [in] $details <b>(string)</b> il dettaglio del messaggio d'errore da visualizzare
         *  
         *  @return <b>(string)</b> il messaggio in html dell'errore
         */     
        function error($details = false) {
            
            //importa l'oggetto MySQLi della connesisone al database
            $db = $GLOBALS['db'];
            
            //genera il messaggio di errore in automatico
            $backtrace = debug_backtrace(DEBUG_BACKTRACE_PROVIDE_OBJECT, 50);
            $error_msg = '<strong>GDRCD MySQLi Error</strong> [File: '. basename($backtrace[1]['file']) 
            . '; Line: ' . $backtrace[1]['line'] . ']<br>'.'<strong>Error Code</strong>: ' . mysqli_errno($db) 
            . '<br>' . '<strong>Error String</strong>: ' . mysqli_error($db);

            //se è stato aggiunto un dettaglio sull'errore
            if($details !== false) {
                
                //lo appende al messaggio d'errore automatico
                $error_msg .= '<br><br><strong>Error Detail</strong>: '.$details;
            
            }

            //ritorna il messagigo d'errore
            return $error_msg;
        }       
        
        /**
         *  @brief Formatta l'array contenente i parametri per i prepared statement
         *  
         *  @param [in] $param <b>(array)</b> Array associativo contenente i parametri per lo statement
         *  
         *  @return <b>(array)</b> Array associativo nel formato compatibile per il mysqli_stmt_bind_param
         *  
         *  @details La funzione formatta l'array in un formato compatibile per i prepared statement di mysqli usando 
         *  il formato array(tipi,par1,par2);
         */     
        function paramPrepare($param) {
            
            //inizializza l'elenco dei tipi dei parametri
            $type = '';
            
            //inizializza l'elenco dei parametri
            $new_param = array();
            
            //CICLA L'ELENCO DEI PARAMETRI SINGOLI
            foreach($param as $v) {

                //compone la stringa con i tipi dei parametri
                $type .= $v['type']; 

                //compone l'elenco dei parametri
                $new_param[] = $v['value'];
            
            }
            
            //aggiunge l'elenco dei tipi dei parametri in testa all'array con l'elenco
            array_unshift($new_param,$type);

            //ritorna l'array formattato
            return $new_param;
            
        }
        
        /**
         *  @brief      Formatta la query per l'utilizzo in applicazioni tipo PhpMyAdmin
         *  
         *  @param [in] $query <b>(string)</b> query da inviare al database
         *  @param [in] $param  <b>(array)</b> array multidimensionale contenente i valori delle variabili e i parametri
         *  
         *  @return     <b>(string)</b> la query formattata 
         *  
         *  @details    Formatta il testo della query per renderlo più leggibile sostituendo i parametri ai placeholder 
         *  ? e poterlo inserire in applicazioni dome PhpMyAdmin
         */     
        function queryFormat($query,$param=array())
        {
    
            //inizializza la query formattata con i dati
            $formattedQuery = '';
            
            //verifica che il numero di parametri della query e i segnaposto della query siano uguali
            //$this->numeroParam($query,$param);
            
            $querySplit = explode('?',$query);          
            
            //CICLA LA QUERY SPEZZATA NEI SUOI ELEMENTI
            foreach($querySplit as $key => $value) {
                
                //concatena i pezzi per creare la query formattata
                $formattedQuery .= $value;
                
                if($key < count($param)) {
                    
                    //rimuove eventuali escape automatici
                    //$param_value = str_replace('\\','',$param[$key]['value']);
                    
                    if($param[$key]['type'] == 's') {
                    
                        //inserisce il parametro tra degli apici singoli
                        $formattedQuery .= "'" . $param[$key]['value'] . "'";
                        
                    } else {
                        
                        //inserisce il parametro tra degli apici singoli
                        $formattedQuery .= $param[$key]['value'];                       
                    
                    }
                
                }
            
            }
            
            //ritorna la query formattata sostituendo i parametri ai segnaposto
            return $formattedQuery;
        
        }       
        
        /**
         *  @brief      Analisi dell'operazione eseguita dalla query
         *  
         *  @param [in] $query <b>(string)</b> query da inviare al database
         *  
         *  @return     <b>(string)</b> l'operazione principale eseguita dalla query
         *  
         *  @details    Il metodo tramite l'analisi con una espressione regolare recupera quale è l'operazione principale 
         *  che la query vuole eseguire, in maniera da poter salvare i dati specifici di quella operazione come l'id 
         *  del record inserito dalla query o il numero di record influenzati dalla query stessa.
         */     
        function action($query)
        {
            
            //regex per l'analisi dell'operazione della query
            $search = '#^ *\(? *?\b(SELECT|SHOW TABLES|CHECK TABLES|REPAIR|INSERT|REPLACE)\b#i';

            //esegue l'analisi della query
            preg_match($search,$query,$matches);

            //definisce l'operazione eseguita dalla query
            $matches[1] = isset($matches[1]) ? $matches[1] : '';
            
            //restituisce l'operaizone
            return $matches[1];
            
        }       
        
        /**
         *  @brief Esegue una normale query
         *  
         *  @param [in] $query <b>(string)</b> la query da inviare al database
         *  
         *  @return <b>(array)</b> Array associativo contenente le info sulla query e sui dati
         *  
         *  @details La funzione esegue una query al database e recupera le informazioni sull'esito della stessa e sugli 
         *  eventuali dati recuperati
         */     
        function query($query)
        {
            
            //importa l'oggetto MySQLi della connesisone al database
            $db_link = $GLOBALS['db'];

			//SE È STATO IMPOSTATO IL CONTROLLO DELLA QUERY	
			//il controllo dell'esistenza della funzione è stato messo non essendo ancora sicuro se introdurre DefCon in questa 
			//release
			if($defcon === true) {
					
				//SE ESISTE LA FUNZIONE DI CONTROLLOD ELLE QUERY
				if(function_exists('\defcon\controlQuery')) {
				
					//salva i dati della query
					\defcon\controlQuery($query);
					
				}
			
			}            
			
			//inserisce nei dati la query
            $data['info']['query'] = $query;
            
            //INDIVIDUA IL TIPO DI QUERY INVIATA
            switch(strtoupper(\gdrcd\db\action($query))) {
                
                //query di selezione
                case 'SHOW':
                case 'CHECK':
                case 'REPAIR':
                case 'SELECT':
                    
                    $result = mysqli_query($db_link, $query) or die(\gdrcd\db\error($query));
                    
                    //inserisce il numero di record recuperati nelle info
                    $data['info']['num_rows'] = (int) mysqli_num_rows($result);
                    
                    //SE NON CI SONO RECORD RECUPERATI
                    if($data['info']['num_rows'] == 0) {
                    
                        //imposta i dati a false
                        $data['data'] = false;
                    
                    //SE CI SONO RECORD RECUPARATI
                    } else {    
                        
                        //CICLA I RECORD RECUPERATI
                        while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
                            
                            //inserendoli nell'array di ritorno
                            $data['data'][] = $row;
                        
                        }
                        
                    }
                    
                    //svuota il set di result
                    mysqli_free_result($result);

                break;
                
                //query di inserimento
                case 'INSERT' :
                
                    //inserisce nelle info l'ultimo id inserito
                    $data['info']['last_id'] = mysqli_insert_id($db_link);
                    //inserisce nelle info il numero di record inseriti
                    $data['info']['affected_rows'] = (int) mysqli_affected_rows($db_link);
                
                break;
                
                //altro tipo di query
                default:
                    
                    //inserisce nelle info il numero di record influenzati
                    $data['info']['affected_rows'] = (int) mysqli_affected_rows($db_link);

                break;
            
            }           
            
            //restituisce i dati
            return $data;

        }       
        
        /**
         *  @brief Esegue un prepared statement
         *  
         *  @param [in] $sql <b>(string)</b> la query al database
         *  @param [in] $binds <b>(array)</b> l'array con i parametri per lo statement
         *  
         *  @return <b>(array)</b> Array associativo contenente le info sulla query e sui dati
         *  
         *  @details La funzione invia un prepared statement al database e recupera le info e i dati dello statement 
         *  i paramatri vanno passati alla fnzione nel formato:
         *  array (
         *      array (
         *        'type' => PARAM_STR || PARAM_INT,
         *        'value' => 'valore1'
         *      ),
         *      array (
         *        'type' => PARAM_STR || PARAM_INT,
         *        'value' => 'valore2'
         *      )
         *  )
         */
        function stmt($sql, $binds = array(), $defcon=true)
        {
			
			//importa l'oggetto MySQLi della connesisone al database
            $db_link = $GLOBALS['db'];

            //prepara lo statement per l'inserimento
            $stmt = mysqli_prepare($db_link, $sql);
            
            //formatta la query per una visualizzazione migliore se stampata a video
            $query = \gdrcd\db\queryFormat($sql,$binds);

			//SE È STATO IMPOSTATO IL CONTROLLO DELLA QUERY	
			//il controllo dell'esistenza della funzione è stato messo non essendo ancora sicuro se introdurre DefCon in questa 
			//release
			if($defcon === true) {
					
				//SE ESISTE LA FUNZIONE DI CONTROLLOD ELLE QUERY
				if(function_exists('\defcon\controlQuery')) {
				
					//salva i dati della query
					\defcon\controlQuery($query);
					
				}
			
			}
			
			//SE LA PREPARAZIONE DELLO STATEMENT NON HA AVUTO PROBLEMI
            if ($stmt !== false) {

                //se sono stati inviati parametri
                if (!empty($binds)) {
                    
                    //prepara i parametri in un array in formato compatibile conn il gestore delle query;
                    $binds = \gdrcd\db\paramPrepare($binds);
                    
                    //esegue il bind dei parametri
                    $ref = array();
                    
                    foreach ($binds as $k => $v) {
                        if ($k > 0) {
                            $ref[$k] = &$binds[$k];
                        }else{
                            $ref[$k] = $v;
                        }
                    }
                    
                    array_unshift($ref, $stmt);
                    call_user_func_array('mysqli_stmt_bind_param', $ref);
                }
                
                //esegue lo statement
                mysqli_stmt_execute($stmt);
                
                //salva il numero di righe recuperate
                $data['info']['query'] = $query;                
                
                //INDIVIDUA IL TIPO DI QUERY INVIATA
                switch (strtoupper(\gdrcd\db\action($sql))) {
                    
                    //query di selezione
                    case 'SHOW':
                    case 'CHECK':
                    case 'REPAIR':
                    case 'SELECT':
                        
                        //controlla se esiste dil driver MySQLI Native Driver
                        $mysqlnd = function_exists('mysqli_fetch_all');

                        //SE ESISTE IL DRIVER
                        if ($mysqlnd === true) {

                            //esegue il recupero dei dati usando le sue funzioni 
                            $data['data'] = \gdrcd\db\fetch_assoc_nd($stmt);
                        
                        //SE NON ESISTE IL DRIVER
                        } else {
                            
                            //recupera i driver usando le normali funzioni di MySQLi
                            $data['data'] = \gdrcd\db\fetch_assoc($stmt);                   
                            
                        }
                        
                        //conta il numero di record
                        $data['info']['num_rows'] = count($data['data']);
                        
                        //SE NON CI SONO RECORD
                        if($data['info']['num_rows'] == 0) {
                        
                            //imposta i dati a false
                            $data['data'] = false;
                            
                        }
                    
                    break;
                    
                    //query di inserimento
                    case 'INSERT':
                        
                        //inserisce nelle info l'id inserito
                        $data['info']['last_id'] = mysqli_stmt_insert_id($stmt);
                        //inserisce nelle info il numero di righe inserite
                        $data['info']['affected_rows'] = mysqli_stmt_affected_rows($stmt);


                    break;
                    
                    //altro tipo di query
                    default:
                        
                        //inserisce nelle info il numero di righe inserite
                        $data['info']['affected_rows'] = mysqli_stmt_affected_rows($stmt);
                    
                    break;
                
                }               
                
                //recupara l'eventuale tipo di errore nell'operazione
                $stmtError = mysqli_stmt_error($stmt);
                
                //SE CI SONO ERRORI
                if (!empty($stmtError)) {
                    
                    //arresta lo script visualizzando l'errore
                    die(\gdrcd\db\error($stmtError));
                    
                }
                
                //libera la memoria
                mysqli_stmt_close($stmt);
                
                //ritorna i dati
                return $data;
                
            //SE LA PREPARAZIONE DELLO STATEMENT HA AVUTO PROBLEMI
            } else {
                
                //interrompe lo script mostrando l'errore;
                die(\gdrcd\db\error('Failed when creating the statement.'));
            
            }
        
        }       

        /**
         *  @brief Recupera i dati della query di selezione
         *  
         *  @param [in] $stmt <b>(object)</b> L'oggetto dello statement
         *  
         *  @return <b>(array)</b> l'array associativo contenente i dati recuperati dallo statement
         *  
         *  @details La funzione recupera i dari richiesti dallo statement usando le funzioni di MySQLi Native Driver 
         *  molto più semplici e intuitive da usare ma non presenti su tutti gli host
         */
        function fetch_assoc_nd($stmt) {
            
            //recupera il set di risultati da un prepared statement 
            $result = mysqli_stmt_get_result($stmt);
            
            //CICLA IL RESULT PER RECUPERARE I RECORD DEI DATI
            while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC))
            {
                
                $data[] = $row;
            
            }
            
            //restituisce i dati
            return $data;
            
        }
        
        /**
         *  @brief Recupera i dati della query di selezione
         *  
         *  @param [in] $stmt <b>(object)</b> L'oggetto dello statement
         *  
         *  @return <b>(array)</b> l'array associativo contenente i dati recuperati dallo statement
         *  
         *  @details La funzione recupera i dari richiesti dallo statement usando le funzioni base di MySQLi
         */     
        function fetch_assoc ($stmt) {
            
            //recupera il nome dei campi delle tabelle richiesti per usarli poi come indici dell'array dei dati
            $data = mysqli_stmt_result_metadata($stmt);
            $fields = array();
            $out = array();

            $fields[0] = $stmt;

            while($field = mysqli_fetch_field($data)) {
                
                $fields[] = &$out[$field->name];

            }
         
            call_user_func_array('mysqli_stmt_bind_result', $fields);

            //cicla il set di result dello statement per recuperare i dati ed inserirli nell'array
            while (mysqli_stmt_fetch($stmt)) {

                foreach( $out as $key=>$value )
                {
                    $row_tmb[ $key ] = $value;
                }

                $array[] = $row_tmb;

            }
          
            //restituisce i dati
            return $array;

        }       
        
    }