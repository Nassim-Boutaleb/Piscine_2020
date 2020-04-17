<?php
    session_start();  // Lancer une session 

    // Connexion à la BDD
    //identifier le nom de base de données 
    $database = "ecebay"; 
        
    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
    $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
    $db_found = mysqli_select_db($db_handle, $database); 


    if ($db_found) 
    { 
        // On récupéère les données du formulaire:
        $montantEnchere = isset($_POST["montantEnchere"])?$_POST["montantEnchere"]:"undefined";

        if (isset ($_POST["enchereAutoCheckbox"]))
        {
            $enchereAuto = 1;
            $enchereMax = $_POST["autoMax"];
        }
        else
        {
            $enchereAuto = 0;
            $enchereMax = 0;
        }
        $login = $_SESSION["login"];
        $idItem = $_POST["idItem"];
        
        // On va d'abord vérifier si c'est la 1ere fois que l'acheteur fait une enchère sur ce produit
        // On l'ajoute dans la table acheteur_enchere

        //1ere etape: récupérer l'ID de l'enchère sur laquelle on travaille, en se servant de l'ID item
        $sql = "SELECT IdEnchere FROM enchere WHERE IdItem='$idItem'";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);
        
        $IdEnchere = $data["IdEnchere"];
        //echo ("IDI ".$idItem);
        
        // 2eme etape: regarder dans la table acheteur_enchere si l'acheteur a déjà fait une enchère sur l'article ou pas
        // et si non mettre a jour la table 
        $sql = "SELECT * FROM acheteur_enchere WHERE IdEnchere='$IdEnchere' AND loginAcheteur='$login' ";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        if (!isset ($data))  // il faut l'ajouter
        {
            //echo ("$login , $IdEnchere , $enchereAuto , $enchereMax");
            $sql = "INSERT INTO acheteur_enchere (loginAcheteur,IdEnchere,EnchereAuto,EnchereMax) VALUES ('$login','$IdEnchere','$enchereAuto','$enchereMax') ";  
            $result = mysqli_query($db_handle, $sql);

            if (!$result)
            {
                echo ("Erreur lors de l'ajout dans acheteur_item");
            }
        }

        // Maintenant il faut gérer la mise a jour : si l'utilisateur a décidé d'activer (ou désactiver?)
        // les encheres auto ou s'il a changé son montant max
        // on va mettre a jour la table dans tous les cas (changé ou pas, de ttes façon si ce n'est pas 
        //changé alors on fera un update avec les mêmes valeurs)
        else
        {
            $sql = "UPDATE acheteur_enchere SET EnchereAuto='$enchereAuto', EnchereMax = '$enchereMax' ";  
            $result = mysqli_query($db_handle, $sql);

            if (!$result)
            {
                echo ("Erreur lors de la mise a jour dans acheteur_item");
            }
        }

        // Ensuite il faut regarder l'offre faite et vérifier qu'elle soit
        // superieure à l'ancienne offre (sauf si c'est la 1ere offre)

        // On regarde s'il s'agit d'une nouvelle enchere
        $sql = "SELECT meilleureOffre FROM enchere WHERE IdItem ='$idItem'  ";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        // on est le 1er à enchérir : pas de comparaison à faire car il n'y a aucune autre offre: on se content de MAJ la table encheres
        if (!isset($data["meilleureOffre"]))
        {
            //echo("New ench");
            $sql = "UPDATE enchere SET meilleureOffre='$montantEnchere' , loginMeilleureOffre = '$login' WHERE IdEnchere='$IdEnchere' ";  
            $result = mysqli_query($db_handle, $sql);

            if (!$result)
            {
                echo ("Erreur mise a jour de enchere pour 1ere offre");
            }
        } 
        else // on n'est pas le 1er : on regarde l'enchère faite et si elle est valide (> à la meilleure offre)
        {
            if ($montantEnchere != "undefined") // si le champ a été rempli (car on peut ne faire que des enchères auto)
            {
                // on récupère la valeur de la meilleure offre actuelle
                $sql = "SELECT meilleureOffre FROM enchere WHERE IdEnchere='$IdEnchere' ";  
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);

                if ($data["meilleureOffre"] > $montantEnchere) // enchère trop basse
                {
                    echo ("enchère trop basse");
                    // redirection et Java script sur model_encheres ... 
                }
                else // mettre a jour meilleureOfre et loginMeilleureOffre
                {

                }

            }
        }

        // NE PAS OUBLIER AUSSI DE INSERT INTO acheter_item POUR LE PANIER

        /*while ($data = mysqli_fetch_assoc($result)) 
        {
             
        } */

    }
    else
    {
        echo("Database not found");
    }

    //fermer la connection 
	mysqli_close($db_handle); 

?>
