<?php
    //identifier le nom de base de données 
	$database = "ebayece"; 
	
	//connectez-vous dans votre BDD 
	//Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
	$db_handle = mysqli_connect('localhost', 'root', 'root' ); 
	$db_found = mysqli_select_db($db_handle, $database); 
	
	//si le BDD existe, faire le traitement 
	if ($db_found) { 
        
        $sql = "SELECT SUM(PIBParTete) AS somme FROM g20 WHERE Region='Asie'";
        $result = mysqli_query($db_handle, $sql); 

		while ($data = mysqli_fetch_assoc($result)) {  
            echo "La somme est: " . $data['somme'] . '<br>'; 
            echo ("<br>");
		}   //end while 
	}   //end if 
	
	//si le BDD n'existe pas 
	else { 
		echo "Database not found"; 
		}   //end else 
		
	//fermer la connection 
	mysqli_close($db_handle); 


?>