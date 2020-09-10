<?php
/**
 *  @file       themes/_common/template/mappa/info_location.php
 *  
 *  @brief      Template per il menù principale della land
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */
    defined('GDRCD') OR exit('Non è permesso accesso diretto ai template'); 
?>
	<div class="info_location">
		<div class="page_title">
			<h2 style="white-space:nowrap;"><?php out($TAG['page']['dati']['luogo']); ?></h2>
		</div>
		<div class="img_wrapper">
<?php
			//SE È UNA MAPPA
			if($TAG['page']['dati']['type'] == 'map') {
				//visualizza il riquadro cliccabile per la mappa
?>				
				<a href="main.php?page=info_location&op=map_details&id=<?php out($TAG['page']['dati']['id']); ?>" data-function="dialog">
					<img src="themes/advanced/imgs/maps/<?php out($TAG['page']['dati']['urlimg']); ?>" alt="<?php out($TAG['page']['dati']['luogo']); ?>" />
				</a>
<?php
			//SE È UNA LOCAIZONE
			} else {
				//visualizza il riquadro cliccabile per l alocaizone
?>
				<a href="main.php?page=info_location&op=locations_details&id=<?php out($TAG['page']['dati']['id']); ?>" data-function="dialog">
					<img src="themes/advanced/imgs/locations/<?php out($TAG['page']['dati']['urlimg']); ?>" alt="<?php out($TAG['page']['dati']['luogo']); ?>" />
				</a>
<?php
			}
?>
		</div>
	</div>