<?php
include '../settings/configurazione.inc';

include HOME_ROOT.'/html/testa.php';
?>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("ecommerce")or die('Morto');

$utente = $_SESSION['username'];
$quantita = $_POST['quantitaeliminazione'];
$codiceprodottodaeliminare = $_GET['prodotto'];

$sql2 = sprintf("SELECT idutente FROM tblUtenti WHERE user='".$utente."'");
$result2 = mysql_query($sql2);
$vet2 = mysql_fetch_array($result2);

$sql3=sprintf("SELECT * FROM tblcarrelli WHERE codiceutente='".$vet2['idutente']."' AND codiceprodotto='".$codiceprodottodaeliminare."'");
$result3 = mysql_query($sql3);
$vet3 = mysql_fetch_array($result3);

if ($quantita > $vet3['quantita']) {
	print "Non puoi eliminare dal carrello una quantita maggiore di quella inserita precedentemente";
} else { 		
		$quantitaaggiornata = $vet3['quantita'] - $quantita;
		$sql = sprintf("UPDATE tblCarrelli SET quantita='%d' WHERE codiceprodotto='".$codiceprodottodaeliminare."'"."AND codiceutente='".$vet2['idutente']."'",$quantitaaggiornata);
		$result = mysql_query($sql);	
		
		$sql3=sprintf("SELECT * FROM tblcarrelli WHERE codiceutente='".$vet2['idutente']."' AND codiceprodotto='".$codiceprodottodaeliminare."'");
		$result3 = mysql_query($sql3);
		$vet3 = mysql_fetch_array($result3);		
		
		if ($vet3['quantita'] == 0) {
				$sql7=sprintf("DELETE FROM tblcarrelli WHERE codiceutente='%d' AND codiceprodotto='%s'",$vet2['idutente'],$codiceprodottodaeliminare);
				$result7 = mysql_query($sql7);					
				header("location: ../html/moduloVisualizzazioneCarrello.php");
		}
		header("location: ../html/moduloVisualizzazioneCarrello.php");
	}
		


?>

<?php include HOME_ROOT.'/html/coda.html';?>