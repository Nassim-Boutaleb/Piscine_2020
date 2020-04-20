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
                <p class="mb-0">BON POUR LE MUSE</p>
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

            if (connecte == 0) // Si on est pas connecte : empecher l'accès à acheter et vendre et panier
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });
                
                // Désactiver les liens
               

                $("#ajout").attr ({
                    "aria-disabled" : "true",
                    
                }).addClass("disabled");

                

            }

            else if (connecte == 1 && statut == "acheteur") // Si on est un acheteur
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });

                // désactiver les popovers de Achat et panier qui sont accssibles aux acheteurs
                
                $("#ppvajout").removeAttr("data-toggle");
                
                // Bloquer le lien vers vendre
                
            }

            else if (connecte == 1 && statut != "acheteur") // Si on n'est pas un acheteur (vendeur ou admin)
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });

                // Supprimer le popover de vendre qui est accsssible
                $("#ppvajout").removeAttr("data-toggle");
                
                // Bloquer les liens vers acheter et panier
                $("#ajout").attr ({
                    "aria-disabled" : "true",
                    
                }).addClass("disabled");

            }
        });
</script>
           

        <?php



        $database = "ecebay";
        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database);

        if ($db_found) 
        {
            
            $sql="SELECT * FROM item WHERE Categorie='Bon pour Muse'";          $result = mysqli_query($db_handle, $sql);

            while ($data = mysqli_fetch_assoc($result))
            {
                //Sauvegarder les variables 
                $nomItem = $data["Nom"];
                $idItem = $data["NumeroID"];
                ?>

                
            <div class="container" id="affarticle">
                <figure class="figure">
                    <img src="<?php echo $data["Image"];?>" alt="Photo Article" width="400" height="300" class="figure-img img-fluid img-thumbnail rounded">
                    <figcaption class="figure-caption float-right">
                        <h2><?php echo $data["Nom"]."  ";?></h2>
                    <p>Prix : <?php echo $data["Prix"];?>€</p>
                
                    <p>Type de vente : <?php echo $data["TypeVente"];?></p>
                    <p>Catégorie : <?php echo $data["Categorie"];?></p> 
                    <p class="lead" id="descriptionitem">Description : <?php echo $data["Description"];?></p></figcaption>
           
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
                            echo"Article ajouté au panier";
                        }
                        else
                        {
                            echo"L'article  est déja dans le panier";
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
