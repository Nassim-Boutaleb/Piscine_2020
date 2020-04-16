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

    <style>
        #finEnchere {
            display: none;
        }
    </style>

    <script type="text/javascript">
    $(document).ready(function() {
        $("#modifierImage").on("click",function(){  // Cliquer sur l'encoche modifier image= activer le champ
          
            if ($("#champModifierImage").attr("disabled") == "disabled")
            {
                $("#champModifierImage").removeAttr("disabled");
            }
            else
            {
                $("#champModifierImage").prop("disabled", true).trigger("click");
            }
        });

        $("#typevente").on("click",function(){
            if (document.getElementById("typevente").selectedIndex == 0)
            {
                $("#finEnchere").slideDown();
            }
            else
            {
                $("#finEnchere").slideUp();
            }
        });

    });
    </script>

    <!-- Empecher l'accès à la page si on est pas vendeur (blindage côté serveur) -->
    <?php 
        if ($_SESSION["statut"] != "administrateur" && $_SESSION["statut"] != "vendeur" )
        {
            echo("ERREUR PAS DE DROIT D'ACCES ! REDIRECTION EN COURS");
            ?> <meta http-equiv="refresh" content="0; url=accueil.php?alertCode=3"> <?php
        }
    ?>
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
                    $vendeur = $_SESSION["login"];
                    
                    // Pour le chargement de l'image
                    $uploaddir = 'Images/Ventes/'; // Chemin où les images seront enregistrées sur wamp
                    $uploadfile = $uploaddir . basename($_FILES['Photoitem']['name']);

                    
                    if (move_uploaded_file($_FILES['Photoitem']['tmp_name'], $uploadfile)) {
                        echo "Le fichier est valide, et a été téléchargé
                            avec succès. Voici plus d'informations :\n";
                    } else {
                        echo "Attaque potentielle par téléchargement de fichiers.
                            Voici plus d'informations :\n";
                        echo 'Voici quelques informations de débogage :';
                        print_r($_FILES);
                    }

                    // Pour la database: on enregistre le chemin de l'image
                    $Photo = $uploadfile;

                    // Connection database
                    $database = "ecebay";

                    if($nom&&$Description&&$Categorie&&$Prix&&$type&&$Photo)
                    {
                       
                        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                        $db_found = mysqli_select_db($db_handle, $database); 
                        if ($db_found) 
                        { 
                            // Ajouter l'itam à la table item
                            $sql="INSERT INTO item (Nom,Categorie,Description,Prix,TypeVente,Image,vendeur) VALUES ('$nom','$Categorie','$Description','$Prix','$type','$Photo','$vendeur')";
                            $result = mysqli_query($db_handle, $sql);

                            if($result)
                            {                              
                                // Si c'est une enchère: ajouter l'item aussi dans la table des enchères
                                if ($type == "Enchere")
                                {
                                    // Il faut d'abord récupérer son id créé automatiquement par sql en auto-increment...
                                    // Vu qu'on fait un auto-inrement, on récupéère l'ID le + élevé = c'est l'id du dernier item ajouté
                                    $sqlE="SELECT MAX(NumeroID) AS maxIdItem FROM item ";
                                    $resultE = mysqli_query($db_handle, $sqlE);
                                    $dataE = mysqli_fetch_assoc($resultE);
                                    $numeroIDItem = $dataE["maxIdItem"];

                                    
                                    /*$dateAjout = time();  // timestamp de l'ajout
                                    $dureeSecondes = 2*60*60;      //Disons 2heures // $_POST["typevente"]; pour récup valeur utilisateur une fois mis en place 

                                    $timestamp = date("Y-m-d H:i:s"); */

                                    $dateFin = date('Y-m-d', strtotime($_POST['dateFinEnchere']));
                                    $heureFin=date('H:i:00', strtotime($_POST['timeFinEnchere']));
                                    $dateHeureFin = $dateFin." ".$heureFin;

                                    echo("DR: $dateFin; HR: $heureFin, MM: $dateHeureFin, MAX:$numeroIDItem");
                                    

                                    $sqlE="INSERT INTO enchere (IdItem,dateDebut,dateFin) VALUES ('$numeroIDItem',NOW(),'$dateHeureFin')";
                                    $resultE = mysqli_query($db_handle, $sqlE);
                                    if ($resultE)
                                    {
                                        echo"Article ajouté";
                                        header("refresh:2, url=Gestionitem.php");
                                    }
                                    else
                                    {
                                        echo"Erreur ajout enchère";
                                    }
                                }
                                else 
                                {
                                    echo"Article ajouté";
                                    header("refresh:2, url=Gestionitem.php");
                                }
                                
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
        <form enctype="multipart/form-data" action="" method="POST">
            <div class="form-group">
                <label for="nomitem">Nom</label>
                <input type="text" class="form-control" name="nomitem" aria-describedby="AideNom"
                    placeholder="Nom Article">
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
            <div class="form-row" id="finEnchere" >
                <div class="form-row col-md-4" >
                    <label for="dateFinEnchere">Date de fin de l'enchère</label>
                    <input type="date" class="form-control" id="dateFinEnchere" name="dateFinEnchere">
                </div>
                <div class="form-row col-md-4" >
                    <label for="timeFinEnchere">Heure de fin de l'enchère</label>
                    <input type="time" class="form-control" id="timeFinEnchere" name="timeFinEnchere">
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <label for="Photoitem">Photo de l'article</label>
                <input type="file" class="form-control-file" name="Photoitem" accept=".jpg, .jpeg, .png">
            </div>
            <div class="form-check">
                <input type="checkbox" class="form-check-input" name="Check1">
                <label class="form-check-label" for="Check1">Validation</label>
            </div>
            <button type="submit" class="btn btn-primary" name='submit'>Soumettre</button>
        </form>
    </div>

    <!-- Traitement modifier ou supprimer -->
    <?php

            

            }else if($_GET['action']=='modifsupp'){
                $database = "ecebay";

                
                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database);
                $vendeur = $_SESSION["login"]; 
                { 
                    
                $sql="SELECT * FROM item WHERE vendeur='$vendeur' ";

                $result = mysqli_query($db_handle, $sql);

                

                while ($data = mysqli_fetch_assoc($result)){

                    
                    echo $data["NumeroID"]."  ";
                   
                    echo $data["Nom"];
                    
                    ?>
    <br>
    <button class="btn btn-secondary"><a href="?action=modifier&amp;id=<?php echo $data["NumeroID"];?>"> Modifier
        </a></button>
    <button class="btn btn-secondary"><a href="?action=supp&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer
        </a></button>
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
                    
                    $sql3="SELECT * FROM item WHERE NumeroID='$id' ";
                    $result3 = mysqli_query($db_handle, $sql3);
                    $data = mysqli_fetch_assoc($result3);
               
                }

                ?>
                    <div class="container">
                        <form enctype="multipart/form-data" action="" method="POST">
                            <div class="form-group">
                                <label for="nomitem">Nom</label>
                                <input type="text" class="form-control" name="nomitem" aria-describedby="AideNom"
                                    value="<?php echo $data["Nom"];?>">
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
                                <label for="typevente">Type de vente : <?php echo $data["TypeVente"];?> </label>
                                <select id="typevente" name="typevente">
                                    <?php echo $data["TypeVente"];?>"
                                    <option value="Enchere">Enchère</option>
                                    <option value="Meilleure Offre">Meilleure Offre</option>
                                    <option value="Achat direct">Achat immédiat</option>
                                </select>
                            </div>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="customCheck1" name="modImg">
                                <label class="custom-control-label" for="customCheck1" id="modifierImage">Modifier l'image de l'article</label>
                            </div>
                            <div class="form-group">
                                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                                <label for="PhotoitemR">Photo de l'article</label>
                                <input type="file" class="form-control-file" name="PhotoitemR" id="champModifierImage" disabled>
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
                        if (isset($_POST["modImg"]))// Si on a modifié la photo (case cochée): on la télécharge à nouveau
                        {
                            // Pour le chargement de l'image
                            $uploaddir = 'Images/Ventes/'; // Chemin où les images seront enregistrées sur wamp
                            $uploadfile = $uploaddir . basename($_FILES['PhotoitemR']['name']);

                            
                            if (move_uploaded_file($_FILES['PhotoitemR']['tmp_name'], $uploadfile)) {
                                echo "Le fichier est valide, et a été téléchargé
                                    avec succès. Voici plus d'informations :\n";
                            } else {
                                echo "Attaque potentielle par téléchargement de fichiers.
                                    Voici plus d'informations :\n";
                                echo 'Voici quelques informations de débogage :';
                                print_r($_FILES);
                            }

                            // Pour la database: on enregistre le chemin de l'image
                            $Photo = $uploadfile;
                        }

                        else // Si on ne l'a pas modifié : on garde la valeur actuelle dans la BDD
                        {
                            $Photo = $data["Image"];
                        }

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