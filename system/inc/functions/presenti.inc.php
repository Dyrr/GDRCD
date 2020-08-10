<?php

    namespace presenti {
        
		function update($pg) 
		{
			
			$query = "UPDATE 
					     personaggio 
					 SET 
					    ultimo_refresh = NOW() 
					 WHERE 
					    nome = ?";			
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_STR,
				'value' => $pg
			);
			$result = \gdrcd\db\stmt($query,$param);			
			
		}
		
		function permessiIcon($permessi)
		{
			
			switch($permessi) {
               
			   case USER:
					
					$icon_permessi = 'fas fa-chess-pawn';
               
 			    break;
                
				case GUILDMODERATOR:

					$icon_permessi = 'fas fa-chess-bishop';
                    
				break;
                
				case GAMEMASTER:

					$icon_permessi = 'fas fa-chess-rook';
                
				break;
				
                case MODERATOR:

					$icon_permessi = 'fas fa-chess-queen';
               
			   break;
                
				case SUPERUSER:

					$icon_permessi = 'fas fa-chess-king';
				
				break;
            
				case DEVELOPER:

					$icon_permessi = 'fas fa-chess-king';
				
				break;			
			}			
		
			return $icon_permessi;
		
		}
		
		function entrati()
		{
			$query = "SELECT 
						 personaggio.nome, 
						 personaggio.cognome, 
						 personaggio.permessi, 
						 personaggio.sesso, 
						 personaggio.id_razza, 
						 razza.sing_m, 
						 razza.sing_f, 
						 razza.icon, 
						 personaggio.disponibile, 
						 personaggio.is_invisible, 
						 mappa.stanza_apparente, 
						 mappa.nome as luogo 
					 FROM personaggio 
					 LEFT JOIN mappa 
					 ON 
						 personaggio.ultimo_luogo = mappa.id 
					 LEFT JOIN razza 
					 ON 
						 personaggio.id_razza = razza.id_razza 
					 WHERE 
					     DATE_ADD(personaggio.ora_entrata, INTERVAL 2 MINUTE) > NOW() 
					 ORDER BY 
					     personaggio.ora_entrata, 
						 personaggio.nome";
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_INT,
				'value' => $luogo
			);
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $mappa
			);

			$result = \gdrcd\db\stmt($query,$param);

			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
			
				foreach ($result['data'] as $v) {

					if($_SESSION['permessi'] >= $v['permessi']) {
					
						
						$v['set_invisibility'] = false;
						$v['nome_completo'] = trim($v['nome'] . ' ' . $v['cognome']);
						$v['icona_permessi'] = \presenti\permessiIcon($v['permessi']);
						$v['new_status'] =($v['disponibile']+1)%3;
						if(    $_SESSION['permessi'] >= GAMEMASTER
						   && (   \nome($_SESSION['login']) == \nome($v['nome']) 
						       || $_SESSION['permessi'] > $v['permessi'])) {
						
							$v['set_invisibility'] = true;
							
						}
						$data[] = $v;
						
					}

				}
				
			}

			return $data;
			
		}
		
		function usciti()
		{
			$query = "SELECT 
						 personaggio.nome, 
						 personaggio.cognome, 
						 personaggio.permessi, 
						 personaggio.sesso, 
						 personaggio.id_razza, 
						 razza.sing_m, 
						 razza.sing_f, 
						 razza.icon, 
						 personaggio.disponibile, 
						 personaggio.is_invisible, 
						 mappa.stanza_apparente, 
						 mappa.nome as luogo 
					 FROM personaggio 
					 LEFT JOIN mappa 
					 ON 
						 personaggio.ultimo_luogo = mappa.id 
					 LEFT JOIN razza 
					 ON 
						 personaggio.id_razza = razza.id_razza 
					 WHERE 
					     (    personaggio.ora_uscita > personaggio.ora_entrata 
						  AND DATE_ADD(personaggio.ora_uscita, INTERVAL 1 MINUTE) > NOW()) 
						  OR  (    personaggio.ora_uscita < personaggio.ora_entrata 
						       AND DATE_ADD(personaggio.ultimo_refresh, INTERVAL 4 MINUTE) > NOW() 
							   AND DATE_ADD(personaggio.ultimo_refresh, INTERVAL 3 MINUTE) < NOW()) 
					 ORDER BY 
					     personaggio.ultimo_refresh, 
						 personaggio.nome";
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_INT,
				'value' => $luogo
			);
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $mappa
			);

			$result = \gdrcd\db\stmt($query,$param);

			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
			
				foreach ($result['data'] as $v) {

					if($_SESSION['permessi'] >= $v['permessi']) {
					
						
						$v['set_invisibility'] = false;
						$v['nome_completo'] = trim($v['nome'] . ' ' . $v['cognome']);
						$v['icona_permessi'] = \presenti\permessiIcon($v['permessi']);
						$v['new_status'] =($v['disponibile']+1)%3;
						if(    $_SESSION['permessi'] >= GAMEMASTER
						   && (   \nome($_SESSION['login']) == \nome($v['nome']) 
						       || $_SESSION['permessi'] > $v['permessi'])) {
						
							$v['set_invisibility'] = true;
							
						}
						$data[] = $v;
						
					}

				}
				
			}

			return $data;
			
		}		
		
		function inLuogo($mappa,$luogo)
		{
			$query = "SELECT 
						 personaggio.nome, 
						 personaggio.cognome, 
						 personaggio.permessi, 
						 personaggio.sesso, 
						 personaggio.id_razza, 
						 razza.sing_m, 
						 razza.sing_f, 
						 razza.icon, 
						 personaggio.disponibile, 
						 personaggio.is_invisible, 
						 mappa.stanza_apparente, 
						 mappa.nome as luogo 
					 FROM personaggio 
					 LEFT JOIN mappa 
					 ON 
						 personaggio.ultimo_luogo = mappa.id 
					 LEFT JOIN razza 
					 ON 
						 personaggio.id_razza = razza.id_razza 
					 WHERE 
							  (   personaggio.ora_entrata > personaggio.ora_uscita 
							  AND DATE_ADD(personaggio.ultimo_refresh, INTERVAL 4 MINUTE) > NOW()) 
						  AND personaggio.ultimo_luogo = ? 
						  AND personaggio.ultima_mappa = ? 
					 ORDER BY 
						 personaggio.is_invisible, 
						 personaggio.ultimo_luogo, 
						 personaggio.nome";
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_INT,
				'value' => $luogo
			);
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $mappa
			);

			$result = \gdrcd\db\stmt($query,$param);

			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
			
				foreach ($result['data'] as $v) {

					if(   $v['is_invisible'] == 0 
					   || (   $v['is_invisible'] == 1 
					       && $_SESSION['permessi'] >= $v['permessi'])) {
						
						$v['set_invisibility'] = false;
						$v['nome_completo'] = trim($v['nome'] . ' ' . $v['cognome']);
						$v['icona_permessi'] = \presenti\permessiIcon($v['permessi']);
						$v['new_status'] =($v['disponibile']+1)%3;
						if(    $_SESSION['permessi'] >= GAMEMASTER
						   && (   \nome($_SESSION['login']) == \nome($v['nome']) 
						       || $_SESSION['permessi'] > $v['permessi'])) {
						
							$v['set_invisibility'] = true;
							
						}
						$data[] = $v;
						
					}

				}
				
			}

			return $data;
			
			
		}
		
		function disponibile($pg,$disponibile) 
		{
			
			$query = "UPDATE personaggio 
					 SET 
					     ultimo_refresh = NOW(), 
					     disponibile = ? 
					 WHERE 
					     nome = ?";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_INT,
				'value' => $disponibile
			);			
			$param[] = array(
				'type' 	=> PARAM_STR,
				'value' => $pg
			);
			$result = \gdrcd\db\stmt($query,$param);						 
			
		}
		
		function invisibility($pg) 
		{
			
			$query = "UPDATE personaggio 
					 SET 
					     ultimo_refresh = NOW(), 					     
						 is_invisible = 1 - is_invisible 
					 WHERE 
					     nome = ?";
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_STR,
				'value' => $pg
			);
			$result = \gdrcd\db\stmt($query,$param);						 
			
		}		
        
    }