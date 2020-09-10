<?php
/**
 *  @file       pages/_vuoto.inc.php
 *  
 *  @brief      Modulo vuoto da cui partire
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details   Modulo vuoto da usare come base per crearne di nuovi
 */     
    
    //imposta l'op e la view
    $op = isset($_REQUEST['op']) ? $_REQUEST['op'] : 'default';
    $view = $op;

    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALL'OPERAZIONE RICHIESTA
    switch(strtoupper($op)) {

        default :
        
        break;

    }
    
    //OPERAZIONI COMUNIPER LA VIEW
    
    //ESEGUE IL SET DI ISTRUZIONI IN BASE ALLA VIEW RICHIESTA       
    switch(strtoupper($view)) {
        
        default :
        
        break;
    
    }

    //filtra le variabili in uscita in automatico in modo da dover evitare di usare il gdrcd_filter_out ogni volta
    $TAG = \template\filterOut($TAG);
    //CARICA IL TEMPLATE RICHIESTO  
    require \template\file($TAG['template']);