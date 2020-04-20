<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link rel="stylesheet" type="text/css" href="Catalogue.css"> 
        <link rel="stylesheet" type="text/css" href="styles.css">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
         

        <style>
            .alert {
                display:none;
            }
        </style>
        
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
        <?php require("Navbars/navbar_def.php");  ?>

       

       
            
<?php
    if (!isset ($_SESSION["login"])) // Si on est pas connecté
    {
        $connecte = 0;
        $statut = "null";
    }
    else 
    {
        $connecte = 1;
        $statut = $_SESSION["statut"];
    }

    // Messages d'alerte
    $alertCode = isset($_GET["alertCode"])?$_GET["alertCode"] : "0" ;

    // Dans modal_encheres on a besoin de connaitre l'URL de la page qui l'appelle
    $urlRed = "catalogue.php";

    // Récupérer l'erreur de la modal enchère et l'item concerné
    $erreurEnchere = isset($_GET["erreurEnch"])?$_GET["erreurEnch"]:"0";
    $numeroIdItemERR = isset($_GET["NumeroId"])?$_GET["NumeroId"]:"0";
      // Récupérer l'erreur de la modal meilleure offre et l'item concerné
      $erreurMO = isset($_GET["erreurMO"])?$_GET["erreurMO"]:"0";
      $numeroIdItemERRMO = isset($_GET["IdItemErrMO"])?$_GET["IdItemErrMO"]:"0";
?>

<script>
        $(document).ready (function()
        {
            var connecte = <?php echo("$connecte"); ?>;
            var statut = "<?php echo("$statut"); ?>";

            // Blinder accès à la page
            // on fera après

            // affichage d'une alerte pour la déconnexion
            var alertCode = <?php echo($alertCode); ?>;
            if (alertCode == 80) // on affiche le succès de déconnexion
            {
                $("#texteAlerteD").text("Pas assez de crédit sur votre carte pour cette enchère");
                $("#AlerteD").slideDown();
            }

            if (alertCode == 82) // on affiche le succès de déconnexion
            {
                $("#texteAlerteD").text("Erreur relative à la carte de paiement BDD");
                $("#AlerteD").slideDown();
            }

            // Récupérer les erreurs
            var erreurEnchere = <?php echo($erreurEnchere); ?>;
            var numeroIdItemERR = <?php echo($numeroIdItemERR); ?>;

            // Rouvrir la modal enchere (la pop up) si besoin 
            if (erreurEnchere == 5) // montant de l'enchère trop petit
            {
                //alert ("enchereID: "+numeroIdItem);
                $("#BtnEnchere"+numeroIdItemERR).trigger ("click"); // réafficher la fenêtre (comme si on avait cliqué sur le bonton enchère de l'item concerné)
            }

        });
</script>
           

 <!-- Alertes -->
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


        <blockquote class="blockquote text-center">
                <p class="mb-0">CATALOGUE COMPLET</p>
                <footer class="blockquote-footer">Une selection d'articles hors du commun </footer>
            </blockquote>

        <?php



        $database = "ecebay";
        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database);

        if ($db_found) 
        {
            
            $sql="SELECT * FROM item WHERE afficher='1' ";
            $result = mysqli_query($db_handle, $sql);

            while ($data = mysqli_fetch_assoc($result))
            {
                //Sauvegarder les variables 
                $nomItem = $data["Nom"];
                $idItem = $data["NumeroID"];
                ?>

                
<div class="card mb-3" style="max-width: 570px; margin-left:450px; height: 240px ;">
<figure class="figure">
  <div class="row no-gutters">
    <div class="col-md-4">
      <img src="<?php echo $data["Image"];?>" class="card-img" style="width: 265px; height: 237px ;" alt="Photo Article">
    </div>
    <div class="col-md-8">
      <div class="card-body" style="margin-left:100px; margin-top:-18px; width:320px;">
        <h5 class="card-title"><?php echo $data["Nom"]."  ";?> </h5>
        <p class="card-text">Prix : <?php echo $data["Prix"];?>€</p>
        <p class="card-text">Type de vente : <?php echo $data["TypeVente"];?></p>
        <p class="card-text">Catégorie : <?php echo $data["Categorie"];?></p> 
        <p class="card-text"><small class="text-muted">Description : <?php echo $data["Description"];?></small></p>
           
            <?php
            
                if ($statut == "acheteur")
                {
                    if ($data["TypeVente"] == "Enchere") // Si c'est une enchere alors pop up
                    {
                        ?><button type="submit" id="BtnEnchere<?php echo($data["NumeroID"]); ?>"name="enchere" value="<?php echo($data["NumeroID"]); ?>" class="btn btn-outline-primary" data-toggle="modal" data-target="#enchereID<?php echo($data["NumeroID"]); ?>">Enchérir</button>
                            <div class="modal fade" id="enchereID<?php echo($data["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <?php require ("modal_encheres.php"); ?>
                            </div>
                        <?php
                    }
                    else if ($data["TypeVente"] == "Meilleure Offre")
                    {
                        ?><button type="submit" id="BtnMO<?php echo($data["NumeroID"]); ?>" name="negocier" value="<?php echo($data["NumeroID"]); ?>" class="btn btn-outline-primary" data-toggle="modal" data-target="#offreID<?php echo($data["NumeroID"]); ?>">Negocier</a></button>
                        
                            <div class="modal fade" id="offreID<?php echo($data["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <?php require ("modal_meilleure_offre.php"); ?>
                            </div>
                        <?php
                    }
                    else 
                    {
                        ?>
                            <button  class="btn btn-outline-primary"> <a href="?action=ajouterpanier&amp;id=<?php echo $data["NumeroID"];?> " >Ajouter au panier</a></button>
                        <?php
                    }
                    ?>
                    
                    </div>
    </div>
  </div>
                    <?php
                        
                    
                }
                                         ?>
            </figure>              
                <br>
            </div>
            <br>  
            <?php

            }  
            if(isset($_GET['action'])){
                            
                if($_GET['action']=='ajouterpanier'){
                                
                    $login=$_SESSION["login"];
                    $NumID=$_GET['id'];
                                
                        $sql2="INSERT INTO acheter_item(loginAcheteur,NumeroIDItem) VALUES ('$login','$NumID')";
                        $result2 = mysqli_query($db_handle, $sql2);
                        if($result2)
                        {
                            //echo"Article ajouté au panier";
                        }
                        else
                        {
                            //echo"L'article  est déja dans le panier";
                        }
                            
                        
                        }

                    }
  


        }


        ?>
                   
              
    </div>
    
    </body>
    
    <footer>
        <?php require("Footer.php");  ?>
    </footer>
    </html>
