<?php session_start() ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet"  href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">            
    <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 
    <title>Mes informations</title>
    <link href="login.css" rel="stylesheet" type="text/css"/> 
    <?php
        // Se connecter à la BDD pour récupérer les informations à afficher
        $login = $_SESSION["login"];  // qui est connecté ?

        //identifier le nom de base de données 
        $database = "ebayece"; 
        
        //connectez-vous dans votre BDD 
        //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
        $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
        $db_found = mysqli_select_db($db_handle, $database); 
        
        //si le BDD existe, faire le traitement 
        if ($db_found) { 
            
            $sql = "SELECT * FROM utilisateur WHERE login='$login' ";  
            $result = mysqli_query($db_handle, $sql); 

            while ($data = mysqli_fetch_assoc($result)) {
                $password = $data["password"];
                $nom = $data["nom"]; 
                $prenom = $data["prenom"]; 
                $adresse = $data["adresse"]; 
                $ville = $data["ville"]; 
                $code_postal = $data["code_postal"]; 
                $pays = $data["pays"]; 
                $numero_tel = $data["numero_tel"]; 
                $statut = $data["statut"]; 
            }
        } 
        else { 
            echo "Database not found"; 
        }   //end else 

        // Gestion des erreurs (après avoir validé le formulaire une 1ere fois)
    ?>
    <script>
        $(document).ready (function() {
            // Cocher la bonne radio pour le statut
            var statut = "<?php echo($statut); ?>";
            if (statut == "vendeur")
            {
                $("#statutV").prop("checked", true).trigger("click");
            }
            else if (statut == "acheteur")
            {
                $("#statutA").prop("checked", true).trigger("click");
                
            }
            
            // Si clic sur le bouton modifier mes informations: les champs deviennent modifiables et on active le bouton
            // enregistrer qui va valider le formulaire
            var envoi = false;
            $("#modifierBtn").on ("click", function(e){
                if (envoi == false)
                {
                    e.preventDefault(); // Le bouton modifier mes informations ne déclenche pas l'envoi du formulaire:
                    $("#email").removeAttr("readonly");
                    $("#nom").removeAttr("readonly");
                    $("#prenom").removeAttr("readonly");
                    $("#adresse").removeAttr("readonly");
                    $("#ville").removeAttr("readonly");
                    $("#pays").removeAttr("readonly");
                    $("#cp").removeAttr("readonly");
                    $("#tel").removeAttr("readonly");

                    // Modifier le bouton
                    $("#modifierBtn").removeClass("btn-secondary"); // il devient vert !
                    $("#modifierBtn").addClass("btn-success"); // il devient vert !
                    $("#modifierBtn").text("Valider les modifications");
                    envoi = true;
                }
                else if (envoi == true)
                {
                        // Envoyer le formulaire
                         document.getElementById("formulaire").submit();
                }
            });

            


            // Gestion des erreurs (après avoir envoyé le formulaire une première fois)
            // Indique à l'utilisateur son erreur


            
        });
    </script>
</head>

<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>

    <!-- Contenu page -->
    

    <div class="container-fluid">
       
        <div class="card border-secondary text-center">
            <div class="card-header">
                Mes informations
            </div>

            <form method="post" action="gerer_compte_traitements.php" id="formulaire">
                <div class="card-body">
                    <div class="form-group row">
                        <label for="email" class="col-sm-2 col-form-label">Email</label>
                        <input type="email" class="form-control col-sm-10" name="email" id="email" value="<?php echo($login) ?>"required readonly>
                        <div class="invalid-feedback">
                            Login déjà utilisé. Veuillez utiliser un autre login SVP.
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="password" class="col-sm-2 col-form-label">Mot de passe</label>
                        <input type="text" class="form-control col-sm-10" name="password" id="password" value="<?php echo($password) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="nom" class="col-sm-2 col-form-label">Nom</label>
                        <input type="text" class="form-control col-sm-10" name="nom" id="nom" value="<?php echo($nom) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="prenom" class="col-sm-2 col-form-label">Prenom</label>
                        <input type="text" class="form-control col-sm-10" name="prenom" id="prenom" value="<?php echo($prenom) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="adresse" class="col-sm-2 col-form-label">Adresse</label>
                        <input type="text" class="form-control col-sm-10" name="adresse" id="adresse" value="<?php echo($adresse) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="ville" class="col-sm-2 col-form-label">Ville</label>
                        <input type="text" class="form-control col-sm-10" name="ville" id="ville" value="<?php echo($ville) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="cp" class="col-sm-2 col-form-label">Code postal</label>
                        <input type="text" class="form-control col-sm-10" name="cp" id="cp" value="<?php echo($code_postal) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="pays" class="col-sm-2 col-form-label">Pays</label>
                        <input type="text" class="form-control col-sm-10" name="pays" id="pays" value="<?php echo($pays) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <div class="form-group row">
                        <label for="tel" class="col-sm-2 col-form-label">Numéro de téléphone</label>
                        <input type="phone" class="form-control col-sm-10" name="tel" id="tel" value="<?php echo($numero_tel) ?>" required readonly>
                        <div class="invalid-feedback">
                            Login inconnu
                        </div>
                    </div>

                    <fieldset class="form-group">
                        <div class="row">
                          <legend class="col-form-label col-sm-2 pt-0">Type de compte</legend>
                          <div class="col-sm-10">
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="statut" id="statutA" value="acheteur" required disabled >
                              <label class="form-check-label" for="statutA">
                                Acheteur
                              </label>
                            </div>
                            <div class="form-check">
                              <input class="form-check-input" type="radio" name="statut" id="statutV" value="vendeur" required disabled >
                              <label class="form-check-label" for="statutV">
                                Vendeur
                              </label>
                            </div>
                          </div>
                        </div>
                      </fieldset>
                    
                    <button class="btn btn-secondary" id="modifierBtn">Modifier mes informations</button>
                </div>

            </form>
        </div>


    </div>
</body>

</html>

