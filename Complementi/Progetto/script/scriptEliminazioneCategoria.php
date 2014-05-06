<?php
include '../settings/configurazione.inc';

include HOME_ROOT.'/html/testa.php';
?>

<?php

if (isset($_SESSION['collegato'])){
        if ($_SESSION['amministratore'] == true){
		
			mysql_connect("localhost", "root", "");
			mysql_select_db("ecommerce");		
	
			$sql = sprintf("DELETE FROM tblCategorie WHERE nome='%s'", $_SESSION['nomecat']);
			$result = mysql_query($sql);			
			
			$sql = sprintf("SELECT * FROM tblcategorie WHERE idcat='".$_POST['categoria']."'");
			$result = mysql_query($sql);
			$vet = mysql_fetch_array($result);
	
			$sql = sprintf("DELETE FROM tblProdotti WHERE categoria='%d'", $vet['idcat']);
			$result = mysql_query($sql);
			
			header("location: ../index.php");
		
	} else {
		print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
	}
} else {
	print 'Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login';
}


?>

<?php include HOME_ROOT.'/html/coda.html';?>