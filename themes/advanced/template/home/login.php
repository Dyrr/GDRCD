		<h2>Login</h2>
		<form action="login.php" id="do_login"
			  method="post"
<?php
			  if($PARAMETERS['mode']['popup_choise'] == 'ON') {

				  echo ' onsubmit="check_login(); return false;"';
			  }?>>
			<div class="fields">
				<label for="username"><?php echo $MESSAGE['homepage']['forms']['username']; ?></label>
				<input type="text" id="username" name="login1" />
				<label for="password"><?php echo $MESSAGE['homepage']['forms']['password']; ?></label>
				<input type="password" id="password" name="pass1" />
<?php 
				if($PARAMETERS['mode']['popup_choise'] == 'ONN') {
?>
					<label for="allow_popup"><?php echo $MESSAGE['homepage']['forms']['open_in_popup']; ?></label>
					<input type="checkbox" id="allow_popup" />
					

<?php 
				}
?>
			</div>
			<div class="submit">
				<input type="hidden" value="0" name="popup" id="popup">
				<input type="submit" value="<?php echo $MESSAGE['homepage']['forms']['login']; ?>" />
			</div>
		</form>