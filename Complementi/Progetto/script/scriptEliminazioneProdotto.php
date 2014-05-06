<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/html/testa.php';
include HOME_ROOT.'/script/funzioni.php';

if (isset($_SESSION['collegato'])){
        if ($_SESSION['amministratore'] == true){
        $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
        $query = sprintf("SELECT codiceprodotto FROM tblProdotti WHERE nomeprodotto='%s'", $_POST['nome']);
        $risultato = eseguiQuery($connessione,$query);
        $query = sprintf("DELETE FROM tblprodotticonsole WHERE codiceprodotto='%s'", $risultato[0]['codiceprodotto']);
        $dati = eseguiQuery($connessione,$query);
        $query = sprintf("DELETE FROM tblprodotti WHERE codiceprodotto='%s'", $risultato[0]['codiceprodotto']);
        $dati = eseguiQuery($connessione,$query);
        print '<p class="successo">Il prodotto è stato eliminato con successo</p>';
        chiudiConnessione($connessione);
	} else {
		print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
	}
} else {
	print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
}

include HOME_ROOT.'/html/coda.html';
?>