<?php session_start(); ?> 
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Votre panier</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <!-- <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css"> -->
        <link rel="stylesheet" type="text/css" href="styles.css"> 
        <link rel="stylesheet" type="text/css" href="panier.css"> 

        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> 
        <?php
         $alertCode2 = isset($_GET["alertCode2"])?$_GET["alertCode2"] : "0" ; 
        ?>

        <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran 

                // affichage d'une alerte pour la déconnexion
                var alertCode2 = <?php echo($alertCode2); ?>;
                if (alertCode2 == 1) // on affiche le succès de déconnexion
                {
                  $("#texteAlerte2").text("l'article a été supprimé");
                  $("#Alerte2").slideDown();
                }

                if (alertCode2 == 2) // on affiche le succès de création de compte
                {
                  $("#texteAlerteD2").text("l'article n'a pas pu être supprimé");
                  $("#AlerteD2").slideDown();
                }

                
            }); 
        </script>
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
        <?php require("Navbars/navbar_def.php");  ?>

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
    <a class="nav-link active" id="tab_enchere" data-toggle="tab" href="#enchere" role="tab" aria-controls="enchere" aria-selected="true">Enchere</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="tab_offre" data-toggle="tab" href="#offre" role="tab" aria-controls="offre" aria-selected="false">Meilleure Offre</a>
  </li>
  <li class="nav-item">
    <a class="nav-link" id="tab_achat" data-toggle="tab" href="#achat" role="tab" aria-controls="achat" aria-selected="false">Achats immédiats</a>
  </li>
</ul>
<div class="tab-content" id="myTabContent">
  <div class="tab-pane fade show active" id="enchere" role="tabpanel" aria-labelledby="tab_enchere">

      <?php 
            
        $sql="SELECT * FROM item,acheter_item WHERE acheter_item.loginAcheteur='$login'AND acheter_item.NumeroIDItem=item.NumeroID AND item.TypeVente='enchere'";
           $result = mysqli_query($db_handle, $sql);
            while ($data = mysqli_fetch_assoc($result))
            {
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
                <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer
        </a></button>
            <?php
                        if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer'){
                $NumID=$_GET['id'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){?>
                        <meta http-equiv="refresh" content="0; url=Panier.php?alertCode2=1"> <?php
                        echo "Article supprimé";
                    }
                    else{
                        ?>
                        <meta http-equiv="refresh" content="0; url=Panier.php?alertCode2=2"> <?php
                        echo "L'article n'a pas pu être supprimé";
                    }
            }
        }
        }


      
        

      ?>
  </div>

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
                    <img src="<?php echo $data["Image"];?>" alt="Photo Article" width="400" height="300" class="figure-img img-fluid img-thumbnail rounded">
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
                <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;id=<?php echo $data2["NumeroID"];?>&amp;PrixV=<?php echo $data2["Prix"]?>"> Supprimer</a></button>
                <button type="submit" name="negocier" value="<?php echo($data2["NumeroID"]); ?>" class="btn btn-secondary " data-toggle="modal" data-target="#offreID<?php echo($data2["NumeroID"]); ?>">Negocier</a></button>    
                    <div class="modal fade" id="offreID<?php echo($data2["NumeroID"]); ?>" data-backdrop="static" tabindex="-1" role="dialog" aria-labelledby="staticBackdropLabel" aria-hidden="true">
                                <?php require ("modal_meilleure_offre.php"); ?>
                    </div>
            <?php
                        if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer')
            {
                $NumID=$_GET['id'];
                $Prix=$_GET['PrixV'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                $result4 = mysqli_query($db_handle, $sql4);

                if($result4)
                {

                    echo "Article supprimé";
                    $sql5="UPDATE item SET afficher='1' WHERE NumeroID='$NumID'";
                    $result5=mysqli_query($db_handle, $sql5);

                    if($result5)
                    { 
                        $sql6="SELECT * FROM meilleure_offre WHERE idItemOffre='NumID' ";
                        $result6=mysqli_query($db_handle, $sql6);

                        while($data6=mysqli_fetch_assoc($result6))
                        {
                            $idOffre=$data6["IdOffre"];
                            $sql7="DELETE FROM acheteur_offre WHERE IdOffre='IdOffre'";
                            $result7=mysqli_query($db_handle, $sql7);

                            if($result7)
                           {
                                    
                                $sql8="UPDATE meilleure_offre SET nbOffres='0',PrixVendeur='$Prix' WHERE idItemOffre='$NumID'";
                                $result8=mysqli_fetch_assoc($db_handle,$sql8);

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
                    ?>
                    <meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=2">
                    <?php
                    echo "L'article n'a pas pu être supprimé";
                }
            }
        }
    }
      
        

      ?>

  </div>
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
                    <button class="btn btn-outline-primary"><a href="?action=Supprimer&amp;id=<?php echo $data3["NumeroID"];?>"> Supprimer
        </a></button>
                    </figcaption>
                </figure>              
                <br>
                </div>   
                <br>
                
            <?php

            if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer'){
                $NumID=$_GET['id'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){
                        echo "Article supprimé";?>
                        <meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=1"> 
                        <?php
                    }
                    else{
                        ?>
                        <meta http-equiv="refresh" content="1; url=Panier.php?alertCode2=2">
                         <?php
                        echo "L'article n'a pas pu être supprimé";
                    }
            }
        }        
    }echo"$Total";


      
        

      ?>
      <button class="btn btn-outline-primary"><a href=""> Paiement</a></button>
      </div>
   </div>
</div>
<?php

}


?>
    </body>
    <footer>
        <?php require("Footer.php");  ?>
    </footer>
    </html>