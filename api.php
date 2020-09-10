<?php
/**
 *  @file       api.php
 *  
 *  @brief      File index del GDRCD
 *  
 *  @version    5.6.0
 *  @date       1/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 */    
    define('ROOT', __DIR__);

    //Includo i parametri, la configurazione, la lingua e le funzioni
    require_once ROOT . '/system/inc/required.php';

    //include la parte con la logica della pagina
    require modulo\file('home/api/api');

    //pulizia variabili
    unset($MESSAGE);
    unset($PARAMETERS);

    //stampa a video la pagina
    \template\render($OUT,$TAG['render']['mode']);