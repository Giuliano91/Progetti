<?php
include '../settings/configurazione.inc';

include HOME_ROOT.'/html/testa.php';
?>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("ecommerce")or die('Morto');

$utente = $_SESSION['username'];


$sql2 = sprintf("SELECT idutente FROM tblUtenti WHERE user='".$utente."'");
$result2 = mysql_query($sql2);
$vet2 = mysql_fetch_array($result2);

$sql3=sprintf("SELECT * FROM tblcarrelli WHERE codiceutente='".$vet2['idutente']."'");
$result3 = mysql_query($sql3);
$vet3 = mysql_fetch_array($result3);

	$sql8=sprintf("SELECT numeropezzi FROM tblProdotti WHERE codiceprodotto='%s'",$vet3['codiceprodotto']);
	$result8 = mysql_query($sql8);
	$vet8 = mysql_fetch_array($result8);

	$sql=sprintf("DELETE FROM tblcarrelli WHERE codiceutente='%d' AND codiceprodotto='%s' ",$vet2['idutente'],$vet3['codiceprodotto']);
	$result = mysql_query($sql);

	$quantitaaggiornata = $vet8['numeropezzi'] - $vet3['quantita'];

	$sql = sprintf("UPDATE tblprodotti SET numeropezzi='%d' WHERE codiceprodotto='".$vet3['codiceprodotto']."'",$quantitaaggiornata);
	$result = mysql_query($sql);	

	header("location: ../html/moduloVisualizzazioneCortesia.php");

?>

<?php include HOME_ROOT.'/html/coda.html';?>