<?php
		$text = $GLOBALS['MESSAGE']['homepage']['forms'];
?>
		<h2>Login</h2>
		<form action="index.php?page=login__access" id="do_login"
			  method="post"
<?php
			  if($GLOBALS['PARAMETERS']['mode']['popup_choise'] == 'ON') {

				  echo ' onsubmit="check_login(); return false;"';
			  }?>>
			<div class="fields">
				<label for="username"><?php out($text['username']); ?></label>
				<input type="text" id="username" name="login1" />
				<label for="password"><?php out($text['password']); ?></label>
				<input type="password" id="password" name="pass1" />
<?php 
				if($GLOBALS['PARAMETERS']['mode']['popup_choise'] == 'ONN') {
?>
					<label for="allow_popup"><?php out($text['open_in_popup']); ?></label>
					<input type="checkbox" id="allow_popup" />
					

<?php 
				}
?>
			</div>
			<div class="submit">
				<input type="hidden" value="0" name="popup" id="popup" />
				<input type="hidden" value="login" name="op" />
				<input type="submit" value="<?php out($text['login']); ?>" />
			</div>
		</form>