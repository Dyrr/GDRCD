<?php
/**
 *  @file       system/inc/functions/personaggio.inc.php
 *  
 *  @brief      Set di funzioni riguardanti il personaggio
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @todo       commentare le funzioni
 *  @todo       creare un set di costanti per i codici degli errori
 *  
 */     
    
    namespace pg {
    
		function check($nome)
		{
			
			$data = false;
			$nome = ucfirst(trim($nome));

			if (   isset($nome) === false 
				|| $nome == '') {
				
				$data['errors'][] = array(
					'code' => 211,
					'testo' => 'Non è stato inserito il nome del pg'
				); 			
			
			}

			$query = "SELECT 
						 idpg 
					 FROM personaggio 
					 WHERE 
						 nome = '" . gdrcd_filter_in($nome) . "' 
					 LIMIT 0,1";
					 
			//SE IL NOME ESISTE GIA
			$result = gdrcd_query($query,'result');
			
			if (gdrcd_query($result, 'num_rows') == 0){
				 
				 $data['errors'][] = array(
					'code' => 212,
					'testo' => 'Il pg selezionato non esiste'
				); 			
			
			}       
			
			return $data;
			
		}
		
		function dati($nome)
		{
			
			$query = "SELECT 
						 personaggio.*, 
						 razza.sing_m, 
						 razza.sing_f, 
						 razza.id_razza, 
						 razza.bonus_car0, 
						 razza.bonus_car1, 
						 razza.bonus_car2, 
						 razza.bonus_car3, 
						 razza.bonus_car4, 
						 razza.bonus_car5
					 FROM personaggio 
					 LEFT JOIN razza 
					 ON 
						 personaggio.id_razza=razza.id_razza
					 WHERE 
						 personaggio.nome = '".gdrcd_filter_in($_REQUEST['pg'])."' 
					 LIMIT 0,1";
			$dati = gdrcd_query($query);
			$dati['nome_completo'] = trim($dati['nome'] . ' ' . $dati['cognome']);
			return $dati;
		}
		
		function bonusOggetti($nome)
		{
			$query = "SELECT 
						 SUM(oggetto.bonus_car0) AS BO0, 
						 SUM(oggetto.bonus_car1) AS BO1, 
						 SUM(oggetto.bonus_car2) AS BO2, 
						 SUM(oggetto.bonus_car3) AS BO3, 
						 SUM(oggetto.bonus_car4) AS BO4, 
						 SUM(oggetto.bonus_car5) AS BO5
					 FROM oggetto 
					 JOIN clgpersonaggiooggetto 
					 ON 
						 oggetto.id_oggetto = clgpersonaggiooggetto.id_oggetto 
					 WHERE 
							 clgpersonaggiooggetto.nome = '" . gdrcd_filter($nome) . "' 
						 AND clgpersonaggiooggetto.posizione > " . ZAINO . "";
				
			$dati = gdrcd_query($query);
			
		}
	
	}
	
	namespace pg\skill {
		
		function lista($pg,$id_razza)
		{
			
			$old_car = -1;
			
			$query = "SELECT 
					     a.nome, 
						 a.car, 
						 a.id_abilita, 
						 pa.grado
					 FROM abilita AS a
					 LEFT JOIN clgpersonaggioabilita as pa 
					 ON 
					         a.id_abilita = pa.id_abilita
						 AND pa.nome = '" . gdrcd_filter_in($pg) . "' 
					 WHERE 
					        a.id_razza = -1 
						 OR a.id_razza =  " . gdrcd_filter_num($id_razza) . " 
					 ORDER BY 
					  a.car, 
					  a.nome";
			
			$result = gdrcd_query($query,'result');
			
			while($row = gdrcd_query($result, 'fetch')) {
				
				$row['grado'] = (int)(0 + $row['grado']);
				
				//controlla se la skill è in ordine la prima skill per quella statistica
				$row['first'] = false;
				
				if($old_car != $row['car']) {
					
					$row['first'] = true;
					
					$old_car = $row['car'];
					
				}
				
				$dati[] = $row;
			
			}
			
			return $dati;
		
		}
		
	}
	
	