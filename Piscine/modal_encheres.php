<style>
    #enchereAutoForm {
        display : none;
    }
</style>

<?php
    
        
        // On va commencer par savoir si l'enchère a déjà débuté (une offre faite) ou si 
        // elle n'a pas encore débuté (l'utilisateur va faire la 1ere offre)
        $sql2 = "SELECT meilleureOffre FROM enchere WHERE IdItem ='$idItem'  ";  
        $result2 = mysqli_query($db_handle, $sql2); 

        
        if (!isset($data2)) // Si aucune offre n'a encore été faite
        {
            $newEnchere = true; // Pour les affichages

        }
        else // Si une offre a déja été faite 
        {
            $newEnchere = false;
            while ($data2 = mysqli_fetch_assoc($result2)) {   
        
                echo ("R:".$data2["meilleureOffre"]);
            }
        }

        // Récupérer l'id de l'enchere
        //...

?>
<script>
        $(document).ready(function() {
            $("#enchereAutoCheckbox").on("click",function(){  // Cliquer sur l'encoche encheres auto pour dévoiler le champ du montant max
                if (document.getElementById("enchereAutoCheckbox").checked)
                {
                    $("#enchereAutoForm").slideDown();
                }
                else
                {
                    $("#enchereAutoForm").slideUp();

                }
            });   
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
            <?php echo($idItem); ?>
            <?php 
                if ($newEnchere == true)
                {
                    ?>
                        <p>Aucune offre n'a encore été faite. Vous êtes le premier ! </p>
                    <?php
                }
                else
                {
                    ?>
                        <p> Dernière offre: <strong> </strong> par:  <strong> </strong></p>
                    <?php
                }
            ?>
            <form method="post" action="modal_encheres_traitements.php">
                <div class="form-group">
                    <label for="enchereMontant">Faire une enchère</label>
                    <input type="number" class="form-control" id="enchereMontant" aria-describedby="enchere" name="montantEnchere" >
                    <small id="enchereMontantHelp" class="form-text text-muted">Une enchère en € qui doit être supérieure au prix de départ</small>
                </div>
                <div class="form-group form-check">
                    <input type="checkbox" class="form-check-input" id="enchereAutoCheckbox" name="enchereAutoCheckbox">
                    <label class="form-check-label" for="exampleCheck1">Activer les enchères automatiques</label>
                </div>
                <div class="form-group" id="enchereAutoForm">
                    <label for="enchereAutoMontant">Monant maximal</label>
                    <input type="number" class="form-control" id="enchereAutoMontant" name="autoMax">
                    <small id="enchereAutoMontantHelp" class="form-text text-muted">Le site va enchérir automatiquement pour vous, sans dépasser votre montant maximal</small>
                </div>
                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                <button type="submit" class="btn btn-success">Démarer les enchères</button> 
            </form>
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
            <a href="#"><button type="button" class="btn btn-info">Aide et mentions légales</button></a>
        </div>
    </div>
</div>