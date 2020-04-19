
<?php
    
    date_default_timezone_set('Europe/Paris');

    // Script qui va être lancé à chaque visite de la page d'accueil (voire des autres pages)
    //Il va passer en revue la table des enchères et regarder si une enchère est arrivée à terme
    // si oui, regarder le gagant et ajouter la transaction dans la table des transactions
    // puis supprimer l'enchère des tables enchere et acheteur_enchere ainsi que du panier (acheter_item)

    //identifier le nom de base de données 
    $database = "ecebay"; 
    
    // Des erreurs ?
    $erreurVE = 0;
	
	//connectez-vous dans votre BDD 
	 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
	$db_found = mysqli_select_db($db_handle, $database); 
	
	//si le BDD existe, faire le traitement 
    if ($db_found) 
    { 
        
        $sql = "SELECT * FROM enchere ";  // on regarde toutes les enchères ouvertes
        $result = mysqli_query($db_handle, $sql); 

        while ($data = mysqli_fetch_assoc($result)) 
        {   
            // regarder si la date actuelle est > à la date de fin de l'enchère
            // Date actuelle
            $aujourdhui = date("Y-m-d H:i:s");

            // récupérer la date de fin de l'enchere
            $finEnchere = $data["dateFin"];

            // on compare
            if ($aujourdhui > $finEnchere ) // si l'enchere est terminée
            {
                //echo("Une enchere terminée");
                //qui a gagné ?
                $loginGagnant = $data["loginMeilleureOffre"];

                //les informations sont enregistrées dans son historique des transactions
                $idItem = $data["IdItem"];
                $idEnchere = $data["IdEnchere"];
                $prix = $data["meilleureOffre"];
                $dateTransaction = $aujourdhui;

                // Mais il faut  récupérer le nom du produit ...
                $sql2 = "SELECT Nom FROM item WHERE NumeroID='$idItem' ";  // on regarde toutes les enchères ouvertes
                $result2 = mysqli_query($db_handle, $sql2); 
                $data2 = mysqli_fetch_assoc($result2);
                $nomProduit = $data2 ["Nom"];

                

                $sql2 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,idEnchere,date,accepteeRefusee,nomProduit) VALUES ('$loginGagnant','$idItem','$prix','Enchere','$idEnchere','$dateTransaction','1','$nomProduit')";
                $result2 = mysqli_query($db_handle, $sql2);
                
                if (!$result2)
                {
                    echo ("erreur lors de l'ajout de la transaction");
                    $erreurVE = 1;
                }
                else  
                {
                    // regarder dans acheteur enchere tous ceux qui ont participé et leur ajouter une transaction refusee
                    
                    $sql3 = "SELECT loginAcheteur FROM acheteur_enchere WHERE IdEnchere = '$idEnchere' AND loginAcheteur != '$loginGagnant' " ;
                    $result3 = mysqli_query($db_handle, $sql3);
                    while ($data3 = mysqli_fetch_assoc($result3)) 
                    {
                        $loginPerdant = $data3["loginAcheteur"];
                        $sql4 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,idEnchere,date,accepteeRefusee,nomProduit) VALUES ('$loginPerdant','$idItem','$prix','Enchere','$idEnchere','$dateTransaction','2','$nomProduit')";
                        $result4 = mysqli_query($db_handle, $sql4);
                        
                        if (!$result4)
                        {
                            echo ("erreur lors de l'ajout de la transaction pour les perdants");
                            $erreurVE = 99;
                        }
                    }


                    // supprimer l'item : il n'est plus disponible à la vente
                    $sql3 = "DELETE FROM item WHERE NumeroID = '$idItem' ";
                    $result3 = mysqli_query($db_handle, $sql3);

                    if (!$result3)
                    {
                        $erreurVE = 2;
                        echo ("ERREUR Pas pu supprimer l'item ! ");
                    }
                    else
                    {
                        //On supprime l'enchere des autres tables aussi
                        // Normalement SQL le fait automatiquement avec le système des clés étrangères
                        // mais au cas où ...
                        $sql3 = "DELETE FROM enchere WHERE IdEnchere = '$idEnchere' ";
                        $result3 = mysqli_query($db_handle, $sql3);

                        if (!$result3)
                        {
                            $erreurVE = 3;
                            echo ("ERREUR Pas pu supprimer l'enchere ! ");
                        }   


                    }
                    
                }

                

            }
            
        }
    }  
        else
        {
            echo ("Database not found");
        }

       /* $result2 = mysqli_query($db_handle, $sql2); 
                while ($data2 = mysqli_fetch_assoc($result2)) 
                {

                } */

    
?>
