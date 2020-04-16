<link rel="stylesheet" type="text/css" href="Navbars/navbar_style.css">

<?php
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
?>

<script>
        $(document).ready (function()
        {
            var connecte = <?php echo("$connecte"); ?>;
            var statut = "<?php echo("$statut"); ?>";

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
                
                // Désactiver les liens
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

            else if (connecte == 1 && statut == "acheteur") // Si on est un acheteur
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });

                // désactiver les popovers de Achat et panier qui sont accssibles aux acheteurs
                $("#ppvAcheter").removeAttr("data-toggle");
                $("#ppvPanier").removeAttr("data-toggle");
                
                // Bloquer le lien vers vendre
                $("#Vendre").attr ({
                    "aria-disabled" : "true",
                    "href" : "#"
                }).addClass("disabled");
            }

            else if (connecte == 1 && statut != "acheteur") // Si on n'est pas un acheteur (vendeur ou admin)
            {
                // popover (pop up)
                $(function () {
                    $('[data-toggle="popover"]').popover()
                });

                // annuler popover au clic
                $('.popover-dismiss').popover({
                    trigger: 'focus'
                });

                // Supprimer le popover de vendre qui est accsssible
                $("#ppvVendre").removeAttr("data-toggle");
                
                // Bloquer les liens vers acheter et panier
                $("#Acheter").attr ({
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
                    aria-haspopup="true" aria-expanded="false"> Catalogue</a>
                <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <a class="dropdown-item" href="CatalogueFerOr.php">Ferraille ou Trésor</a>
                    <a class="dropdown-item" href="CatalogueMuse.php">Bon pour le Musée</a>
                    <a class="dropdown-item" href="CatalogueVIP.php">Accessoire VIP
                    </a>
                    <div class="dropdown-divider"></div>
                    <a class="dropdown-item" href="catalogue.php">Catalogue complet
                    </a>

                </div>

            </li>
            <!--FIN MENU DESCENDANT-->
            <span class="d-inline-block" id="ppvAcheter" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous avec un compte acheteur pour accéder à la page des achats">
                <li class="nav-item"><a class="nav-link" href="login.php" id="Acheter">Acheter</a></li>
            </span>
            <span class="d-inline-block" id="ppvVendre" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous avec un compte vendeur pour accéder à la page des ventes">
                <li class="nav-item"><a class="nav-link" href="Gestionitem.php"  id="Vendre">Vendre</a></li>
            </span>

            <!-- Pour les admins seulement: bouton gerer comptes -->
            <?php 
                if ($statut == "administrateur")
                {
                    ?>
                        <li class="nav-item"><a class="nav-link" href="admin_gerer_comptes.php" id="admin_gerer_comptes">Gerer les comptes</a></li>
                    <?php
                }
            ?>
        </ul>

        <ul class="navbar-nav ml-auto" id="elementsDroite">
            <span class="d-inline-block" id="ppvPanier" data-toggle="popover" data-trigger="focus" data-placement="bottom" data-content="Connectez vous pour accéder au panier">
                <li class="nav-item"><a class="nav-link" href="panier.php" id="panier"><i class="fa fa-shopping-cart"></i> Panier
                        <span class="badge badge-light">3
                            <!-- FAIRE UN JAVASCRIPT POUR RENDRE LE NOMBRE DYNAMIQUE--></span> <span
                            class="sr-only">(current)</span></a>

                </li>
            </span>
            <?php 
                        if (!isset ($_SESSION["login"])) // Si on est pas connecté
                        {
                            ?> 
                                <li class="nav-item"><a class="nav-link" href="login.php">Se connecter/Créer compte</a></li> 
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