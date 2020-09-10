<?php
/**
 *  @file       system/inc/functions/game_engine/interlock/personaggio/soldi.inc.php
 *  
 *  @brief      Set di funzioni per le operazioni sul denaro del pg
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
    
    namespace pg\soldi {

        /**
         *  @brief Recupero finanze del pg
         *  
         *  @param [in] $nome <b>(int)</b> ID univoco del pg
         *  
         *  @return <b>(array)</b> array contenente le finanze (soldi e banca) del pg
         *  
         *  @details La funzione recupera le finanze del pg
         */        
        function get($idpg)
        {
            
            //recupero delle finanze del pg
            $query = "SELECT
                         soldi, 
                         banca 
                     FROM personaggio 
                     WHERE 
                         idpg = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $result = \gdrcd\db\stmt($query,$param);
            
            //SE NON È STATO TROVATO IL PG
            if($result['info']['num_rows'] == 0) {
                
                //imposta a false i dati
                $data = false;
                
            //SE È STATO TROVATO IL PG
            } else {
                
                //recupera i dati
                $data = $result['data'][0];
            
            }
            
            //restituisce i dati
            return $data;
          
        }
        
        /**
         *  @brief Recupera i soldi trasportati dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  
         *  @return <b>(int)</b> i soldi trasportati dal pg
         *  
         *  @details La funzione recupera i soldi trasportati dal pg
         */         
        function soldiGet($idpg)
        {
            
            //recupera i dati delle finanze del pg
            $data = \pg\soldi\get($idpg);
            
            //SE NON È STATO TROVATO IL PG
            if($data === false) {
                
                //imposta i dati a false;
                return $data;
                
            //SE È STATO TROVATO IL PG
            } else {
                
                //restituisce i soldi trasportati dal pg
                return $data['soldi'];
            
            }           
            
        }
        
        /**
         *  @brief Recupera i soldi in banca dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  
         *  @return <b>(int)</b> i soldi in banca dal pg
         *  
         *  @details La funzione recupera i soldi in banca dal pg
         */         
        function bancaGet($idpg)
        {
            
            //recupera i dati delle finanze del pg
            $data = \pg\soldi\get($idpg);
            
            //SE NON È STATO TROVATO IL PG
            if($data === false) {
                
                //imposta i dati a false;
                return $data;
                
            //SE È STATO TROVATO IL PG
            } else {
                
                //restituisce i soldi in banca dal pg
                return $data['banca'];
            
            }           
            
        }
        
        /**
         *  @brief Aggiorna i soldi trasportati dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  @param [in] $soldi <b>(int)</b> la somma di denaro da aggiornare
         */     
        function soldiUpdate($idpg,$soldi)
        {
            
            $query = "UPDATE personaggio 
                     SET 
                         soldi = soldi + ? 
                     WHERE 
                         idpg = ? 
                     LIMIT 1";
            $param =array();
            $param[] = array(
                'value' => $soldi,
                'type'  => PARAM_INT
            
            );          
            $param[] = array(
                'value' => $idpg,
                'type'  => PARAM_INT
            
            );               
            $result = \gdrcd\db\stmt($query,$param);            
            
        }
    
        /**
         *  @brief Aggiorna i soldi in banca dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  @param [in] $soldi <b>(int)</b> la somma di denaro da aggiornare
         */         
        function bancaUpdate($idpg,$soldi)
        {
            
            $query = "UPDATE personaggio 
                     SET 
                         banca = banca + ? 
                     WHERE 
                         idpg = ? 
                     LIMIT 1";
            $param =array();
            $param[] = array(
                'value' => $soldi,
                'type'  => PARAM_INT
            
            );          
            $param[] = array(
                'value' => $idpg,
                'type'  => PARAM_INT
            
            );               
            $result = \gdrcd\db\stmt($query,$param);            
            
        }

        /**
         *  @brief Imposta i soldi trasportati dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  @param [in] $soldi <b>(int)</b> la somma di denaro da aggiornare
         */         
        function soldiSet($idpg,$soldi)
        {
            
            $query = "UPDATE personaggio 
                     SET 
                         soldi = ? 
                     WHERE 
                         idpg = ? 
                     LIMIT 1";
            $param =array();
            $param[] = array(
                'value' => $soldi,
                'type'  => PARAM_INT
            
            );          
            $param[] = array(
                'value' => $idpg,
                'type'  => PARAM_INT
            
            );               
            $result = \gdrcd\db\stmt($query,$param);            
            
        }

        /**
         *  @brief Imposta i soldi in banca dal pg
         *  
         *  @param [in] $idpg <b>(int)</b> ID univoco del pg
         *  @param [in] $soldi <b>(int)</b> la somma di denaro da aggiornare
         */         
        function bancaSet($idpg,$soldi)
        {
            
            $query = "UPDATE personaggio 
                     SET 
                         banca = ? 
                     WHERE 
                         idpg = ? 
                     LIMIT 1";
            $param =array();
            $param[] = array(
                'value' => $soldi,
                'type'  => PARAM_INT
            
            );          
            $param[] = array(
                'value' => $idpg,
                'type'  => PARAM_INT
            
            );               
            $result = \gdrcd\db\stmt($query,$param);            
            
        }

        function stipendioGet($idpg)
        {
            
            $stipendio = 0;
            
            $query = "SELECT 
                        r.stipendio 
                     FROM clgpersonaggioruolo AS pgr 
                     LEFT JOIN ruolo AS r 
                     ON 
                        pgr.id_ruolo = r.id_ruolo 
                     WHERE 
                        pgr.personaggio = ?";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $result = \gdrcd\db\stmt($query,$param);            
            
            if($result['info']['num_rows'] != 0) {
                
                foreach($result['data'] as $v) {
                    
                    $stipendio = $stipendio + $v['stipendio'];
                
                }
                
            }           
            
            return $stipendio;          
        
        }
        
        function stipendioSet($idpg) {
            
            //recupera l'intervallo dello stipendio
            $intervallo = $GLOBALS['ARAMETERS']['stipendio']['intervallo'];
            
            //imposta l'intervallo dello stipoendio per la query
            switch(strtoupper($intervallo)) {
                
                case 'SETTIMANALE' :
                
                    $query_interval = '1 WEEK';
                
                break;
                
                case 'MENSILE' :
                
                    $query_interval = '1 MONTH';
                
                break;
                
                case 'GIORNALIERO' :
                default :
                
                    $query_interval = '1 DAY';
                
                break;
            
            }
            
            //seleziona se il pg ha ritirato lo stipendio per l'intervallo selezionato
            $query = "SELECT 
                        IF(DATE_ADD(ultimo_stipendio, INTERVAL " . $query_interval . " > NOW()),0,1) AS stipendio   
                     FROM personaggio 
                     WHERE 
                        idpg = ? 
                     LIMIT 0,1";
            $param = array();
            $param[] = array(                   
                'type'  => PARAM_INT,
                'value' => $idpg
            );          
            $result = \gdrcd\db\stmt($query,$param);
            
            //SE IL PG NON HA RITIRATO LO STIPENDIO
            if($result['data'][0]['stipendio'] == 1) {

                //recupera il valore dello stipendio
                $stipendio = \pg\soldi\stipendioGet($nome);
                
                //aggiorna i soldi in banca del pg
                \pg\soldi\bancaUpdate($idpg,$stipendio);
                
                //prepara i dati per l'inserimento dell'evento nei log
                $dati_log = array(
                    'interessato' => $idpg,
                    'autore' => '3', 
                    'categoria' => SOLDI, 
                    'codice' => STIPENDIO, 
                    'txt' => '',
                );

                //inserisce l'evento nel log
                \log\insert($dati_log);                 
            
            }           
            
        }       
    
    }