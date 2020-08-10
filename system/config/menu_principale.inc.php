<?php
/**
 *  @file       system/config/menu_principale.inc.php
 *  
 *  @brief      file le voci del menù principale del gdrcd
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @note       Se si vuole usare delle immagini per il menù, semplicemente lasciare in bianco il campo text e gestite 
 *  il menu tramite i css
 *  
 *  @todo       passare il menu da file a database gestibile tramite interfaccia
 *  @todo       fare un css di esempio per il menu con immagini
 */  

    $PARAMETERS['menu']['refresh']['text'] = '<i class="fas fa-sync"></i> Aggiorna';
    $PARAMETERS['menu']['refresh']['url'] = 'main.php?dir=' . $_SESSION['luogo'];
    $PARAMETERS['menu']['refresh']['function'] = 'main';

    $PARAMETERS['menu']['map']['text'] = '<i class="fas fa-map"></i> Mappa';
    $PARAMETERS['menu']['map']['url'] = 'main.php?page=mappaclick&map_id=' . $_SESSION['mappa'];
    $PARAMETERS['menu']['map']['function'] = 'main';

    $PARAMETERS['menu']['profile']['text'] = '<i class="fas fa-user"></i> Scheda';
    $PARAMETERS['menu']['profile']['url'] = 'main.php?page=scheda__scheda&pg=' . $_SESSION['login'];
    $PARAMETERS['menu']['profile']['function'] = 'scheda';

    $PARAMETERS['menu']['forum']['text'] = '<i class="fas fa-hashtag"></i> Bacheca';
    $PARAMETERS['menu']['forum']['url'] = 'main.php?page=forum';
    $PARAMETERS['menu']['forum']['function'] = 'main';

    if ($_SESSION['permessi'] >= MODERATOR) {
        
        $PARAMETERS['menu']['backend']['text'] = '<i class="fas fa-cogs"></i> Gestione';
        $PARAMETERS['menu']['backend']['url'] = 'main.php?page=gestione';
        $PARAMETERS['menu']['backend']['function'] = 'main';    
    
    }

    $PARAMETERS['menu']['services']['text'] = '<i class="fas fa-tools"></i> Servizi';
    $PARAMETERS['menu']['services']['url'] = 'main.php?page=uffici';
    $PARAMETERS['menu']['services']['function'] = 'main';

    $PARAMETERS['menu']['user_services']['text'] = '<i class="fas fa-user-cog"></i> Menu utente';
    $PARAMETERS['menu']['user_services']['url'] = 'main.php?page=utenti';
    $PARAMETERS['menu']['user_services']['function'] = 'main';

    $PARAMETERS['menu']['quit']['text'] = '<i class="fas fa-power-off"></i> Esci';
    $PARAMETERS['menu']['quit']['url'] = 'logout.php';
    $PARAMETERS['menu']['quit']['function'] = 'main';