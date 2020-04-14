<link rel="stylesheet" type="text/css" href="Navbars/navbar_style.css">

<?php
    if (!isset ($_SESSION["login"])) // Si on est pas connecté
    {
        $connecte = 0;
    }
    else 
    {
        $connecte = 1;
        $statut = $_SESSION["statut"];
    }
?>

<script>
        $(document).ready (function()
        {
            var connecte = <?php echo("$connecte"); ?>;
            

            if (connecte == 0) // Si on est pas connecte : empecher l'accès à acheter et vendre et panier
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });
                
                $("#Acheter").attr ({
                    "aria-disabled" : "true",
                    "href" : "#"
                }).addClass("disabled");

                $("#Vendre").attr ({
                    "aria-disabled" : "true",
                    "href" : "#"
                }).addClass("disabled");

                $("#panier").attr ({
                    "aria-disabled" : "true",
                    "href" : "#"
                }).addClass("disabled");

            }
        });
</script>


<nav class="navbar navbar-expand-md">
    <a class="navbar-brand" href="#"><img src="Images/logoece.png" width="70px" height="30px" alt="Logo"></a>
    <!-- Logo-->

    <!-- Bouton pour les écrans plus petits-->
    <button class="navbar-toggler navbar-dark" type="button" data-toggle="collapse" data-target="#main-navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <!-- Boutons de navigation-->
    <div class="collapse navbar-collapse" id="main-navigation">
        <ul class="navbar-nav">
            <li class="nav-item"><a class="nav-link" href="accueil.php" >Accueil</a></li>
            <!-- MENU DESCENDANT-->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="Categories" role="button" data-toggle="dropdown"
                    aria-haspopup="true" aria-expanded="false"> Catégories</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="#">Ferraille ou Trésor</a>
                    <a class="dropdown-item" href="#">Bon pour le Musée</a>
                    <a class="dropdown-item" href="#">Accessoire VIP</a>
                </div>

            </li>
            <!--FIN MENU DESCENDANT-->
            <span class="d-inline-block" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous avec un compte acheteur pour accéder à la page des achats">
                <li class="nav-item"><a class="nav-link" href="login.php" id="Acheter">Acheter</a></li>
            </span>
            <span class="d-inline-block" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous avec un compte vdendeur pour accéder à la page des ventes">
                <li class="nav-item"><a class="nav-link" href="Gestionitem.php"  id="Vendre">Vendre</a></li>
            </span>
        </ul>

        <ul class="navbar-nav ml-auto" id="elementsDroite">
            <span class="d-inline-block" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous pour accéder au panier">
                <li class="nav-item"><a class="nav-link" href="panier.php" id="panier"><i class="fa fa-shopping-cart"></i> Panier
                        <span class="badge badge-light">3
                            <!-- FAIRE UN JAVASCRIPT POUR RENDRE LE NOMBRE DYNAMIQUE--></span> <span
                            class="sr-only">(current)</span></a>

                </li>
            </span>
            <?php 
                        if (!isset ($_SESSION["login"])) // Si on est pas connecté
                        {
                            ?> <li class="nav-item"><a class="nav-link" href="login.php">Se connecter/Créer compte</a></li> 
            <?php
                        }
                        else if (isset ($_SESSION["login"])) // Si une session est configurée = si on est connecté
                        {
            ?>
                            <li class="nav-item dropdown" id="menu_compte">
                                <a class="nav-link dropdown-toggle" href="#" id="compte" role="button" data-toggle="dropdown"
                                    aria-haspopup="true" aria-expanded="false"><?php echo("Bonjour ".$_SESSION["nom"]); ?></a>
                                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                                    <a class="dropdown-item" href="gerer_compte.php">Mes informations personnelles</a>
                                    <a class="dropdown-item" href="deconnexion.php">Me déconnecter</a>
                                </div>
                            </li>
            <?php
                        } 
            ?>
        </ul>
    </div>
</nav>