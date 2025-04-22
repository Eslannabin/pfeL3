<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Listes des Memoires</title>

    <!-- Load all CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/sidebar2.css">
  <link rel="stylesheet" href="css/liste_de_memoire.css">

</head>

<body>
<header>
        <?php include 'html/headeR.html' ?>
    </header>
    <div class="wrapper">
        <?php
        include 'html/Admin_sidebar.html';
        ?>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="display-6 text-center">Liste de Memoires</h2>
                </div>
                <!-- AJOUTER UN FILTRE DE RECHERCHE -->
                <div class="card-body">
                    <H1 style="color:darkblue;"> FILTRE DE RECHERCHE</H1>
                    <table class="class=table table-striped">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>Id</th>
                                <th>Nom d'Utilisateur</th>
                                <th>Date</th>
                                <th>Memoire</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            for ($i = 0; $i <= 10; $i++) {
                                echo "<tr>";
                                echo "<td>-php-</td>";
                                echo "<td>-php-</td>";
                                echo "<td>-php-</td>";
                                echo "<td>-php-</td>";
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"> </script>
</body>

</html>