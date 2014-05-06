<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/html/testa.php';
include HOME_ROOT.'/script/funzioni.php';

if (isset($_SESSION['collegato'])){
    if ($_SESSION['amministratore'] == true){
        $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
        $query = sprintf("SELECT galleria FROM tblprodotti WHERE codiceprodotto='%s'",$_POST['codiceprodotto']);
        $dati = eseguiQuery($connessione,$query);

        $percorsoThumbnails = '../img/thumb/'.$dati[0]['galleria'].'/';
        $thumbnails = glob($percorsoThumbnails . "*.jpg");

        print '<p class="informazione">Seleziona le immagini da eliminare</p>';

        print '<form method="post" action="../script/scriptEliminazioneImmagine.php">';
        print '<input type="hidden" name="galleria" value="'.$dati[0]['galleria'].'">';
        foreach ($thumbnails as $thumb) {
            print '<div id="immagineEliminazione">';
            print '<div><img src="'.$thumb.'"></div>';
            print '<div><input type="checkbox" name="immagine[]" value="'.basename($thumb).'"/>';
            print '<label>'.basename($thumb).'</label></div>';
            print '</div>';
        }
        print '<div id="pulsanteEliminazione"><input type="submit" value="Elimina"/></div>';
        print '</form>';

        chiudiConnessione($connessione);
    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}

include HOME_ROOT.'/html/coda.html';
?>