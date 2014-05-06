<?php

function creaConnessione($server,$utente,$password,$database) {
    $connessione = mysqli_connect($server, $utente, $password);
    mysqli_select_db($connessione,$database) or die(mostraErrore($connessione));
    return $connessione;
}

function eseguiQuery($connessione,$query){
    $risultatoQuery = mysqli_query($connessione,$query)or die(mostraErrore($connessione));
    $dati = array();
    if(!is_bool($risultatoQuery)) {
        while($riga = mysqli_fetch_assoc($risultatoQuery)){
            $dati[] = $riga;
        }
    }
    return $dati;
}

function chiudiConnessione($connessione){
    mysqli_close($connessione);
}

function mostraErrore($connessione){
    echo '<p class="errore">'."I dati che hai inserito hanno generato questo errore: ".mysqli_error($connessione)."</p>";
}

function gestioneImmagine($indice, $galleria){
    if($indice == -1){
        $errore = $_FILES['immagine']['error'];
        $nome = $_FILES['immagine']['name'];
        $temp = $_FILES['immagine']['tmp_name'];
    }else{
        $errore = $_FILES['immagini']['error'][$indice];
        $nome = $_FILES['immagini']['name'][$indice];
        $temp = $_FILES['immagini']['tmp_name'][$indice];
    }
    if ($errore == UPLOAD_ERR_OK) {
        copy($temp, HOME_ROOT . '/' . 'img' . '/'.$galleria.'/' . $nome);
        $messaggio = "Il file è stato caricato senza problemi";
        print '<p class="successo">' . $nome . ' - Esito : ' . strtoupper($messaggio) . "</p>";
    } else {
        switch ($errore) {
            case UPLOAD_ERR_INI_SIZE:
                $messaggio = "Il file caricato è troppo grande rispetto alla direttiva specificata in php.ini";
                break;
            case UPLOAD_ERR_FORM_SIZE:
                $messaggio = "Il file caricato è troppo grande rispetto alla direttiva specificata nel form html";
                break;
            case UPLOAD_ERR_PARTIAL:
                $messaggio = "Il file è stato caricato parzialmente";
                break;
            case UPLOAD_ERR_NO_FILE:
                $messaggio = "Il file non è stato caricato";
                break;
            case UPLOAD_ERR_NO_TMP_DIR:
                $messaggio = "File temporaneo mancante";
                break;
            case UPLOAD_ERR_CANT_WRITE:
                $messaggio = "Impossibile scrivere file su disco";
                break;
            case UPLOAD_ERR_EXTENSION:
                $messaggio = "Caricamento del file bloccato da un estensione";
                break;
        }
        print '<p class="errore">' . $nome . ' - Esito : ' . strtoupper($messaggio) . "</p>";
    }
}

function generaThumbnail($imSorgente, $percorso, $larghezza, $altezza, $indice){
    if(!is_dir(HOME_ROOT .$percorso)){
        mkdir(HOME_ROOT .$percorso);
    }
    list($larghezzaOriginale, $altezzaOriginale) = getimagesize($imSorgente);
    $thumb = imagecreatetruecolor($larghezza, $altezza);
    if($indice == -1){
        $tipo = $_FILES['immagine']['type'];
    }else{
        $tipo = $_FILES['immagini']['type'][$indice];
    }
    switch($tipo) {
        case "image/jpeg":
        $immagine = @imagecreatefromjpeg($imSorgente);
        break;
        case "image/gif":
        $immagine = @imagecreatefromgif($imSorgente);
        break;
        case "image/png":
        $immagine = @imagecreatefrompng($imSorgente);
        break;
    }
    imagecopyresized($thumb, $immagine, 0, 0, 0, 0, $larghezza, $altezza, $larghezzaOriginale, $altezzaOriginale);
    if($indice == -1){
        imagejpeg($thumb,HOME_ROOT.$percorso.'/'. $_FILES['immagine']['name']);
    } else {
        imagejpeg($thumb,HOME_ROOT.$percorso.'/'. $_FILES['immagini']['name'][$indice]);
    }
    imagedestroy($thumb);
    imagedestroy($immagine);
}

function ricercaProdotto($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT * FROM tblprodotti AS p LEFT JOIN tblprodotticonsole AS pc ON p.codiceprodotto = pc.codiceprodotto");

    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nomeprodotto']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            print '<form method="post" action="'.trim($destinazione).'">';
            print '<input type="hidden" name="codiceprodotto" value="'.$riga['codiceprodotto'].'"/>';
            print '<input type="hidden" name="console" value="'.$riga['console'].'"/>';
            print '<div class="label"><label>'.$riga['nomeprodotto'].'</label><label> - '.$riga['console'].'</label></div>';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
        }
    }
    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function ricercaCategoria($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT * FROM tblcategorie");
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nome']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            print '<form method="post" action="'.trim($destinazione).'">';
            print '<div class="label"><label>'.$riga['nome'].'</label></div>';
            print '<input type="hidden" name="nome" value="'.$riga['nome'].'">';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
        }
    }
    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}

function ricercaConsole($nomeCercato, $destinazione){
    $connessione = creaConnessione(SERVER,UTENTE,PASSWORD,DATABASE);
    $query = sprintf("SELECT * FROM tblconsole");
    $dati = eseguiQuery($connessione,$query);
    $contantoreRisultati = 0;

    print '<p class="informazione">Sono stati individuati i seguenti risultati potenziali</p>';
    foreach($dati as $riga ){
        $risultatoPotenziale = strtolower(substr(trim($riga['nome']),0,strlen($nomeCercato)));
        if($risultatoPotenziale==strtolower($nomeCercato)){
            print '<form method="post" action="'.trim($destinazione).'">';
            print '<div class="label"><label>'.$riga['nome'].'</label></div>';
            print '<input type="hidden" name="nome" value="'.$riga['nome'].'">';
            print '<input type="submit" value="Seleziona"/>';
            print '</form>';
            print '<br />';
            $contantoreRisultati++;
        }
    }
    if($contantoreRisultati == 0){
        print '<p class="errore">La ricerca non ha prodotto alcun risultato.</p>';
    }
}


function stampaModuloRicerca($destinazione, $nome){
    print '<form method="post" action="'.trim($destinazione).'">';
    print '<fieldset><legend>Ricerca '.$nome.'</legend>';
    print '<div class="label"><label >Nome</label></div>';
    print '<input type="text" name="nome" class="obbligatorio"></input>';
    print '<input type="submit" value="Cerca" class="inviato"></input>';
    print '</fieldset>';
    print "</form>";
}

?>