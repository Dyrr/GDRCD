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
    
        function mio($pg)
		{
			
			$mio = (ucfirst(trim($pg)) == ucfirst(trim($_SESSION['login'])))
				? true 
				: false;
				
			return $mio;
			
		}
		
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
        
        
        /**
         *  @brief elenco skill del pg e info relative
         *  
         *  @param [in] $pg <b>(string)</b> nome del pg
         *  @param [in] $id_razza <b>(int)</b> razza del personaggio
         *  @param [in] $px_rimasti <b>(int)</b> px rimasti
         *  
         *  @return <b>(array)</b> Array associativo ordinato per caratteristica con i deti delle skill
         *  
         *  @details La funzione recupera l'elenco delle skill della land e i relativi gradi del personaggio su queste 
         *  oltre che ad una serie di informazioni aggiuntive come la caratteristica di riferimento e se la skill sia 
         *  incrementabile o meno. Si è scelto di recuperare tutti i dati in quanto al web designer interessa solo se la 
         *  skill è incrementabile o meno e non le condizioni che la rendono tale
         */     
        function lista($pg,$id_razza,$px_rimasti)
        {
            
            //formattazione nome del pg
            $pg = ucfirst(trim($pg));
            
            //costo base della skill
            $costo_skill = $GLOBALS['PARAMETERS']['settings']['px_x_rank'];

            //recupero i dati sulle skill
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
                
                //costo prossimo punto della skill
                $row['costo'] = ($row['grado'] + 1) * $costo_skill;
                
                //grado massimo sulla skill
                $row['grado_massimo'] = ($row['grado'] >= $GLOBALS['PARAMETERS']['settings']['skills_cap'])
                    ? true
                    : false;
                
                //SE IL PERSONAGGIO È IL MIO PG E HO ABBASTANZA PX E NON HO RAGGIUNTO IL CAP MASSIMO DELLA SKILL
                //O SE HO I PERMESSI MAGIGORI DI MASTER
                if(     (    $_SESSION['login'] == $pg 
                          && $px_rimasti >= $row['costo'] 
                          && $row['grado_massimo'] === false) 
                     || $_SESSION['permessi'] >= GAMEMASTER) {
                         
                         //segna la skill come incrementabile
                         $row['skill_up'] = true;
                         
                //SE NON SUSSISTONO LE PRECEDENTI CONDIZIONI
                } else {
                    
                        //segna la skill come non incrementabile
                        $row['skill_up'] = false;
                    
                }
                
                //SE HO I PERMESSI DA MASTER
                if($_SESSION['permessi'] >= GAMEMASTER) {
                    
                    //segna la skill come decrementabile
                    $row['skill_down'] = true;
                                    
                //SE NON HO I PERMESSI DA MASTER
                } else {
                     
                    //segna la skill come non decrementabile
                    $row['skill_down'] = false;                   
                
                }
                
				$dati[$row['car']][] = $row;
            
            }
            
            return $dati;
        
        }
        
		function add($pg,$idskill)
		{
			
			$ps_spesi = \pg\px\spesi($pg);
			
			
			
			
			
			
		}
	
	}
    
    namespace pg\px {

        function totali($pg)
		{
			
			$query = "SELECT 
					     esperienza 
					 FROM personaggio 
					 WHERE 
					     nome = '" . gdrcd_filter_in($pg) . "' 
					 LIMIT 0,1";
			$result = gdrcd_query($query,'result');
			
			if(gdrcd_query($query,'num_rows') == 0) {

				$dati = false;
				
			} else { 
			
				$dati = gdrcd_query($result,'fetch');
				
			}
			
			gdrcd_query($result,'free');
			
			return $data;
			
			
		}
		
		function spesi($pg)
        {
            
            $px_spesi = 0;
            $costo_skill = $GLOBALS['PARAMETERS']['settings']['px_x_rank'];         
            
            $query = "SELECT 
                         pa.grado
                     FROM clgpersonaggioabilita as pa 
                     WHERE 
                         pa.nome = ?";
			$param = array();
			$param[] = array(
				'type' 	=> PARAM_STR,
				'value' => $pg
			);

		   $result = \gdrcd\db\stmt($query,$param);
            
            foreach($result['data'] as $v) {

                $v['grado'] = (int)(0 + $v['grado']);
                
                $px_spesi = $px_spesi + ($costo_skill * (($v['grado'] * ($v['grado'] + 1)) / 2));


            }
            
            return $px_spesi;
            
        }
        
        



    }