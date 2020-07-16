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
 $i = 0;
?>
    <section class="scheda">
        <?php require \template\file('scheda/nav'); // include il template del menù di navigazione ?>
        <div class="ajax">
			<div class="skill_list">
			<div class="single">
			<h2>Skill</h2>
			PX: <?php echo gdrcd_filter_num($TAG['page']['pg']['esperienza'] - $TAG['page']['pg']['esperienza_spesa']); ?>/<?php echo gdrcd_filter_num($TAG['page']['pg']['esperienza']); ?>
			
			</div>
<?php //var_dump($TAG['page']['skill']); ?>			
<?php
			foreach($TAG['page']['skill'] as $v) {
?>
<?php
				if($v['first'] === true) {
					$i = $i + 1;
?>
<?php
					if($i == 4) {
?>
						</div>
<?php
					}
?>
<?php
					if($i == 1 || $i == 4) {
?>
						<div class="pair">
<?php
					}
?>
					<h2><?php echo gdrcd_filter_out($PARAMETERS['names']['stats']['car'.$v['car']]); ?></h2>
<?php
				}
?>
					<div class="item">
						<div>
							<?php echo gdrcd_filter_out($v['nome']); ?>
						</div>
						<div>
							<i class="far fa-minus-square"></i>
							<i class="far fa-plus-square"></i>
						</div>
						<div>
							<progress value="<?php echo gdrcd_filter_out($v['grado']); ?>" max="10" />
						</div>
						<div><?php echo gdrcd_filter_out($v['grado']); ?></div>
					</div>
<?php
			}
?>
			</div>
			
			</div>
		</div>
    </section>