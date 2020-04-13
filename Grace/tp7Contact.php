<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>  
    <link rel="stylesheet" type="text/css" href="styles.css"> 
    <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran    
            }); 
    </script>
</head>
<body>
    <!-- Conteneur pour le header-->
    <header class="page-header header container-fluid"> 
        <div class="overlay"> <!-- Superposition-->
            <div class="description" id="Accueil">       
                <?php 
                $nom = isset($_POST["nom"])?$_POST["nom"] : "non rempli" ;  // if then else
                $couriel = isset($_POST["email"])?$_POST["email"] : "non rempli" ;
                $comm = isset($_POST["comm"])?$_POST["comm"] : "non rempli" ;
                echo ("<h1> Prise de contact enregistrée ! Récapitulatif: </h1>");
                echo ("<p> Votre nom: ".$nom."<br> Votre email: ".$couriel.
                "<br> Votre commentaire: ".$comm."</p>"); ?>   
                
                <a href="acceuil.html"><button class="btn btn-success btn-lg">Retour au site web</button></a>
            </div> 
        </div> 
    </header> 
        
</body>
</html>