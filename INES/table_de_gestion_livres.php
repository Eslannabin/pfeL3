<?php
require 'a111.php';

// Fetch all livres from database
try {
    $stmt = $pdo->query("SELECT * FROM memoires ORDER BY date_ajout DESC");
    $livres = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching livres: " . $e->getMessage());
}
?>
<div class="main-content">
    <h1>Gestion des Livres</h1>
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
                                <?php if ($livre['status'] === 'en_attente'): ?>
                                    <form method="post" action="a11.php" style="display: inline;">
                                        <input type="hidden" name="livre_id" value="<?= $livre['id'] ?>">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="btn accept-btn">Accepter</button>
                                    </form>
                                    <form method="post" action="a11.php" style="display: inline;">
                                        <input type="hidden" name="livre_id" value="<?= $livre['id'] ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn reject-btn">Rejeter</button>
                                    </form>
                                <?php else: ?>
                                    <em>Traité</em>
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
