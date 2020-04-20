<?php
    session_start();  // Lancer une session
    
    //Booléen
    $error = 0;

    // Récupérer données de session
    $totalPrix= $_SESSION["TotalPanier"];
    $login= $_SESSION["login"];

    //On a créé une nouvelle carte ou on a utilisé une carte existante ?
    if (isset($_POST["useBtn"])&&$_POST["useBtn"]="use")
    {
        $numeroCarte = $_POST["useCarte"];
        echo ("on utilise la carte".$_POST["useCarte"]);

        //identifier le nom de base de données 
        $database = "ecebay"; 

        //connectez-vous dans votre BDD 
        //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
        $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
        $db_found = mysqli_select_db($db_handle, $database);

        //si le BDD existe, faire le traitement 
        
        
        if ($db_found) 
        { 
            $sql = "SELECT * FROM paiement WHERE numerocarte = '$numeroCarte' AND login = '$login' ";  
            $result = mysqli_query($db_handle, $sql); 
            $data = mysqli_fetch_assoc($result);

            // On récupère la valeur du crédit dans la carte
            $creditCarte = $data["credit"];

            if($totalPrix>=$creditCarte)  // c'est trop cher : la transaction est refusée !
            {
                $error = 2;
                echo ("Paiement refusé: solde insuffisant:  totalPrix= $totalPrix / creditCarte = $creditCarte");
                ?><meta http-equiv="refresh" content="1; url=paiement.php?alertCodeC=1"><?php
            }
            else  // paiement accepté: on est débité (MAJ de la table), supprimer l'item de la table item (et par voie de conséquence du panier)
            {
                $error=0;
                echo ("Paiement accepté"); 

                $newCredit = 500-$totalPrix;
                $sql = "UPDATE paiement SET credit = '$newCredit' WHERE numerocarte ='$numeroCarte' ";  
                $result = mysqli_query($db_handle, $sql);

                if (!$result)
                {
                    $error = 4;
                    echo ("Une erreur est survenue lors de la mise a jour du crédit");
                    ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
                }
                else
                {
                    // supprimer l'item
                    // Récupérer les items du panier en acahat direct
                    $sql3="SELECT * FROM item,acheter_item WHERE loginAcheteur='$login'AND NumeroIDItem=item.NumeroID AND item.TypeVente='Achat direct' ";
                    $result3 = mysqli_query($db_handle, $sql3);
                    while ($data3 = mysqli_fetch_assoc($result3)) // défiler les items du panier qui sont des achats directs et les supprimer de la table item
                    {
                        $idItemSupp = $data3["NumeroIDItem"];
                        $prixItem = $data3["Prix"];
                        $typeVenteItem = $data3["TypeVente"];
                        $nomItem = $data3["Nom"];


                        //ajouter une transaction
                        $sql2 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,date,accepteeRefusee,nomProduit) VALUES ('$login','$idItemSupp','$prixItem','$typeVenteItem',NOW(),'1','$nomItem')";
                        $result2 = mysqli_query($db_handle, $sql2);
                
                        if (!$result2)
                        {
                            echo ("erreur lors de l'ajout de la transaction");
                            $erreur = 51;
                            ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
                        }

                        // supprimer l'item
                        $sql = "DELETE FROM item WHERE NumeroID='$idItemSupp'";  
                        $result = mysqli_query($db_handle, $sql);
                        if (!$result)
                        {
                            $error = 50;
                            echo ("Une erreur à eu lieu lors du vidange du panier");
                            ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
                        }
                    }
                }


            }       
        }
        else
        {
            echo ("Database not found");
        }

        if ($error == 0)
        {
            echo ("Aucune erreur, redirection en cours");
            ?><meta http-equiv="refresh" content="1; url=accueil.php?alertCode=15"><?php
        }

        
    }
    else if (isset($_POST["createBtn"]) && $_POST["createBtn"]="create" )
    {
        //echo ("on crée une nouvelle carte");

        // Récupérer les infos du formulaire rempli par l'utilisateur
        $idtransaction = isset($_POST["cle"])?$_POST["cle"] : "" ;  
        $numerocarte = isset($_POST["numcarte"])?$_POST["numcarte"] : "" ;  
        $datelimiteP = isset($_POST["datelimite"])?$_POST["datelimite"] : "" ;
        $datelimite = date('Y-m-d', strtotime($datelimiteP));
        $codesecret = isset($_POST["codesecret"])?$_POST["codesecret"] : "" ;
        $nom = isset($_POST["nom"])?$_POST["nom"] : "" ;


        //____________________________________

        // Fontion de prévérification de la carte bancaire
        function validite($numerocarte,$longueur)
        { 
            // On passe à la fonction la variable contenant le numéro à vérifier
            // et la longueur qu'il doit impérativement avoir
        
            if ((strlen($numerocarte)==$longueur) && preg_match("#[0-9]{".$longueur."}#i", 
            $numerocarte))
            {
                echo ("C'est ok ici");
                // si la longueur est bonne et que l'on n'a que des chiffres
        
                /* on décompose le numéro dans un tableau  */
                for ($i=0;$i<$longueur;$i++){
                    $tableauChiffresNumero[$i]=substr($numerocarte,$i,1);
                }
        
                /* on parcours le tableau pour additionner les chiffres */
                $validite=0; // clef de luhn à tester
                for ($i=0;$i<$longueur;$i++)
                {
                    if ($i%2==0)
                    { // si le rang est pair (0,2,4 etc.)
                        if(($tableauChiffresNumero[$i]*2) > 9)
                        { 
                        // On regarde si son double est > à 9
                            $tableauChiffresNumero[$i]=($tableauChiffresNumero[$i]*2)-9;
                            //si oui on lui retire 9
                            // et on remplace la valeur
                            // par ce double corrigé
                        }
                        else
                        {
        
                            $tableauChiffresNumero[$i]=$tableauChiffresNumero[$i]*2; 
                            // si non on remplace la valeur
                            // par le double
                        }
                    }
                    $validite=$validite+$tableauChiffresNumero[$i]; 
                    // on additionne le chiffre à la clef de luhn
                }
        
                /* test de la divition par 10 */
                if($validite%10==0)
                {
                    return true;
                }
                else{
                    return false;
                }
            }
            else
            {
                return false;
                echo("Carte invalide");
                // la valeur fournie n'est pas conforme (caractère non numérique ou mauvaise
                // longueur)
            }
        }

        // appel à la fonction !!!
        //$ok = validite ($numerocarte,16);

        /*if ($ok == false)
        {
            $error = 35;
            echo ("Nombre de caractères invalide");
            ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=3"><?php
        } */
    
        //____________________________________

        //identifier le nom de base de données 
        $database = "ecebay"; 

        //connectez-vous dans votre BDD 
        //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 
        $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
        $db_found = mysqli_select_db($db_handle, $database);

        //si le BDD existe, faire le traitement 
        $creditCarte = 500;  // une nouvelle carte a 500 €
        
        if ($db_found && $error == 0) 
        { 
            $sql = "INSERT INTO paiement(numerocarte,dateexpiration,cvc,credit,nom,login) VALUES('$numerocarte','$datelimite','$codesecret','$creditCarte','$nom','$login') ";  
            $result = mysqli_query($db_handle, $sql); 
            if(!$result)
            {
                $error = 1;
                echo ("ERREUR $numerocarte - -$datelimite -- $codesecret -- 500 -- $nom -- $login");
                ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php 
            }
            else
            {
                if($totalPrix>=$creditCarte)  // c'est trop cher : la transaction est refusée !
                {
                    $error = 2;
                    echo ("Paiement refusé: solde insuffisant");
                    ?><meta http-equiv="refresh" content="1; url=paiement.php?alertCodeC=1"><?php
                }
                else  // paiement accepté: on est débité (MAJ de la table), supprimer l'item de la table item (et par voie de conséquence du panier)
                {
                    $error=0;
                    echo ("Paiement accepté"); 

                    $newCredit = 500-$totalPrix;
                    $sql = "UPDATE paiement SET credit = '$newCredit' WHERE numerocarte ='$numerocarte' ";  
                    $result = mysqli_query($db_handle, $sql);

                    if (!$result)
                    {
                        $error = 4;
                        echo ("Une erreur est survenue lors de la mise a jour du crédit");
                        ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
                    }
                    else
                    {
                        
                        
                        // supprimer l'item
                        // Récupérer les items du panier en acahat direct
                        $sql3="SELECT * FROM item,acheter_item WHERE loginAcheteur='$login'AND NumeroIDItem=item.NumeroID AND item.TypeVente='Achat direct' ";
                        $result3 = mysqli_query($db_handle, $sql3);
                        while ($data3 = mysqli_fetch_assoc($result3)) // défiler les items du panier qui sont des achats directs et les supprimer de la table item
                        {
                            $idItemSupp = $data3["NumeroIDItem"];
                            $prixItem = $data3["Prix"];
                            $typeVenteItem = $data3["TypeVente"];
                            $nomItem = $data3["Nom"];


                            //ajouter une transaction
                            $sql2 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,date,accepteeRefusee,nomProduit) VALUES ('$login','$idItemSupp','$prixItem','$typeVenteItem',NOW(),'1','$nomItem')";
                            $result2 = mysqli_query($db_handle, $sql2);
                    
                            if (!$result2)
                            {
                                echo ("erreur lors de l'ajout de la transaction");
                                $erreur = 51;
                                ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
                            }

                            // supprimer l'item
                            $sql = "DELETE FROM item WHERE NumeroID='$idItemSupp'";  
                            $result = mysqli_query($db_handle, $sql);
                            if (!$result)
                            {
                                $error = 50;
                                echo ("Une erreur à eu lieu lors du vidange du panier");
                                ?><meta http-equiv="refresh" content="9; url=paiement.php?alertCodeC=2"><?php
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

        if ($error == 0)
        {
            echo ("Aucune erreur, redirection en cours");
            ?><meta http-equiv="refresh" content="0; url=accueil.php?alertCode=15"><?php
        }
    }
    
    
        
    //fermer la connection 
	mysqli_close($db_handle);
?>
 