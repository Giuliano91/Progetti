<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT.'/html/testa.php';

$connessione = creaConnessione(SERVER, UTENTE, PASSWORD, DATABASE);
$query = sprintf("SELECT * FROM tblprodotti AS p LEFT JOIN tblprodotticonsole AS pc ON p.codiceprodotto = pc.codiceprodotto");
$dati = eseguiQuery($connessione, $query);
$cartellaImmaginePrincipale = 'img';
foreach($dati as $riga){
	print '<div id="corpoCatalogo">'.'<div id="catcolsx"><img src="'.HOME_WEB.'/'.$cartellaImmaginePrincipale.'/thumb/'.$riga['immagine'].'"></img>'.'</div>'.
	'<div id="catcoldx"><p><b>Codice Prodotto: </b>'.$riga['codiceprodotto'].'</p>'.
	'<p><b>Nome Prodotto: </b>'.$riga['nomeprodotto'].'</p>'.
	'<p><b>Descrizione: </b>'.$riga['descrizione'].'</p>'.
	'<p><b>Prezzo: </b>'.$riga['prezzo'].' €</p>'.
	'<p><b>Quantita Disponibile: </b>'.$riga['numeropezzi'].'</p>'.
	'<p><b>Categoria: </b>'.$riga['categoria'].'</p>'.
	'<p><b>Console: </b>'.$riga['console'].'</p>';
	if(isset($_SESSION['collegato'])){	
		print '<form method="post" action="../script/scriptInserimentoCarrello.php?prodotto='.$riga['codiceprodotto'].'">';
		print'<p><img src="../'.$cartellaImmaginePrincipale.'/style/cart_add.png"></img></p>';
		print '<p><b>Quantita di prodotto da inserire:</b>';
		print '<input type="text" name="quantitainserimento"></input></p>';
		print '<input type="submit" value="Inserisci Prodotto"></input>';
		print '</form>';
	} else {
		print '<p>Esegui il login per inserire il prodotto nel carrello</p>';
	}
	print '</div>'.'</div>';

}		

include HOME_ROOT.'/html/coda.html';
?>
