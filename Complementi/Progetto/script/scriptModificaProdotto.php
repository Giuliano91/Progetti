<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT . '/script/funzioni.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);

//Se l'indice è -1 indica che viene caricata una singola immagine.
$indice = -1;

gestioneImmagine($indice,'');
generaThumbnail($_FILES['immagine']['tmp_name'],'/img/thumb',220,320,$indice);

$query = sprintf("SELECT galleria FROM tblprodotti WHERE codiceprodotto='%s'", $_POST['codiceprodotto']);
$dati = eseguiQuery($connessione, $query);
$galleriaOld = $dati[0]['galleria'];

if (rename(HOME_ROOT . '/' . 'img' . '/' . $dati[0]['galleria'], HOME_ROOT . '/' . 'img' . '/' . $_POST['galleria'])) {
    print '<p class="successo">' . "La cartella della galleria è stata rinominata con successo</p>";
} else {
    print '<p class="informazione">' . "La cartella della galleria non è stata rinominata</p>";
}

$query = sprintf("UPDATE tblprodotti SET nomeprodotto='%s', descrizione='%s', prezzo='%d', numeropezzi='%d', immagine='%s',galleria='%s',categoria='%s' WHERE codiceprodotto='%s'", $_POST['nomeprodotto'], $_POST['descrizione'], $_POST['prezzo'], $_POST['numeropezzi'], $_FILES['immagine']['name'], $_POST['galleria'], $_POST['categoria'], $_POST['codiceprodotto']);
$dati = eseguiQuery($connessione, $query);

$query = sprintf("UPDATE tblprodotti SET galleria='%s' WHERE galleria='%s'", $_POST['galleria'], $galleriaOld);
$dati = eseguiQuery($connessione, $query);

print '<p class="successo">La modifica del prodotto è avvenuta correttamente</p>';

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>