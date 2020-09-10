<?php
	namespace lista {

		function pg()
		{
			
			$query = "SELECT 
						idpg AS value, 
						nome, 
						cognome, 
						TRIM(CONCAT(nome,' ',cognome)) AS completo, 
						'pg' AS tipo 
					 FROM personaggio 
					 ORDER BY completo";
			$result = \gdrcd\db\stmt($query);	
			
			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}

			return $data;
			
			
		}
		
		
		function gilde()
		{
			
			$query = "SELECT 
			             id_gilda AS value, 
						 nome,  
						 nome AS completo,  
						 'gilda' AS tipo 
					 FROM gilda
					 ORDER BY completo";
			$result = \gdrcd\db\stmt($query);			
			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}

			return $data;			
			
		}
		
	}
