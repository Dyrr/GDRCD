<?php
/**
 *  @file       index.php
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

    //definizione della sezione da caricare
    $page = ( ! empty($_GET['page'])) ? gdrcd_filter('include', $_GET['page']) : 'index';

    //include la parte con la logica della pagina
    require modulo\file('home/' . $page);

    //chiude la connesisone al database
    gdrcd_close_connection($handleDBConnection);

    //pulizia variabili
    unset($MESSAGE);
    unset($PARAMETERS);

    //stampa a video la pagina
    \template\render($OUT);