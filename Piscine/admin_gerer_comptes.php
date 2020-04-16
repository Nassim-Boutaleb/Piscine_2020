<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gerer les comptes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin_gerer_comptes.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
    <?php
        //identifier le nom de base de données 
        $database = "ecebay"; 
        
        //connectez-vous dans votre BDD 
        //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
        $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
        $db_found = mysqli_select_db($db_handle, $database); 
        
            
        function afficher_elements_vendeur ()
        {
            //si le BDD existe, faire le traitement 
            global $db_found;
            global $db_handle;

            if ($db_found) { 
                $sql = "SELECT * FROM utilisateur WHERE statut='vendeur'";  // on regarde tous les login
                $result = mysqli_query($db_handle, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                       <tr>
                            <th scope="row"><?php echo($data["login"]); ?></th>
                            <td><?php echo($data["password"]); ?></td>
                            <td><?php echo($data["nom"]); ?></td>
                            <td><?php echo($data["prenom"]); ?></td>
                            <td><?php echo($data["adresse"]); ?></td>
                            <td><?php echo($data["ville"]); ?></td>
                            <td><?php echo($data["code_postal"]); ?></td>
                            <td><?php echo($data["pays"]); ?></td>
                            <td><?php echo($data["numero_tel"]); ?></td>
                            <form method="post" action="gerer_compte.php">
                                <td><button type="submit" name="AGMod" value="<?php echo($data["login"]); ?>" class="btn btn-secondary btn-sm">Modifier</button></td>
                            </form>
                            <form method="post" action="supprimer_compte.php">
                                <td><button type="submit" name="AGSupp" value="<?php echo($data["login"]); ?>" class="btn btn-danger btn-sm">Supprimer</button></td>
                            </form>
                        </tr>
                    <?php
                }
            }
            else { 
                echo "Database not found"; 
            }   //end else 
            

            
        }

        function afficher_elements_acheteurs ()
        {
            //si le BDD existe, faire le traitement 
            global $db_found;
            global $db_handle;
            
            if ($db_found) { 
                $sql = "SELECT * FROM utilisateur WHERE statut='acheteur'";  // on regarde tous les login
                $result = mysqli_query($db_handle, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                       <tr>
                            <th scope="row"><?php echo($data["login"]); ?></th>
                            <td><?php echo($data["password"]); ?></td>
                            <td><?php echo($data["nom"]); ?></td>
                            <td><?php echo($data["prenom"]); ?></td>
                            <td><?php echo($data["adresse"]); ?></td>
                            <td><?php echo($data["ville"]); ?></td>
                            <td><?php echo($data["code_postal"]); ?></td>
                            <td><?php echo($data["pays"]); ?></td>
                            <td><?php echo($data["numero_tel"]); ?></td>
                            <form method="post" action="gerer_compte.php">
                                <td><button type="submit" name="AGMod" value="<?php echo($data["login"]); ?>" class="btn btn-secondary btn-sm">Modifier</button></td>
                            </form>
                            <form method="post" action="supprimer_compte.php">
                                <td><button type="submit" name="AGSupp" value="<?php echo($data["login"]); ?>" class="btn btn-danger btn-sm">Supprimer</button></td>
                            </form>
                        </tr>
                    <?php
                }
            }
            else { 
                echo "Database not found"; 
            }   //end else 
            

           
        }

        function afficher_elements_admin ()
        {
            //si le BDD existe, faire le traitement 
            global $db_found;
            global $db_handle;
            
            if ($db_found) { 
                $sql = "SELECT * FROM utilisateur WHERE statut='administrateur'";  // on regarde tous les login
                $result = mysqli_query($db_handle, $sql);
                while ($data = mysqli_fetch_assoc($result)) {
                    ?>
                       <tr>
                            <th scope="row"><?php echo($data["login"]); ?></th>
                            <td><?php echo($data["password"]); ?></td>
                            <td><?php echo($data["nom"]); ?></td>
                            <td><?php echo($data["prenom"]); ?></td>
                            <td><?php echo($data["adresse"]); ?></td>
                            <td><?php echo($data["ville"]); ?></td>
                            <td><?php echo($data["code_postal"]); ?></td>
                            <td><?php echo($data["pays"]); ?></td>
                            <td><?php echo($data["numero_tel"]); ?></td>
                            <form method="post" action="gerer_compte.php">
                                <td><button type="submit" name="AGMod" value="<?php echo($data["login"]); ?>" class="btn btn-secondary btn-sm">Modifier</button></td>
                            </form>
                            <?php
                                if ($data["login"] != $_SESSION["login"]) // un admin ne peut pas se supprimer lui-même !!
                                {
                                    ?>
                                        <form method="post" action="supprimer_compte.php">
                                            <td><button type="submit" name="AGSupp" value="<?php echo($data["login"]); ?>" class="btn btn-danger btn-sm">Supprimer</button></td>
                                        </form> 
                                    <?php
                                }
                            ?>
                        </tr>
                    <?php
                }
            }
            else { 
                echo "Database not found"; 
            }   //end else 
            

        }
        
    ?>

    <!-- Récupération des messages éventuels -->
    <?php
          $alertCode = isset($_GET["alertCode"])?$_GET["alertCode"] : "0" ; 
    ?>

    <script type="text/javascript">      
            $(document).ready(function(){           
                 
                // affichage d'une alerte pour les succès/erreurs
                var alertCode = <?php echo($alertCode); ?>;

                if (alertCode == 1) // suppression réussie
                {
                  $("#texteAlerteS").text("L'utilisateur a été supprimé");
                  $("#AlerteS").slideDown();
                }

                if (alertCode == 2) // on affiche le succès de création de compte
                {
                  $("#texteAlerteE").text("Erreur lors de l'éxecution de la requête. Pas de suppression.");
                  $("#AlerteE").slideDown();
                }

                if (alertCode == 3) // modification réussie
                {
                  $("#texteAlerteS").text("L'utilisateur a été modifié");
                  $("#AlerteS").slideDown();
                }

                if (alertCode == 4) // ajout réussi
                {
                  $("#texteAlerteS").text("L'utilisateur a été ajouté");
                  $("#AlerteS").slideDown();
                }

            }); 
    </script>



