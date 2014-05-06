<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT.'/html/testa.php';

$connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);

if(trim($_POST['produttore'])==''){
    $query = sprintf("UPDATE tblconsole SET nome='%s', produttore=NULL WHERE nome='%s'", $_POST['nome'],$_POST['nomeOld']);
} else {
    $query = sprintf("UPDATE tblconsole SET nome='%s', produttore='%s' WHERE nome='%s'", $_POST['nome'],$_POST['produttore'],$_POST['nomeOld']);
}

$dati = eseguiQuery($connessione,$query);

chiudiConnessione($connessione);

print '<p class="successo">La modifica della categoria è avvenuta correttamente</p>';

include HOME_ROOT.'/html/coda.html';
?>