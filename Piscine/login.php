<?php session_start();  ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">            
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> 
    <title>Connexion</title>
    <link href="login.css" rel="stylesheet" type="text/css"/>
    
    <script>
        <?php
            // Vérifier si des erreurs sont présentes (après un 1er envoi par loginTraitement.php)
            $erreur = isset($_POST["erreursLogin"])?$_POST["erreursLogin"] : "0" ; 
        ?>
        $(document).ready (function()
        {
            var erreur =<?php echo($erreur); ?>; // récupérer le numéro de l'erreur 
            // Alerter l'utilisateur sur son erreur ...
            if (erreur == 1)
            {
                $("#email").addClass ("is-invalid");
            } 

            else if (erreur == 2)
            {
                $("#password").addClass ("is-invalid");
            } 
        });
    </script>


</head>
<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>

    <!-- Contenu de la page -->
    <div class="container-fluid">
       
        <div class="card border-secondary text-center">
            <form method="post" action="loginTraitement.php">
                <div class="card-header">
                    Se connecter
                </div>

                <div class="card-body">
                    <div class="form-group">
                        <h5 class="card-title">Email/login</h5>
                        <input type="email" class="form-control" name="email" id="email" required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <h5 class="card-title">Mot de passe</h5>
                        <input type="password" class="form-control" name="pass" id="password" required>
                        <div class="invalid-feedback">
                            Mot de passe incorrect
                        </div> 
                    </div>

                    <button type="submit" class="btn btn-secondary">Se connecter</button>
                </div>
            </form>

                <div class="card-footer">
                    Créer un compte <br>
                    <a href="creer_compte.php"><button class="btn btn-secondary">Créer un compte</button></a>
                </div>
                
            
        </div>


    </div>
    

    
</body>
</html>