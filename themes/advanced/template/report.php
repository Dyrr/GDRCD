<?php 
	if(isset($TAG['page']['errors'])) {
?>
		<div class="error">
			<h2>Elenco errori</h2>
			<ol>
<?php
				foreach($TAG['page']['errors'] as $v) {
?>
					<li>
<?php
						if(isset($v['code'])) {
?>
							Errore <?php out($v['code']); ?>:
<?php
						}
?>
						<?php echo out($v['testo']); ?>
					</li>
<?php
				}
?>
			</ol>
		</div>
<?php
	}
	if(isset($TAG['page']['completed'])) {
?>
		<div class="completed">
			<h2>Report</h2>
			<ol>
<?php
				foreach($TAG['page']['completed'] as $v) {
?>
					<li>
<?php
						if(isset($v['code'])) {
?>
							Code <?php out($v['code']); ?>:
<?php
						}
?>
						<?php echo out($v['testo']); ?>
					</li>
<?php
				}
?>
			</ol>
		</div>
<?php
	}		
	if(isset($TAG['page']['warning'])) {
?>
		<div class="warning">
			<h2>Warning</h2>
			<ol>
<?php
				foreach($TAG['page']['warning'] as $v) {
?>
					<li>
<?php
						if(isset($v['code'])) {
?>
							Errore <?php out($v['code']); ?>:
<?php
						}
?>
						<?php echo out($v['testo']); ?>
					</li>
<?php
				}
?>
			</ol>
		</div>
<?php
	}
	if(isset($TAG['page']['results'])) {
?>
		<div class="completed">
			<ol>
<?php
				foreach($TAG['page']['results'] as $v) {
?>
					<li>
<?php
						if(isset($v['code'])) {
?>
							Code <?php out($v['code']); ?>:
<?php
						}
?>
						<?php echo out($v['testo']); ?>
					</li>
<?php
				}
?>
			</ol>
		</div>
<?php
	}
	if(isset($TAG['page']['link_back'])) {
?>
		<div class="tc">
			<div class="button">
<?php
				foreach($TAG['page']['link_back'] as $v) {
?>				
					<a href="<?php rawout($v['url']); ?>">
						<?php out($v['testo']); ?>
					</a>
				<div class="break"></div>
<?php
				}
?>				
			</div>
		</div>
<?php
	}