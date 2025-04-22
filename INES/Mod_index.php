<!doctype html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Moderateur Index</title>

  <!-- Load all CSS -->
  <link href="https://cdn.lineicons.com/4.0/lineicons.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
    include 'html/Mod_sidebar.html';
    include 'html/Mod_dashbord.php';
    // if (isset($Mod_index)) include "Mod_index.php"; (Just a test
    ?>
  </div>
  <!-- Load all JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
  <script src="js/sidebar.js"> </script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>