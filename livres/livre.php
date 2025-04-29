<?php
require 'class.php';
session_start();

// Vérification de l'ID du livre
if (!isset($_GET['id']) || empty($_GET['id'])) {
    header("Location: liv.php");
    exit();
}

$id = $_GET['id'];
$obj = new Bibliotheque();

try {
    // Récupération des informations du livre
    $livre = $obj->getLivreById($id);
    
    if (!$livre) {
        header('Location: liv.php');
        exit();
    }
    
    // Traitement du fichier PDF
    $pdf_path = 'uploads/pdfs/' . basename($livre['fichier_pdf']);
    $file_size = 'N/A';
    $pdf_valid = false;
    
    if (file_exists($pdf_path)) {
        $file_size = round(filesize($pdf_path) / (1024 * 1024), 2) . ' Mo';
        
        // Vérification du type MIME
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $pdf_path);
        finfo_close($finfo);
        
        $pdf_valid = ($mime == 'application/pdf');
    }
    
    // Récupération des commentaires
    $commentaires = $obj->getCommentairesByLivreId($id);



} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
} 
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($livre['titre']) ?> - Bibliothèque Numérique</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link rel="stylesheet" href="memoire.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf_viewer.min.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no">
</head>
<body>
    <?php include 'header.html'; ?>
    <!-- ... code PHP inchangé ... -->

    <main class="container">
    <div class="book-container">
        <div class="book-header">
            <div class="book-cover-container">
<
            <?php if (!empty($livre['image'])): ?>
                <img src="uploads/covers/<?= htmlspecialchars($livre['image']) ?>" alt="Couverture du livre">
            <?php else: ?>
                <div class="book-cover no-cover">
                        <i class="fas fa-book-open" style="font-size: 60px;"></i>
                    </div>
            <?php endif; ?>
        </div>
        
        <div class="book-meta">
                <div style="display: flex; justify-content: flex-end; margin-bottom: 10px;">
                    <a href="#" class="btn-circle btn-like" id="btn-like">
                        <i class="fas fa-heart"></i>
                        <span class="btn-tooltip">J'aime</span>
                    </a>
                </div>
        
        <!-- Informations du livre à droite -->
        <h1 class="book-title"><?= htmlspecialchars($livre['titre']) ?></h1>
        <div class="meta-list">
                    <div class="meta-item"><span class="meta-label">Auteur:</span><span class="meta-value"><?= htmlspecialchars($livre['auteur']) ?></span></div>
                    
                    <div class="meta-item"><span class="meta-label">Catégorie:</span><span class="meta-value"><?= htmlspecialchars($livre['categorie_nom']) ?></span></div>
                    <div class="meta-item"><span class="meta-label">Année:</span><span class="meta-value"><?= htmlspecialchars($livre['annee_publication']) ?></span></div>
                    <div class="meta-item"><span class="meta-label">Pages:</span><span class="meta-value"><?= htmlspecialchars($livre['nombre_pages']) ?></span></div>
                    <div class="meta-item"><span class="meta-label">Taille du fichier:</span><span class="meta-value"><?= $file_size ?></span></div>
                    <div class="meta-item"><span class="meta-label">Format:</span><span class="meta-value">PDF</span></div>
                </div>
            </div>
        </div>
        
    <!-- Description -->
    
    <div class="book-content">
            <h2 class="section-title">Résumé</h2>
            <div class="book-description">
                <?= nl2br(htmlspecialchars($livre['description'])) ?>
            </div>

            <div class="action-buttons">
                <a href="" class="btn-circle btn-read" id="btn-reader">
                    <i class="fas fa-book-open"></i>
                    <span class="btn-tooltip">Lire</span>
                </a>
                <a href="uploads/pdfs/<?= htmlspecialchars($livre['fichier_pdf']) ?>" class="btn-circle btn-download" download>
                    <i class="fas fa-download"></i>
                    <span class="btn-tooltip">Télécharger</span>
                </a>
            </div>
        </div>
 </div>
