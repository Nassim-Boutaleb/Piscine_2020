<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">            
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 
    <title>Crer un compte</title>
    <link href="login.css" rel="stylesheet" type="text/css"/>
    <script>
        <?php
            // Vérifier si des erreurs sont présentes (après un 1er envoi par loginTraitement.php)
            $erreur = isset($_POST["erreursCreation"])?$_POST["erreursCreation"] : "0" ; 
        ?>
        $(document).ready (function()
        {
            var erreur =<?php echo($erreur); ?>; // récupérer le numéro de l'erreur 
            // Alerter l'utilisateur sur son erreur ...
            if (erreur == 1)
            {
                $("#email").addClass ("is-invalid");
            } 
        });
    </script>

<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>

    <!-- Contenu page -->
    <div class="container-fluid">
       
        <div class="card border-secondary text-center">
            <div class="card-header">
                Créer un compte
            </div>

            <form method="post" action="creer_compte_Traitements.php">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <input type="email" class="form-control col-sm-10" name="email" id="email"required>
                        <div class="invalid-feedback">
                            Login déjà utilisé. Veuillez utiliser un autre login SVP.
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
                        <input type="text" class="form-control col-sm-10" name="password" id="password"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                        <input type="text" class="form-control col-sm-10" name="nom" id="nom"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="prenom" class="col-sm-2 col-form-label">Prenom</label>
                        <input type="text" class="form-control col-sm-10" name="prenom" id="prenom"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="adresse" class="col-sm-2 col-form-label">Adresse</label>
                        <input type="text" class="form-control col-sm-10" name="adresse" id="adresse"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ville" class="col-sm-2 col-form-label">Ville</label>
                        <input type="text" class="form-control col-sm-10" name="ville" id="ville"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cp" class="col-sm-2 col-form-label">Code postal</label>
                        <input type="text" class="form-control col-sm-10" name="cp" id="cp"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pays" class="col-sm-2 col-form-label">Pays</label>
                        <input type="text" class="form-control col-sm-10" name="pays" id="pays"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tel" class="col-sm-2 col-form-label">Numéro de téléphone</label>
                        <input type="phone" class="form-control col-sm-10" name="tel" id="tel"required>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                          <legend class="col-form-label col-sm-2 pt-0">Type de compte</legend>
                          <div class="col-sm-10">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="statut" id="statutA" value="acheteur" required>
                              <label class="form-check-label" for="statutA">
                                Acheteur
                              </label>
                            </div>

                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="statut" id="statutV" value="vendeur" required>
                              <label class="form-check-label" for="statutV">
                                Vendeur
                              </label>
                            </div>

                            <?php
                                if ($_SESSION["statut"]=="administrateur") // Seul un admin peut créer un compte admin
                                {
                                    ?>
                                        <div class="form-check">
                                            <input class="form-check-input" type="radio" name="statut" id="statutAdmin" value="administrateur" required>
                                            <label class="form-check-label" for="statutAdmin">
                                                 Admin
                                            </label>
                                        </div>
                                  <?php
                                }
                            ?>
                          </div>
                        </div>
                    </fieldset>
       
                    <button type="submit" class="btn btn-secondary">Créer mon compte</button>
                </div>

            </form>
        </div>


    </div>
</body>
</html>