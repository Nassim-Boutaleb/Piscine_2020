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
        $sql0="UPDATE meilleure_offre SET Consensus='2' WHERE IdOffre='$idOffre'";
        $result0=mysqli_query($db_handle,$sql0);
        if($result0)
        {
            echo"OK1";
            $sql1="SELECT * FROM item WHERE NumeroID='$idItem'";
            $result1=mysqli_query($db_handle,$sql1);
            $data1=mysqli_fetch_assoc($result1);
            if($result1)
            {
                echo"OK2";
                $PrixV=$data1["Prix"];
                $nomProduit=$data1["Nom"];

                $sql2 = "INSERT INTO transactions_effectuees (login,idItem,prix,typeVente,idMeilleureOffre,date,accepteeRefusee,nomProduit) VALUES ('$login','$idItem','$PrixV','Meilleure Offre','$idOffre',NOW(),'1','$nomProduit')";

                $result2=mysqli_query($db_handle,$sql2);

                if($result2)
                {
                    echo"OK3";
                    $sql3="DELETE FROM item WHERE NumeroID='$idItem'";
                    $result3=mysqli_query($db_handle,$sql3);
                    if($result3)
                    {
                    echo"OK4";
                    }
                }

            }
        }
    }