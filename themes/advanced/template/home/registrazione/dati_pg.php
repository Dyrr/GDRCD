<?php
/**
 *  @file       themes/advanced/template/home/registrazione/dati_pg.php
 *  
 *  @brief      Set di input con i dati del personaggio da passare da pagina a pagina durante l'iscrizione
 *  
 *  @version    5.6.0
 *  @date       14/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details    Il template contiene tutti quei tag input che verranno usati per passare i dati della creazione del 
 *  personaggio da pagina a pagina della registrazione. Sono stati separati dalle altre pagine per far si che se 
 *  vengono aggiunti dei campi da passare da una pagina all'altra una volta selezionati basti aggiungerli solo su 
 *  quest.
 */ 
   defined('GDRCD') OR exit('Non è permesso accesso diretto ai template');
?> 
    <input type="hidden" name="email" value="<?php echo gdrcd_filter_out($_REQUEST['email']) ?>" />
    <input type="hidden" name="nome" value="<?php echo gdrcd_filter_out($_REQUEST['nome']) ?>" />
    <input type="hidden" name="cognome" value="<?php echo gdrcd_filter_out($_REQUEST['cognome']) ?>" />
    <input type="hidden" name="genere" value="<?php echo gdrcd_filter_out($_REQUEST['genere']) ?>" />
    <input type="hidden" name="razza" value="<?php echo gdrcd_filter_num($_REQUEST['razza']) ?>" />
    <input type="hidden" name="car0" value="<?php echo gdrcd_filter_num($_REQUEST['car0']) ?>" />
    <input type="hidden" name="car1" value="<?php echo gdrcd_filter_num($_REQUEST['car1']) ?>" />
    <input type="hidden" name="car2" value="<?php echo gdrcd_filter_num($_REQUEST['car2']) ?>" />
    <input type="hidden" name="car3" value="<?php echo gdrcd_filter_num($_REQUEST['car3']) ?>" />
    <input type="hidden" name="car4" value="<?php echo gdrcd_filter_num($_REQUEST['car4']) ?>"/>
    <input type="hidden" name="car5" value="<?php echo gdrcd_filter_num($_REQUEST['car5']) ?>" />