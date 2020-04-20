
<?php
    
        $login = $_SESSION["login"];
        // On va commencer par savoir si l'enchère a déjà débuté (une offre faite) ou si 
        // elle n'a pas encore débuté (l'utilisateur va faire la 1ere offre)
        // ATTENTION la variable $idItem doit être définie dans la page qui appelle modal_encheres.php

        $sql240 = "SELECT * FROM enchere WHERE IdItem ='$idItem'  ";  
        $result240 = mysqli_query($db_handle, $sql240);
        $data240 = mysqli_fetch_assoc($result240); 

        $meilleureOffre = isset($data240["meilleureOffre"])?$data240["meilleureOffre"]:0;
        $idEnchere = $data240["IdEnchere"];
        $dateFinEnchere = date('d/m/Y--H:i:s', strtotime($data240["dateFin"]));

        if (!isset($data240["loginMeilleureOffre"])) // Si aucune offre n'a encore été faite
        {
            $newEnchere = true; // Pour les affichages
            

        }
        else // Si une offre a déja été faite 
        {
            $newEnchere = false;
            $loginMeilleureOffre = $data240["loginMeilleureOffre"];
        }

        // Si on a fait une enchere auto, on va cocher la case par défaut et rappeler le montant (avec JavaScript)
        $sql299 = "SELECT * FROM acheteur_enchere WHERE IdEnchere ='$idEnchere' AND loginAcheteur = '$login' ";  
        $result299 = mysqli_query($db_handle, $sql299);
        $data299 = mysqli_fetch_assoc($result299);
        $cocherAuto = 0;
        $montantMaxRappel = 0;
        $maPremiereOffre = true ;  // 1ere fois que je fais une enchère ?

        if (isset($data299))
        {
            $maPremiereOffre = false;
            if ($data299["EnchereAuto"] == 1)
            {
                $cocherAuto = 1;
                $montantMaxRappel = $data299["EnchereMax"];
                
            }
        }

        
        


?>
<script>
        $(document).ready(function() {
            // La gestion des erreurs
            // Les variables  php numeroIdItemERR et erreurEnchere sont définies dans la page qui appelle la modal
            var erreurEnchere = <?php echo($erreurEnchere); ?>;
            var numeroIdItemERR = <?php echo($numeroIdItemERR); ?>; // l'ID de l'item dont l'enchere est en erreur
            var idItem = <?php echo($idItem); ?>;  // l'id de l'item dont on affiche l'enchere
            var maPremiereOffre = "<?php echo($maPremiereOffre); ?>"; // boolénes php: true=1 et false =""

            // Cliquer sur l'encoche encheres auto pour dévoiler le champ du montant max
            $("#enchereAutoCheckbox"+idItem).on("click",function(){  
                //alert ("CLICK "+"enchereAutoCheckbox"+idItem);
                if (document.getElementById("enchereAutoCheckbox"+idItem).checked)
                {
                    //alert ("OOP");
                    $("#enchereAutoForm"+idItem).slideDown();
                }
                else
                {
                    //alert ("NNP");
                    $("#enchereAutoForm"+idItem).slideUp();
                }
            }); 

            
            if (erreurEnchere == 5)  // montant trop bas
            {
                $("#enchereMontant"+numeroIdItemERR).addClass ("is-invalid");
            }
            if (erreurEnchere == 9)  // enchere max montant trop bas
            {
                $("#enchereAutoForm"+numeroIdItemERR).addClass ("is-invalid");
            }

            // Si on a activé les encheres auto: cocher la case et rappeler le montant
            var cocherAuto = <?php echo($cocherAuto); ?>;
            var montantMaxRappel = <?php echo($montantMaxRappel); ?>;

            if (cocherAuto !=0) // encheres auto activées précédemment par l'utilisateur
            {
                document.getElementById("enchereAutoCheckbox"+idItem).checked = true;
                $("#enchereAutoForm"+idItem).slideDown();
                document.getElementById("enchereAutoMontant"+idItem).value = montantMaxRappel;
            }


        });
