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

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 

         
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
        <?php require("Navbars/navbar_def.php");  ?>
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

                
                <h2><?php echo $data["Nom"]."  ";?></h2>
                <p>Prix : <?php echo $data["Prix"];?> €</p>
                <p id="descriptionitem">Description : <?php echo $data["Description"];?></p>
                <p>Type de vente : <?php echo $data["TypeVente"];?></p>
                <p>Catégorie : <?php echo $data["Categorie"];?></p>            
            <br>
            <button class="btn btn-secondary"><a href="?action=Supprimer&amp;id=<?php echo $data["NumeroID"];?>"> Supprimer
        </a></button>
            <?php
                        if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer'){
                $NumID=$_GET['id'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){
                        echo "Article supprimé";
                    }
                    else{
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
                ?>

                
                <h2><?php echo $data2["Nom"]."  ";?></h2>
                <p>Prix : <?php echo $data2["Prix"];?> €</p>
                <p id="descriptionitem">Description : <?php echo $data2["Description"];?></p>
                <p>Type de vente : <?php echo $data2["TypeVente"];?></p>
                <p>Catégorie : <?php echo $data2["Categorie"];?></p>            
            <br>
            <button class="btn btn-secondary"><a href="?action=Supprimer&amp;id=<?php echo $data3["NumeroID"];?>"> Supprimer
        </a></button>
            <?php
                        if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer'){
                $NumID=$_GET['id'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){
                        echo "Article supprimé";
                    }
                    else{
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


            while ($data3 = mysqli_fetch_assoc($result3))
            {
                
                ?>
                <h2><?php echo $data3["Nom"]."  ";?></h2>
                <p>Prix : <?php echo $data3["Prix"];?> €</p>
                <p id="descriptionitem">Description : <?php echo $data3["Description"];?></p>
                <p>Type de vente : <?php echo $data3["TypeVente"];?></p>
                <p>Catégorie : <?php echo $data3["Categorie"];?></p>            
            <br>
            <button class="btn btn-secondary"><a href="?action=Supprimer&amp;id=<?php echo $data3["NumeroID"];?>"> Supprimer
        </a></button>
            <?php

            if(isset($_GET['action'])){
               
            if($_GET['action']=='Supprimer'){
                $NumID=$_GET['id'];
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$NumID'";
                    $result4 = mysqli_query($db_handle, $sql4);
                    if($result4){
                        echo "Article supprimé";
                    }
                    else{
                        echo "L'article n'a pas pu être supprimé";
                    }
            }
        }
        }

      
        

      ?>
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