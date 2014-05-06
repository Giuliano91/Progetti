<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

if (isset($_SESSION['collegato'])) {
    if ($_SESSION['amministratore'] == true) {

        $connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
        $query = sprintf("SELECT * FROM tblprodotti WHERE codiceprodotto='" . $_POST['codiceprodotto'] . "'");
        $dati = eseguiQuery($connessione, $query);
        print '<form enctype="multipart/form-data" method="post" action="../script/scriptModificaProdotto.php">';
        print '<fieldset><legend>Modifica Prodotto</legend>';
        print '<input type="hidden" name="codiceprodotto" value="' . $dati[0]['codiceprodotto'] . '"></input><br /> ';
        print '<div class="label"><label >Nome Prodotto</label></div>';
        print '<input type="text" name="nomeprodotto" class="obbligatorio" value="' . $dati[0]['nomeprodotto'] . '"></input><br /> ';
        print '<div class="label"><label >Descrizione</label></div>';
        print '<textarea rows="5" cols="40" name="descrizione" class="obbligatorio">' . $dati[0]['descrizione'] . '</textarea><br />';
        print '<div class="label"><label >Prezzo (€)</label></div>';
        print '<input type="text" name="prezzo" class="obbligatorio" value="' . $dati[0]['prezzo'] . '"/><br />';
        print '<div class="label"><label >Numero Pezzi</label></div>';
        print '<input type="text" name="numeropezzi" class="obbligatorio" value="' . $dati[0]['numeropezzi'] . '"/><br />';
        print '<div class="label"><label >Immagine</label></div>';
        print '<input type="file" name="immagine" class="obbligatorio"/><br />';
        print '<div class="label"><label >Galleria Immagini</label></div>';
        print '<input type="text" name="galleria" class="obbligatorio" value="' . $dati[0]['galleria'] . '"/><br />';
        print '<div class="label"><label >Categoria Prodotto</label></div>';
        print '<select name="categoria" class="obbligatorio">';
        $query = sprintf("SELECT nome FROM tblcategorie");
        $datiCategoria = eseguiQuery($connessione, $query);
        foreach ($datiCategoria as $riga) {
            print '<option value="' . $riga['nome'] . '"' . ($riga['nome'] == $dati[0]['categoria'] ? 'selected="selected"' : "") . '>' . $riga['nome'] . '</option>';
        }
        print '</select><br />';
        print '<div class="label"><label >Console</label></div>';
        print '<select name="console" class="obbligatorio">';
        $query = sprintf("SELECT nome FROM tblconsole");
        $datiConsole = eseguiQuery($connessione, $query);
        foreach ($datiConsole as $riga) {
            print '<option value="' . $riga['nome'] . '"' . ($riga['nome'] == $_POST['console'] ? 'selected="selected"' : "") . '>' . $riga['nome'] . '</option>';
        }
        print '</select>';
        print '<br /><input type="submit" class="invia" value="Conferma"></input>';
        print '</fieldset>';
        print "</form>";

        chiudiConnessione($connessione);
    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {

    print '<p class="errore">non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';

}

include HOME_ROOT . '/html/coda.html';
?>