<?php
require 'a111.php';

// Fetch all memories from database
try {
    $stmt = $pdo->query("SELECT * FROM memoires ORDER BY date_ajout DESC");
    $memories = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Error fetching memories: " . $e->getMessage());
}
?>
<div class="main-content">
    <h1>Gestion des Mémoires de Thèse</h1>
    <?php if (empty($memories)): ?>
        <p>Aucun mémoire trouvé dans le système.</p>
    <?php else: ?>
        <div class="table-container">
            <h1 style="color: darkblue;">Filtre de recherche</h1>
            <table>
                <thead>
                    <tr>
                        <th>Université</th>
                        <th>Filière</th>
                        <th>Spécialité</th>
                        <th>Diplôme</th>
                        <th>Titre</th>
                        <th>Auteur</th>
                        <th>Année</th>
                        <th>Résumé</th>
                        <th>Memoire</th>
                        <th>Statut</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($memories as $memory): ?>
                        <tr>
                            <td><?= htmlspecialchars($memory['universite']) ?></td>
                            <td><?= htmlspecialchars($memory['filiere']) ?></td>
                            <td><?= htmlspecialchars($memory['specialite']) ?></td>
                            <td><?= htmlspecialchars($memory['diplome']) ?></td>
                            <td><?= htmlspecialchars($memory['titre']) ?></td>
                            <td><?= htmlspecialchars($memory['auteur']) ?></td>
                            <td><?= htmlspecialchars($memory['annee']) ?></td>
                            <td class="resume" title="<?= htmlspecialchars($memory['resume']) ?>">
                                <?= htmlspecialchars($memory['resume']) ?>
                            </td>
                            <td>
                                <?php if (!empty($memory['fichier_pdf'])): ?>
                                    <a href="<?= htmlspecialchars($memory['fichier_pdf']) ?>" class="pdf-link" target="_blank">Voir pdf</a>
                                <?php else: ?>
                                    N/A
                                <?php endif; ?>
                            </td>
                            <td class="status-<?= str_replace('-', '', $memory['status']) ?>">
                                <?= htmlspecialchars($memory['status']) ?>
                            </td>
                            <td class="action-buttons">
                                <?php if ($memory['status'] === 'en_attente'): ?>
                                    <form method="post" action="a11.php" style="display: inline;">
                                        <input type="hidden" name="memory_id" value="<?= $memory['id'] ?>">
                                        <input type="hidden" name="action" value="accept">
                                        <button type="submit" class="btn accept-btn">Accepter</button>
                                    </form>
                                    <form method="post" action="a11.php" style="display: inline;">
                                        <input type="hidden" name="memory_id" value="<?= $memory['id'] ?>">
                                        <input type="hidden" name="action" value="reject">
                                        <button type="submit" class="btn reject-btn">Refuser</button>
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

    <a href="a1111.php" class="add-memory">Ajouter un Mémoire</a>

</div>