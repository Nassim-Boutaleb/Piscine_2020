<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <a href="login.php"><button>Se connecter</button></a>
    <form method="post" action="deconnexion.php">
        <input type="submit" value="se déconnecter">
    </form>
    
    <?php
        if (isset($_SESSION["login"])){
            echo ('<h3> Bienvuenue '.$_SESSION["login"].' </h3>');
        }
        else
        {
            echo ("<h3> Pas encore connecté </h3>");
        }
    ?>
</body>
</html>
