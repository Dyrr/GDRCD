	<div class="error">
		<h2>Elenco errori</h2>
		<ol>
<?php
			foreach($TAG['page']['errors'] as $v) {
?>
				<li>Errore <?php echo gdrcd_filter_num($v['code']); ?>: <?php echo gdrcd_filter_out($v['testo']); ?></li>
<?php
			}
?>
		</ol>
	</div>