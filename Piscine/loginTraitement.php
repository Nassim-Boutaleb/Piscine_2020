<?php
    session_start();  // Lancer une session
    //Booléen
    $loginOK = false;
    $passOK = false;

    // Récupérer les infos du formulaire rempli par l'utilisateur
    $login = isset($_POST["email"])?$_POST["email"] : "" ;  
    $pass = isset($_POST["pass"])?$_POST["pass"] : "" ;


    // Comparer le login avec les logins dans la BDD et vérifier qu'il existe.

    //identifier le nom de base de données 
	$database = "ecebay"; 
	
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
                $sql2 = "SELECT password FROM utilisateur WHERE login='$login' "; // on regarde le mot de passe associé au login entré
                $result2 = mysqli_query($db_handle, $sql2);
                
                while ($data2 = mysqli_fetch_assoc($result2)) {
                    if ($pass == $data2["password"])  // le mot de passe est correct
                    {
                        $passOK = true;
                        //echo ("Connexion OK login: $login et pass: $pass");
                        // Configurer la session
                        $_SESSION["login"] = $login;

                        $sql2 = "SELECT nom FROM utilisateur WHERE login='$login' "; // on regarde le nom associé au login entré
                        $result2 = mysqli_query($db_handle, $sql2);
                
                        while ($data2 = mysqli_fetch_assoc($result2)) {
                            $nom = $data2["nom"];
                        }
                        $_SESSION["nom"] = $nom;
                        ?>
                        <meta http-equiv="refresh" content="0; url=accueil.php">
                        <?php

                    }
                }
            }
        }  
        
        // En cas d'erreur : retour à la page du formulaire avec la transmission des erreurs
        if ($loginOK == false || $passOK == false)
        {
            $erreurLog = 0;   // 1 si le login est faux , 2 si le mot de passe est faux
            if ($loginOK == false)
            {
                //echo ("Login incorrect <br>");
                $erreurLog = 1;
            }
            else if ($passOK == false)
            {
                //echo ("mdp incorrect");
                $erreurLog = 2;
            }
            echo("erreur: $erreurLog");
            ?>

            <!-- Formulaire qui va transmettre à la page de login l'erreur. Il est envoyé automatiquement
            par un script javascript -->
            <form method="post" action="login.php" id="erreurF">
                <input type="hidden" name="erreursLogin" value="<?php echo($erreurLog) ?>">
            </form>
            <script> 
                document.getElementById("erreurF").submit(); // soumission du formulaire = reidrection vers login.php
            </script>
       <?php } // fin if erreur

	}   //end if base de données existe
	
	//si le BDD n'existe pas 
	else { 
		echo "Database not found"; 
		}   //end else 
		
	//fermer la connection 
	mysqli_close($db_handle); 



?>