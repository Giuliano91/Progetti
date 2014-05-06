<?php print '<?xml version="1.0" encoding="UTF-8"?>';?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <title>Games Commerce</title>
    <script type="text/javascript" src="<?php print HOME_WEB;?>js/jquery.min.js"></script>
    <script type="text/javascript" src="<?php print HOME_WEB;?>js/jquery-ui.min.js"></script>
    <script type="text/javascript" src="<?php print HOME_WEB;?>js/funzioni.js"></script>
    <style type="text/css">
        @import url(<?php print HOME_WEB;?>css/stile.css);
        @import url(<?php print HOME_WEB;?>css/jquery-ui.min.css);
    </style>
</head>
<body>
<div id="contenuto">
    <div id="testa">
        <p id="titolo">Games Commerce</p>
    </div>
    <div id="logo">
    </div>
    <div id="corpo">
        <div id="colsx">
            <a href="<?php print HOME_WEB; ?>index.php">HomePage</a><br/>
            
            <?php

            if (!isset($_SESSION['collegato'])) {
                print '<a href="'.HOME_WEB.'html/moduloRegistrazione.php">Registrazione Utente</a><br/>';
            }
            if(isset($_SESSION['amministratore'])) {
                if($_SESSION['amministratore']) {
                    print'<a href=' . HOME_WEB . 'html/moduloInserimentoProdotto.php>Inserimento Prodotto</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloModificaProdotto.php>Modifica Prodotto</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloEliminazioneProdotto.php>Eliminazione Prodotto</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloInserimentoImmagine.php>Inserimento Immagini</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloEliminazioneImmagine.php>Eliminazione Immagini</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloInserimentoCategoria.php>Inserimento Categoria</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloModificaCategoria.php>Modifica Categoria</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloEliminazioneCategoria.php>Eliminazione Categoria</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloInserimentoConsole.php>Inserimento Console</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloModificaConsole.php>Modifica Console</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloEliminazioneConsole.php>Eliminazione Console</a><br />';
                    print'<a href=' . HOME_WEB . 'html/moduloAmministrazione.php>Pannello Amministrativo</a><br />';
                }
            }
            if (isset($_SESSION['amministratore']) || isset($_SESSION['utenteautorizzato'])) {
                print'<a href=' . HOME_WEB . 'html/moduloVisualizzazioneCarrello.php>Visualizza Carrello</a><br />';
            } else {
                print'<a href=' . HOME_WEB . 'html/moduloLogin.php>Visualizza Carrello</a><br />';
            }
            ?>
            <a href="<?php print HOME_WEB ?>html/moduloVisualizzazioneCatalogo.php">Visualizza Catalogo</a><br/>
            <?php
            if (isset($_SESSION['collegato'])) {
                print '<a href='.HOME_WEB.'html/moduloProfiloUtente.php>Gestione Profilo Utente</a><br/>';
            }
            if (!isset($_SESSION['collegato'])) {
                print '<a href='.HOME_WEB.'html/moduloLogin.php>Login</a><br/>';
            } else {
                print '<a href='.HOME_WEB.'script/scriptLogout.php>Logout</a><br/>';
            }
            if (isset($_SESSION['utenteautorizzato'])) {
                if ($_SESSION['utenteautorizzato']) {
                    $status = "COLLEGATO";
                    print $status;
                }
            } else {
                $status = "NON COLLEGATO";
                print $status;
            }
            ?>
        </div>
        <div id="coldx">