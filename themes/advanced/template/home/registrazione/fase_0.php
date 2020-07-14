<section class="iscrizione">
	<h1><?php echo gdrcd_filter('out', $MESSAGE['register']['page_name']); ?></h1>
	<h2>Fase 0</h2>
	<article class="disclaimer_iscrizione">
		<?php echo gdrcd_filter('out', $MESSAGE['register']['disclaimer']); ?>
	</article>
	<article class="disclaimer_iscrizione">
		<?php echo gdrcd_filter('out', $MESSAGE['register']['rules_read']); ?>
	</article>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']; ?>"	method="post">
		<div class="submit">
			<input type="hidden" name="fase" value="1"/>
			<input type="submit" value="<?php echo gdrcd_filter('out', $MESSAGE['register']['forms']['accept']); ?>"/>
		</div>
	</form>
	<form action="index.php" method="post">
		<div class="submit">
			<input type="submit" value="<?php echo gdrcd_filter('out', $MESSAGE['register']['forms']['refuse']); ?>"/>
		</div>
	</form>
</section>