<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <link rel="stylesheet" type="text/css" href="styles.css">  

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> 

        <?php
          $alertCode = isset($_GET["alertCode"])?$_GET["alertCode"] : "0" ; 
        ?>

        <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran 

                // affichage d'une alerte pour la déconnexion
                var alertCode = <?php echo($alertCode); ?>;
                if (alertCode == 1) // on affiche le succès de déconnexion
                {
                  $("#texteAlerte").text("Vous avez été déconnecté");
                  $("#Alerte").slideDown();
                }

                if (alertCode == 2) // on affiche le succès de création de compte
                {
                  $("#texteAlerte").text("Compte créé avec succès.Vous êtes connecté");
                  $("#Alerte").slideDown();
                }

                if (alertCode == 3) // erreur de droit d'accès
                {
                  $("#texteAlerteD").text("ERREUR DROIT D'ACCES");
                  $("#AlerteD").slideDown();
                }

            }); 
        </script>

    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
        <?php require("Navbars/navbar_def.php");  ?>

        <!-- Fenetres d'alertes -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="Alerte">
          <strong id="texteAlerte"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="AlerteD">
          <strong id="texteAlerteD"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!-- Un caroussel (code inspiré de la doc de bootstrap ) -->
                       

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="Images/column1.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="Images/column2.jpg" alt="Second slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        <!-- Pied de page-->
 <?php 
require("footer.php");
 ?>
    </body> 
    
</html> 