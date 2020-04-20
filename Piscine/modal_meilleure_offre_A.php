<style>
    .acacher {
        display : none;
    }
     
</style>

<?php
    // On verrifier si l'utilisateur a deja fait une offre
 
       $sql2 = "SELECT * FROM meilleure_offre WHERE idItemOffre ='$idItem'  ";  

        $result2 = mysqli_query($db_handle, $sql2);
        if($result2){
            $data2 = mysqli_fetch_assoc($result2); 
        

        if ($data2["nbOffres"]==0) // Si aucune offre n'a encore été faite
            
        {
            
            $newnegotiation = true; // Pour les affichages
            

        }
        else // Si une offre a déja été faite 
        {
            $newnegotiation = false;
            
        }
        $lastnegociation = $data2["PrixVendeur"];
        $consensus=$data2["Consensus"];

        $idOffre=$data2["IdOffre"];
        $nbOffres=$data2["nbOffres"];
        
        }


?>
<script>
        $(document).ready(function() {
            // La gestion des erreurs
            // Les variables  php numeroIdItemERR et erreurEnchere sont définies dans la page qui appelle la modal
           
            
            var idItem = <?php echo($idItem); ?>;

            // Cliquer sur l'encoche encheres auto pour dévoiler le champ du montant max
            $("#nouvellenegotiation"+idItem).on("click",function(){  
                //alert ("CLICK "+"enchereAutoCheckbox"+idItem);
                
                    //alert ("OOP");
                    $("#montantOffre"+idItem).slideDown();
                    $("#soumettreoffre"+idItem).slideDown();
                   
                    
                
            }); 

            
           

            
            

        });


</script>


<div class="modal-dialog modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="staticBackdropLabel">Faire une Offre</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>

        <div class="modal-body">
            <?php //echo($idItem); ?>
             <?php 
             if($newnegotiation == true){ 
            ?>
            <p>1ère tentative de négotiation !  </p>

            <form method="post" action="modal_meilleure_offre_traitement.php">
                <div class="form-group">
                     <label for="montantOffre">Faire une offre</label>
                     <input type="number" class="form-control" id="montantOffre<?php echo($idItem); ?>" aria-describedby="negociation" id="montantOffre" name="montantOffreinput">
                     <small id="NegociationMontantHelp" class="form-text text-muted">Essayez de convaincre notre vendeur</small>
                      <div class="invalid-feedback">
                            Pour negocier Le montant entré doit être inférieur au prix de l'article, sinon possibilité de se le procurer à l'achat direct
                    </div>


                </div>
                <?php $urlRed="panier.php"; ?>
                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                 <input type="hidden" name="idOffre" value=<?php echo($idOffre); ?> >
                <input type="hidden" name="nbOffres" value=<?php echo($nbOffres); ?> >
                <input type="hidden" name="urlRedirection" value=<?php echo($urlRed); ?> > <!-- Cette variable $urlRed doit être définie dans la page qui appelle modal_encheres.php -->
                <button type="submit" class="btn btn-success">Soumettre l'offre</button> 

            </form>
        <?php }
        else{
            
            ?>

                <p>tentative de négotiation !  </p>
              

              <button  type="button" id="nouvellenegotiation<?php echo($idItem); ?>" class="btn btn-danger" name="nouvellenegotiation">Faire une autre offre</button>
              


            <form method="post" action="modal_meilleure_offre_traitement.php" >
 
                <div class="form-group acacher" id="montantOffre<?php echo($idItem); ?>" >

                    
                     <label for="montantoffre">nouvelle offre</label>

                                         <input type="number" class="form-control  "  aria-describedby="negotiation"  id="montantOffre" name="montantOffreinput">

                        <!--<small id="NegociationMontantHelp" class="form-text text-muted">Essayez de convaincre notre vendeur</small>-->
                      <div class="invalid-feedback">
                            Pour negocier Le montant entré doit être inférieur au prix de l'article, sinon possibilité de se le procurer à l'achat direct
                    </div>


                </div>
                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                
                <input type="hidden" name="idOffre" value=<?php echo($idOffre); ?> >
                <input type="hidden" name="nbOffres" value=<?php echo($nbOffres); ?> >

                <input type="hidden" name="urlRedirection" value=<?php echo($urlRed); ?> > <!-- Cette variable $urlRed doit être définie dans la page qui appelle modal_encheres.php -->
                <button type="submit" class="btn btn-success acacher " id="soumettreoffre<?php echo($idItem); ?>">Soumettre l'offre</button> 

            </form>
            <br>
            <form  method="post" action="modal_meilleure_offre_traitement2.php">
                <button  type="submit" id="Finnegotiation<?php echo($idItem); ?>" class="btn btn-danger" name="Finnegotiation">Accepter la dernière offre</button>
            </form>


        <?php
        
    }
   

      
        
      ?>
            
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
          
        </div>
    </div>
</div>