</div>
    <!-- Section Commentaires -->
<div class="comment-section">
    <h2 class="section-title">Commentaires</h2>
    
    <!-- Formulaire d'ajout de commentaire -->
    <div class="comment-form">
        <form id="comment-form" method="POST">
            <textarea name="comment" id="comment-text" placeholder="Ajouter un commentaire..." required></textarea>
            <button type="submit" class="btn-submit">Publier</button>
        </form>
    </div>
    </div>
    <!-- Liste des commentaires -->
    <div class="comment-list" id="comment-list">
        <?php
        $commentaires = $obj->getCommentaires($id);
        if (empty($commentaires)) {
            echo '<p class="no-comments">Aucun commentaire pour le moment.</p>';
        } else {
            foreach ($commentaires as $commentaire) {
                echo '<div class="comment-item">';
                echo '<div class="comment-header">';
                echo '<span class="comment-author">'.htmlspecialchars($commentaire['nom_utilisateur']).'</span>';
                echo '<span class="comment-date">'.date('d/m/Y H:i', strtotime($commentaire['date_creation'])).'</span>';
                echo '</div>';
                echo '<div class="comment-content">'.nl2br(htmlspecialchars($commentaire['contenu'])).'</div>';
                echo '</div>';
            }
        }
        ?>
    </div>
</div>

</main>
    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
       
        
        // Gestion des favoris
        document.getElementById('btn-like')?.addEventListener('click', function(e) {
            e.preventDefault();
            fetch('check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        toggleFavorite(<?= $id ?>);
                    } else {
                        if (confirm('Vous devez être connecté pour ajouter ce livre à vos favoris. Voulez-vous vous connecter maintenant ?')) {
                            window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                        }
                    }
                });
        });
        
        // Gestion des commentaires
        document.getElementById('comment-form')?.addEventListener('submit', function(e) {
            e.preventDefault();
            const commentText = document.getElementById('comment-text').value;
            
            fetch('check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        submitComment(<?= $id ?>, commentText);
                    } else {
                        if (confirm('Vous devez être connecté pour commenter. Voulez-vous vous connecter maintenant ?')) {
                            window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                        }
                    }
                });
        });
        
        // Fonctions utilitaires
        function toggleFavorite(bookId) {
            fetch('toggle_favorite.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ livre_id: bookId })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    updateFavoriteIcon(data.isFavorite);
                    showTooltip(data.message);
                }
            });
        }
        
        function updateFavoriteIcon(isFavorite) {
            const icon = document.querySelector('#btn-like i');
            icon.classList.toggle('far', !isFavorite);
            icon.classList.toggle('fas', isFavorite);
            document.getElementById('btn-like').style.color = isFavorite ? '#e74c3c' : '';
        }
        
        function submitComment(bookId, comment) {
            fetch('ajouter_commentaire.php', {
                method: 'POST',
                headers: { 'Content-Type': 'application/json' },
                body: JSON.stringify({ memoire_id: bookId, comment: comment })
            })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    location.reload();
                } else {
                    alert(data.message);
                }
            });
        }
        
        function showTooltip(message) {
            const tooltip = document.querySelector('.btn-tooltip');
            tooltip.textContent = message;
            tooltip.style.opacity = '1';
            setTimeout(() => tooltip.style.opacity = '0', 2000);
        }
        
        // Vérification initiale de l'état du favori
        function checkFavoriteStatus() {
            fetch('check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (data.logged_in) {
                        fetch('check_favorite.php?livre_id=<?= $id ?>')
                            .then(response => response.json())
                            .then(data => {
                                if (data.success) {
                                    updateFavoriteIcon(data.isFavorite);
                                }
                            });
                    }
                });
        }
        
        // Initialisation
        document.addEventListener('DOMContentLoaded', function() {
            checkFavoriteStatus();
        });
    </script>
    
    <script src="darkMode.js"></script>
    <?php include 'footer.html'; ?>
</body>
</html>