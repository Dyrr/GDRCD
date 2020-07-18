   <div class="single">
		<h2>Caratteristiche</h2>
	</div>
	<div class="break"></div>                
<?php
	//CICLA I BLOCCKI DELLE STATISTICHE
	foreach($TAG['page']['stats1'] as $block) {
?>
		<div class="block">
<?php
			//CICLA LE STATISTICHE
			foreach($block as $stat) {
				
				//inserendo il titolo della statistica
?>
				<div class="item">
					<div>
						<?php echo gdrcd_filter_out($stat); ?>
					</div>
					<div>
						<i class="far fa-minus-square"></i>
						<i class="far fa-plus-square"></i>
					</div>
					<div>
						<progress value="<?php echo gdrcd_filter_out($TAG['page']['pg']['car' . $i]); ?>" max="10" />
					</div>
					<div><?php echo gdrcd_filter_out($TAG['page']['pg']['car' . $i]); ?></div>
				</div>					
<?php
				$i = $i + 1;
			}
?>					
		</div>
<?php
	}