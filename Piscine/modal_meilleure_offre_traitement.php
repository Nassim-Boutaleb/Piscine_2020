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
        
    

    $idItem = $_POST["idItem"];
    $nbOffres = $_POST["nbOffres"];
    $idOffre = $_POST["idOffre"];
    $login = $_SESSION["login"];
    $montantOffreinput = isset($_POST["montantOffreinput"])?$_POST["montantOffreinput"]:"undefined";
        
    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 

    $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
    $db_found = mysqli_select_db($db_handle, $database); 
    if ($db_found) 
    { 
        $sqlA = "SELECT * FROM meilleure_offre WHERE idItemOffre ='$idItem'  ";  

        $resultA = mysqli_query($db_handle, $sqlA);
        if($resultA){
            $dataA = mysqli_fetch_assoc($resultA); 
        

            if ($dataA["nbOffres"]==0) // Si aucune offre n'a encore été faite
            
            {
            
                $newnegotiation = true; // Pour les affichages
            

            }
             else // Si une offre a déja été faite 
            {
                $newnegotiation = false;
                echo"$newnegotiation";
    
            }

            $lastnegotiation = $dataA["PrixVendeur"];
            $consensus=$dataA["Consensus"];
        
        if($newnegotiation == true)
        {
            $sql0="INSERT INTO acheter_item(loginAcheteur,NumeroIDItem) VALUES ('$login','$idItem')";
            $result0= mysqli_query($db_handle, $sql0);
            if ($result0)
            {
                echo"INSERTION ACHETER ITEM OK";
            }
            else
            {
                echo"ERREUR ACHETER ITEM --";
                echo"$login";
                echo"$idItem";
            }


            $sql="INSERT INTO acheteur_offre(login,prixAcheteur,IdOffre) VALUES ('$login','$montantOffreinput','$idOffre')";
            $result = mysqli_query($db_handle, $sql);
            if($result)
            {
               
                //on défini le nombre d'offre actuel
                $newnboffre=$nbOffres+1;
                
                echo"nvx nombre offre $newnboffre";
                $sql1="UPDATE meilleure_offre SET nbOffres= '$newnboffre' WHERE IdOffre='$idOffre'";
                
                $result1=mysqli_query($db_handle, $sql1);
                if ($result1) 
                {
                    $sql2="UPDATE item SET afficher= '0' WHERE NumeroID='$idItem'";
                    $result2=mysqli_query($db_handle, $sql2);
                    if($result2)
                    {
                        $sql3="INSERT INTO acheter_item(loginAcheteur,NumeroIDItem) VALUES ('$login','$idItem')";
                        echo"Update item ok";
                        ?>
                            <meta http-equiv="refresh" content="1; url=Panier.php"> 
                        <?php
                    }
                    else
                    {
                        echo"ERREUR Update item ";
                    }
                }
            }

        }

        else if($newnegotiation == false)
        {
            echo"new negociation -- ";
            if($nbOffres<5)
            {
                echo"nb offres= $nbOffres  -- ";
                $sql="UPDATE acheteur_offre SET prixAcheteur='$montantOffreinput' WHERE IdOffre='$idOffre'";
                $result = mysqli_query($db_handle, $sql);

                if($result)
                { 
                    echo"UPDATING1 OK -- ";
                    
                    //on défini le nombre d'offre actuel
                    $newnboffre=$nbOffres+1;
                    echo"nvx nombre offre $newnboffre";
                    $sql1="UPDATE meilleure_offre SET nbOffres= '$newnboffre' WHERE IdOffre='$idOffre'";
                
                    $result1=mysqli_query($db_handle, $sql1);
                    if ($result1) 
                    {
                        echo"UPDATING2 OK -- ";
                        ?>
                            <meta http-equiv="refresh" content="1; url=Panier.php"> 
                        <?php

                    }
                
                }

            }
            else
            {
               echo"Nombre maximal de négotiation atteint, l'article sera remis dans le catalogue";
                $sql4="DELETE FROM acheter_item WHERE NumeroIDItem='$idItem'";
                $result4 = mysqli_query($db_handle, $sql4);
                
                if($result4)
                {

                    echo "Article supprimé";
                    $sql5="UPDATE item SET afficher='1' WHERE NumeroID='$idItem'";
                    $result5=mysqli_query($db_handle, $sql5);

                    if($result5)
                    { 
                        echo"result5";
                        $sql6="SELECT * FROM meilleure_offre WHERE IdItemOffre='$idItem' ";
                        $result6=mysqli_query($db_handle, $sql6);

                        if($data6=mysqli_fetch_assoc($result6))
                        {   echo"result6";
                            $idOffre=$data6["IdOffre"];
                            $sql7="DELETE FROM acheteur_offre WHERE IdOffre='$idOffre'";
                            $result7=mysqli_query($db_handle, $sql7);

                            if($result7)
                           {   echo"result7";
                                $sql8="SELECT Prix FROM item WHERE NumeroID='$idItem'";
                                $result8=mysqli_query($db_handle,$sql8);
                                $data=mysqli_fetch_assoc($result8);
                                $PrixV=$data["Prix"];
                                echo"$PrixV";
                                $newnboffre=0;
                                $sql9="UPDATE meilleure_offre SET nbOffres ='$newnboffre',PrixVendeur='$PrixV' WHERE IdItemOffre ='$idItem'";

                            
                                $result9=mysqli_query($db_handle,$sql9);

                                if($result9)
                                {   echo"result9";
                                    ?>
                                    <meta http-equiv="refresh" content="1; url=Panier.php"> 
                                    <?php
                                }
                            }
                        }
                    }
                }
            }
        }
    }
}
    else{
        echo "Erreur chargement de la base";
    }





    
