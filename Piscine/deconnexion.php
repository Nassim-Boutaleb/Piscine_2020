<?php
    session_start();  // reprendre la session en cours
    session_destroy(); // la détruire
?>

<meta http-equiv="refresh" content="0; url=accueil.php?alertCode=1">