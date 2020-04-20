<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        
        <link rel="stylesheet" type="text/css" href="Catalogue.css">  
        <link rel="stylesheet" type="text/css" href="styles.css">
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> 

        
        
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
        <?php require("Navbars/navbar_def.php");  ?>

       
            <blockquote class="blockquote text-center">
                <p class="mb-0">Disponibles à l'achat immédiat</p>
                <footer class="blockquote-footer">Une selection d'articles hors du commun </footer>
            </blockquote>
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
?>

<script>
        $(document).ready (function()
        {
            var connecte = <?php echo("$connecte"); ?>;
            var statut = "<?php echo("$statut"); ?>";

        });
</script>
           

        <?php



        $database = "ecebay";
        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database);

        if ($db_found) 
        {
            
            $sql="SELECT * FROM item WHERE TypeVente='Achat direct'";           $result = mysqli_query($db_handle, $sql);

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
                        ?><button type="submit" name="enchere" value="<?php echo($data["NumeroID"]); ?>" class="btn btn-secondary " data-toggle="modal" data-target="#enchereID<?php echo($data["NumeroID"]); ?>">Enchérir</button>
                            <div class="modal fade" id="enchereID<?php echo($data["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <?php require ("modal_encheres.php"); ?>
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
