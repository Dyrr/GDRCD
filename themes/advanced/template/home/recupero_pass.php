	<h2>Recupero pass</h2>
<?php 
	if(empty($RP_response)) {
?>
		<form action="index.php" method="post">
			<div class="fields">
				<label for="passrecovery"><?php echo $MESSAGE['homepage']['forms']['email']; ?></label>
				<input type="text" id="passrecovery" name="email" />
			</div>
			<div class="submit">
				<input type="submit" value="<?php echo $MESSAGE['homepage']['forms']['new_pass']; ?>" />
			</div>
		</form>
<?php 
	} else {
?>
		<div class="pass_rec">
			<?php echo $RP_response; ?>
		</div>
<?php 
	}