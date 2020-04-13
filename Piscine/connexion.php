<?php
    //Booléen
    $loginOK = false;
    $passOK = false;

    // Récupérer les infos du formulaire rempli par l'utilisateur
    $login = isset($_POST["email"])?$_POST["email"] : "" ;  
    $pass = isset($_POST["pass"])?$_POST["pass"] : "" ;


    // Comparer le login avec les logins dans la BDD et vérifier qu'il existe.

    //identifier le nom de base de données 
	$database = "ebayece"; 
	
	//connectez-vous dans votre BDD 
	//Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
	$db_found = mysqli_select_db($db_handle, $database); 
	
	//si le BDD existe, faire le traitement 
	if ($db_found) { 
        
        $sql = "SELECT login FROM utilisateur ";  // on regarde tous les login
        $result = mysqli_query($db_handle, $sql); 

		while ($data = mysqli_fetch_assoc($result)) {   
            
            // Regarder si le login entré existe dans la BDD
            if ($login == $data["login"]) // le login existe : on va comparer les mots de passe maintenant
            {
                $loginOK = true;
                $sql2 = "SELECT password FROM utilisateur WHERE login='$login' "; // on regarde le mot de passe associé au login
                $result2 = mysqli_query($db_handle, $sql2);
                
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    if ($pass == $data2["password"])  // le mot de passe est correct
                    {
                        $passOK = true;
                        echo ("Connexion OK login: $login et pass: $pass");
                    }
                }
            }
        }   //end while 
        
        // Affichage des erreurs
        if ($loginOK == false)
        {
            echo ("Login incorrect <br>");
        }
        if ($passOK == false)
        {
            echo ("mdp incorrect");
        }
	}   //end if 
	
	//si le BDD n'existe pas 
	else { 
		echo "Database not found"; 
		}   //end else 
		
	//fermer la connection 
	mysqli_close($db_handle); 



?>