<?php
/**
 *  @file       themes/advanced/template/scheda/storia.php
 *  
 *  @brief      Template della pagina della scheda per la storia del pg
 *  
 *  @version    5.6.0
 *  @date       11/07/2020
 *  
 *  @author     Davide 'Dyrr' Grandi
 *  
 *  @details i tag che possono essere in bbcode o html puro in base alle impostazioni sono gia filtrati nella pagina 
 *  della logica della scheda non è un errore se qui non sono filtrati prima di essere stampati non rifiltrateli 
 *  
 *  @see        pages/scheda/scheda.inc.php
 *  
 *  @todo       effettuare i cambi pagina tramite ajax
 */
 
 //separa in due gli elementi dell'elenco skill per poterli in due sezioni.
 //fatto qui e non nella parte di logica del template per permettere al web designer di decidere in autonomia in quante
 //sezoni dividere le skill
	$TAG['page']['skill'] = array_chunk($TAG['page']['skill'], 3, true);
	$TAG['page']['stats1'] = array_chunk($TAG['page']['stats'], 3, true);
?>
    <section class="scheda">
        <?php require \template\file('scheda/nav'); // include il template del menù di navigazione ?>
        <div class="ajax">
            <div class="skill_list">
<?php
                //SE È ABILITATO IL SISTEMA DI CARATTERISTICHE DEL PG
                if($TAG['page']['section']['stat'] === true) {
                     // include il template delle catatteristiche 
?>
                    <?php require \template\file('scheda/statistiche');?>
<?php
                }
?>               
<?php
                //SE È ABILITATO IL SISTEMA DI ABILITÀ DEL PG
                if($TAG['page']['section']['skill'] === true) {
                     // include il template delle skill 
?>
                    <?php require \template\file('scheda/skill'); ?>
<?php
                }
?>
            </div>
        </div>
    </section>