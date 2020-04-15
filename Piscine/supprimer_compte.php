<?php
    session_start();  // Lancer une session
    
    //Booléen
    $error = false;

    
    
    // Récupérer le login à supprimer 
    $login = isset($_POST["AGSupp"])?$_POST["AGSupp"] : " " ;  
    
    
    //identifier le nom de base de données 
	$database = "ecebay"; 
	
	//connectez-vous dans votre BDD 
	//Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
	$db_found = mysqli_select_db($db_handle, $database); 
	
	//si le BDD existe, faire le traitement 
	if ($db_found) { 
        
        $sql = "DELETE FROM utilisateur WHERE login='$login' ";  // on regarde tous les login
        $result = mysqli_query($db_handle, $sql); 

		
        if ($result) // OK bien supprimé
        {
            // Redirection
            ?> <meta http-equiv="refresh" content="0; url=admin_gerer_comptes.php?alertCode=1"> <?php
        }
        else // Une erreur
        {
            ?> <meta http-equiv="refresh" content="0; url=admin_gerer_comptes.php?alertCode=2"> <?php
        }

	}   //end if base de données existe
	
	//si le BDD n'existe pas 
	else { 
		echo "Database not found"; 
		}   //end else 
		
	//fermer la connection 
	mysqli_close($db_handle); 

    

?>