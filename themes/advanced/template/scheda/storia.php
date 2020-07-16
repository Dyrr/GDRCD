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
 *  @todo		effettuare i cambi pagina tramite ajax
 */     
?>
    <section class="scheda">
        <?php require \template\file('scheda/nav'); // include il template del menù di navigazione ?>
        <div class="ajax">
			<h2>Storia</h2>
			<?php echo $TAG['page']['pg']['affetti']; ?>
		</div>
    </section>