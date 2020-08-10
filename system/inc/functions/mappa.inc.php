<?php
/**
 *  @file       system/inc/functions/mappa.inc.php
 *  
 *  @brief      Set di funzioni riguardanti le mappe
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    
	namespace mappa {
        
		/**
		 *  @brief Genera l'elenco mappe e locazioni
		 *  
		 *  @return <b>(arraye)</b> l'array con i dati dell'elenco da generare
		 *  
		 *  @details La funzione genera un array contenente l'elenco delle mappe e delle locazioni di quella mappa 
		 *  elenco che può essere usato per generare i menù a tendina per lo spostamento o altri elenchi del genere.
		 */		
		function lista()
		{
			
			//recupera l'elenco delle mappe e chat
			$query = "SELECT 
					     mappa_click.id_click, 
						 mappa_click.nome, 
						 mappa.id, 
						 mappa.nome AS nome_chat, 
						 mappa.chat, 
						 mappa.pagina, 
						 mappa.id_mappa_collegata
					 FROM mappa_click
					 LEFT JOIN mappa 
					 ON 
					     mappa.id_mappa = mappa_click.id_click 
					 ORDER BY 
					     nome, 
						 id_click, 
						 nome_chat";
			$result = \gdrcd\db\stmt($query);
			
			//SE NON CI SONO RISULTATI
			if($result['info']['num_rows'] === false) {
				
				//imposta i dati a false
				$data = false; 
			
			//SE CI SONO RISULTATI
			} else {
				
				//imposta la variabile di controllo di mappa diversa
				$old_id_click = -1;
				
				//CICLA L'ELENCO DEI DATI
				foreach($result['data'] as $v) {
				
					//SE È UNA MAPPA DIVERSA DA QUELLA PRECEDENTE
					if($v['id_click'] != $old_id_click) {
					
						//imposta che il valore dell'elenco è una mappa
						$v['mappa'] = true;
						//inserisce i dati nell'elenco
						$data[] = $v;

						//aggiorna la variabile di contorllo
						$old_id_click = $v['id_click'];
			
					}
					
					//imposta che i dati successivi dell'elenco per quella mappa saranno locaizoni
					$v['mappa'] = false;
						
					if($v['id'] != '') {
						
						//inserisce i dati della locaizone
						$data[] = $v;
						
					}
				
				}
			
			}
			
			//ritorna i dati
			return $data;
			
		}
		
		function mappaDati($idmappa)
		{
			
			$query = "SELECT 
					     * 
					 FROM mappaclick 
					 WHERE 
					     id_click = ? 
					 LIMIT 0,1";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $idmappa
			);			
			$result = \gdrcd\db\stmt($query,$param);

			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}
			
			return $data;
			
		}
        
    }