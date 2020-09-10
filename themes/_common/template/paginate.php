		<div class="pager">
<?php 
			if($TAG['status'] === true) {
?>
				<h2>Vai a pagina</h2>
<?php
				
				for($i = 0; $i <= $TAG['numero']; $i++) {
					
					if($i != $_REQUEST['offset']) {
?>
						<a href="<?php rawout($TAG['url']); ?>&offset=<?php out($i); ?>">
							<?php out(($i + 1)); ?>
						</a>
<?php 
					} else {
?>						
						 <?php out(($i + 1)); ?> 
<?php					
					}
				
				} //for
			
			}//if
?>
		</div>