<nav class="navbar navbar-expand-md">      
            <a class="navbar-brand" href="#"><img src="./Images/logoece.png" width="70px" height="30px" alt="Logo"></a> <!-- Logo-->        
            
            <!-- Bouton pour les écrans plus petits-->
            <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">      
                <span class="navbar-toggler-icon"></span>        
            </button>   

            <!-- Boutons de navigation-->
            <div class="collapse navbar-collapse" id="main-navigation">      
                <ul class="navbar-nav">             
                    <li class="nav-item"><a class="nav-link" href="accueil.php">Accueil</a></li>             
                    <!-- MENU DESCENDANT-->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Catégories</a>
                         <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            <a class="dropdown-item" href="#">Ferraille ou Trésor</a>
                            <a class="dropdown-item" href="#">Bon pour le Musée</a>
                             <a class="dropdown-item" href="#">Accessoire VIP</a>
                         </div>

                    </li>  
                    <!--FIN MENU DESCENDANT-->           
                    <li class="nav-item"><a class="nav-link" href="#Acheter">Acheter</a></li>  
                    <li class="nav-item"><a class="nav-link" href="#Vendre">Vendre</a></li>     
                </ul>

                <ul class="navbar-nav ml-auto">
                     <li class="nav-item"><a class="nav-link" href="panier.php"><i class="fa fa-shopping-cart"></i> Panier
                    <span class="badge badge-light">3 <!-- FAIRE UN JAVASCRIPT POUR RENDRE LE NOMBRE DYNAMIQUE--></span> <span class="sr-only">(current)</span></a>
                     
            </li>
                     <li class="nav-item"><a class="nav-link" href="#Compte">Votre Compte</a></li>
                </ul>       
            </div> 
        </nav> 