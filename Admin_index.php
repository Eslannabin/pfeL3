<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Administrateur Index</title>

    <!-- Load all CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/sidebar2.css">
    <link rel="stylesheet" href="css/Mod_dahsbord.css">
    <link rel="stylesheet" href="css/Mod_index.css">
</head>

<body>
    <header>
        <?php include 'html/headeR.html' ?>
    </header>
    <div class="wrapper">

        <?php
        include 'html/Admin_sidebar.html';
        include 'html/Admin_dashbord.php';
        // if (isset($Mod_index)) include "Mod_index.php"; (Just a test
        ?>
    </div>
    <!-- Load all JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"> </script>
</body>

</html>