</script>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Faire une enchère</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <form method="post" action="modal_encheres_traitements.php">
                <?php
                if ($maPremiereOffre == true)
                {
                    ?>
                    <!-- Informations de paiement (cachées sauf si c'est ma 1ere offre sur cette enchère) -->
                    <div  class="acacher" id="paiement<?php echo($idItem); ?>">
                            <div class="card border-secondary text-center">
                                <div class="card-header">
                                    Avant d'enchérir, choisissez une carte de paiement
                                </div>

                                
                                <div class="card-body">
                                    <h5>Mes cartes enregistrées </h5>
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
                                                        
                                                        $sqlC = "SELECT DISTINCT(numerocarte),dateexpiration,cvc,credit,nom,login FROM paiement WHERE login='$login'";  
                                                        $resultC = mysqli_query($db_handle, $sqlC); 
                                                        
                                                        while ($dataC = mysqli_fetch_assoc($resultC)) 
                                                        {
                                                            $numerocarte = $dataC["numerocarte"];
                                                            $dateexpiration = $dataC["dateexpiration"]; 
                                                            $cvc = $dataC["cvc"]; 
                                                            $credit = $dataC["credit"]; 
                                                            $nom = $dataC["nom"]; 

                                                            ?>
                                                            
                                                            <tr>
                                                                <td><?php echo($numerocarte); ?> </td>
                                                                <td><?php echo($nom); ?> </td>
                                                                <td><?php echo($dateexpiration); ?> </td>
                                                                <td><?php echo($cvc); ?> </td>
                                                                <td><?php echo($credit); ?> </td>
                                                                <td><input required type="radio" name="useCarte" value="<?php echo($numerocarte); ?>"  ></td>
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
                                    
                                        
                                        
                                        <hr/>
                                        <h5>Enregistrer une nouvelle carte <input required type="radio" name="useCarte" value="nouvCarte"  > </h5> 
                                        <div class="form-group row">
                                            <label for="ville" class="col-sm-2 col-form-label">Nom sur la carte</label>
                                            <input type="" class="form-control col-sm-10" name="nom" id="nom">
                                            <div class="invalid-feedback">
                                                Login inconnu
                                            </div>
                                        </div>
                                        <div class="form-group row">
                                            <label for="ville" class="col-sm-2 col-form-label">Numero de carte </label>
                                            <input type="text" class="form-control col-sm-10" name="numcarte" id="numcarte" >
                                            <div class="invalid-feedback">
                                                Nombre de caractères invalide. Le numéro doit contenir 16 chiffres
                                            </div>
                                        </div>

                                        <div class="form-group row">
                                            <label for="cp" class="col-sm-2 col-form-label">Date d'expiration</label>
                                            <input type="date" class="form-control col-sm-10" name="datelimite" id="datelimite">
                                            <small class="form-text text-muted">JJ/MM/AAAA</small>
                                        </div>

                                        <div class="form-group row">
                                            <label for="pays" class="col-sm-2 col-form-label">CVC</label>
                                            <input type="text" class="form-control col-sm-10" name="codesecret" id="codesecret">
                                            <div class="invalid-feedback">
                                                Login inconnu
                                            </div>
                                        </div>

                        
                                        
                                </div>
                            </div>
                        

                    </div> <!-- Fin des infos de paiement -->
                <?php } ?>

                
                <?php //echo($idItem); ?>
                <?php 
                    if ($newEnchere == true)
                    {
                        ?>
                            <p>Aucune offre n'a encore été faite. Vous êtes le premier ! </p>
                            <p>Le prix minimal demandé par le vendeur est <?php echo($meilleureOffre); ?> € </p>
                        <?php
                    }
                    else
                    {
                        ?>
                            <p> Dernière offre: <strong><?php echo($meilleureOffre); ?> €</strong> par: <strong><?php echo($loginMeilleureOffre); ?></strong></p>
                        <?php
                    }
                ?>
                <p>Fin de l'enchère le: <?php echo($dateFinEnchere); ?> </p>
                
                <div class="form-group">
                    <label for="enchereMontant">Faire une enchère</label>
                    <input type="number" class="form-control" id="enchereMontant<?php echo($idItem); ?>" aria-describedby="enchere" name="montantEnchere" value="<?php echo($meilleureOffre+1); ?>" >
                    <small id="enchereMontantHelp" class="form-text text-muted">Une enchère en € qui doit être supérieure au prix de départ</small>
                    <div class="invalid-feedback">
                            Le montant entré doit être supérieur au montant de l'offre actuelle ! 
                    </div>
                </div>

                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="enchereAutoCheckbox<?php echo($idItem); ?>" name="enchereAutoCheckbox">
                    <label class="form-check-label" for="exampleCheck1">Activer les enchères automatiques</label>
                </div>

                <div class="form-group" style="display:none;" id="enchereAutoForm<?php echo($idItem); ?>">
                    <label for="enchereAutoMontant">Monant maximal</label>
                    <input type="number" class="form-control" id="enchereAutoMontant<?php echo($idItem); ?>" name="autoMax" >
                    <small id="enchereAutoMontantHelp" class="form-text text-muted">Le site va enchérir automatiquement pour vous, sans dépasser votre montant maximal</small>
                    <div class="invalid-feedback">
                            Le montant entré doit être supérieur au montant de l'offre actuelle ! 
                    </div>
                </div>

                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                <input type="hidden" name="urlRedirection" value=<?php echo($urlRed); ?> > <!-- Cette variable $urlRed doit être définie dans la page qui appelle modal_encheres.php -->
                <input type="hidden" name="maPremiereOffre" value=<?php echo($maPremiereOffre); ?> >

                <button type="submit" class="btn btn-success">Enchère !</button> 
            </form>
        </div> <!-- Fin modal body -->

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
            <a href="#"><button type="button" class="btn btn-info">Aide et mentions légales</button></a>
        </div>
    </div> <!-- Fin modal-content -->
</div> <!-- Fin modal dialogue -->