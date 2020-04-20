<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>

<form enctype="multipart/form-data" action="" method="post">
    <div class="form-group">
        <!-- MAX_FILE_SIZE doit précéder le champ input de type file -->
        <input type="hidden" name="MAX_FILE_SIZE" value="300000" />
        <label for="Photoitem">Photo de l'article</label>
        <input type="file" class="form-control-file" name="Photoitem" accept=".jpg, .jpeg, .png">
        <button type="submit" class="btn btn-primary" name='submit'>Soumettre</button>
    </div>
</form>

<?php
    if(isset($_POST['submit']))  
    {
        echo ("Allo");
        $uploaddir = 'Images/Ventes/';
        $uploadfile = $uploaddir . basename($_FILES['Photoitem']['name']);

        echo '<pre>';
        if (move_uploaded_file($_FILES['Photoitem']['tmp_name'], $uploadfile)) {
            echo "Le fichier est valide, et a été téléchargé
                avec succès. Voici plus d'informations :\n";
        } else {
            echo "Attaque potentielle par téléchargement de fichiers.
                Voici plus d'informations :\n";
        }

        echo 'Voici quelques informations de débogage :';
        print_r($_FILES);

        echo '</pre>'; 

        echo("Chemin du fichier: ".$uploadfile);
    }

?>
    <img src="<?php echo($uploadfile); ?>">

</body>
</html>
