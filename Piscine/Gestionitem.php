<?php session_start(); ?>
<!DOCTYPE html>
<html>

<head>
    <title>Ebay ECE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="styles.css">
    <link rel="stylesheet" type="text/css" href="Gestionitem.css">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>

    <style>
        #finEnchere {
            display: none;
        }
    </style>

    <?php $alertCode = isset($_GET["alertCode"])?$_GET["alertCode"] : "0" ; ?>

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
                    document.getElementById("timeFinEnchere").required = true;
                    document.getElementById("dateFinEnchere").required = true;
                }
                else
                {
                    $("#finEnchere").slideUp();
                    document.getElementById("timeFinEnchere").required = false;
                    document.getElementById("dateFinEnchere").required = false;
                }
            });

            // affichage d'une alerte pour la déconnexion
            var alertCode = <?php echo($alertCode); ?>;

            if (alertCode == 101) // on affiche le succès de déconnexion
            {
                $("#texteAlerte").text("Article mis en vente !");
                $("#Alerte").slideDown();
            }
            if (alertCode == 105) // on affiche le succès de déconnexion
            {
                $("#texteAlerteD").text("Une erreur est survenue dans la BDD");
                $("#AlerteD").slideDown();
            }
            if (alertCode == 105) // on affiche le succès de déconnexion
            {
                $("#texteAlerteD").text("Veuillez remplir tous les champs");
                $("#AlerteD").slideDown();
            }
            if (alertCode == 115) // on affiche le succès de déconnexion
            {
                $("#texteAlerte").text("Article modifié");
                $("#Alerte").slideDown();
            }
            if (alertCode == 119) // on affiche le succès de déconnexion
            {
                $("#texteAlerte").text("Article supprimé");
                $("#Alerte").slideDown();
            }
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


    <!-- Contenu -->
    <div class="card " style="width: 55rem;height: 30rem;">
        <div class="card-body">
            <h2 class="card-title" style="margin-left: 385px">Options</h2>
                <button type="button" class="btn btn-secondary float-left" style="margin-top: 90px"><a href="?action=ajout">Ajouter un produit</a></button>

                <button type="button" class="btn btn-secondary float-none" style="margin-top: 90px; margin-left: 110px"><a href="?action=modifsupp">Modifier ou supprimer un produit</a></button>

                <button type="button" class="btn btn-secondary float-right" style="margin-top: 90px"><a href="?action=negotiations">Voir negotiations en cours</a></button>
        </div>
    </div>
    

    <!--TRAITEMENT DE L'AJOUT-->

    <?php

        if(isset($_GET['action']))
        {
            if($_GET['action']=='ajout')
            {
                if(isset($_POST['submit']))
                {

                    $nom = $_POST["nomitem"];
                    $Description =$_POST["Descriptionitem"];
                    $Categorie= $_POST["Categorieitem"];
                    $Prix = $_POST["Prixitem"];
                    $type = $_POST["typevente"];
                    $vendeur = $_SESSION["login"];
                    
                    // Pour le chargement de l'image
                    $uploaddir = 'Images/Ventes/'; // Chemin où les images seront enregistrées sur wamp
                    $uploadfile = $uploaddir . basename($_FILES['Photoitem']['name']);

                    
                    if (move_uploaded_file($_FILES['Photoitem']['tmp_name'], $uploadfile)) 
                    {
                        /*echo "Le fichier est valide, et a été téléchargé
                            avec succès. Voici plus d'informations :\n"; */
                    } 
                    else 
                    {
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
                            $sql="INSERT INTO item (Nom,Categorie,Description,Prix,TypeVente,Image,vendeur,afficher) VALUES ('$nom','$Categorie','$Description','$Prix','$type','$Photo','$vendeur','1')";
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

                                    
                                    

                                    $dateFin = date('Y-m-d', strtotime($_POST['dateFinEnchere']));
                                    $heureFin=date('H:i:00', strtotime($_POST['timeFinEnchere']));
                                    $dateHeureFin = $dateFin." ".$heureFin;

                                    //echo("DR: $dateFin; HR: $heureFin, MM: $dateHeureFin, MAX:$numeroIDItem");
                                    

                                    $sqlE="INSERT INTO enchere (IdItem,meilleureOffre,dateDebut,dateFin) VALUES ('$numeroIDItem',$Prix,NOW(),'$dateHeureFin')";
                                    $resultE = mysqli_query($db_handle, $sqlE);
                                    if ($resultE)
                                    {
                                        //echo"Article ajouté";
                                        ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=101"><?php
                                    }
                                    else
                                    {
                                        //echo"Erreur ajout enchère";
                                    }
                                }
                                /* Si L'article est de type meilleure offre remplir la table*/
                                else if ($type == "Meilleure Offre")
                                {
                                    
                                   $sqlE="SELECT MAX(NumeroID) AS maxIdItem FROM item ";
                                    $resultE = mysqli_query($db_handle, $sqlE);
                                    $dataE = mysqli_fetch_assoc($resultE);
                                    $numeroIDItem = $dataE["maxIdItem"];


                                    $sqlO="INSERT INTO meilleure_offre(IdItemOffre,nbOffres,PrixVendeur,Consensus) VALUES('$numeroIDItem','0','$Prix','0')"; 
                                    $resultO=mysqli_query($db_handle, $sqlO);
                                    if($resultO){
                                        //echo"Article ajouté";
                                        ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=101"><?php
                                    }
                                    else
                                    {
                                        echo"ERREUR ajout meilleure offre";
                                    }

                                }

                                else 
                                {
                                    //echo"Article ajouté";
                                    ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=101"><?php
                                }
                                //echo"Article ajouté";
                                ?>
                                <meta http-equiv="refresh" content="0; url=Gestionitem.php?alertCode=101"> <?php
                            }
                            else
                            {
                                echo"L'article n'a pas pu être ajouté";
                                ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=105"><?php
                            }
                        }
                        else
                        {
                            echo"BDD inexistante";
                            ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=105"><?php
                        }
                    } 
                    else 
                    {
                        echo"veuillez remplir tout les champs";
                        ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=109"><?php
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
                    <option value="Achat direct" selected>Achat immédiat</option>
                </select>
            </div>
            <div class="form-row" id="finEnchere" >
                <div class="form-row col-md-4" >
                    <label for="dateFinEnchere">Date de fin de l'enchère</label>
                    <input type="date" class="form-control" id="dateFinEnchere" name="dateFinEnchere">
                    <small class="form-text text-muted">JJ/MM/AAAA</small>
                </div>
                <div class="form-row col-md-4" >
                    <label for="timeFinEnchere">Heure de fin de l'enchère</label>
                    <input type="time" class="form-control" id="timeFinEnchere" name="timeFinEnchere">
                    <small class="form-text text-muted">HH:MM</small>
                </div>
            </div>
            <div class="form-group">
                <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
                <label for="Photoitem">Photo de l'article</label>
                <input type="file" class="form-control-file" name="Photoitem" accept=".jpg, .jpeg, .png">
            </div>
    
            <button type="submit" class="btn btn-primary" name='submit'>Soumettre</button>
        </form>
    </div>

    <!-- Traitement modifier ou supprimer -->
            <?php

            

            } // fermer if get[action] = ajout
            else if($_GET['action']=='modifsupp')
            {
                $database = "ecebay";

                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database);
                $vendeur = $_SESSION["login"]; 
                 
                if($_SESSION["statut"] == "administrateur")
                {
                    $sql="SELECT * FROM item";
                }
                else 
                {
                    //echo ($vendeur);
                    $sql="SELECT * FROM item WHERE vendeur='$vendeur' ";
                }
                /* FAIRE DEUX CAS DISTINCTSPOUR VENDEUR ET ADMIN*/
                $result = mysqli_query($db_handle, $sql);

                ?>
                <br>
                <h3 style="text-align: center;">Liste des articles en ligne </h3><?php
                while ($data = mysqli_fetch_assoc($result))
                {
                    ?>
                    <div class="container" id="listeArticles">
                        <?php echo $data["Nom"]; ?>    
                        <br>
                        <button class="btn btn-success"><a href="?action=modifier&amp;id=<?php echo $data["NumeroID"];?>"> Modifier</a></button>
                        <button class="btn btn-danger"><a href="?action=supp&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer</a></button>
                        <br><br>
                    </div>
            <?php
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
                    <div class="container" id="formmodif">
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
                     if(isset($_POST['modif']))
                     {
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
                                /*echo "Le fichier est valide, et a été téléchargé
                                    avec succès. Voici plus d'informations :\n"; */
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

                        $sql4="UPDATE item SET Nom='$nom',Categorie='$Categorie',Description='$Description',Prix='$Prix',TypeVente='$type',Image='$Photo' WHERE NumeroID='$id'";
                        $result4 = mysqli_query($db_handle, $sql4);
                        if($result4){
                            //echo"Article modifié";
                            ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=115"><?php
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
                    
                    $id=$_GET['id'];
                    $sql3="SELECT * FROM item WHERE NumeroID='$id'";
                    $result3=mysqli_query($db_handle,$sql3);
                    $data3=mysqli_fetch_assoc($result3);
                    $typevente=$data3["TypeVente"];
                    if($typevente=='Meilleure Offre')
                    {
                        $sql6="SELECT * FROM meilleure_offre WHERE IdItemOffre='$id' ";
                        $result6=mysqli_query($db_handle, $sql6);

                        if($data6=mysqli_fetch_assoc($result6))
                        {   
                            $idOffre=$data6["IdOffre"];
                            $sql7="DELETE FROM acheteur_offre WHERE IdOffre='$idOffre'";
                            $result7=mysqli_query($db_handle, $sql7);

                            if($result7)
                           {   

                                $sql8="DELETE FROM meilleure_offre  WHERE IdItemOffre='$id'";
                                $result8=mysqli_query($db_handle,$sql8);
                                if($result8)
                                {
                                    $sql2="DELETE FROM item WHERE NumeroID=$id";
                                    $result2 = mysqli_query($db_handle, $sql2);
                                    echo"Article supprimé";
                                }      
                            }
                        } 

                    }
                    else{
                        $sql2="DELETE FROM item WHERE NumeroID=$id";
                    $result2 = mysqli_query($db_handle, $sql2);
                    $data2=mysqli_fetch_assoc($result2);
                    }
                    ?><meta http-equiv="refresh" content="0; url=gestionitem.php?alertCode=119"><?php
                }                
            }
            
            else if($_GET['action']=='negotiations')
            {
                $database = "ecebay";
                $db_handle = mysqli_connect('localhost', 'root', 'root'); 
                $db_found = mysqli_select_db($db_handle, $database);
                if ($db_found) 
                {
                        $vendeur = $_SESSION["login"]; 
                 
                        if($_SESSION["statut"] == "administrateur")
                        {
                            $sql="SELECT * FROM item";
                        }
                            else 
                        {
                    //echo ($vendeur);
                            $sql="SELECT * FROM item WHERE vendeur='$vendeur' ";
                        }


                        $sqlA="SELECT * FROM item WHERE TypeVente='Meilleure Offre' AND afficher='0' AND vendeur='$vendeur'";
                        $resultA=mysqli_query($db_handle,$sqlA);
                     
                        ?>
                         <br>
                        <h3 style="text-align: center;">Liste des articles en cours de négotiations </h3>
                        <?php

                        while($dataA=mysqli_fetch_assoc($resultA))
                        {
                            $idItem=$dataA["NumeroID"];

                            ?>

                            <div class="container" id="listeNegotiations">
                    
                            <?php echo $dataA["Nom"];?>
                            <br>
                            <button type="submit" name="negocier" value="$id" class="btn btn-secondary " data-toggle="modal" data-target="#offreID<?php echo($idItem); ?>">Negocier</a></button>

                            <div class="modal fade" id="offreID<?php echo($idItem); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <?php require ("modal_meilleure_offre_vendeur.php"); ?>
                            </div>


                            <br><br>
                            </div> 
                            <?php

                        }
                    
                }
                           
            }
        } // fin if isset action
        ?>
        

</body>
<footer>
    <?php require("Footer.php");  ?>
</footer>

</html>