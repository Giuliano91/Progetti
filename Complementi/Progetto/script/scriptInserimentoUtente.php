<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT.'/script/funzioni.php';

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
$query = sprintf("INSERT INTO tblUtenti(codicefiscale, nome, cognome, datanascita, indirizzo, email, telefono, user, psw, dirittoamministratore) VALUE ('%s','%s','%s','%s','%s','%s','%s','%s','%s','%s')", strtoupper($_POST['codicefiscale']), $_POST['nome'], $_POST['cognome'], $_POST['datanascita'], $_POST['indirizzo'], $_POST['email'], $_POST['telefono'], $_POST['username'],sha1($_POST['password']),"no");
$dati = eseguiQuery($connessione,$query);
chiudiConnessione($connessione);

print '<p class="successo">'."L'inserimento dell'utente è avvenuto correttamente</p>";

include HOME_ROOT . '/html/coda.html';
?>