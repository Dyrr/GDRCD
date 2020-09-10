<?php
/**
 *  @file       system/inc/functions/personaggio.inc.php
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
    
    namespace pg\px {

        function totali($pg)
        {
            
            $query = "SELECT 
                         esperienza 
                     FROM personaggio 
                     WHERE 
                         nome = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            
            $result = \gdrcd\db\stmt($query,$param);
            
            $data = $result['data'];
            
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
                'type'  => PARAM_STR,
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