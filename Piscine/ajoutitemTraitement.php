<?php
echo"erreur0";
    $nomitem = isset($_POST["nomitem"])?$_POST["nomitem"] : "" ;  // if then else
    $Descriptionitem = isset($_POST["Descriptionitem"])?$_POST["Descriptionitem"] : "" ;
    $Categorieitem = isset($_POST["Categorieitem"])?$_POST["Categorieitem"] : " " ;
    $Prixitem = isset($_POST["Prixitem"])?$_POST["Prixitem"] : " " ;
    $typevente = isset($_POST["typevente"])?$_POST["typevente"] : " " ;
    $Photoitem = isset($_POST["Photoitem"])?$_POST["Photoitem"] : " " ;
    $Videoitem = isset($_POST["Videoitem"])?$_POST["Videoitem"] : " " ;
   
    $database = "ecebay"; 
    echo"erreur0";
    $error = "";

    if ($nomitem == "")
    {
        $error.= "Nom vide <br>";
    }
    if ($Descriptionitem == "")
    {
        $error.= "Description vide <br>";
    }
    if ($Categorieitem == "")
    {
        $error.= "Catégorie non renseignée  <br>";
    }
    if ($Prixitem == "")
    {
        $error.= "Prix non renseignée <br>";
    }
     if ($typevente == "")
    {
        $error.= "Prix non renseignée <br>";
    }
    if ($Photoitem == "")
    {
        $error.= "Photo non renseignée <br>";
    }
     if ($Videoitem == "")
    {
        $error.= "Video non renseignée <br>";
        echo"erreur1";
    }
echo"erreur2";
    if ($error == "")
    {
        echo ("formulaire valide");

        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database); 
        if ($db_found) { 

            $sql="INSERT INTO item(Nom,Categorie,Description,Prix,typevente,Image,Video)  VALUES('$nomitem' , '$Categorieitem' , '$Descriptionitem', '$Prixitem', '$typevente','$Photoitem')";
            
            
            if(!mysql_query($db_handle,$sql))
        {
            echo"not inserted";
        }
        else{
            echo"inserted";
        }
        header("refresh:4, url=Ajoutitem.php");
        }   //end if 
    }   
    else
    {
        echo ("Erreur : $error");

        $db_handle = mysqli_connect('localhost', 'root', 'root'); 
        $db_found = mysqli_select_db($db_handle, $database); 
        if ($db_found) { 

        $sql="INSERT INTO item(Nom,Categorie,Description,Prix,typevente,Image)  VALUES('$nomitem' , '$Categorieitem' , '$Descriptionitem', '$Prixitem', '$typevente','$Photoitem')";
        if(!mysql_query($db_handle,$sql))
        {
            echo"not inserted";
        }
        else{
            echo"inserted";
        }
        header("refresh:4, url=Ajoutitem.php");
    





