<!DOCTYPE html> 
<html> 
    <head>  
        <title>Ebay ECE</title> 
        <meta charset="utf-8">  
        <meta name="viewport" content="width=device-width, initial-scale=1">      
         <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css"> 
        <link rel="stylesheet" type="text/css" href="styles.css"> 

        <script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>  
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script> 

        <script type="text/javascript">      
            $(document).ready(function(){           
                $('.header').height($(window).height());  // Taille du header = taille totale de l'écran   
            }); 
        </script>
    </head> 
    
    <body> 

        <!--HEADER-->

        <!-- Navbar (barre de navigation)-->
 
        <?php require("Navbars/navbar_def.php");  ?>

        <!-- Un caroussel (code inspiré de la doc de bootstrap ) -->
                       

        <div id="carouselExampleControls" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner">
              <div class="carousel-item active">
                <img class="d-block w-100" src="Images/column1.jpg" alt="First slide">
              </div>
              <div class="carousel-item">
                <img class="d-block w-100" src="Images/column2.jpg" alt="Second slide">
              </div>
            </div>
            <a class="carousel-control-prev" href="#carouselExampleControls" role="button" data-slide="prev">
              <span class="carousel-control-prev-icon" aria-hidden="true"></span>
              <span class="sr-only">Previous</span>
            </a>
            <a class="carousel-control-next" href="#carouselExampleControls" role="button" data-slide="next">
              <span class="carousel-control-next-icon" aria-hidden="true"></span>
              <span class="sr-only">Next</span>
            </a>
          </div>

        <!-- Pied de page-->
        <footer class="page-footer" id="pied">   
            <div class="container">   
                 <div class="row">      
                      <div class="col-lg-8 col-md-8 col-sm-12">       
                          <h6 class="text-uppercase font-weight-bold">Information additionnelle</h6>       
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
    </body> 
    
</html> 