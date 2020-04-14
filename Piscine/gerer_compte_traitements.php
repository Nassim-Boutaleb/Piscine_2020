<?php
    session_start();  // Lancer une session
    
    //Booléen
    $error = false;

    // Récupérer les infos du formulaire rempli par l'utilisateur
    $login = isset($_POST["email"])?$_POST["email"] : "" ;  
    $pass = isset($_POST["password"])?$_POST["password"] : "" ;
    $nom = isset($_POST["nom"])?$_POST["nom"] : "" ;
    $prenom = isset($_POST["prenom"])?$_POST["prenom"] : "" ;
    $adresse = isset($_POST["adresse"])?$_POST["adresse"] : "" ;
    $ville = isset($_POST["ville"])?$_POST["ville"] : "" ;
    $cp = isset($_POST["cp"])?$_POST["cp"] : "" ;
    $pays = isset($_POST["pays"])?$_POST["pays"] : "" ;
    $tel = isset($_POST["tel"])?$_POST["tel"] : "" ;
    $statut = isset($_POST["statut"])?$_POST["statut"] : "" ;
    

    $ancienLogin = $_SESSION["login"];

    // Vérifier que le login entré n'existe pas déjà dans la BDD

    //identifier le nom de base de données 
	$database = "ecebay"; 
	
	//connectez-vous dans votre BDD 
	//Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
	$db_found = mysqli_select_db($db_handle, $database); 
	
	//si le BDD existe, faire le traitement 
	if ($db_found) { 
        
        // Regarder si le login a changé en comparant la valeur du formulaire avec celle de la session
        if ($login != $_SESSION["login"])
        {
            // Vérifier que le nouveau login n'existe pas déjà
            $sql = "SELECT login FROM utilisateur ";  // on regarde tous les login
            $result = mysqli_query($db_handle, $sql); 

            while ($data = mysqli_fetch_assoc($result)) {   
                
                // Regarder si le login entré existe dans la BDD
                if ($login == $data["login"]) // le login existe : erreur
                {
                    $error = 1;
                    echo ("ERREUR LOGIN");
                    ?>

                    <!-- Formulaire qui va transmettre à la page de modif de compte l'erreur. Il est envoyé automatiquement
                    par un script javascript -->
                    <form method="post" action="gerer_compte.php" id="erreurF">
                        <input type="hidden" name="erreursCreation" value="<?php echo($error) ?>">
                    </form>
                    <script> 
                    document.getElementById("erreurF").submit(); // soumission du formulaire = redirection vers creer_compte.php
                    </script>
                    <?php
                }
            }  
        }
        
        
        // S'il n'y a pas d'erreur : on met à jour la session et la BDD, puis on redirige vers la page de gestion du compte
        // et on y affiche un message de succès
        if ($error == false)
        {
            // MAJ BDD
            $sql = "UPDATE utilisateur SET login='$login',password='$pass',nom='$nom',prenom='$prenom',
            adresse='$adresse',ville='$ville',code_postal='$cp',pays='$pays',numero_tel='$tel',statut='$statut' WHERE login='$ancienLogin' ";

            $result = mysqli_query($db_handle, $sql);

            // mise a jour de session
            if ($result)
            {
                 $_SESSION["login"]=$login;
                 $_SESSION["nom"] = $nom;
                 $_SESSION["statut"] = $statut;
 
                // Message de succès
                ?> <script> alert("Connexion succès"); </script> <?php

                // Redirection
                ?> <meta http-equiv="refresh" content="0; url=gerer_compte.php"> <?php
            }
            else
            {
                echo ("ERREUR AJOUT COMPTE DANS BDD");
            }
           
            
        }

	}   //end if base de données existe
	
	//si le BDD n'existe pas 
	else { 
		echo "Database not found"; 
		}   //end else 
		
	//fermer la connection 
	mysqli_close($db_handle); 



?>