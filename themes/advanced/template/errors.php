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
						Errore <?php isset($v['code']) ? out($v['code']) : ''; ?>: 
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
			<h2>Risultato</h2>
			<ol>
<?php
				foreach($TAG['page']['errors'] as $v) {
?>
					<li>
						Errore <?php isset($v['code']) ? out($v['code']) : ''; ?>: 
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
						Errore <?php isset($v['code']) ? out($v['code']) : ''; ?>: 
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
				foreach($TAG['page']['warning'] as $v) {
?>
					<li>
						<?php echo out($v['testo']); ?>
					</li>
<?php
				}
?>
			</ol>
		</div>
<?php
	}	