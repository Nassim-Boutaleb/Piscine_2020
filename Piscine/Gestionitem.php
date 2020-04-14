<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <link rel="stylesheet" type="text/css" href="styles.css"> 

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 

        <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran   
            }); 
        </script>
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
        <?php require("Navbars/navbar_def.php");  ?>

        <a href="?action=ajout">Ajouter un produit</a>
        <br>
        <a href="?action=modifier">Modifier un produit</a>
        <br>
        <a href="?action=supp">Supprimer un produit</a>
        <br>

        <!--TRAITEMENT DE L'AJOUT-->

        <?php

        if(isset($_GET['action'])){
           
            if($_GET['action']=='ajout'){


                if(isset($_POST['submit'])){

                    $nom = $_POST["nomitem"];
                    $Description =$_POST["Descriptionitem"];
                    $Categorie= $_POST["Categorieitem"];
                    $Prix = $_POST["Prixitem"];
                    $type = $_POST["typevente"];
                    $Photo = $_POST["Photoitem"];
                    

                    

                echo"nom: $nom, $Description,$Categorie, $Prix , $type,
                         $Photo ";

                    $database = "ecebay";

                    if($nom&&$Description&&$Categorie&&$Prix&&$type&&$Photo){
                        echo"Champs ok";

                        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                        $db_found = mysqli_select_db($db_handle, $database); 
                        if ($db_found) { 
                            echo"Bon pour la bdd";

                            $sql="INSERT INTO item (Nom,Categorie,Description,Prix,TypeVente,Image) VALUES ('$nom','$Categorie','$Description','$Prix','$type','$Photo')";
                            $result = mysqli_query($db_handle, $sql);

                            if($result)
                            {
                                
                                echo"inserted";
                            }
                            else{
                                echo"not inserted";
                            }

                        }
                        else{
                            echo"BDD ineexistante";
                        }

                   

                       

                    } else {

                        echo"veuillez remplir tout les champs";
                    }




                }

        ?>
<!--FORMULAIRE D'AJOUT-->
<div class="container">
    <form action="" method="POST" >
        <div class="form-group">
            <label for="nomitem">Nom</label>
             <input type="text" class="form-control" name="nomitem" aria-describedby="AideNom" placeholder="Nom Article">
            <small id="AideNom" class="form-text text-muted">Le nom de l'article mis en vente</small>
        </div>
        <div class="form-group">
            <label for="Descriptionitem">Description</label>
            <input type="text" class="form-control" name="Descriptionitem" placeholder="Description">
        </div>
         <div class="form-group">
            <label for="Categorieitem">Catégorie</label>
            <input type="text" class="form-control" name="Categorieitem" placeholder="Catégorie">
        </div>
        <div class="form-group">
            <label for="Prixitem">Prix</label>
            <input type="text" class="form-control" name="Prixitem" placeholder="Prix">
        </div>
        <div class="form-group">
            <label for="typevente">Type de vente </label>
            <input type="text" class="form-control" name="typevente" placeholder="Type de vente">
        </div>


            <div class="form-group">
            <label for="Photoitem">Photo de l'article</label>
            <input type="file" class="form-control-file" name="Photoitem">
        </div>
        <div class="form-check">
            <input type="checkbox" class="form-check-input" name="Check1">
            <label class="form-check-label" for="Check1">Validation</label>
        </div>
        <button type="submit" class="btn btn-primary" name='submit'>Soumettre</button>
    </form>
</div>

        <?php

            

            }else if($GET['action']=='modifier'){

            }else if($_GET['action']=='supp'){

            }else{

                die('erreur');
        }
        }

        ?>

    </body>
    </html>
