<!-- Ce script est intégré par require dans modal_encheres_meilleure_offre.php et n'est pas indéêndant ! -->
<?php
    
    //Booléen
    $errorPaiement = 0;

    //On a créé une nouvelle carte ou on a utilisé une carte existante ?
    if ($_POST["useCarte"] != "nouvCarte" )  // carte existante
    {
        $numeroCarte = $_POST["useCarte"];
        //echo ("on utilise la carte".$_POST["useCarte"]);

        

    
        
        
        if ($db_found) 
        { 
            $sql = "SELECT * FROM paiement WHERE numerocarte = '$numeroCarte' AND login = '$login' ";  
            $result = mysqli_query($db_handle, $sql); 
            $data = mysqli_fetch_assoc($result);

            // On récupère la valeur du crédit dans la carte
            $creditCarte = $data["credit"];
            if(isset ($_POST["enchereAutoCheckbox"])) // on a activé les encheres automatiques
            {
                if($enchereMax>=$creditCarte)  // c'est trop cher : la transaction est refusée !
                {
                    $errorPaiement = 2;
                    echo ("Enchère refusée: solde insuffisant");
                    ?><meta http-equiv="refresh" content="1; url=<?php echo($urlRed); ?>?alertCode=80"><?php
                }
                else  // l'enchere est possible
                {
                    $errorPaiement=0;
                    //echo ("Enchere possible"); 
                } 
            }
            else // on regarde le montant non auto proposé
            {
                
                if($montantEnchere>=$creditCarte)  // c'est trop cher : la transaction est refusée !
                {
                    $errorPaiement = 2;
                    echo ("Enchère refusée: solde insuffisant");
                    ?><meta http-equiv="refresh" content="1; url=<?php echo($urlRed); ?>?alertCode=80"><?php
                }
                else  // l'enchere est possible
                {
                    $errorPaiement=0;
                    //echo ("Enchere possible"); 
                } 
            }
                  
        }
        else
        {
            echo ("Database not found");
        }
    }
    else 
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
        $longueur=16;
        function validite($numerocarte,$longueur)
        { 
            // On passe à la fonction la variable contenant le numéro à vérifier
            // et la longueur qu'il doit impérativement avoir
        
            if ((strlen($numerocarte)==$longueur) && preg_match("#[0-9]{".$longueur."}#i", 
            $numerocarte))
            {
                //echo ("C'est ok ici");
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
            $errorPaiement = 35;
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
        
        if ($db_found && $errorPaiement == 0) 
        { 
            $sql = "INSERT INTO paiement(numerocarte,dateexpiration,cvc,credit,nom,login) VALUES('$numerocarte','$datelimite','$codesecret','$creditCarte','$nom','$login') ";  
            $result = mysqli_query($db_handle, $sql); 
            if(!$result)
            {
                $errorPaiement = 1;
                echo ("ERREUR $numerocarte - -$datelimite -- $codesecret -- 500 -- $nom -- $login");
                ?><meta http-equiv="refresh" content="9; url=<?php echo($urlRed); ?>?alertCode=82"><?php 
            }
            else
            {
                if(isset ($_POST["enchereAutoCheckbox"])) // on a activé les encheres automatiques
                {
                    if($enchereMax>=$creditCarte)  // c'est trop cher : la transaction est refusée !
                    {
                        $errorPaiement = 2;
                        echo ("Enchère refusée: solde insuffisant");
                        ?><meta http-equiv="refresh" content="1; url=<?php echo($urlRed); ?>?alertCode=80"><?php
                    }
                    else  // l'enchere est possible
                    {
                        $errorPaiement=0;
                        //echo ("Enchere possible"); 
                    } 
                }
                else // on regarde le montant non auto proposé
                {
                    
                    if($montantEnchere>=$creditCarte)  // c'est trop cher : la transaction est refusée !
                    {
                        $errorPaiement = 2;
                        echo ("Enchère refusée: solde insuffisant");
                        ?><meta http-equiv="refresh" content="1; url=<?php echo($urlRed); ?>?alertCode=80"><?php
                    }
                    else  // l'enchere est possible
                    {
                        $errorPaiement=0;
                        //echo ("Enchere possible"); 
                    } 
                }
            }
        }
        else
        {
            echo ("Database not found");
        }

        if ($errorPaiement == 0)
        {
            //echo ("Aucune erreur");
            
        }
    }
    
?>
 