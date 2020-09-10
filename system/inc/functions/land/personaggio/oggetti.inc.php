<?php
/**
 *  @file       system/inc/functions/land/personaggio/oggetti.inc.php
 *  
 *  @brief      Set di funzioni per gli oggetti
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
    
    namespace pg\oggetti {
        
        /**
         *  @brief Controllo del possesso di un oggetto
         *  
         *  @param [in] $pg <b>(string)</b> nome del personaggio interessato
         *  @param [in] $idoggetto <b>(type)</b> id dell'oggetto interessato
         *  
         *  @return <b>(bool)</b> true se il pg possiede l'oggetto, false se non lo possiede
         */     
        function possiede($pg,$idoggetto)
        {
            
            $query = "SELECT 
                         idpooggetto 
                     FROM clgpersonaggiooggetto 
                     WHERE 
                            idpooggetto = ? 
                        AND nome = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idoggetto
            );
            
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );
            $result = \gdrcd\db\stmt($query,$param);

            if($result['info']['num_rows'] != 0) {

                $data = true;
                
            } else {
                
                $data = false;
                
            }
            
            return $data;
            
        }
        
        /**
         *  @brief Mette in zaino un oggetto posseduto
         *  
         *  @param [in] $pg <b>(string)</b> nome del pg interessato
         *  @param [in] $idoggetto <b>(int)</b> ID dell'oggetto interessato
         */     
        function trasporta($pg,$idoggetto)
        {
            
            $query = "UPDATE clgpersonaggiooggetto AS po 
                     LEFT JOIN oggetto AS o 
                     ON 
                         po.id_oggetto = o.id_oggetto 
                     SET 
                         po.posizione = 1 
                     WHERE 
                             o.ubicabile <> 0 
                         AND po.nome = ? 
                         AND po.idpooggetto = ?";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idoggetto
            );
            $result = \gdrcd\db\stmt($query,$param);            

        }
        
        /**
         *  @brief Toglie dallo zaino un oggetto
         *  
         *  @param [in] $pg <b>(string)</b> nome del pg interessato
         *  @param [in] $idoggetto <b>(int)</b> ID dell'oggetto interessato
         */         
        function deposita($pg,$idoggetto)
        {
            
            $query = "UPDATE clgpersonaggiooggetto AS po 
                     LEFT JOIN oggetto AS o 
                     ON 
                         po.id_oggetto = o.id_oggetto 
                     SET 
                         po.posizione = 0 
                     WHERE 
                             o.ubicabile <> 0 
                         AND po.nome = ? 
                         AND po.idpooggetto = ?";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idoggetto
            );
            $result = \gdrcd\db\stmt($query,$param);            

        }       
        
        /**
         *  @brief Dati singolo oggetto
         *  
         *  @param [in] $idpooggetto <b>(int)</b> ID dell'oggetto interessato
         *  @return <b>(array/bool)</b> L'array con i dati dell'oggetto o false nel caso non esista
         */     
        function singolo($idpooggetto)
        {
            
            //recupera i dati sulle locazioni degli oggetti
            $locazioni = $GLOBALS['MESSAGE']['interface']['administration']['items']['fit_in'];
            $key = array_keys($locazioni);
            
            $query = "SELECT 
                         po.idpooggetto, 
                         po.nome AS proprietario, 
                         po.cariche, 
                         po.commento, 
                         po.posizione, 
                         o.*, 
                         ot.descrizione AS categoria
                     FROM 
                         clgpersonaggiooggetto AS po 
                     LEFT JOIN oggetto AS o 
                     ON po.id_oggetto = o.id_oggetto 
                     LEFT JOIN 
                         codtipooggetto AS ot 
                     ON o.tipo = ot.cod_tipo 
                     WHERE 
                         po.idpooggetto = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idpooggetto
            );          
            $result = \gdrcd\db\stmt($query,$param);

            //SE CI SONO OGGETTI
            if($result['info']['num_rows'] != 0) {
            
                //CICLA L'ELENCO DEGLI OGGETTO
                foreach($result['data'] as $v) {
                    
                    if($v['posizione'] >= 2) {
                        
                        $v['indossato'] = true;
                        $v['nome_posizione'] = $locazioni[$key[$v['posizione']]];
                        
                    } else {
                        
                        $v['indossato'] = false;
                    
                    }
                    
                    $temp = $v;
                
                }
                
                $data = $temp;
                
            } else {
                
                $data = false;
            
            }
            
            return $data;           
        
        }
        
        /**
         *  @brief Indossa un oggetto trasportato
         *  
         *  @param [in] $idpooggetto <b>(int)</b> ID dell'oggetto interessato
         */     
        function indossa($idpooggetto)
        {
            //recupera i dati dell'oggetto
            $item = \pg\oggetti\singolo($idpooggetto);
            
            //SE L'OGGETTO NON ESISTE           
            if($item === false) {
                
                //imposta l'operazione come non riuscita
                $op = false;
            
            //SE L'OGGETTO ESISTE
            } else {
                
                //SE SONO IL PROPRIETARIO DELL'OGGETTO
                if(\pg\mio($item['proprietario'])) {
                    
                    //SE L'OGGETTO È TRASPORTATO
                    //ED È INDOSSABILE
                    if(   $item['posizione'] < 2
                       && $item['ubicabile'] >= 2) {
                           
                        //indossa l'oggetto nella locazione predisposta
                        $query = "UPDATE clgpersonaggiooggetto 
                                 SET 
                                     posizione = ? 
                                 WHERE 
                                     idpooggetto = ?";
                        $param = array();
                        $param[] = array(
                            'type'  => PARAM_INT,
                            'value' => $item['ubicabile']
                        );                          
                        $param[] = array(
                            'type'  => PARAM_INT,
                            'value' => $idpooggetto
                        );          
                        
                        $result = \gdrcd\db\stmt($query,$param);                    
                    
                    }
                
                }
            
            }
        
        }
        
        /**
         *  @brief Togli un oggetto trasportato
         *  
         *  @param [in] $idpooggetto <b>(int)</b> ID dell'oggetto interessato
         */     
        function togli($idpooggetto)
        {
            //recupera i dati dell'oggetto
            $item = \pg\oggetti\singolo($idpooggetto);
            
            //SE L'OGGETTO NON ESISTE
            if($item === false) {
                
                //imposta l'operazione come non riuscita
                $op = false;
            
            //SE L'OGGETTO ESISTE
            } else {
                
                //SE SONO IL PROPRIETARIO DELL'OGGETTO
                if(\pg\mio($item['proprietario'])) {
                    
                    //SE L'OGGETTO È TRASPORTATO
                    //ED È INDOSSABILE
                    if(   $item['posizione'] >= 2
                       && $item['ubicabile'] >= 2) {
                           
                        //rimette l'oggetto nello zaino
                        $query = "UPDATE clgpersonaggiooggetto 
                                 SET 
                                     posizione = 1 
                                 WHERE 
                                     idpooggetto = ?";
                        $param = array();
                        $param[] = array(
                            'type'  => PARAM_INT,
                            'value' => $idpooggetto
                        );          
                        
                        $result = \gdrcd\db\stmt($query,$param);                    
                    
                    }
                
                }
            
            }
        
        }       
        
        function __lista($pg,$tipo = 'proprieta')
        {
            
            $locazioni = $GLOBALS['MESSAGE']['interface']['administration']['items']['fit_in'];
            $key = array_keys($locazioni);
            
            $query = "SELECT 
                         po.idpooggetto, 
                         po.nome AS proprietario, 
                         po.cariche, 
                         po.commento, 
                         po.posizione, 
                         o.*, 
                         ot.descrizione AS categoria
                     FROM 
                         clgpersonaggiooggetto AS po 
                     LEFT JOIN oggetto AS o 
                     ON po.id_oggetto = o.id_oggetto 
                     LEFT JOIN 
                         codtipooggetto AS ot 
                     ON o.tipo = ot.cod_tipo 
                     WHERE ";
            
            //SE SONO STATE RICHIESTE LE PROPRIETÀ
            if($tipo != 'equip') {
                
                $query .=  " po.posizione <= 0 ";
            
            //SE È STATO RICHIESTO L'EQUIPAGGIAMENTO INDOSSATO          
            } else {
                
                $query .=  " po.posizione > 0 ";

            }
            
            $query .= "  AND po.nome = ? 
                     ORDER BY 
                         ot.descrizione, 
                         o.nome";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            
            $result = \gdrcd\db\stmt($query,$param);

            if($result['info']['num_rows'] != 0) {
            
                foreach($result['data'] as $v) {
                    
                    if($v['posizione'] >= 2) {
                        
                        $v['indossato'] = true;
                        $v['nome_posizione'] = $locazioni[$key[$v['posizione']]];
                        
                    } else {
                        
                        $v['indossato'] = false;
                    
                    }
                    
                    $data['categorie'][$v['tipo']] = $v['categoria'];
                    $data['oggetti'][$v['id_oggetto']] = $v['nome'];
                    $data['lista'][$v['tipo']][$v['id_oggetto']][] = $v; 
                
                }
            
            }
            return $data;
            
        }
        
        function siluette($pg)
        {
            
            $query = "SELECT 
                         po.idpooggetto, 
                         po.nome AS proprietario, 
                         po.cariche, 
                         po.commento, 
                         po.posizione, 
                         o.*, 
                         ot.descrizione AS categoria
                     FROM 
                         clgpersonaggiooggetto AS po 
                     LEFT JOIN oggetto AS o 
                     ON po.id_oggetto = o.id_oggetto 
                     LEFT JOIN codtipooggetto AS ot 
                     ON o.tipo = ot.cod_tipo 
                     WHERE 
                             po.posizione >= 2 
                         AND po.nome = ? 
                     ORDER BY 
                         ot.descrizione, 
                         o.nome";
            $param = array();
            $param[] = array(
                'type'  => PARAM_STR,
                'value' => $pg
            );          
            
            $result = \gdrcd\db\stmt($query,$param);

            if($result['info']['num_rows'] != 0) {
            
                foreach($result['data'] as $v) {
                    
                    $data[$v['posizione']] = $v;
                
                }
            
            }
            return $data;
            
        }       
        
        function lista($pg) {
            
            return \pg\oggetti\__lista($pg);
            
        }
        
        function equip($pg) {
            
            return \pg\oggetti\__lista($pg,'equip');            
        
        }       
        
    }