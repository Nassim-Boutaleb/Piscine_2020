<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
    <form action="traitements.php" method="post">
        <table>
            <tr>
                <td>Nom:</td>
                <td><input type="text" name="nom"></td>
            </tr>
            <tr>
                <td> Age:</td>
                <td> <input type="text" name="age"></td>
            </tr>
            <tr>
                <td>Téléphone:</td>
                <td><input type="text" name="telephone"></td>
            </tr>
            <tr>
                <td>Date de naissance:</td>
                <td><input type="text" name="naissance"></td>
            </tr>
            <tr>
                <td colspan="2">
                    <input type="submit" value="valider">
                </td>
            </tr>
        </table>
    </form>
    
    <div id="error"></div>
</body>
</html>