<?php
include '../settings/configurazione.inc';

include HOME_ROOT.'/html/testa.php';
?>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("ecommerce")or die('Morto');

$utente = $_SESSION['username'];
$password = $_SESSION['password'];

$quantita = $_POST['quantitainserimento'];

$codiceprodottodainserire = $_GET['prodotto'];

$sql = sprintf("SELECT * FROM tblProdotti");
$result = mysql_query($sql);
$vet = mysql_fetch_array($result);


if (($quantita > $vet['numeropezzi']) || ($quantita <= 0)) {
	print 'Non puoi comprare un numero di prodotti negativo oppure maggiore della quantita disponibile. Riprova.'; 
} else {
	$sql = sprintf("SELECT idutente FROM tblUtenti WHERE user='".$utente."'");
	$result = mysql_query($sql);
	$vet = mysql_fetch_array($result);
	
	$sql = sprintf("SELECT * FROM tblCarrelli WHERE codiceutente='".$vet['idutente']."'");
	$result = mysql_query($sql);	
	$vet2= mysql_fetch_array($result);
	
	if ($vet2['codiceprodotto'] == "" && $vet2['codiceutente'] == "") {
		$sql = sprintf("INSERT INTO tblcarrelli(codiceprodotto, codiceutente, quantita) VALUE ('%s','%d','%d')",$codiceprodottodainserire,$vet['idutente'],$quantita);
		$result = mysql_query($sql);
	} else {
		
		$sql = sprintf("SELECT * FROM tblCarrelli WHERE codiceutente='".$vet['idutente']."'"."AND codiceprodotto='".$codiceprodottodainserire."'");
		$result = mysql_query($sql);	
		$vet3= mysql_fetch_array($result);
		
		$quantitatotale = $vet3['quantita']+$quantita;		
		
		$sql = sprintf("SELECT numeropezzi FROM tblProdotti WHERE codiceprodotto='".$codiceprodottodainserire."'");
		$result = mysql_query($sql);	
		$vet5= mysql_fetch_array($result);
			
		if($quantitatotale>$vet5['numeropezzi']) {
			print "Attenzione, non puoi inserire una quantità di prodotto maggiore di quella in magazzino!";
		} else {			
			if($vet3['codiceprodotto'] == $codiceprodottodainserire && $vet3['codiceutente'] == $vet['idutente']) {					
				$sql = sprintf("UPDATE tblCarrelli SET quantita='%d' WHERE codiceprodotto='".$codiceprodottodainserire."'"."AND codiceutente='".$vet['idutente']."'",$quantitatotale);
				$result = mysql_query($sql);				
			} else {
				$sql = sprintf("INSERT INTO tblcarrelli(codiceprodotto, codiceutente, quantita) VALUE ('%s','%d','%d')",$codiceprodottodainserire,$vet['idutente'],$quantita);
				$result = mysql_query($sql);			
			}	
		}
	}	
}




?>

<?php include HOME_ROOT.'/html/coda.html';?>