<style>
    .acacher {
        display : none;
    }
</style>

<?php
    
        $login = $_SESSION["login"];
        // On va commencer par savoir si l'enchère a déjà débuté (une offre faite) ou si 
        // elle n'a pas encore débuté (l'utilisateur va faire la 1ere offre)
        // ATTENTION la variable $idItem doit être définie dans la page qui appelle modal_encheres.php

        $sql2 = "SELECT * FROM enchere WHERE IdItem ='$idItem'  ";  
        $result2 = mysqli_query($db_handle, $sql2);
        $data2 = mysqli_fetch_assoc($result2); 

        $meilleureOffre = isset($data2["meilleureOffre"])?$data2["meilleureOffre"]:0;
        $idEnchere = $data2["IdEnchere"];
        $dateFinEnchere = date('d/m/Y--H:i:s', strtotime($data2["dateFin"]));

        if (!isset($data2["loginMeilleureOffre"])) // Si aucune offre n'a encore été faite
        {
            $newEnchere = true; // Pour les affichages
            

        }
        else // Si une offre a déja été faite 
        {
            $newEnchere = false;
            $loginMeilleureOffre = $data2["loginMeilleureOffre"];
        }

        // Si on a fait une enchere auto, on va cocher la case par défaut et rappeler le montant (avec JavaScript)
        $sql2 = "SELECT * FROM acheteur_enchere WHERE IdEnchere ='$idEnchere' AND loginAcheteur = '$login' ";  
        $result2 = mysqli_query($db_handle, $sql2);
        $data2 = mysqli_fetch_assoc($result2);
        $cocherAuto = 0;
        $montantMaxRappel = 0;

        if (isset($data2))
        {
            if ($data2["EnchereAuto"] == 1)
            {
                $cocherAuto = 1;
                $montantMaxRappel = $data2["EnchereMax"];
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
                document.getElementById("enchereAutoMontant").value = montantMaxRappel;
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
            <form method="post" action="modal_encheres_traitements.php">
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

                <div class="form-group acacher" id="enchereAutoForm<?php echo($idItem); ?>">
                    <label for="enchereAutoMontant">Monant maximal</label>
                    <input type="number" class="form-control" id="enchereAutoMontant" name="autoMax" >
                    <small id="enchereAutoMontantHelp" class="form-text text-muted">Le site va enchérir automatiquement pour vous, sans dépasser votre montant maximal</small>
                    <div class="invalid-feedback">
                            Le montant entré doit être supérieur au montant de l'offre actuelle ! 
                    </div>
                </div>

                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                <input type="hidden" name="urlRedirection" value=<?php echo($urlRed); ?> > <!-- Cette variable $urlRed doit être définie dans la page qui appelle modal_encheres.php -->

                <button type="submit" class="btn btn-success">Démarer les enchères</button> 
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
            <a href="#"><button type="button" class="btn btn-info">Aide et mentions légales</button></a>
        </div>
    </div>
</div>