</head>

<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>

    <!-- Fenetres d'alertes -->
    <div class="alert alert-warning alert-dismissible fade show" role="alert" id="AlerteS">
          <strong id="texteAlerteS"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="AlerteE">
          <strong id="texteAlerteE"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>


    <!-- Contenu -->
    <div class="container-fluid">
        <div class="card border-secondary text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active tab" id="vendeursTab" data-toggle="tab" href="#vendeursAff" role="tab"
                            aria-controls="home" aria-selected="true" style="color:black;">Vendeurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab" id="acheteursTab" data-toggle="tab" href="#acheteursAff" role="tab"
                            aria-controls="profile" aria-selected="false" style="color:black;">Acheteurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab" id="adminsTab" data-toggle="tab" href="#adminsAff" role="tab"
                            aria-controls="contact" aria-selected="false" style="color:black;">Admins</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="vendeursAff" role="tabpanel"aria-labelledby="vendeursTab">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mot de passe</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Code postal</th>
                                    <th scope="col">Pays</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Modifier</th>
                                    <th scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php afficher_elements_vendeur (); ?>
                            </tbody>
                        </table>
                        <a href="creer_compte.php" class="btn btn-primary">Ajouter vendeur</a>
                    </div>

                    <div class="tab-pane fade" id="acheteursAff" role="tabpanel" aria-labelledby="acheteursTab">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mot de passe</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Code postal</th>
                                    <th scope="col">Pays</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Modifier</th>
                                    <th scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php afficher_elements_acheteurs (); ?>
                            </tbody>
                        </table>
                        <a href="creer_compte.php" class="btn btn-primary">Ajouter acheteur</a>
                    </div>

                    <div class="tab-pane fade" id="adminsAff" role="tabpanel" aria-labelledby="adminsTab">
                        <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mot de passe</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Code postal</th>
                                    <th scope="col">Pays</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Modifier</th>
                                    <th scope="col">Supprimer</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php afficher_elements_admin (); ?>
                            </tbody>
                        </table>
                        <a href="creer_compte.php" class="btn btn-primary">Ajouter administrateur</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<?php
    //fermer la connection 
    mysqli_close($db_handle);
?>

</html>