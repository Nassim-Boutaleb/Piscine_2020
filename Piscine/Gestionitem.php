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
        <a href="?action=modifsupp">Modifier ou supprimer un produit</a>
        <br>
        <br>
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

                    $database = "ecebay";

                    if($nom&&$Description&&$Categorie&&$Prix&&$type&&$Photo)
                    {
                       
                        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                        $db_found = mysqli_select_db($db_handle, $database); 
                        if ($db_found) 
                        { 
                            $sql="INSERT INTO item (Nom,Categorie,Description,Prix,TypeVente,Image) VALUES ('$nom','$Categorie','$Description','$Prix','$type','$Photo')";
                            $result = mysqli_query($db_handle, $sql);

                            if($result)
                            {                              
                                echo"Article ajouté";
                                header("refresh:2, url=Gestionitem.php");
                            }
                            else
                            {
                                echo"L'article n'a pas pu être ajouté";
                            }
                        }
                        else
                        {
                            echo"BDD inexistante";
                        }
                    } 
                    else 
                    {
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
            <textarea class="form-control" name="Descriptionitem" placeholder="Description"> </textarea> 
        </div>

        <div class="form-group">
            <label for="Prixitem">Prix</label>
            <input type="text" class="form-control" name="Prixitem" placeholder="Prix">
        </div>
                 <div class="form-group">
            <label for="Categorieitem">Catégorie</label>
            
            <select id="Categorieitem" name="Categorieitem">
            <option value="Feraille ou Or">Feraille ou Or</option>
            <option value="Bon pour Muse">Bon pour le musé</option>
            <option value="Accesoire VIP">Accessoire VIP</option>
            </select>
        </div>
        <div class="form-group">
            <label for="typevente">Type de vente </label>
            <select id="typevente" name="typevente">
            <option value="Enchere">Enchère</option>
            <option value="Meilleure Offre">Meilleure Offre</option>
            <option value="Achat direct">Achat immédiat</option>
            </select>
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

            

            }else if($_GET['action']=='modifsupp'){
                $database = "ecebay";

                
                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database); 
                { 
                    
                $sql="SELECT * FROM item";

                $result = mysqli_query($db_handle, $sql);

                

                while ($data = mysqli_fetch_assoc($result)){

                    
                    echo $data["NumeroID"]."  ";
                   
                    echo $data["Nom"];
                    
                    ?>
                    <br>
                    <button class="btn btn-secondary"><a href="?action=modifier&amp;id=<?php echo $data["NumeroID"];?>"> Modifier </a></button>
                    <button class="btn btn-secondary"><a href="?action=supp&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer </a></button>
                    <br><br>

                    <?php

                }
            }
                
            }
            else if($_GET['action']=='modifier')       
            {




                $database = "ecebay";
                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database);
                if ($db_found) 
                {

                $id=$_GET['id'];
                
                $sql3="SELECT * FROM item WHERE NumeroID='$id'";
                $result3 = mysqli_query($db_handle, $sql3);
                $data = mysqli_fetch_assoc($result3);
               
                }

                ?>
<div class="container">
    <form action="" method="POST" >
        <div class="form-group">
            <label for="nomitem">Nom</label>
             <input type="text" class="form-control" name="nomitem" aria-describedby="AideNom" value="<?php echo $data["Nom"];?>">
            <small id="AideNom" class="form-text text-muted">Le nom de l'article mis en vente</small>
        </div>
        <div class="form-group">
            <label for="Descriptionitem">Description</label>
            <textarea class="form-control" name="Descriptionitem"><?php echo $data["Description"];?> </textarea> 
        </div>

        <div class="form-group">
            <label for="Prixitem">Prix</label>
            <input type="text" class="form-control" name="Prixitem" value="<?php echo $data["Prix"];?>">
        </div>
                 <div class="form-group">
            <label for="Categorieitem">Catégorie: <?php echo $data["Categorie"];?> </label>
            
            <select id="Categorieitem" name="Categorieitem" value="<?php echo $data["Categorie"];?>">
            <option value="Feraille ou Or">Feraille ou Or</option>
            <option value="bon pour Musé">Bon pour le musé</option>
            <option value="Accesoire VIP">Accessoire VIP</option>
            </select>
        </div>
        <div class="form-group">
            <label for="typevente" >Type de vente : <?php echo $data["TypeVente"];?> </label>
            <select id="typevente" name="typevente" >
                <?php echo $data["TypeVente"];?>"
            <option value="Enchere">Enchère</option>
            <option value="Meilleure Offre">Meilleure Offre</option>
            <option value="Achat direct">Achat immédiat</option>
            </select>
        </div>
        <div class="form-group">
            <label for="Photoitem">Photo de l'article</label>
            <input type="file" class="form-control-file" name="Photoitem" >
        </div>
        
        <button type="submit" class="btn btn-primary" name="modif" value='Modifier'>Modifier</button>
    </form>
</div>



                <?php
                     if(isset($_POST['modif'])){
                    $nom = $_POST["nomitem"];
                    $Description =$_POST["Descriptionitem"];
                    $Categorie= $_POST["Categorieitem"];
                    $Prix = $_POST["Prixitem"];
                    $type = $_POST["typevente"];
                    $Photo = $_POST["Photoitem"];

                    echo"submit ok   - ";
                    
                    $sql4="UPDATE item SET Nom='$nom',Categorie='$Categorie',Description='$Description',Prix='$Prix',TypeVente='$type',Image='$Photo' WHERE NumeroID='$id'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){
                        echo"requete OK";
                    }

                }

            }
            /* SUPPRESION ARTICLE*/

            else if($_GET['action']=='supp')
            {
                $database = "ecebay";
                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database);
                if ($db_found) 
                {
                    echo"BDD OK";
                    $id=$_GET['id'];
                    $sql2="DELETE FROM item WHERE NumeroID=$id";
                    $result2 = mysqli_query($db_handle, $sql2);
                }                
            }
        }
        ?>

    </body>
    <footer>
        <?php require("Footer.php");  ?>
    </footer>
    </html>
