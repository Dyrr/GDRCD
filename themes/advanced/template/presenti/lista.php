<?php
/**
 *  @file       themes/advanced/template/presenti/index.php
 *  
 *  @brief      Template della padina principale dei presenti
 *  
 *  @version    5.6.0
 *  @date       dyrr/dyrr/dyrr
 *  
 *  @author     Davide 'Dyrr' Grandi
 */     
?>
			<ul>
<?php
				//CICLA L'ELENCO DEI PG
				foreach($TAG['lista'] as $v) {
?>
					<li>
						<i class="<?php out($v['icona_permessi']); ?>"></i> 
<?php
						if($v['sesso'] == 'm') {
?>
							<i class="fas fa-mars"></i> 
<?php
						} else {
?>
							<i class="fas fa-venus"></i> 
<?php
						}
?>
						<a href="main.php?page=presenti&op=disponibile&dispo=<?php url($v['new_status']); ?>" 
						   data-function="ajax_link" 
						   data-target=".modulo.presenti" 
						   data-delay="none">
							<div class="status status_<?php out($v['disponibile']); ?>"></div> 
						</a>
						<a href="main.php?page=scheda__scheda&pg=<?php url($v['nome']); ?>" data-function="main" style="white-space:nowrap;">
							<?php out($v['nome_completo']); ?> 
						</a>
<?php
						if($v['set_invisibility'] == true) {
?>
							<a href="main.php?page=presenti&op=invisibility" 
							   data-function="ajax_link" 
							   data-target=".modulo.presenti" 
							   data-delay="none">
								<i class="fas fa-eye<?php ($v['is_invisible'] == 0) ? '' : out('-slash'); ?>"></i>
							</a>
<?php
						} else {
?>
							<i class="fas fa-eye<?php ($v['is_invisible'] == 0) ? '' : '-slash'; ?>"></i>
<?php
						}
?>
					</li>
<?php
				}
?>
			<ul>