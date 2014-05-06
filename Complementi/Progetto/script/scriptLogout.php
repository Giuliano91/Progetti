<?php
include '../settings/configurazione.inc';
session_destroy();
header("location: ../index.php");
?>