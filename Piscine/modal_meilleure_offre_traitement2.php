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
        echo"OK0";
        $sql0="UPDATE meilleure_offre SET Consensus='4' WHERE IdOffre='$idOffre'";
        $result0=mysqli_query($db_handle,$sql0);
        if($result0)
        {
            echo"OK1";
            $sql1="SELECT * FROM item WHERE NumeroID='$idItem'";
            $result1=mysqli_query($db_handle,$sql1);
            $data1=mysqli_fetch_assoc($result1);
            if($result1)
            {
                
                $nomProduit=$data1["Nom"];
                 echo"OK2";
                $sql2="SELECT * FROM meilleure_offre WHERE IdItemOffre='$idItem'";
                $result2=mysqli_query($db_handle,$sql2);
                $data2=mysqli_fetch_assoc($result2);

                if($result2){
                    echo"OK3";
                    $PrixV=$data2["PrixVendeur"];

                    $sql3 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,idMeilleureOffre,date,accepteeRefusee,nomProduit) VALUES ('$login','$idItem','$PrixV','Meilleure Offre','$idOffre',NOW(),'1','$nomProduit')";

                    $result3=mysqli_query($db_handle,$sql3);

                    if($result3)
                    {
                        echo"OK4";
                        $sql4="DELETE FROM item WHERE NumeroID='$idItem'";
                        $result4=mysqli_query($db_handle,$sql4);
                        if($result4)
                        {
                            $sql4="DELETE FROM acheteur_offre WHERE IdItemOffre='$idItem";
                        echo"OK5";
                        ?>
                        <meta http-equiv="refresh" content="1; url=Panier.php"> 
                        <?php
                        }
                    }
                }
            }
        }
    }