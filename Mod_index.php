<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>L'index des Moderateurs</title>
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
            
            <ul class="sidebar-nav">
                <!-- PROFILE DE L'ADMIN -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                        <i class="lni lni-user"></i>
                        <span>Profile</span>
                    </a>
                </li>
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link">
                    <i class="lni lni-pencil-alt"></i>
                        <span>Gestion des memoires</span>
                    </a>
                </li>
                <!-- TOUS LES LIVRES ET MEMOIRES ACCEPTES -->
                <li class="sidebar-item">
                    <a href="#" class="sidebar-link collapsed has-dropdown" data-bs-toggle="collapse"
                        data-bs-target="#auth-ajouter" aria-expanded="false" aria-controls="auth-ajouter">
                        <i class="lni lni-library"></i>
                        <span>Galerie</span>
                    </a>
                    <ul id="auth-ajouter" class="sidebar-dropdown list-unstyled collapse" data-bs-parent="#sidebar">
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Memoires</a>
                        </li>
                        <li class="sidebar-item">
                            <a href="#" class="sidebar-link">Livres</a>
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
                    MODERATEURS FASHBORD
                </h1>
            </div>
            <?php include "Mod_front.php"?>
        </div> 
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe"
        crossorigin="anonymous"></script>
    <script src="sidebar2.js"></script>
</body>

</html>
