<?php session_start(); ?> 
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Votre panier</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
        <link rel="stylesheet" type="text/css" href="styles.css"> 
        <link rel="stylesheet" type="text/css" href="panier.css"> 
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
        <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
        <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>

        
        <?php
            $alertCode2 = isset($_GET["alertCode2"])?$_GET["alertCode2"] : "0" ;  // code erreur

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

            // Blinder accès à la page
            if ($connecte == 0 || $statut !="acheteur" )
            {
               ?> <meta http-equiv="refresh" content="0; url=accueil.php?alertCode=3"> <?php
            }
        
            // Dans modal_encheres on a besoin de connaitre l'URL de la page qui l'appelle
            $urlRed = "catalogue.php";
        
            // Récupérer l'erreur de la modal enchère et l'item concerné
            $erreurEnchere = isset($_GET["erreurEnch"])?$_GET["erreurEnch"]:"0";
            $numeroIdItemERR = isset($_GET["NumeroId"])?$_GET["NumeroId"]:"0";  
            
            // Récupérer l'erreur de la modal meilleure offre et l'item concerné
            $erreurMO = isset($_GET["erreurMO"])?$_GET["erreurMO"]:"0";
            $numeroIdItemERRMO = isset($_GET["IdItemErrMO"])?$_GET["IdItemErrMO"]:"0";
        ?>

        <script type="text/javascript">      
            $(document).ready(function(){           
                
                var alertCode2 = <?php echo($alertCode2); ?>;

                if (alertCode2 == 1) 
                {
                  $("#texteAlerte2").text("l'article a été supprimé");
                  $("#Alerte2").slideDown();
                }

                if (alertCode2 == 2) 
                {
                  $("#texteAlerteD2").text("l'article n'a pas pu être supprimé");
                  $("#AlerteD2").slideDown();
                }

                if (alertCode2 == 6) 
                {
                  $("#texteAlerteD2").text("Vous ne pouvez pas supprimer une enchère une fois démarrée !");
                  $("#AlerteD2").slideDown();
                }

                // Récupérer les erreurs (enchères)
                var erreurEnchere = <?php echo($erreurEnchere); ?>;
                var numeroIdItemERR = <?php echo($numeroIdItemERR); ?>;
                
                // Récupérer les erreurs (meilleures offres)
                var erreurMO = <?php echo($erreurMO); ?>;
                var numeroIdItemERRMO = <?php echo($numeroIdItemERRMO); ?>;                
                

                // Rouvrir la modal enchere (la pop up) si besoin 
                if (erreurEnchere == 5) // montant de l'enchère trop petit
                {
                    //alert ("enchereID: "+numeroIdItem);
                    $("#BtnEnchere"+numeroIdItemERR).trigger ("click"); // réafficher la fenêtre (comme si on avait cliqué sur le bonton enchère de l'item concerné)
                }  

                // Rouvrir la modal meilleure offre (la pop up) si besoin 
                if (erreurMO == 5) // montant de l'enchère trop petit
                {
                    $("#myTab li:nth-child(2) a").tab('show');
                    $("#BtnMO"+numeroIdItemERRMO).trigger ("click"); // réafficher la fenêtre (comme si on avait cliqué sur le bonton enchère de l'item concerné)
                }
            }); 
        </script>
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
        <?php require("Navbars/navbar_def.php");  ?>

        <!-- Alertes -->
        <div class="alert alert-warning alert-dismissible fade show" role="alert" id="Alerte2">
          <strong id="texteAlerte2"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <div class="alert alert-danger alert-dismissible fade show" role="alert" id="AlerteD2">
          <strong id="texteAlerteD2"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>

        <!--PHP Panier-->

        <?php 
   
            //identifier le nom de base de données 
            $database = "ecebay"; 
            $login=$_SESSION["login"];
            //connectez-vous dans votre BDD 
            //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
            $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
            $db_found = mysqli_select_db($db_handle, $database); 
            if ($db_found) 
            {
                ?>     
                <!--Panier-->
                <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item">
                    <a class="nav-link active" id="tab_enchere" data-toggle="tab" href="#enchere" role="tab" aria-controls="enchere" aria-selected="true" style="color:black;">Enchere</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab_offre" data-toggle="tab" href="#offre" role="tab" aria-controls="offre" aria-selected="false" style="color:grey;">Meilleure Offre</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab_achat" data-toggle="tab" href="#achat" role="tab" aria-controls="achat" aria-selected="false" style="color:grey;">Achats immédiats</a>
                </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    
                    <!-- Onglet enchères -->
                    <div class="tab-pane fade show active" id="enchere" role="tabpanel" aria-labelledby="tab_enchere">
                        <?php 
                            $urlRed = "Panier.php";
                            $sql="SELECT * FROM item,acheter_item WHERE acheter_item.loginAcheteur='$login'AND acheter_item.NumeroIDItem=item.NumeroID AND item.TypeVente='enchere'";
                            $result = mysqli_query($db_handle, $sql);
                            while ($data = mysqli_fetch_assoc($result))
                            {
                                $idItem = $data["NumeroID"];
                                $nomItem = $data["Nom"];
                                ?>
                                <div class="container" id="affarticle">
                                    <figure class="figure">
                                        <img src="<?php echo $data["Image"];?>" alt="Photo Article" width="400" height="300" class="figure-img img-fluid img-thumbnail rounded">
                                        <figcaption class="figure-caption float-right">
                                            <h2><?php echo $data["Nom"]."  ";?></h2>
                                                <p>Prix : <?php echo $data["Prix"];?>€</p>
                                                <p>Type de vente : <?php echo $data["TypeVente"];?></p>
                                                <p>Catégorie : <?php echo $data["Categorie"];?></p> 
                                        </figcaption>
                                    </figure>              
                                    <br>
                                </div>   
                                <br>
                                <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;TV=E&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer</a></button>
                                <button  id="BtnEnchere<?php echo($data["NumeroID"]); ?>" name="negocier" value="<?php echo($data["NumeroID"]); ?>" class="btn btn-secondary " data-toggle="modal" data-target="#enchereID<?php echo($data["NumeroID"]); ?>">Enchérir</a></button>    
                                
                                <!-- Modal enchere -->
                                <div class="modal fade" id="enchereID<?php echo($data["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <?php require ("modal_encheres.php"); ?>
                                </div>

                                <?php
                            }
                        ?>
                    </div>

                    <!-- onglet Offres -->
                    <div class="tab-pane fade" id="offre" role="tabpanel" aria-labelledby="tab_offre"> 
                        <?php 
                            $sql2="SELECT * FROM item,acheter_item WHERE loginAcheteur='$login'AND NumeroIDItem=item.NumeroID AND item.TypeVente='Meilleure Offre' ";
                            $result2 = mysqli_query($db_handle, $sql2);
                            while ($data2 = mysqli_fetch_assoc($result2))
                            {
                                $idItem = $data2["NumeroID"];
                                ?>
                                <div class="container" id="affarticle">
                                    <figure class="figure">
                                        <img src="<?php echo $data2["Image"];?>" alt="Photo Article" width="400" height="300" class="figure-img img-fluid img-thumbnail rounded">
                                        <figcaption class="figure-caption float-right">
                                            <h2><?php echo $data2["Nom"]."  ";?></h2>
                                            <p>Prix : <?php echo $data2["Prix"];?>€</p>
                                            <p>Type de vente : <?php echo $data2["TypeVente"];?></p>
                                            <p>Catégorie : <?php echo $data2["Categorie"];?></p> 
                                        </figcaption>
                                    </figure>              
                                    <br>
                                </div> 

                                <br>
                                <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;TV=O&amp;id=<?php echo $data2["NumeroID"];?>&amp;PrixV=<?php echo $data2["Prix"]?>"> Supprimer</a></button>
                                <button id="BtnMO<?php echo($data2["NumeroID"]); ?>" type="submit" name="negocier" value="<?php echo($data2["NumeroID"]); ?>" class="btn btn-secondary " data-toggle="modal" data-target="#offreID<?php echo($data2["NumeroID"]); ?>">Negocier</a></button>    
                                
                                <!-- Modal offre -->
                                <div class="modal fade" id="offreID<?php echo($data2["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                    <?php require ("modal_meilleure_offre.php"); ?>
                                </div>
                                
                                <?php
                                
                            }
                        ?>
                    </div> <!-- Fin onglet offres -->

                    <!-- Onglet acahts directs -->
                    <div class="tab-pane fade" id="achat" role="tabpanel" aria-labelledby="tab_achat">
                        <div class="container">  
                            <?php 
                                $sql3="SELECT * FROM item,acheter_item WHERE loginAcheteur='$login'AND NumeroIDItem=item.NumeroID AND item.TypeVente='Achat direct' ";
                                $result3 = mysqli_query($db_handle, $sql3);
                                $Total=0;
                                while ($data3 = mysqli_fetch_assoc($result3))
                                {   
                                    $Total=$data3["Prix"]+$Total;
                                    ?>
                                    <div class="container" id="affarticle">
                                        <figure class="figure">
                                            <img src="<?php echo $data3["Image"];?>" alt="Photo Article" width="200" height="100" class="figure-img img-fluid img-thumbnail rounded">
                                            <figcaption class="figure-caption float-right">
                                                <h2><?php echo $data3["Nom"]."  ";?></h2>
                                                <p>Prix : <?php echo $data3["Prix"];?>€</p>
                                                <p>Type de vente : <?php echo $data3["TypeVente"];?></p>
                                                <p>Catégorie : <?php echo $data3["Categorie"];?></p> 
                                                <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;TV=D&amp;id=<?php echo $data3["NumeroID"];?>"> Supprimer</a></button>
                                            </figcaption>
                                        </figure>              
                                        <br>
                                    </div>   
                                    <br>
                                    <?php
                                                
                                }
                                //echo"$Total";
                                $_SESSION["TotalPanier"]=$Total;
                            ?>
                            <button class="btn btn-outline-primary"><a href="paiement.php"> Paiement</a></button>
                        </div>
                    </div>
                </div> <!-- Fin du tab-content -->
                <?php
                
                //Gestion des suppressions:
                if(isset($_GET['action']))
                {
                    if($_GET['action']=='Supprimer')
                    {
                        $typeDeVente = $_GET["TV"];
                        
                        if ($typeDeVente == "E")
                        {
                            ?> <meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=6"> <?php
                        }
                        else if ($typeDeVente == "O")
                        {
                            $NumID=$_GET['id'];
                            $Prix=$_GET['PrixV'];
                            $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                            $result4 = mysqli_query($db_handle, $sql4);
                            if($result4)
                            {
                                //echo "Article supprimé";
                                $sql5="UPDATE item SET afficher='1' WHERE NumeroID='$NumID'";
                                $result5=mysqli_query($db_handle, $sql5);

                                if($result5)
                                { 
                                    $sql6="SELECT * FROM meilleure_offre WHERE IdItemOffre='$NumID' ";
                                    $result6=mysqli_query($db_handle, $sql6);
                                    if($data6=mysqli_fetch_assoc($result6))
                                    {
                                        $idOffre=$data6["IdOffre"];
                                        $sql7="DELETE FROM acheteur_offre WHERE IdOffre='$idOffre'";
                                        $result7=mysqli_query($db_handle, $sql7);
                                        if($result7)
                                        {
                                            $newnboffre=0;
                                            $sql8="UPDATE meilleure_offre SET nbOffres='$newnboffre',PrixVendeur='$Prix' WHERE IdItemOffre='$NumID'";
                                            $result8=mysqli_query($db_handle,$sql8);
                                            if($result8)
                                            {
                                                ?>
                                                <meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=1"> 
                                                <?php
                                            }
                                        }
                                    }
                                }
                            }
                            else
                            {
                                ?><meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=2"><?php                       
                                echo "L'article n'a pas pu être supprimé";
                            }
                        }
                        else if ($typeDeVente == "D")
                        {
                            $NumID=$_GET['id'];
                            $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                            $result4 = mysqli_query($db_handle, $sql4);
                            if($result4)
                            {
                                echo "Article supprimé";
                                ?><meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=1"> <?php
                            }
                            else
                            {
                                ?><meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=2"><?php
                                echo "L'article n'a pas pu être supprimé";
                            }
                        }

                        
                    }
                }

            }
        ?>
    </body>

    <footer>
        <?php require("Footer.php");  ?>
    </footer>
</html>