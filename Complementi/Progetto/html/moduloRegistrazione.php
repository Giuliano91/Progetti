<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
?>

<form enctype="multipart/form-data" method="post" action="../script/scriptInserimentoUtente.php">
	<fieldset><legend>Informazioni Utente</legend>
        <div class="label"><label >Nome</label></div>
        <input type="text" name="nome" class="obbligatorio"></input><br />
        <div class="label"><label >Cognome</label></div>
        <input type="text" name="cognome" class="obbligatorio"></input><br />
        <div class="label"><label >Data Nascita</label></div>
		<input type="text" name="datanascita" class="obbligatorio" id="calendario"></input><br />
		<div class="label"><label >Indirizzo</label></div>
		<input type="text" name="indirizzo" class="obbligatorio" /><br />
		<div class="label"><label >Email</label></div>
		<input type="text" name="email" class="obbligatorio"/><br />
		<div class="label"><label >Telefono</label></div>
		<input type="text" name="telefono" class="obbligatorio"/><br />
		<div class="label"><label >Username</label></div>
		<input type="text" name="username" class="obbligatorio"/><br />
		<div class="label"><label >Password</label></div>
		<input type="password" name="password" class="obbligatorio"/><br />
		<div class="label"><label >Codice Fiscale</label></div>
        <input type="text" maxlength="16" name="codicefiscale" id="codicefiscale"/><br />
        <br /><input type="submit" class="invia" value="Conferma"></input>
	</fieldset>
</form>

<?php include HOME_ROOT.'/html/coda.html';?>