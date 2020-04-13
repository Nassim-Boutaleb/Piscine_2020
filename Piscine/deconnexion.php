<?php
    session_start();  // reprendre la session en cours
    session_destroy(); // la détruire
?>
<script>
    alert ("Vous avez été déconnecté(e) correctement");
</script>
<meta http-equiv="refresh" content="0; url=test_acc.php">