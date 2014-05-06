<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
$query = sprintf("INSERT INTO tblcategorie(nome) VALUE ('%s')",$_POST['nome']);
$dati = eseguiQuery($connessione,$query);

chiudiConnessione($connessione);

print '<p class="successo">'."L'inserimento della categoria è avvenuto correttamente</p>";

include HOME_ROOT . '/html/coda.html';
?>