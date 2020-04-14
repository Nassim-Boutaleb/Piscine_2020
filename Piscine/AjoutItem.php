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
        <?php require("Navbars/navbar_def.php");  ?>

        <br>
        <br>
    <div class="container">
      <form>
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
