<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/script/funzioni.php';
include HOME_ROOT.'/html/testa.php';

if (isset($_SESSION['collegato'])){
    if ($_SESSION['amministratore'] == true){

        print '<form method="post" action="../script/scriptInserimentoConsole.php">';
        print '<fieldset><legend>Informazioni Console</legend>';
        print '<div class="label"><label >Nome</label></div>';
        print '<input type="text" name="nome" class="obbligatorio"></input><br /> ';
        print '<div class="label"><label >Produttore</label></div>	';
        print '<input type="text" name="produttore"></input><br /> ';
        print '<br /><input type="submit" class="invia" value="Conferma"></input>';
        print '</fieldset>';
        print "</form>";

    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}

include HOME_ROOT.'/html/coda.html';
?>