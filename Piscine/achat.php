<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <link href="achat.css" rel="stylesheet" type="text/css"/>

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
    });
    </script>
    <title>Achat_piscine</title>
</head>
<body>

 <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
     <?php require("Navbars/navbar_def.php");  ?>
    
<div class="row"> 

    <div class="col-md-4">
    <div class="card" style="width: 18rem;">
        <img src="Images/column2.jpg" id="img1" class="card-img-top" alt="...">
        <div id="card1" class="card-body">
            <h5 class="card-title">Offre au plus offrants</h5>
            <p class="card-text">SLes enchères sont ouvetrs de .. à .. au .. à ..</p>
            <a href="catalogue_encheres.php" class="btn btn-primary">Enchères</a>
        </div>
    </div> 
   </div> 

   <div class="col-md-4">
    <div class="card" style="width: 18rem;">
        <img src="Images/column1.jpg" id="img2" class="card-img-top" alt="...">
        <div id="card2" class="card-body">
            <h5 class="card-title">Nos articles</h5>
            <p class="card-text">Si vous cliquer dessus, vous n'allais pas pouvoir marchander, les prix seront donc fixes. Bonne course!</p>
            <a href="catalogue_acheter_now.php" id="but2" class="btn btn-primary">Achetez-le-maintenant</a>
        </div>
    </div> 
    </div> 

    <div class="col-md-4">
    <div class="card" style="width: 18rem;">
        <img src="Images/column2.jpg" id="img3" class="card-img-top" alt="...">
        <div id="card3"  class="card-body">
            <h5 class="card-title">À vous de négocier</h5>
            <p class="card-text">Le marché est ouvert, nous vous offrons nos meilleurs prix! Vous pouvez négocier jusqu'à 5 fois</p>
            <a href="catalogue_meilleuroffre.php" class="btn btn-primary">Meilleur offre</a>
        </div>
    </div>  
</div>

</div> 
</body>
</html>