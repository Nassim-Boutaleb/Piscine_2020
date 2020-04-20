<?php
    session_start();  // Lancer une session 

    // Des erreurs ?
    $erreur = 0;

    
    
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

        $sql2 = "SELECT * FROM meilleure_offre WHERE idItemOffre ='$idItem'  ";  
        $result2 = mysqli_query($db_handle, $sql2);
        if($result2)
        {
            echo"ok1";
            $data2 = mysqli_fetch_assoc($result2); 
            $consensus=$data2["Consensus"];
            $idOffre=$data2["IdOffre"];
            $nbOffres=$data2["nbOffres"];
            $nbTentatives=$nbOffres+1;
            $sqlPA="SELECT * FROM acheteur_offre WHERE IdOffre='$idOffre'";
            $resultPA=mysqli_query($db_handle,$sqlPA);
            if($resultPA)
            {
                echo"ok2";
                $dataPA=mysqli_fetch_assoc($resultPA);
                $lastnegociation = $dataPA["prixAcheteur"];
            }
        }
        if($consensus==1)
        { 

            $sql="UPDATE meilleure_offre SET PrixVendeur='$montantOffreinput' WHERE IdOffre='$idOffre'";
                $result = mysqli_query($db_handle, $sql);

                if($result)
                { 
                    echo"UPDATING1 OK -- ";
                    
                    //on défini le nombre d'offre actuel
                    $newnboffre=$nbOffres+1;
                    echo"nvx nombre offre $newnboffre";
                        $sql10="UPDATE meilleure_offre SET Consensus='0' WHERE IdOffre='$idOffre'";
                        $result10=mysqli_query($db_handle, $sql10);
                        if($result10)
                        {
                            ?>
                                <meta http-equiv="refresh" content="1; url=Gestionitem.php"> 
                            <?php
                        }

                    
                
                }
        }else
        {

        }


    }