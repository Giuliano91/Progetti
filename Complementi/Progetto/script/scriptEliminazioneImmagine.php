<?php
include '../settings/configurazione.inc';
include HOME_ROOT . '/script/funzioni.php';
include HOME_ROOT . '/html/testa.php';

foreach ($_POST['immagine'] as $immagine) {
    if(file_exists('../img/thumb/'.$_POST['galleria'].'/'.$immagine)){
        unlink('../img/thumb/'.$_POST['galleria'].'/'.$immagine);
    }
    if(file_exists('../img/'.$_POST['galleria'].'/'.$immagine)){
        unlink('../img/'.$_POST['galleria'].'/'.$immagine);
    }
    print '<p class="successo">Il file '.$immagine.' è stato eliminato con successo</p>';
}
print '<p class="successo">Hai eliminato con successo '.count($_POST['immagine']).' immagini</p>';

include HOME_ROOT . '/html/coda.html';
?>