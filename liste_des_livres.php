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

    <div class="wrapper">
        <?php
        include 'html/Admin_sidebar.html';

        require 'a111.php';

        // Fetch all livres from database
        try {
            $stmt = $pdo->query("SELECT * FROM memoires WHERE status != 'en_attente' ORDER BY date_ajout DESC");
            $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            die("Error fetching livres: " . $e->getMessage());
        }
        ?>
        <div class="main-content">
            <h1>Galerie de Livres</h1>
            <?php if (empty($livres)): ?>
                <p>Aucun livre trouvé dans le système.</p>
            <?php else: ?>
                <div class="table-container">
                    <h1 style="color: darkblue;">Filtre de recherche</h1>
                    <table>
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Titre</th>
                                <th>Auteur</th>
                                <th>Année</th>
                                <th>Résumé</th>
                                <th>Livre</th>
                                <th>Date Ajout</th>
                                <th>Date Édition</th>
                                <th>Statut</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($livres as $livre): ?>
                                <tr>
                                    <td><?= htmlspecialchars($livre['id']) ?></td>
                                    <td><?= htmlspecialchars($livre['titre']) ?></td>
                                    <td><?= htmlspecialchars($livre['auteur']) ?></td>
                                    <td><?= htmlspecialchars($livre['annee']) ?></td>
                                    <td class="resume" title="<?= htmlspecialchars($livre['resume']) ?>">
                                        <?= htmlspecialchars($livre['resume']) ?>
                                    </td>
                                    <td>
                                        <?php if (!empty($livre['fichier_pdf'])): ?>
                                            <a href="<?= htmlspecialchars($livre['fichier_pdf']) ?>" class="pdf-link" target="_blank">Voir le livre</a>
                                        <?php else: ?>
                                            N/A
                                        <?php endif; ?>
                                    </td>
                                    <td><?= htmlspecialchars($livre['date_ajout']) ?></td>
                                    <td><?= $livre['date_edition'] ? htmlspecialchars($livre['date_edition']) : 'N/A' ?></td>
                                    <td class="status-<?= str_replace('-', '', $livre['status']) ?>">
                                        <?= htmlspecialchars($livre['status']) ?>
                                    </td>
                                    <td class="action-buttons">
                                        <?php if ($livre['status'] === 'accepter' || 'refuser'): ?>
                                            <form method="post" action="delete_memoire.php" style="display: inline;">
                                                <input type="hidden" name="livre_id" value="<?= $livre['id'] ?>">
                                                <input type="hidden" name="action" value="supprimer">
                                                <button type="submit" class="btn accept-btn">Supprimer</button>
                                            </form>
                                        
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>

            <a href="a1111.php" class="add-livre">Ajouter un livre</a>

        </div>



        <!-- <div class="col-sm-12">
            <div class="card">
                <div class="card-header">
                    <h2 class="display-6 text-center">Liste de Livres</h2>
                </div>
                AJOUTER UN FILTRE DE RECHERCHE 
                <div class="card-body">
                    <H1 style="color:darkblue;"> FILTRE DE RECHERCHE</H1>
                    <table class="class=table table-striped">
                        <thead>
                            <tr class="bg-dark text-white">
                                <th>Id</th>
                                <th>Nom d'Utilisateur</th>
                                <th>Date</th>
                                <th>Livres</th>
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
        </div> -->
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js"></script>
    <script src="js/sidebar.js"> </script>
</body>

</html>