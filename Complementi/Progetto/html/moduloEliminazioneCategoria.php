<?php
include '../settings/configurazione.inc';
include HOME_ROOT.'/html/testa.php';
?>

<?php

mysql_connect("localhost", "root", "");
mysql_select_db("ecommerce");

if (isset($_SESSION['collegato'])){
        if ($_SESSION['amministratore'] == true){
        print '<form method="post" action="../script/scriptEliminazioneCategoria.php">';
        print '<fieldset><legend>Ricerca Categoria</legend>';
        print '<select name="categoria">';
        $sql = sprintf("SELECT * FROM tblCategorie");
        $result = mysql_query($sql);
        while($vet = mysql_fetch_array($result)){
            $_SESSION['nomecat']=$vet['nome'];
            print '<option value='.$vet['idcat'].'>'.$vet['nome'].'</option>';
        }
        print '</select>';
        print '<input type="submit" value="Invia"></input>';
        print '</fieldset>';
        print "</form>";
    } else {
        print '<p class="errore">Per poter visualizzare questa pagina devi avere le credenziali da amministratore.</p>';
    }
} else {
    print '<p class="errore">Non sei autorizzato a visualizzare questa pagina, per favore, esegui il login.</p>';
}
?>

<?php include HOME_ROOT.'/html/coda.html';?>