<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
?>

<form method="post" action="<?php print'../script/scriptControlloLoginAdmin.php';?>">
	<fieldset><legend>Login</legend>		
		<div class="label"><label >Username</label></div>
		<input type="text" name="username" class="obbligatorio" /><br />
        <div class="label"><label >Password</label></div>
		<input type="password" name="password" class="obbligatorio" /><br />
		<br /><input type="submit" class="invia" value="Conferma"></input>
	</fieldset>
</form>

<?php include HOME_ROOT.'/html/coda.html';?>