/*

    if ($db_found) 
    { 
        // On récupéère les données du formulaire:
        $montantoffre = isset($_POST["montantoffre"])?$_POST["montantoffre"]:"undefined";

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

        //Récupérer l'ID de l'enchère sur laquelle on travaille, en se servant de l'ID item
        $sql = "SELECT IdEnchere FROM enchere WHERE IdItem='$idItem'";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);
        
        $IdEnchere = $data["IdEnchere"];
        //echo ("IDI ".$idItem);
        
        // On va d'abord vérifier si c'est la 1ere fois que l'acheteur fait une enchère sur ce produit
        // On l'ajoute dans la table acheteur_enchere

        // 1ere etape: regarder dans la table acheteur_enchere si l'acheteur a déjà fait une enchère sur l'article ou pas
        // et si non mettre a jour la table 
        $sql = "SELECT * FROM acheteur_enchere WHERE IdEnchere='$IdEnchere' AND loginAcheteur='$login' ";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        if (!isset ($data))  // il faut l'ajouter
        {
            //echo ("$login , $IdEnchere , $enchereAuto , $enchereMax");
            $maPremiereOffre = true;
            $sql = "INSERT INTO acheteur_enchere (loginAcheteur,IdEnchere,EnchereAuto,EnchereMax) VALUES ('$login','$IdEnchere','$enchereAuto','$enchereMax') ";  
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
            $sql = "UPDATE acheteur_enchere SET EnchereAuto='$enchereAuto', EnchereMax = '$enchereMax' WHERE IdEnchere = '$IdEnchere'";  
            $result = mysqli_query($db_handle, $sql);

            if (!$result)
            {
                $erreur = 2;
                echo ("Erreur lors de la mise a jour dans acheteur_enchere");
            }
        }

        // Ensuite il faut regarder l'offre faite et vérifier qu'elle soit
        // superieure à l'ancienne offre (sauf si aucune offre n'a étét faite)

        // On regarde s'il s'agit d'une nouvelle enchere (1ere offre)
        $sql = "SELECT meilleureOffre FROM enchere WHERE IdEnchere ='$IdEnchere'  ";  
        $result = mysqli_query($db_handle, $sql);
        $data = mysqli_fetch_assoc($result);

        // on est le 1er à enchérir : pas de comparaison à faire car il n'y a aucune autre offre: on se content de MAJ la table encheres
        if (!isset($data["meilleureOffre"]))
        {
            //echo("New ench");
            $sql2 = "UPDATE enchere SET meilleureOffre='$montantEnchere' , loginMeilleureOffre = '$login' WHERE IdEnchere='$IdEnchere' ";  
            $result2 = mysqli_query($db_handle, $sql2);

            if (!$result2)
            {
                $erreur = 3;
                echo ("Erreur mise a jour de enchere pour 1ere offre");
            }
        } 
        else // on n'est pas le 1er : on regarde l'enchère faite et si elle est valide (> à la meilleure offre)
        {
            if ($montantEnchere != "undefined") // si le champ a été rempli (car on peut ne faire que des enchères auto)
            {
                
                if ($montantEnchere < $data["meilleureOffre"]) // enchère trop basse
                {
                    $erreur = 6;
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

        // C'est terminé, on redirige vers là d'où on vient si aucune erreur
        if ($erreur == 0)
        {
            ?>
                <script> alert("HUEGLLO"), </script>
                <meta http-equiv="refresh" content="0; url=<?php echo($urlRed); ?>">
            <?php
        }

        /*while ($data = mysqli_fetch_assoc($result)) 
        {
             
        } */

/*    }
    else
    {
        echo("Database not found");
    }

    //fermer la connection 
	mysqli_close($db_handle); */

?>
