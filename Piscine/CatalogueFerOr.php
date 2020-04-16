<?php session_start(); ?>
<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <link rel="stylesheet" type="text/css" href="styles.css"> 

<<<<<<< HEAD
        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 
=======
        <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script> 
>>>>>>> develop

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

        <div class="container">

            <h1> FERRAILLE OU OR</h1>

        <?php

        $database = "ecebay";
        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database);

        if ($db_found) 
        {
            
            $sql="SELECT * FROM item WHERE Categorie='Feraille ou Or'";
            $result = mysqli_query($db_handle, $sql);

            while ($data = mysqli_fetch_assoc($result))
            {
                ?>
                <h2><?php echo $data["Nom"]."  ";?></h2>
                <p>Prix : <?php echo $data["Prix"];?></p>
                <p id="descriptionitem">Description : <?php echo $data["Description"];?></p>
                <p>Type de vente : <?php echo $data["TypeVente"];?></p>
                <p>Catégorie : <?php echo $data["Categorie"];?></p>               
            <br>
             <?php
            }                       
        }
        ?>

    </div>
    
    </body>
    
    <footer>
        <?php require("Footer.php");  ?>
    </footer>
    </html>
