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


    // Vérifier que le login entré n'existe pas déjà dans la BDD

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
            if ($login == $data["login"]) // le login existe : erreur
            {
                $error = 1;
                echo ("ERREUR LOGIN");
                ?>

                <!-- Formulaire qui va transmettre à la page de création de compte l'erreur. Il est envoyé automatiquement
                par un script javascript -->
                <form method="post" action="creer_compte.php" id="erreurF">
                    <input type="hidden" name="erreursCreation" value="<?php echo($error) ?>">
                </form>
                <script> 
                   document.getElementById("erreurF").submit(); // soumission du formulaire = redirection vers creer_compte.php
                </script>
                <?php
            }
        }  
        
        // S'il n'y a pas d'erreur : on affiche un message de succès
        // On ajoute dans la BDD le nouvel utilisateur
        // on ouvre une session et on redirige vers la page d'accueil
        if ($error == false)
        {
            // Ajout dans la BDD
            $sql = "INSERT INTO utilisateur (login,password,nom,prenom,adresse,ville,code_postal,pays,numero_tel,statut) 
            VALUES ('$login', '$pass', '$nom', '$prenom','$adresse', '$ville', '$cp', '$pays', '$tel', '$statut') ";

            $result = mysqli_query($db_handle, $sql);

            // Ouverture de session
            if ($result)
            {
                 $_SESSION["login"]=$login;
 
                // Message de succès
                ?> <script> alert("Connexion succès"); </script> <?php

                // Redirection
                ?> <meta http-equiv="refresh" content="0; url=test_acc.php"> <?php
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