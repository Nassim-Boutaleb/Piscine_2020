<?php
    session_start();  // Lancer une session 

    // Des erreurs ?
    $erreur = 0;

    // Il y a 3 cas à gérer pour une enchere:
    //1. Personne n'a encore fait d'enchère et je vais faire la 1ere offre (nouvelle enchère) (INSERT table acheteur_enchere et acheter_item et UPDATE table enchere )
    //2. Il y a déjà des offres faites, mais c'est ma 1ere offre sur cette enchère (UPDATE table enchere et acheter_utem et INSERT table acheteur_enchere)
    //3. J'ai déjà fait des offres sur cettes enchère (UPDATE BDD tables enchère et acheteur_enchere)
    
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
            $enchereMax = isset($_POST["autoMax"])?$_POST["autoMax"]:"0";
        }
        else
        {
            $enchereAuto = 0;
            $enchereMax = 0;
        }
        $login = $_SESSION["login"];
        $idItem = $_POST["idItem"];
        $urlRed = isset($_POST["urlRedirection"])?$_POST["urlRedirection"]:"accueil.php";
        $maPremiereOffre = true;
        if ($_POST["maPremiereOffre"] == "1")
        {
            $maPremiereOffre = true;  
        }
        else
        {
            $maPremiereOffre = false;
        }
        

        //Récupérer l'ID de l'enchère sur laquelle on travaille, en se servant de l'ID item
        $sql = "SELECT IdEnchere FROM enchere WHERE IdItem='$idItem'";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);
        
        $IdEnchere = $data["IdEnchere"];
        //echo ("IDI ".$idItem);
        
        
        // Si c'est la 1ere offre de l'utilisateur sur cette enchère: on va gérer la parte paiement
        if ($maPremiereOffre)
        {
            require ("paiements_traitements_encheres.php");
        }
        

        // Il faut regarder l'offre faite et vérifier qu'elle soit
        // superieure à l'ancienne offre (ou au prix si aucune offre n'a étét faite)
        $errorPaiement = isset($errorPaiement)?$errorPaiement:0;
        if ($errorPaiement == 0)
        {
            $sql = "SELECT meilleureOffre FROM enchere WHERE IdEnchere ='$IdEnchere'  ";  
            $result = mysqli_query($db_handle, $sql);
            $data = mysqli_fetch_assoc($result);

            // si le champ a été rempli (car on peut ne faire que des enchères auto)
            // Le champ d'offre est prioritaire sur le champ d'enchere auto
            if ($montantEnchere != "undefined") 
            {
                if ($montantEnchere <= $data["meilleureOffre"]) // enchère trop basse
                {
                    $erreur = 5;
                    //echo ("enchère trop basse car $montantEnchere < ".$data["meilleureOffre"]);
                    // redirection et Java script sur model_encheres ...
                    ?>
                        <meta http-equiv="refresh" content="0; url=<?php echo($urlRed."?erreurEnch=5&amp;NumeroId=$idItem"); ?>" >
                    <?php

                }
                else // mettre a jour meilleureOfre et loginMeilleureOffre
                {
                    $sql2 = "UPDATE enchere SET meilleureOffre='$montantEnchere' , loginMeilleureOffre = '$login' WHERE IdEnchere='$IdEnchere' ";  
                    $result2 = mysqli_query($db_handle, $sql2);
                    
                    if (!$result2)
                    {
                        $erreur = 5;
                        echo ("Erreur mise a jour de enchere pour nouvelle offre");
                    }
                    
                }

            }

            // si on a uniquement activé les encheres auto sans faire d'enchere à la main$
            else if ($montantEnchere == "undefined")
            {
                if ($enchereMax <= $data["meilleureOffre"]) // enchère trop basse
                {
                    $erreur = 9;
                    //echo ("enchère trop basse car $montantEnchere < ".$data["meilleureOffre"]);
                    // redirection et Java script sur model_encheres ...
                    ?>
                        <meta http-equiv="refresh" content="0; url=<?php echo($urlRed."?erreurEnch=9&amp;NumeroId=$idItem"); ?>" >
                    <?php

                }
                else // mettre a jour meilleureOfre et loginMeilleureOffre. Pour une enchere max on se contente de rajouter 1 à la meilleure offre actuelle
                {
                    $nvMO = $data["meilleureOffre"]+1;
                    $sql2 = "UPDATE enchere SET meilleureOffre='$nvMO' , loginMeilleureOffre = '$login' WHERE IdEnchere='$IdEnchere' ";  
                    $result2 = mysqli_query($db_handle, $sql2);
                    
                    if (!$result2)
                    {
                        $erreur = 10;
                        echo ("Erreur mise a jour de enchere pour nouvelle offre par auto");
                    }

                    $montantEnchere = $nvMO;
                    
                }
            }
            

            // On va vérifier si c'est la 1ere fois que l'acheteur fait une enchère sur ce produit
            // On l'ajoute dans la table acheteur_enchere
            // Une fois l'enchere validée si il n'y a aucune erreur regarder dans la table acheteur_enchere si l'acheteur a déjà fait une enchère sur l'article ou pas
            // et si non mettre a jour la table 
            if ($erreur == 0)
            {
                $sql = "SELECT * FROM acheteur_enchere WHERE IdEnchere='$IdEnchere' AND loginAcheteur='$login' ";  
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);

                if (!isset ($data))  // il faut l'ajouter
                {
                    //echo ("$login , $IdEnchere , $enchereAuto , $enchereMax");
                    $maPremiereOffre = true;
                    $sql = "INSERT INTO acheteur_enchere (loginAcheteur,IdEnchere,EnchereAuto,EnchereMax,numeroCarte) VALUES ('$login','$IdEnchere','$enchereAuto','$enchereMax','$numeroCarte') ";  
                    $result = mysqli_query($db_handle, $sql);

                    if (!$result)
                    {
                        $erreur = 1;
                        echo ("Erreur lors de l'ajout dans acheteur_enchere");
                    }
                }

                // Maintenant il faut gérer la mise a jour : si l'utilisateur a décidé d'activer (ou désactiver?)
                // les encheres auto ou s'il a changé son montant max
                // on va mettre a jour la table dans tous les cas (changé ou pas, de ttes façon si ce n'est pas 
                //changé alors on fera un update avec les mêmes valeurs)

                else  // si j'ai déjà fait une offre pour cette enchère mais j'ai peut être modifié des infos sur les enchères auto
                {
                    $maPremiereOffre = false; 
                    $sql = "UPDATE acheteur_enchere SET EnchereAuto='$enchereAuto', EnchereMax = '$enchereMax' WHERE IdEnchere = '$IdEnchere' AND loginAcheteur = '$login'";  
                    $result = mysqli_query($db_handle, $sql);

                    if (!$result)
                    {
                        $erreur = 2;
                        echo ("Erreur lors de la mise a jour dans acheteur_enchere");
                    }
                }
            }
            else
            {
                echo ("Il y a eu une erreur. pas d'ajout dans acheteur_enchere");
            }

            // Une fois l'enchère validée, s'il s'agit de notre 1ère offre sur l'enchère: on l'ajoute
            // dans notre panier = on l'ajoute dans la table acheter_item

            if ($maPremiereOffre)// si c'est notre 1ere offre sur l'enchère
            {
                if ($erreur == 0)// s'il n'y a eu aucune erreur lors des étapes précédentes
                {
                    $sql = "INSERT INTO acheter_item (loginAcheteur,NumeroIDItem) VALUES ('$login','$idItem') ";  
                    $result = mysqli_query($db_handle, $sql);

                    if (!$result)
                    {
                        $erreur = 4;
                        echo ("erreur lors de l'ajout dans le panier (acheter_item)");
                    }

                }
            }


            // et enfin gérer la partie enchere automatique:
            // on va regarder si par rapport à la meilleure offre actuelle (apres les traitements)
            // il y a des encheres qui peuvent encore s'incrémenter (max non dépassé) et si oui,
            // regarder quelle est l'enchere qui pourra aller le plus loin et définir sa valeur
            
            if ($erreur == 0)
            {
                //1. Récupérer celui dont le montant max est le + élevé et son compétiteur le plus proche(2eme la + élevé)
                //echo("$montantEnchere -- $IdEnchere");
                $sql = "SELECT loginAcheteur, MAX(EnchereMax) AS emax FROM acheteur_enchere WHERE EnchereAuto='1' AND EnchereMax > '$montantEnchere' AND IdEnchere = '$IdEnchere'";  
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);
                $maxP = $data["emax"];  // en cas d'égalité on ne garde que le 1er à avoir fait une offre auto
                $maxL = isset($data["loginAcheteur"])?$data["loginAcheteur"]:"undefinedMaxL"; 
                //echo("MAX -- $maxP -- $maxL");
                
                //2. récupérons l'avant dernier
                //echo("$montantEnchere -- $IdEnchere");
                $sql = "SELECT EnchereMax FROM acheteur_enchere WHERE EnchereAuto='1' AND EnchereMax > '$montantEnchere' AND IdEnchere = '$IdEnchere' ORDER BY EnchereMax DESC LIMIT 1 OFFSET 1";  
                $result = mysqli_query($db_handle, $sql);
                $data = mysqli_fetch_assoc($result);
                $maxAP = isset($data["EnchereMax"])?$data["EnchereMax"]:0;  // en cas d'égalité on ne garde que le 1er à avoir fait une offre auto
                
                //echo("$maxAP");

                //3. On compare l'offre qui vient d'être fait (en manuel) avec le montant max de l'avant dernier

                if ($maxL != "undefinedMaxL")
                {
                    if ($maxAP !=0 || $maxL != $login) // ne pas s'enchérir soi même !
                    {
                        if ($maxAP > $montantEnchere)  // la nouvelle meilleure offre sera le montant max de la 2eme offre la plus élevée+1
                        {
                            $montantEnchere = $maxAP+1;
        
                            // mise a jour BDD
                            $sql2 = "UPDATE enchere SET meilleureOffre='$montantEnchere' , loginMeilleureOffre = '$maxL' WHERE IdEnchere='$IdEnchere' ";  
                            $result2 = mysqli_query($db_handle, $sql2);
                            
                            if (!$result2)
                            {
                                $erreur = 22;
                                echo ("Erreur enchere auto 01");
                            }
        
                        }
                        else  // une nouvelle offre manuelle est en fait l'offre qu'il faudra dépasser
                        {
                            $montantEnchere = $montantEnchere+1;
        
                            // mise a jour BDD
                            $sql2 = "UPDATE enchere SET meilleureOffre='$montantEnchere' , loginMeilleureOffre = '$maxL' WHERE IdEnchere='$IdEnchere' ";  
                            $result2 = mysqli_query($db_handle, $sql2);
                            
                            if (!$result2)
                            {
                                $erreur = 23;
                                echo ("Erreur enchere auto 02");
                            }
                        }
                    }
                }
                
                

            }
        }
            

        // C'est terminé, on redirige vers là d'où on vient si aucune erreur
        if ($erreur == 0 && $errorPaiement == 0)
        {
            ?>
                <meta http-equiv="refresh" content="0; url=<?php echo($urlRed); ?>">
            <?php
        }
        

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
