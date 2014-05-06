<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/script/funzioni.php';
include HOME_ROOT.'/html/testa.php';

if (isset($_SESSION['collegato'])){
        if ($_SESSION['amministratore'] == true){

        $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);

        $query = sprintf("SELECT codiceprodotto, nomeprodotto FROM tblprodotti WHERE codiceprodotto='".$_POST['codiceprodotto']."'");
        $dati = eseguiQuery($connessione,$query);

        if(!$dati) {
            print '<p class="errore">Il prodotto non è stato individuato, controlla il nome inserito</p>';
        } else {
            print '<form method="post" enctype="multipart/form-data" action="../script/scriptInserimentoImmagine.php">';
            print '<fieldset><legend>Inserisci immagini nella galleria di '.$dati[0]['nomeprodotto'].'</legend>';
            print '<div class="label"><label>Seleziona le immagini</label></div>';
            print '<input type="hidden" name="codiceprodotto" value="'.$dati[0]['codiceprodotto'].'"/>';
            print '<input type="file" class="obbligatorio" name="immagini[]" multiple="multiple" accept="image/*" />';
            print '<input type="submit" value="Inserisci" class="invia" />';
            print '</fieldset>';
            print '</form>';
        }
        chiudiConnessione($connessione);
    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}

include HOME_ROOT.'/html/coda.html';
?>