<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/jquery.dataTables.min.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar2.css">
    <link rel="stylesheet" href="css/table_de_gestion.css">
    <link rel="stylesheet" href="css/gestion_des_memoires.css">
    <title>Gestion des Memoires</title>
</head>

<body>
<header>
        <?php include 'html/headeR.html' ?>
    </header>
    <div class="wrapper">
        <?php
        include 'html/Admin_sidebar.html';
        include 'table_de_gestion_memoires.php';
        ?>
    </div>
    <!-- Load all JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"> </script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
</body>

</html>