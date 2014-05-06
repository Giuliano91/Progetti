<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
$percorsoCartella = '../img/' . trim($_POST['galleria']);

//Se l'indice è -1 indica che viene caricata una singola immagine.
$indice = -1;

gestioneImmagine($indice,'');
generaThumbnail($_FILES['immagine']['tmp_name'],'/img/thumb',220,320,$indice);

$query = sprintf("INSERT INTO tblprodotti(codiceprodotto, nomeprodotto, descrizione, prezzo, numeropezzi, immagine, galleria, categoria) VALUE ('%s','%s','%s','%d','%d','%s','%s','%s')", strtoupper(trim($_POST['codiceprodotto'])), $_POST['nomeprodotto'], $_POST['descrizione'], $_POST['prezzo'], $_POST['numeropezzi'], $_FILES['immagine']['name'], trim($_POST['galleria']), $_POST['categoria']);
$dati = eseguiQuery($connessione, $query);

$query = sprintf("INSERT INTO tblprodotticonsole(codiceprodotto, console) VALUE ('%s','%s')", $_POST['codiceprodotto'], $_POST['console']);
$dati = eseguiQuery($connessione, $query);

if(!file_exists($percorsoCartella)){
    mkdir($percorsoCartella);
    print '<p class="successo">'."La creazione della cartella è avvenuta con successo</p>";
} else {
    print '<p class="informazione">'."La cartella è già esistente</p>";
}

print '<p class="successo">'."L'inserimento del prodotto è avvenuto con successo</p>";

chiudiConnessione($connessione);

include HOME_ROOT . '/html/coda.html';
?>