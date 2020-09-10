<?php
/**
 *  @file       system/inc/functions/gestione/manutenzione.inc.php
 *  
 *  @brief      Set di funzioni riguardanti le mappe
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    
	namespace gestione\manutenzione {
 
		function old_log($mesi)
		{
			
			$query = "DELETE FROM log 
					 WHERE 
					     DATE_SUB(NOW(), INTERVAL ? MONTH) > data_evento";
            $param = array();
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $mesi
            );          
            $result = \gdrcd\db\stmt($query,$param);
		
			$righe = $result['info']['affected_rows'];
			
			$query = "OPTIMIZE TABLE log";			
            $result = \gdrcd\db\stmt($query);			
	
			return $righe;
		
		}
		
		funtion old_chat($mesi)
		{
			
			$query = "DELETE FROM chat 
					 WHERE 
						DATE_SUB(NOW(), INTERVAL ? MONTH) > ora";
            $param = array();
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $mesi
            );          
            $result = \gdrcd\db\stmt($query,$param);
		
			$righe = $result['info']['affected_rows'];			
			
			$query = "OPTIMIZE TABLE chat"
            $result = \gdrcd\db\stmt($query);			
	
			return $righe;		
		
		}
	
	
	
	}