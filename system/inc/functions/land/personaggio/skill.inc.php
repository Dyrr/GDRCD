<?php
/**
 *  @file       system/inc/functions/game_engine/interlock/personaggio/skill.inc.php
 *  
 *  @brief      Set di funzioni per le skill del personaggio per il sistema di gioco interlock
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
        
        function dati($pg,$idskill)
        {
            
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
                         AND pa.nome = ? 
                     WHERE 
                                pa.nome = ?
                            AND a.id_abilita = ?
                            AND (   a.id_razza = -1 
                                 OR a.id_razza =  ?) 
                     ORDER BY 
                      a.car, 
                      a.nome";          
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idskill
            );
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idrazza
            );          
            
            $result = \gdrcd\db\stmt($query,$param);
            
            $data = $result['data'];
            
            return $data;           
        
        }
        
        
        function add($pg,$idskill)
        {
            
            $ps_spesi = \pg\px\spesi($pg);
            $px_totali = \pg\px\spesi($pg);
            
            
            
            
            
        }
    
    }