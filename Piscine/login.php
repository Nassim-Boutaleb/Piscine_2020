<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Connexion</title>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
    <script>
        <?php
            // Vérifier si des erreurs sont présentes (après un 1er envoi par connexion.php)
            $erreur = isset($_POST["erreursLogin"])?$_POST["erreursLogin"] : "0" ; 
        ?>
        $(document).ready (function()
        {
            var erreur =<?php echo($erreur); ?>;
            alert (erreur);
        });
    </script>

</head>
<body>
    <table>
        <form method="post" action="connexion.php">
            <tr>
                <td>Email:</td>
                <td><input type="email" name="email" required></td>
            </tr>
            <tr>
                <td>Mot de passe:</td>
                <td><input type="password" name="pass" required></td>
            </tr>
            <tr>
                <td colspan="2" style="text-align: center;"><input type="submit" value="Se connecter"></td>
            </tr>
        </form>
    </table>

    
</body>
</html>