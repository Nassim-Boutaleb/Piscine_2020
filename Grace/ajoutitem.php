<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
        <link rel="stylesheet" type="text/css" href="styles.css"> 

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 

        <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran

                $("#disPlus").click (function() {
                    alert ("Le formulaire de contact vous permet d'obtenir plus d'informations!");
                    $("#formContact").css ("border","red 4px dashed");                   
                });    
            }); 
        </script>
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
        <nav class="navbar navbar-expand-md">      
            <a class="navbar-brand" href="#"><img src="logoece.png" width="70px" height="30px" alt="Logo"></a> <!-- Logo-->        
            
            <!-- Bouton pour les écrans plus petits-->
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">      
                <span class="navbar-toggler-icon"></span>        
            </button>   

            <!-- Boutons de navigation-->
            <div class="collapse navbar-collapse" id="main-navigation">      
                <ul class="navbar-nav">             
                    <li class="nav-item"><a class="nav-link" href="acceuil.html">Accueil</a></li>             
                    <!-- MENU DESCENDANT-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Catégories</a>
                         <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Ferraille ou Trésor</a>
                            <a class="dropdown-item" href="#">Bon pour le Musée</a>
                             <a class="dropdown-item" href="#">Accessoire VIP</a>
                         </div>

                    </li>  
                    <!--FIN MENU DESCENDANT-->           
                    <li class="nav-item"><a class="nav-link" href="#Acheter">Acheter</a></li>  
                    <li class="nav-item"><a class="nav-link" href="#Vendre">Vendre</a></li>     
                </ul>

                <ul class="navbar-nav ml-auto">
                     <li class="nav-item"><a class="nav-link" href="panier.html"><i class="fa fa-shopping-cart"></i> Panier
                    <span class="badge badge-light"><!-- FAIRE UN JAVASCRIPT POUR RENDRE LE NOMBRE DYNAMIQUE--></span> <span class="sr-only">(current)</span></a>
                     
            </li>
                     <li class="nav-item"><a class="nav-link" href="#Compte">Votre Compte</a></li>
                </ul>         
            </div> 
        </nav> 
        <br>
        <br>
<div class="container">
<form action="ajoutitemTraitement.php" method="post">
  <div class="form-group">
    <label for="nomitem">Nom</label>
    <input type="text" class="form-control" id="nomitem" aria-describedby="AideNom" placeholder="Nom Article">
    <small id="AideNom" class="form-text text-muted">Le nom de l'article mis en vente</small>
  </div>
  <div class="form-group">
    <label for="Descriptionitem">Description</label>
    <input type="text" class="form-control" id="Descriptionitem" placeholder="Description">
  </div>
    <div class="form-group">
    <label for="Categorieitem">Catégorie</label>
    <input type="text" class="form-control" id="Categorieitem" placeholder="Catégorie">
  </div>
    <div class="form-group">
    <label for="Prixitem">Prix</label>
    <input type="text" class="form-control" id="Prixitem" placeholder="Prix">
  </div>
      <div class="form-group">
    <label for="typevente">Type de vente </label>
    <input type="text" class="form-control" id="typevente" placeholder="Type de vente">
  </div>
    <div class="form-group">
    <label for="Photoitem">Photo de l'article</label>
    <input type="file" class="form-control-file" id="photoitem">
  </div>
    <div class="form-group">
    <label for="Videoitem">Video de l'article</label>
    <input type="file" class="form-control-file" id="Videoitem">
  </div>
  <div class="form-check">
    <input type="checkbox" class="form-check-input" id="exampleCheck1">
    <label class="form-check-label" for="exampleCheck1">Validation</label>
  </div>
  <button type="submit" class="btn btn-primary">Soumettre</button>
</form>
</div>






    </body>


</html>
