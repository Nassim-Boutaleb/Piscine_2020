<?php
    session_start();  // Lancer une session 

    // Des erreurs ?
    $erreur = 0;

    
    
    // Connexion à la BDD
    //identifier le nom de base de données 
    $database = "ecebay"; 
        
    

    $idItem = $_POST["idItem"];
    $idOffre = $_POST["idOffre"];
    $nbOffre = $_POST["nbOffres"];
    $login = $_SESSION["login"];
    $montantOffreinput = isset($_POST["montantOffreinput"])?$_POST["montantOffreinput"]:"undefined";
        
    //connectez-vous dans votre BDD 
    //Rappel : votre serveur = localhost | votre login = root | votre mot de pass = '' (rien) 

    $db_handle = mysqli_connect('localhost', 'root', 'root' ); 
    $db_found = mysqli_select_db($db_handle, $database); 
    if ($db_found) 
    { 
        //echo"OK0";
        $sql0="UPDATE meilleure_offre SET Consensus='4' WHERE IdOffre='$idOffre'";
        $result0=mysqli_query($db_handle,$sql0);
        if($result0)
        {
            //echo"OK1";
            $sql1="SELECT * FROM item WHERE NumeroID='$idItem'";
            $result1=mysqli_query($db_handle,$sql1);
            $data1=mysqli_fetch_assoc($result1);
            if($result1)
            {
                
                $nomProduit=$data1["Nom"];
                 //echo"OK2";
                $sql2="SELECT * FROM acheteur_offre WHERE IdOffre='$idOffre'";
                $result2=mysqli_query($db_handle,$sql2);
                $data2=mysqli_fetch_assoc($result2);


                if($result2){
                    //echo"OK3";
                    $PrixV=$data2["prixAcheteur"];
                    $loginA=$data2["login"];

                    $sql3 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,idMeilleureOffre,date,accepteeRefusee,nomProduit) VALUES ('$loginA','$idItem','$PrixV','Meilleure Offre','$idOffre',NOW(),'1','$nomProduit')";

                    $result3=mysqli_query($db_handle,$sql3);

                    if($result3)
                    {
                        // Débiter la carte qui a été enregistrée au début de l'enchère
                        $sql145 = "SELECT carte FROM acheteur_offre WHERE IdOffre = '$idOffre' ";
                        $result145 = mysqli_query($db_handle, $sql145);
                        $data145 = mysqli_fetch_assoc($result145);
                        $numeroCarte = $data145["carte"];

                        $sql146 = "SELECT * FROM paiement WHERE numerocarte = '$numeroCarte' AND login = '$loginA' ";  
                        $result146 = mysqli_query($db_handle, $sql146); 
                        $data146 = mysqli_fetch_assoc($result146);
                        $creditCarte = $data146["credit"];
                        $newCredit = $creditCarte-$PrixV; 

                        $sql147 = "UPDATE paiement SET credit = '$newCredit' WHERE numerocarte ='$numeroCarte' ";  
                        $result147 = mysqli_query($db_handle, $sql147);
                    

                        if (!$result147)
                        {
                            $error = 4;
                            echo ("Une erreur est survenue lors de la mise a jour du crédit");
                            ?><meta http-equiv="refresh" content="9; url=accueil.php?alertCodeC=2"><?php
                        }
                        
                        
                        
                        echo"OK4";
                        $sql4="DELETE FROM item WHERE NumeroID='$idItem'";
                        $result4=mysqli_query($db_handle,$sql4);
                        if($result4)
                        {
                            $sql5="DELETE FROM acheteur_offre WHERE IdOffre='$idOffre'";
                            $sql6="DELETE FROM meilleure_offre WHERE IdOffre='$idOffre'";
                        //echo"OK5";
                        ?>
                        <meta http-equiv="refresh" content="1; url=Gestionitem.php"> 
                        <?php
                        }
                    }
                }
            }
        }
    }