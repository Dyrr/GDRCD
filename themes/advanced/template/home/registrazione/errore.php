<section class="iscrizione">
	<h1><?php echo gdrcd_filter_out($MESSAGE['register']['page_name']); ?></h1>
	<h2>Errore</h2>
<?php 
	//include il template comune per la visualizzazione degli errori
	require \template\file('errors');
?>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post">
		<div class="submit">
			<input type="hidden" name="fase" value="1"/>
<?php 
			//include il template con i dati del personagigo da passare tramite input hidden
			require \template\file('home/registrazione/dati_pg');
?>
			<input type="submit" value="<?php echo gdrcd_filter_out($MESSAGE['register']['forms']['try_again']); ?>" />
		</div>
	</form>
</section>