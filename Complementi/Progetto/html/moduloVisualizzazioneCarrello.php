<?php
include '../settings/configurazione.inc';

include HOME_ROOT.'/html/testa.php';
?>

<?php
	$cartella = "img/";
	$cartella2 = "html";
	$cartella3 = "script";
	mysql_connect("localhost", "root", "");
	mysql_select_db("ecommerce");
	
	$sql = sprintf("SELECT idutente FROM tblUtenti WHERE user='".$_SESSION['username']."'");
	$result = mysql_query($sql);
	$vet = mysql_fetch_array($result);

	$sql2 = sprintf("SELECT * FROM tblcarrelli WHERE codiceutente='".$vet['idutente']."'");
	$result2 = mysql_query($sql2);
			
	while($vet2 = mysql_fetch_array($result2)) {
		$sql3 = sprintf("SELECT * FROM tblprodotti WHERE codiceprodotto='".$vet2['codiceprodotto']."'");
		$result3 = mysql_query($sql3);
		$vet3 = mysql_fetch_array($result3);	
		print '<div id="corpoCatalogo">'.
            '<div id="catcolsx"><img src="'.HOME_WEB.$cartella.$vet3['immagine'].'"></img>'.'</div>'.
            '<div id="catcoldx">
            <p><b>Codice Prodotto: </b>'.$vet3['codiceprodotto'].'</p>'.
            '<p><b>Nome Prodotto: </b>'.$vet3['nomeprodotto'].'</p>'.
            '<p><b>Descrizione: </b>'.$vet3['descrizione'].'</p>'.
            '<p><b>Prezzo: </b>'.$vet3['prezzo'].' Euro</p>'.
            '<p><b>Quantita Richiesta: </b>'.$vet2['quantita'].'</p>'.
            '<p><b>Categoria: </b>'.$vet3['categoria'].'</p>';
        if(isset($_SESSION['autorizzato']) || isset($_SESSION['utenteautorizzato']))	{
            print '<form method="post" action="../script/scriptEliminazioneCarrello.php?prodotto='.$vet3['codiceprodotto'].'">';
            print'<p><img src="../img/style/cart_remove.png"></img></p>';
            print '<p>Quantita di prodotto da eliminare:';
            print '<input type="text" name="quantitaeliminazione"></input></p>';
            print '<input type="submit" value="Elimina prodotto dal carrello"></input>';
            print '</form>';
            print '<form method="post" action="../script/scriptConfermaAcquisto.php?prodotto='.$vet3['codiceprodotto'].'">';
            print '<br /><input type="submit" value="Conferma Acquisto"></input><br />';
            print '</form>';
        } else {
            print '<p>Esegui il login per eliminare prodotti nel carrello o confermare la transazione</p>';
        }
        print '</div>'.'</div>';
	}

include HOME_ROOT.'/html/coda.html';
?>