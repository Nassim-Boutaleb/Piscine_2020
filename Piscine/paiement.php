<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>  
    <style>
        .alert {
            display:none;
        }
    </style>
    <meta charset="utf-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1"> 
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" >
    <script src="https://code.jquery.com/jquery-3.4.1.min.js" ></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" ></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" ></script>
    <title>Paiement</title>
    <link href="login.css" rel="stylesheet" type="text/css"/>
    <?php
          $alertCode = isset($_GET["alertCodeC"])?$_GET["alertCodeC"] : "0" ; 
    ?>
    <script type="text/javascript">      
            $(document).ready(function(){           
                
                // affichage d'une alerte pour le credit insuffisant ou BDD
                var alertCodeC = <?php echo($alertCode); ?>;

                if (alertCodeC == 1) // Crédit insuffisant
                {
                  $("#texteAlerteD").text("Le crédit de votre carte est insuffisant");
                  $("#AlerteD").slideDown();
                }

                if (alertCodeC == 2) // erreur BDD
                {
                  $("#texteAlerteD").text("Un erreur dans la manipulation de la BDD est survenue");
                  $("#AlerteD").slideDown();
                }

                if (alertCodeC == 3)
                {
                    $("#numcarte").addClass ("is-invalid");
                } 
            }); 
    </script>
 
</head> 

<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>

    <!-- Messages d'alerte -->
    <div class="alert alert-danger alert-dismissible fade show" role="alert" id="AlerteD">
          <strong id="texteAlerteD"></strong> 
          <button type="button" class="close" data-dismiss="alert" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
    </div>

    <!-- Contenu page -->
    <div class="container-fluid"> 
        <div class="card border-secondary text-center">
            <div class="card-header">
                Payer vos articles
            </div>

            
            <div class="card-body">
                <h5>Mes cartes enregistrées </h5>
                <form method="post" action="paiement_traitement.php">
                    <table class="table">
                        <thead class="thead-light">
                            <tr>
                                <th scope="col">Numéro carte</th>
                                <th scope="col">Nom</th>
                                <th scope="col">Date expiration</th>
                                <th scope="col">CVC</th>
                                <th scope="col">Crédit restant</th>
                                <th scope="col">Utiliser cette carte</th>
                            </tr>
                        </thead>
                        <tbody>                        
                            <?php
                                //identifier le nom de base de données 
                                $database = "ecebay"; 
                                
                                //connectez-vous dans votre BDD 
                                //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
                                $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
                                $db_found = mysqli_select_db($db_handle, $database); 
                                
                                $login = $_SESSION["login"];  
                                //si le BDD existe, faire le traitement 
                                if ($db_found) 
                                { 
                                    
                                    $sql = "SELECT DISTINCT(numerocarte),dateexpiration,cvc,credit,nom,login FROM paiement WHERE login='$login'";  
                                    $result = mysqli_query($db_handle, $sql); 
                                    
                                    while ($data = mysqli_fetch_assoc($result)) 
                                    {
                                        $numerocarte = $data["numerocarte"];
                                        $dateexpiration = $data["dateexpiration"]; 
                                        $cvc = $data["cvc"]; 
                                        $credit = $data["credit"]; 
                                        $nom = $data["nom"]; 

                                        ?>
                                        
                                        <tr>
                                            <td><?php echo($numerocarte); ?> </td>
                                            <td><?php echo($nom); ?> </td>
                                            <td><?php echo($dateexpiration); ?> </td>
                                            <td><?php echo($cvc); ?> </td>
                                            <td><?php echo($credit); ?> </td>
                                            <td><input type="radio" name="useCarte" value="<?php echo($numerocarte); ?>" ></td>
                                        </tr>
                                        
                                        
                                        <?php
                                    }
                                } 
                                else 
                                { 
                                    echo "Database not found"; 
                                }   //end else 

                            
                            ?>
                        </tbody>
                    </table>
                
                    <button type="submit" name="useBtn" value="use" class="btn btn-primary">Utiliser la carte et payer</button>
                </form>

                <hr/>
                <h5>Enregistrer une nouvelle carte </h5>
                <form method="post" action="paiement_traitement.php">
                        <div class="form-group row">
                            <label for="ville" class="col-sm-2 col-form-label">Nom sur la carte</label>
                            <input type="" class="form-control col-sm-10" name="nom" id="nom"required>
                            <div class="invalid-feedback">
                                Login inconnu
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="ville" class="col-sm-2 col-form-label">Numero de carte </label>
                            <input type="text" class="form-control col-sm-10" name="numcarte" id="numcarte" required>
                            <div class="invalid-feedback">
                                Nombre de caractères invalide. Le numéro doit contenir 16 chiffres
                            </div>
                        </div>

                        <div class="form-group row">
                            <label for="cp" class="col-sm-2 col-form-label">Date d'expiration</label>
                            <input type="date" class="form-control col-sm-10" name="datelimite" id="datelimite"required>
                            <small class="form-text text-muted">JJ/MM/AAAA</small>
                        </div>

                        <div class="form-group row">
                            <label for="pays" class="col-sm-2 col-form-label">CVC</label>
                            <input type="text" class="form-control col-sm-10" name="codesecret" id="codesecret"required>
                            <div class="invalid-feedback">
                                Login inconnu
                            </div>
                        </div>

        
                        <button type="submit" name="createBtn" value="create" class="btn btn-primary">Enregistrer la carte et payer</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>