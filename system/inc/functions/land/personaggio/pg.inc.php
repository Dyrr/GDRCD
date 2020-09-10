<?php
/**
 *  @file       system/inc/functions/land/pg.inc.php
 *  
 *  @brief      Set di funzioni riguardanti il personaggio
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @todo       commentare le funzioni
 *  @todo       creare un set di costanti per i codici degli errori
 *  
 */     
    
    namespace pg {
    
        /**
         *  @brief Controllo proprietà del pg interessato
         *  
         *  @param [in] $pg <b>(string)</b> nome del pg interessato
         *  
         *  @return <b>(bool)</b> true in caso di esito positivo, false in caso negativo
         *  
         *  @details La funzione controlla se il nome del pg richiesto corrisponde al pg con cui si è loggati. Utile 
         *  per tutti quei controlli in cui si deve verificare se il pg è il proprio
         */        
        function mio($pg)
        {
            
            $mio = (ucfirst(trim($pg)) == ucfirst(trim($_SESSION['login'])))
                ? true 
                : false;
                
            return $mio;
            
        }
        
        /**
         *  @brief Controlli di esistenza del pg
         *  
         *  @param [in] $nome <b>(string)</b> nome del pg interessato
         *  
         *  @return <b>(type)</b> true in caso di esito positivo, false in caso negativo
         *  
         *  @details La funzione controlla se il pg richiesto esiste o meno
         */     
        function check($nome)
        {
            
            $data = false;
            $nome = ucfirst(trim($nome));

            if (   isset($nome) === false 
                || $nome == '') {
                
                $data['errors'][] = array(
                    'code' => ERROR['pg']['empty'],
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
						 razza.icon AS url_img_razza, 
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
                         personaggio.nome = ?  
                     LIMIT 0,1";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $nome
			);			
			$result = \gdrcd\db\stmt($query,$param);
            $result['data'][0]['nome_completo'] = trim($result['data'][0]['nome'] . ' ' . $result['data'][0]['cognome']);
            
			$pg = $result['data'][0];
			
			$pg['gilde'] = \pg\gilde($nome);
			
			$stipendio = 0;
			
			if($pg['gilde'] !== false) {
				
				foreach($pg['gilde'] as $v) {
					
					$stipendio = $stipendio + $v['stipendio'];
					
				}
				
			} 
			
			return  $pg;
        
		}
        
		function gilde($nome)
		{
			
			$query = "SELECT 
						g.id_gilda, 
						g.nome AS gilda, 
						g.tipo AS gilda_tipo,
						G.immagine AS gilda_urlimg, 
						g.visibile AS gilda_visibile, 
						r.id_ruolo AS id_ruolo, 
						r.nome_ruolo AS ruolo, 
						r.immagine AS ruolo_urlimg, 
						r.stipendio, 
						capo 
					 FROM clgpersonaggioruolo AS pgr 
					 LEFT JOIN ruolo AS r 
					 ON 
						pgr.id_ruolo = r.id_ruolo 
					 LEFT JOIN gilda AS g 
					 ON r.gilda = g.id_gilda 
					 WHERE 
						pgr.personaggio = ?";
			$param = array();
			$param[] = array(					
				'type' 	=> PARAM_STR,
				'value' => $nome
			);			
			$result = \gdrcd\db\stmt($query,$param);

			if($result['info']['num_rows'] == 0) {
				
				$data = false;
				
			} else {
				
				$data = $result['data'];
				
			}			
			
			return $data;
			
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