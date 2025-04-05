<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The index of the admin page</title>
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <link rel="stylesheet" href="sidebar2.css">
</head>

<body>
    <div class="wrapper">
        <aside id="sidebar">
            <!-- LOGO -->
            <div class="d-flex">
                <button class="toggle-btn" type="button">
                    <i class="lni lni-grid-alt"></i>
                </button>
                <div class="sidebar-logo">
                    <a href="#">CodzSword</a>
                </div>
            </div>
            <!-- PROFILE DE L'ADMIN -->
            <ul class="sidebar-nav">
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <!-- AJOUTER -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth-ajouter" aria-expanded="false" aria-controls="auth-ajouter">
                        <i class="lni lni-plus"></i>
                        <span>Ajouter</span>
                    </a>
                    <ul id="auth-ajouter" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Utilisateur/Moderateur</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Memoire</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Categories</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Filiere</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth-supprimer" aria-expanded="false" aria-controls="auth-supprimer">
                        <i class="lni lni-minus"></i>
                        <span>Supprimer</span>
                    </a>
                    <ul id="auth-supprimer" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Utilisateur/Moderateur</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Memoire</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Categories</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Filiere</a>
                        </li>
                    </ul>
                </li>

                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#multi" aria-expanded="false" aria-controls="multi">
                        <i class="lni lni-layout"></i>
                        <span>Tables</span>
                    </a>
                    <ul id="multi" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <!-- TABLES DE UTILISATEURS -->
                            <a href="#" class="sidebar-link">
                                Utilisateurs
                            </a>
                        </li>
                        <li>
                            <!-- TABLES DE MODERATEURS -->
                            <a href="#" class="sidebar-link" >
                                Moderateurs
                            </a>
                        </li>
                        <li>
                            <!--TABLES DE MOIMOIRES ET LIVRES -->
                            <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                            data-bs-target="#contenu" aria-expanded="false" aria-controls="contenu">
                                Contenu
                            </a>
                            <ul id="contenu" class="sidebar-dropdown list-unstyled collapse">

                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Memoires</a>
                                </li>
                                <li class="sidebar-item">
                                    <a href="#" class="sidebar-link">Livres</a>
                                </li>
                            </ul>
                        </li>
                    </ul>

                </li>
                <!-- NOTIFICATION/ MESSAGES -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-popup"></i>
                        <span>Notification</span>
                    </a>
                </li>
                <!-- PARAMETRES ?? -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-cog"></i>
                        <span>Parametres</span>
                    </a>
                </li>
            </ul>
            <!-- LOGOUT -->
            <div class="sidebar-footer">
                <a href="#" class="sidebar-link">
                    <i class="lni lni-exit"></i>
                    <span>Logout</span>
                </a>
            </div>
        </aside>
        <div class="main p-3">   
            <div class="text-center">
                <h1>
                    ADMIN FASHBORD
                </h1>
            </div>
            <?php include "Admin_front.php"?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="sidebar2.js"></script>
</body>

</html>
