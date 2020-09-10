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
    
	namespace gestione\locazioni {
        
		function insert($data)
		{
			
			$query = "INSERT INTO mappa 
						(nome, 
						descrizione, 
						dascrizione_html, 
						stato, 
						pagina, 
						chat, 
						immagine, 
						stanza_apparente, 
						id_mappa, 
						link_immagine, 
						link_immagine_hover, 
						id_mappa_collegata, 
						x_cord, 
						y_cord, 
						invitati, 
						privata, 
						proprietario, 
						ora_prenotazione, 
						scadenza, 
						costo, 
						class, 
						icona) 
					VALUES
						(?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						'', 
						'', 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?, 
						?)";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['nome']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['descrizione']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['dascrizione_html']) ? 1 : 0
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['stato']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['pagina']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['chat']) ? 1 : 0
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['immagine']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['stanza_apparente']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['id_mappa']) ? $data['id_mappa'] : 1
			);				
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['id_mappa_collegata']) ? $data['id_mappa_collegata'] : 1
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['x_cord']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['y_cord']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['invitati']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['privata']) ? 1 : 0
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['proprietario']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => str_replace('T',' ',$data['ora_prenotazione']) 
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => str_replace('T',' ',$data['scadenza'])
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['costo']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['class']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['icona']
			);				
			$result = \gdrcd\db\stmt($query,$param);							
			
			
			return $result['info']['last_id'];
			
		}
		
		
		function update($data)
		{
			
			$old = \gestione\locazioni\dati($data['id']);
			
			
			$query = "UPDATE mappa
					 SET 
						 nome = ?, 
						 descrizione = ?, 
						 dascrizione_html = ?, 
						 stato = ?, 
						 pagina = ?, 
						 chat = ?, 
						 immagine = ?, 
						 stanza_apparente = ?, 
						 id_mappa = ?, 
						 link_immagine = '', 
						 link_immagine_hover = '', 
						 id_mappa_collegata = ?, 
						 x_cord = ?, 
						 y_cord = ?, 
						 invitati = ?, 
						 privata = ?, 
						 proprietario = ?, 
						 ora_prenotazione = ?, 
						 scadenza = ?, 
						 costo = ?, 
						 class = ?, 
						 icona = ? 
					 WHERE 
					     id = ? 
					 LIMIT 1";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['nome']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['descrizione']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['dascrizione_html']) ? 1 : 0
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['stato']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['pagina']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['chat']) ? 1 : 0
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['immagine']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['stanza_apparente']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['id_mappa']) ? $data['id_mappa'] : 1
			);				
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['id_mappa_collegata']) ? $data['id_mappa_collegata'] : 1
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['x_cord']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['y_cord']
			);			
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['invitati']
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => isset($data['privata']) ? 1 : 0
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['proprietario']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => str_replace('T',' ',$data['ora_prenotazione']) 
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => str_replace('T',' ',$data['scadenza'])
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['costo']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['class']
			);				
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $data['icona']
			);				
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $data['id']
			);						 
			$result = \gdrcd\db\stmt($query,$param);						 
			
		}
		
		
		function lista($begin,$end)
		{
			
			$query = "SELECT 
					     mappa.id, 
						 mappa.nome, 
						 mappa_click.nome AS mappa_click 
					 FROM mappa LEFT JOIN mappa_click 
					 ON 
					     mappa.id_mappa = mappa_click.id_click 
					 ORDER BY 
					     mappa.nome LIMIT ?, ?";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $begin
			);			
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $end
			);			
			$result = \gdrcd\db\stmt($query,$param);						 
			
			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}

			return $data;
		
		}
		
		function dati($id)
		{
			
			$query = "SELECT 
					     l.*, 
						 m.immagine AS urlimgmappa, 
						 m.larghezza, 
						 m.altezza 
					 FROM mappa AS l 
                     LEFT JOIN mappa_click AS m	
                     ON l.id_mappa = m.id_click 					 
					 WHERE 
					     l.id = ? 
					 LIMIT 0,1";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $id
			);			
			$result = \gdrcd\db\stmt($query,$param);						 
			
			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'][0];
				
			}

			return $data;					
		
		}
		
		function mappe()
		{
			
			$query = "SELECT 
			             id_click AS id, 
						 nome 
					 FROM 
					     mappa_click 
					 ORDER BY 
					     nome";
			$result = \gdrcd\db\stmt($query);						 
			
			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}

			return $data;						 
			
		}
    
	
	
	
	}