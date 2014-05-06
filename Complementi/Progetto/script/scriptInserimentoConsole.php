<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
if(trim($_POST['produttore'])==''){
    $query = sprintf("INSERT INTO tblconsole(nome) VALUE ('%s')",$_POST['nome']);
} else {
    $query = sprintf("INSERT INTO tblconsole(nome,produttore) VALUE ('%s','%s')",$_POST['nome'],$_POST['produttore']);
}
$dati = eseguiQuery($connessione,$query);

chiudiConnessione($connessione);

print '<p class="successo">'."L'inserimento della console è avvenuto correttamente</p>";

include HOME_ROOT . '/html/coda.html';
?>