<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/script/funzioni.php';
include HOME_ROOT.'/html/testa.php';

if (isset($_SESSION['collegato'])){
        if ($_SESSION['amministratore'] == true){
		if($_SERVER['REQUEST_METHOD'] == 'POST'){
            ricercaProdotto($_POST['nome'],'moduloModificaProdottoIntermedio.php');
        } else {
			stampaModuloRicerca('moduloModificaProdotto.php','prodotto');
		}
	} else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
	}
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}

include HOME_ROOT.'/html/coda.html';
?>