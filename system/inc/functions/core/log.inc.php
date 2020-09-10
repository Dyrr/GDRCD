<?php
	namespace log {

		function insert($data)
		{
			
			$query = "INSERT INTO log 
					     (
						     nome_interessato, 
						     autore, 
						     data_evento, 
						     categoria, 
						     codice_evento, 
						     descrizione_evento 
						 ) 
					 VALUES 
					     (
							 ?,
							 ?,
							 NOW(),
							 ?,
							 ?,
							 ?
						 )";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['interessato']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => isset($data['autore']) ? $data['autore'] : $_SESSION['login']
			);		
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['categoria']) ? $data['categoria'] : GENERIC
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['codice']) ? $data['codice'] : GENERIC
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['txt']
			);			
			$result = \gdrcd\db\stmt($query,$param);			
	
		}
		
	}    
