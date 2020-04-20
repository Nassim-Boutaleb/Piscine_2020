<?php

    date_default_timezone_set('Europe/Paris');

    // dans ce script on va :
    // 1. Regarder à quelle heure était la dernière vérification des transactions
    // 2. Regarder la liste des transactions faites et leurs dates
    // 3. Si des transactions ont une date postérieure à celle de la dernière connexion, elles sont nouvelles
    // 4. on va regarder si ce sont des transactions à paiement automatiques (enchere,meilleure offre) et si oui
    // informer l'utilisateur (pop up et/ou notification) du paiement automatique
    // 5. enfin ne pas oublier de mettre a jour la date de dernière vérification avec la date actuelle

    //identifier le nom de base de données 
	$database = "ecebay"; 
	
	//connectez-vous dans votre BDD 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
    $db_found = mysqli_select_db($db_handle, $database); 
    
    // variables 
    $login = $_SESSION["login"];
	
	//si le BDD existe, faire le traitement 
    if ($db_found) 
    { 
        // 1. Récupérer la date de la dernière vérification:
        $sql = "SELECT derniereVerif FROM utilisateur WHERE login='$login'";  
        $result = mysqli_query($db_handle, $sql); 
        $data = mysqli_fetch_assoc($result);
        $dateDerniereVerif = isset($data["derniereVerif"])?$data["derniereVerif"]:"1997-06-01 17:00:00"; // on stocke

        // 2. Parcourir la table des transaction_effectuees et comparer à chaque fois les dates
        $sql = "SELECT * FROM transactions_effectuees WHERE login='$login'";  
        $result = mysqli_query($db_handle, $sql);
        while ($data = mysqli_fetch_assoc($result)) 
        {
            if ($dateDerniereVerif < $data["date"]) // si la dernière vérification a été faite avant la transaction
            {
                if (isset($data["idEnchere"]))  // si c'est une enchère = on regarde si on a gagné ou perdu l'enchère (transaction refusée) et il faut prévenir l'utilisateur
                {

                    if ($data["accepteeRefusee"] == 1)  // on a gagné
                    {
                        ?>
                            <script>
                                $(document).ready(function(){ 
                                    // pour les notifications
                                    var nomProduit = "<?php echo($data["nomProduit"]); ?>";
                                    var prix = <?php echo($data["prix"]); ?>;
                                    $("#notifsDOM").append (`
                                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="60000" style="width:280px;">  
                                            <div class="toast-header">  
                                                <strong class="mr-auto">Enchère remportée</strong>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Vous avez remporté l'enchère sur le produit `+nomProduit+` et avez été automatiquement débité de `+prix+`€
                                            </div>
                                        </div>
                                    `);
                                    $('.toast').toast('show');
                                }); 
                            </script>
                        <?php
                    }

                    else  // on a perdu
                    {
                        ?>
                            <script>
                                $(document).ready(function(){ 
                                    // pour les notifications
                                    var nomProduit = "<?php echo($data["nomProduit"]); ?>";
                                    var prix = <?php echo($data["prix"]); ?>;
                                    $("#notifsDOM").append (`
                                        <div class="toast" role="alert" aria-live="assertive" aria-atomic="true" data-autohide="true" data-delay="60000" style="width:280px;">  
                                            <div class="toast-header">  
                                                <strong class="mr-auto">Enchère perdue</strong>
                                                <button type="button" class="ml-2 mb-1 close" data-dismiss="toast" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="toast-body">
                                                Vous avez perdu l'enchère sur le produit `+nomProduit+`
                                            </div>
                                        </div>
                                    `);
                                    $('.toast').toast('show');
                                }); 
                            </script>
                        <?php
                    }
                }
            }
        }
        
        // Mettre a jour la date de dernière visite
        $dateDuJour = date("Y-m-d H:i:s");
        $sql = "UPDATE utilisateur SET derniereVerif='$dateDuJour' WHERE login='$login'";  
        $result = mysqli_query($db_handle, $sql); 

        if (!$result)
        {
            echo ("ERREUR LORS DE LA MISE A JOUR DE LA DERNIERE VERIFICATION");
        }


    }
    else
    {
        echo ("Database not found");
    }

        

?>