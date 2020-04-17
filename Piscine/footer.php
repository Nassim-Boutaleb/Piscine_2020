<link rel="stylesheet" type="text/css" href="styles.css">

<footer class="page-footer" id="pied">   
            <div class="container">   
                 <div class="row">      
                      <div class="col-lg-8 col-md-8 col-sm-12">       
                          <h6 class="text-uppercase font-weight-bold">Informations additionnelles</h6>       
                          <p> Projet Piscine 
                              web officiel
                        </p>       
                      
                    </div>   
                    <div class="col-lg-4 col-md-4 col-sm-12">       
                        <h6 class="text-uppercase font-weight-bold">Contact</h6>       
                        <p>             37, quai de Grenelle, 75015 Paris, France <br>             info@webDynamique.ece.fr <br>             +33 01 02 03 04 05 <br>             +33 01 03 02 05 04       
                        </p>  

                         <!--FORMULAIRE CONTACT-->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#fenetrecontact">Prendre contact</button>


                    <div class="modal fade" id="fenetrecontact" tabindex="-1" role="dialog" aria-labelledby="fenetretitrecentre" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                    <div class="modal-header">
                    <h5 class="modal-title" id="fenetretitrecentre">Formulaire Contact</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                    </button>
                    </div>

                    <div class="modal-body">

                         <div class="col-sm-12" id="formContact">      
                             <form method="post" action="tp7Contact.php">  
                                <div class="form-group">    
                                    <input type="text" class="form-control" placeholder="Votre nom:" name="nom" id="fnom"> 
                                </div> 
                                 <div class="form-group">    
                                    <input type="email" class="form-control" placeholder="Courriel:" name="email" required> 
                                </div> 
                                <div class="form-group">    
                                     <textarea class="form-control" rows="4" name="comm" placeholder="Vos commentaires" id="comm"required></textarea> 
                                </div> 
                                <input type="submit" class="btn btn-secondary btn-block" value="Envoyer" name=""> 
                            </form> 
                        </div>   

                    </div> 
                </div>
                    </div>
                    <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="button" class="btn btn-primary">Save changes</button>
      </div>
    </div>
  </div>
</div>    


                    </div>
                   
                   



                </div>   
                <div class="footer-copyright text-center">
                    &copy; 2019 Copyright | Droit d'auteur: webDynamique.ece.fr
                </div> 
            </footer>