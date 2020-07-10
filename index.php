<?php
    define('ROOT', __DIR__);

    //Includo i parametri, la configurazione, la lingua e le funzioni
    require_once ROOT . '/includes/required.php';

    $query =    "SELECT 
                    COUNT(nome) AS online 
                FROM personaggio 
                WHERE 
                        ora_entrata > ora_uscita 
                    AND DATE_ADD(ultimo_refresh, INTERVAL 4 MINUTE) > NOW()";   
    $users = gdrcd_query($query);

    //definizione della sezione da caricare
    $page = ( ! empty($_GET['page'])) ? gdrcd_filter('include', $_GET['page']) : 'index';

    //include la parte con la logica della pagina
    require modulo\file('home/' . $page);

    gdrcd_close_connection($handleDBConnection);

    unset($MESSAGE);
    unset($PARAMETERS);

    echo $OUT['header'];    
    echo $OUT['layout_top'];    
    echo $OUT['content'];   
    echo $OUT['layout_bottom'];     
    echo $OUT['footer'];