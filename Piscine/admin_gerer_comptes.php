<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Gerer les comptes</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="admin_gerer_comptes.css"> 
    <script src="https://code.jquery.com/jquery-3.3.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.bundle.min.js"></script>
</head>

<body>
    <!-- Navbar -->
    <?php require("Navbars/navbar_def.php");  ?>


    <div class="container-fluid">
        <div class="card border-secondary text-center">
            <div class="card-header">
                <ul class="nav nav-tabs card-header-tabs" id="myTab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active tab" id="vendeursTab" data-toggle="tab" href="#vendeursAff" role="tab"
                            aria-controls="home" aria-selected="true" style="color:black;">Vendeurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab" id="acheteursTab" data-toggle="tab" href="#acheteursAff" role="tab"
                            aria-controls="profile" aria-selected="false" style="color:black;">Acheteurs</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link tab" id="adminsTab" data-toggle="tab" href="#adminsAff" role="tab"
                            aria-controls="contact" aria-selected="false" style="color:black;">Admins</a>
                    </li>
                </ul>
            </div>
            <div class="card-body">
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="vendeursAff" role="tabpanel"aria-labelledby="vendeursTab">
                    <table class="table">
                            <thead class="thead-light">
                                <tr>
                                    <th scope="col">Email</th>
                                    <th scope="col">Mot de passe</th>
                                    <th scope="col">Nom</th>
                                    <th scope="col">Prénom</th>
                                    <th scope="col">Adresse</th>
                                    <th scope="col">Ville</th>
                                    <th scope="col">Code postal</th>
                                    <th scope="col">Pays</th>
                                    <th scope="col">Téléphone</th>
                                    <th scope="col">Modifier</th>
                                    <th scope="col">Prénom</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <th scope="row">1</th>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td>@mdo</td>
                                    <td>Mark</td>
                                    <td>Otto</td>
                                    <td><a href="#"><button type="button" class="btn btn-secondary btn-sm">Modifier</button></a></td>
                                    <td><a href="#"><button type="button" class="btn btn-danger btn-sm">Supprimer</button></a></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div class="tab-pane fade" id="acheteursAff" role="tabpanel" aria-labelledby="acheteursTab">
                        B
                    </div>

                    <div class="tab-pane fade" id="adminsAff" role="tabpanel" aria-labelledby="adminsTab">
                        C
                    </div>
                </div>
                <a href="#" class="btn btn-primary">Go somewhere</a>
            </div>
            <div class="card-footer text-muted">
                2 days ago
            </div>
        </div>
    </div>
</body>

</html>