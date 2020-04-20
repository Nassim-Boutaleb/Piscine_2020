<?php
    // On verrifier si l'utilisateur a deja fait une offre
 
       $sql955 = "SELECT * FROM meilleure_offre WHERE idItemOffre ='$idItem'  ";  

        $result955 = mysqli_query($db_handle, $sql955);
        if($result955){
            $data955 = mysqli_fetch_assoc($result955); 
        

        if ($data955["nbOffres"]==0) // Si aucune offre n'a encore été faite
            
        {
            
            $newnegotiation = true; // Pour les affichages
            

        }
        else // Si une offre a déja été faite 
        {
            $newnegotiation = false;
            
        }
        $lastnegociation = $data955["PrixVendeur"];
        $consensus=$data955["Consensus"];

        $idOffre=$data955["IdOffre"];
        $nbOffres=$data955["nbOffres"];
        $nbTentatives=$nbOffres+1;
        }


?>
<script>
        $(document).ready(function() {
            // La gestion des erreurs
            // Les variables  php numeroIdItemERR et erreurEnchere sont définies dans la page qui appelle la modal
            var erreurMO = <?php echo($erreurMO); ?>;
            var numeroIdItemERR = <?php echo($numeroIdItemERRMO); ?>; // l'ID de l'item dont l'enchere est en erreur
            
            var idItem = <?php echo($idItem); ?>;

            // Cliquer sur l'encoche encheres auto pour dévoiler le champ du montant max
            $("#nouvellenegotiation"+idItem).on("click",function(){  
                //alert ("CLICK "+"enchereAutoCheckbox"+idItem);
                
                    //alert ("OOP");
                    $("#montantOffre"+idItem).slideDown();
                    $("#soumettreoffre"+idItem).slideDown(); 
            }); 
            $("#annulerAchat"+idItem).on("click",function(){  
                //alert ("CLICK "+"enchereAutoCheckbox"+idItem);
                
                    $("#soumettreoffre"+idItem).trigger("click"); 
            }); 


            // Gestion des erreurs
            if (erreurMO == 5)  // montant trop bas
            {
                $("#montantOffre"+numeroIdItemERR).addClass ("is-invalid");
            }
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
            
        if($consensus==0)
        {   
             if($newnegotiation == true)
             { 
            ?>
            <p>1ère tentative de négotiation !  </p>

            <form method="post" action="modal_meilleure_offre_traitement.php">
                <!-- Informations de paiement (cachées sauf si c'est ma 1ere offre sur cette enchère) -->
                <div  id="paiement<?php echo($idItem); ?>">
                    
                    
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
                                                    
                                                    $sqlMO = "SELECT DISTINCT(numerocarte),dateexpiration,cvc,credit,nom,login FROM paiement WHERE login='$login'";  
                                                    $resultMO = mysqli_query($db_handle, $sqlMO); 
                                                    
                                                    while ($dataMO = mysqli_fetch_assoc($resultMO)) 
                                                    {
                                                        $numerocarte = $dataMO["numerocarte"];
                                                        $dateexpiration = $dataMO["dateexpiration"]; 
                                                        $cvc = $dataMO["cvc"]; 
                                                        $credit = $dataMO["credit"]; 
                                                        $nom = $dataMO["nom"]; 

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

                <div class="form-group">
                     <label for="montantOffre">Faire une offre</label>
                     <input type="number" class="form-control" id="montantOffre<?php echo($idItem); ?>" aria-describedby="negociation" id="montantOffre" name="montantOffreinput">
                     <small id="NegociationMontantHelp" class="form-text text-muted">Essayez de convaincre notre vendeur</small>
                      <div class="invalid-feedback">
                            Prix trop élevé
                    </div>


                </div>
                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                 <input type="hidden" name="idOffre" value=<?php echo($idOffre); ?> >
                <input type="hidden" name="nbOffres" value=<?php echo($nbOffres); ?> >
                <input type="hidden" name="urlRedirection" value="Panier.php" > 
                <!-- Cette variable $urlRed doit être définie dans la page qui appelle modal_encheres.php -->
                <button type="submit" class="btn btn-success">Soumettre l'offre</button> 

            </form>
        <?php }
        else
        {
            
            ?>

                <p> <?php echo"$nbTentatives";?> éme tentative de négotiation ! la dernière Offre du vendeur est: <?php echo"$lastnegociation";?> </p>
              

              <?php
               if ($nbTentatives <6)
               {
                ?><button  type="button" id="nouvellenegotiation<?php echo($idItem); ?>" class="btn btn-danger" name="nouvellenegotiation">Faire une autre offre</button><?php
               }
               else 
               {
                ?><button  type="button" id="annulerAchat<?php echo($idItem); ?>" class="btn btn-danger" name="nouvellenegotiation">Annuler l'achat</button><?php
               }
               ?>
               


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
                <input type="hidden" name="idItem" value=<?php echo($idItem); ?> >
                <input type="hidden" name="idOffre" value=<?php echo($idOffre); ?> >
                <input type="hidden" name="nbOffres" value=<?php echo($nbOffres); ?> >
                <button  type="submit" id="Finnegotiation<?php echo($idItem); ?>" class="btn btn-danger" name="Finnegotiation">Accepter la dernière offre</button>
            </form>


        <?php
        
    }
}
else{
    ?>
        <p>le Vendeur n'a pas encore répondu à votre dernière offre! patientez encore quelques temps </p>
    <?php
}
   

      
        
      ?>
            
            
        </div>

        <div class="modal-footer">
            <button type="button" class="btn btn-danger" data-dismiss="modal">Annuler</button>
          
        </div>

    </div>
</div>