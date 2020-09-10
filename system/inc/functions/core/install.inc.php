<?php
	namespace install {

		/**
		 *  @brief Controllo esistenza libreria richiesta
		 *  
		 *  @param [in] $extension <b>(string)</b> il nome della libreria di php di cui si richiede il controllo
		 *  
		 *  @return <b>(bool)</b> true in caso di libreria presente, false in caso contrario
		 *  
		 *  @details Il metodo controlla se la libreria richiesta è attiva, il metodo viene usato per controllare se 
		 *  quelle librerie che potrebbero non fare parte della versione di php usato sono disponibili
		 */		
		function extensionCheck($extension)
		{
			
			
			if(extension_loaded($extension) === false){

				$check = false;
			
			} else {
				
				$check = true;
			
			}
			
			return $check;
			
			
		}
		
		function requisiti()
		{
			
			$PARAMETERS['requisiti'] = $GLOBALS['PARAMETERS']['requisiti'];
			
			$requisiti = array();
			
			$requisiti['PHP'] = array(
				'min_version' => $PARAMETERS['requisiti']['php']['min_version'],
				'version' => PHP_VERSION,
				'status' => \install\PHPcheck()
			);

			$requisiti['MySQL'] = array(
				'version' => \gdrcd\db\version(),
				'min_version' => $PARAMETERS['requisiti']['mysql']['min_version'],
				'status' => \install\MySQLcheck(),
				'connection' => ($GLOBALS['db'] === false) ? false : true,
			);			
			
			$requisiti['estensioni'] = array(); 
			
			$db_est = false;
			
			
			foreach($PARAMETERS['requisiti']['extensions'] as $v) {
				
				$pos = strpos($v,'mysql');
				
				if($pos !== false) {
				
					$db_est = true;
					
				}
				
				$requisiti['estensioni'][$v] = \install\extensionCheck($v);
				
				$requisiti['MySQL']['extensions'] = $db_est;
				
			}
			
			$estensioni = true;
			
			foreach($requisiti['estensioni'] as $v) {
				
				if($v === false) {
					
					$estensioni = false;
					
				}
			
				
			}
			
			if(   $requisiti['PHP']['status']       === true 
			   && $requisiti['MySQL']['status']     === true
			   && $requisiti['MySQL']['status']     === true
			   && $requisiti['MySQL']['extensions'] === true 
			   && $estensioni                       === true) {
				   
				$requisiti['all'] = true;
			
			} else {
				
				$requisiti['all'] = false;
			
			}
			
			
			return $requisiti;
			
			
		}
		
		
		function MySQLcheck()
		{
			
			//SE LA VERSIONE DI PHP È INFERIORE A QUELLA RICHIESTA
			if (version_compare(\gdrcd\db\version(), $PARAMETERS['requisiti']['mysql']['min_version']) < 0) {
				
				$check = false;
			
			} else {

				$check = true;
			
			}
			
			return $check;
		
		}		
		
		function PHPcheck()
		{
			
			//SE LA VERSIONE DI PHP È INFERIORE A QUELLA RICHIESTA
			if (version_compare(PHP_VERSION, $GLOBALS['PARAMETERS']['requisiti']['php']['min_version']) < 0) {
				
				$check = false;
			
			} else {

				$check = true;
			
			}
			
			return $check;
		
		}
		
		function complete()
		{
			
			//recupera il testo del file di configurazione del database
			$file = file_get_contents(ROOT . '/system/config/install.inc.php');			
			
			//imposta ad attiva la connessione al database
			$find = '#\$PARAMETERS\[\'install\'\]\[\'complete\'\] = (true|false)#si';
			$replace = '$PARAMETERS[\'install\'][\'complete\'] = true';
			$file = preg_replace($find,$replace,$file);

			//aggiorna il file
			$file_name = ROOT . '/system/config/install.inc.php';
			file_put_contents($file_name, $file, LOCK_EX);
			chmod($file_name, 0600);				
			
		}

		function connConf($data)
		{
			
			//recupera il testo del file di configurazione del database
			$file = file_get_contents(ROOT . '/system/config/db.inc.php');
			
			//aggiorna il nome dell'utente
			$find = '#\$PARAMETERS\[\'db\'\]\[\'user\'\] = \'(.*?)\'#si';
			$replace = '$PARAMETERS[\'db\'][\'user\'] = \'' . $data['user'] . '\'';
			$file = preg_replace($find,$replace,$file);
			
			//aggiorna la pass nella variabile
			$find = '#\$PARAMETERS\[\'db\'\]\[\'pass\'\] = \'(.*?)\'#si';
			$replace = '$PARAMETERS[\'db\'][\'pass\'] = \'' . $data['pass'] . '\'';
			$file = preg_replace($find,$replace,$file);
			
			//aggiorna il nome del database
			$find = '#\$PARAMETERS\[\'db\'\]\[\'database\'\] = \'(.*?)\'#si';
			$replace = '$PARAMETERS[\'db\'][\'database\'] = \'' . $data['database'] . '\'';
			$file = preg_replace($find,$replace,$file);
			
			//aggiorna l'host
			$find = '#\$PARAMETERS\[\'db\'\]\[\'host\'\] = \'(.*?)\'#si';
			$replace = '$PARAMETERS[\'db\'][\'host\'] = \'' . $data['host'] . '\'';
			$file = preg_replace($find,$replace,$file);
			
			//aggiorna il file
			$file_name = ROOT . '/system/config/db.inc.php';
			file_put_contents($file_name, $file, LOCK_EX);
			chmod($file_name, 0600);

			//recupera il testo del file di configurazione del database
			$file = file_get_contents(ROOT . '/system/config/install.inc.php');			
			
			//imposta ad attiva la connessione al database
			$find = '#\$PARAMETERS\[\'install\'\]\[\'conn\'\] = (true|false)#si';
			$replace = '$PARAMETERS[\'install\'][\'conn\'] = true';
			$file = preg_replace($find,$replace,$file);

			//aggiorna il file
			$file_name = ROOT . '/system/config/install.php';
			file_put_contents($file_name, $file, LOCK_EX);
			chmod($file_name, 0600);			
			
		}

		function dbEmpty()
		{
			
			$query = "SHOW TABLES";

			$result = \gdrcd\db\stmt($query);

			if($result['info']['num_rows'] == 0) {
				
				
				$data = true;	

			} else {
				
				$data = false;
				
			}
		
			return $data;
		
		}
		
		function dbStructure()
		{
			
			$query = "SHOW TABLES";

			$result = \gdrcd\db\stmt($query);

			if($result['info']['num_rows'] == 0) {
				
				
				$data = false;
				
			} else {
			
				//var_dump($result['data']);
				foreach($result['data'] as $k => $v) {
					
					$field = array_keys($v);
					$tables[$v[$field[0]]] = array();
					
					$query = "SHOW COLUMNS 
							 FROM " . $v[$field[0]] ;
		

					$result1 = \gdrcd\db\stmt($query);

					foreach($result1['data'] as $v1) {
						
						$tables[$v[$field[0]]][] = $v1;

					
					}
					
				}
				
				$data = $tables;
				
			}			
			
			return $data;
			
		}
		
		
		function dbCheck()
		{
			
			$tables = \install\dbStructure();
			
			
			
			$original = json_encode($tables,true);
			
			$compare = file_get_contents(ROOT . '/system/install/db_check.json');
			
			
			if($original == $compare) {
				
				$data = true;
			
			} else {
				
				$data = false;				
			
			}

			return $data;
			
		}
		
		function __dbImport($file) {
			
			
			//recupera il file con il dump del database
			$db_dump = file(ROOT . '/system/install/' . $file . '.sql');				
			
			if(file_exists($db_dump)) {
			
			
					//variabile temporanea per la costruzione della query 
					$temp = '';

					//CICLA IL DUMP DEL DATABASE
					foreach ($db_dump as $line) {
					
						//salta la riga se è un commento
						if (
								substr($line, 0, 2) == '--' 
							 || substr($line, 0, 2) == '/*' 
							 || trim($line) == '') {
								 
							continue;
							
						}
					
						//concatena il testo della query
						$temp .= $line;
						
						//SE L'ULTIMO CARATTERE DELLA RIGA È UN PUNTO E VIRGOLA
						if (substr(trim($line), -1, 1) == ';') {

							//esegue la query
							$conn->stmt($temp);
							
							//azzera il testo della query
							$temp = '';
						
						}
					
					}

					$TAG['page']['success'][] = array(
						'code' => FILE_NOT_EXIST, 
						'testo' => $MESSAGE['error'][DB][INSTALLED]
					);		
				
					$data = true;				
			
			} else {
				
				$TAG['page']['errors'][] = array(
					'code' => FILE_NOT_EXIST, 
					'testo' => $MESSAGE['error'][SYS][FILE_NOT_EXIST]
				);		
			
				$data = false;
			
			}
			
			
			
			
			
			
			
			
			
		}
		
		
		
		function import($file)
		{

			$mpty = \install\dbEmpty();
			
			//SE NON È INSTALLATO NESSUN DATABASE
			if($empty === true) {
			
					$db_structure = \install\__import('gdrcd_structure');
					$db_data = \install\__import('gdrcd_data');
				
			
			//SE ESISTE GIA UNA STRUTTURA DI UN DATABASE
			} else {
				
				$db_corrispondence = \install\dbCheck();
				
				if($db_corrispondence === true) {
					
					
					$db_data = \install\__import('gdrcd_data');
					
					
					
					
					
					
				}
				
				
				
				
			}
			
		}		
		
	}    
