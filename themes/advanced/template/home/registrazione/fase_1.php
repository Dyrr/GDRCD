<section class="iscrizione">
	<h1><?php echo gdrcd_filter('out', $MESSAGE['register']['page_name']); ?></h1>
	<h2>Fase 1</h2>
	<form action="<?php echo $_SERVER['SCRIPT_NAME'] . '?' . $_SERVER['QUERY_STRING']; ?>" method="post">
	<div class="fields">
		<label><?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['email']); ?></label>
		<input type="text" name="email" value="<?php echo gdrcd_filter('email', $_POST['email']); ?>" />
	
		<div class="form_info">
			<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['email_info']); ?>
		</div>
		
		<label>Nome</label>
		<input type="text" name="nome" 
		       value="<?php echo gdrcd_filter('out', $_POST['nome']); ?>" placeholder="None del personaggio" />
		<div class="form_info">
			<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['name_info']); ?>
		</div>
		
		<label>Cognome</label>
		<input type="text" name="cognome" 
			   value="<?php echo gdrcd_filter('out', $_POST['cognome']); ?>"  placeholder="None del personaggio" />
		<div class="form_info">
			<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['name_info']); ?>
		</div>


		<label>Sesso</label>
		<select name="genere">
			<option value="m" <?php if (gdrcd_filter('get', $_POST['genere']) == 'm')
			{
				echo 'SELECTED';
			} ?> >
				<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['gender_m']); ?>
			</option>
			<option value="f" <?php if (gdrcd_filter('get', $_POST['genere']) == 'f')
			{
				echo 'SELECTED';
			} ?> >
				<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['gender_f']); ?>
			</option>
		</select>

		<label>Razza</label>
		<select name="razza">
<?php 
			foreach($TAG['page']['razze'] as $v) {
?>
				<option value="<?php echo $v['id_razza']; ?>" 
						<?php echo ($_POST['razza'] == $v['id_razza']) ? 'selected' : ''; ?>>
					<?php echo gdrcd_filter_out($v['nome_razza']); ?>
				</option>
<?php 
			}
?>
		</select>
<?php 
		if ($PARAMETERS['mode']['racialinfo'] == 'ON') { 
?>
			<div class="form_info">
				<a href="ambientazione.php?page=user_razze" target="_new">
					<?php echo gdrcd_filter('out', $MESSAGE['register']['fields']['race_info']); ?>
				</a>
			</div>
<?php 
		}
?>



<?php
		foreach($TAG['page']['pg_stat'] as $k => $v) {
?>
			<label><?php echo gdrcd_filter_out($v); ?></label>
			<select name="<?php echo gdrcd_filter_out($k); ?>">
<?php 
				for ($i = 1; $i <= $PARAMETERS['settings']['initial_cars_cap']; $i++) {
?>
					<option value="<?php echo $i; ?>" <?php echo ($_POST[$k]) == $i ? 'selected' : ''; ?>>
						<?php echo $i; ?>
					</option>
<?php 
				}
?>
			</select>
<?php
		}
?>
		<div class="form_info">
			<?php echo gdrcd_filter('out',
				$MESSAGE['register']['fields']['stats_info'] . ' ' . $PARAMETERS['settings']['cars_sum']); ?>
		</div>
	</div>	
		<div class="submit">
			<input type="hidden" name="fase" value="2"/>
			<input type="submit" value="<?php echo gdrcd_filter('out', $MESSAGE['register']['forms']['next']); ?>"/>
		</div>


	</form>
	<form action="index.php" method="post">
		<div class="submit">
			<input type="submit" value="<?php echo gdrcd_filter('out', $MESSAGE['register']['forms']['abort']); ?>"/>
		</div>
	</form>
 </section>