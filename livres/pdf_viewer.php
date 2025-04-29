<?php
require 'class.php'; // Inclure les dépendances nécessaires
session_start();


$id = $_GET['id'];
$obj = new Bibliotheque();

// 2. Récupérer les infos du livre
try {
    $livre = $obj->getlivreById($id);
    
    // 3. Vérifier le fichier PDF
    $pdf_path = 'uploads/pdfs/' . basename($livre['fichier_pdf']);
    
    if (!file_exists($pdf_path)) {
        die("Fichier PDF non trouvé");
    }

    // 4. Vérifier le type MIME
    $finfo = finfo_open(FILEINFO_MIME_TYPE);
    $mime = finfo_file($finfo, $pdf_path);
    finfo_close($finfo);
    
    if ($mime != 'application/pdf') {
        die("Type de fichier invalide");
    }

} catch (Exception $e) {
    die("Erreur : " . $e->getMessage());
}
?>


<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Visionneuse: <?= htmlspecialchars($livre['titre']) ?></title>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <link rel="stylesheet" href="memoire.css">
    
    <!-- Lecteur PDF Modal -->
    <div id="pdf-modal" class="modal">
        <div class="modal-content">
            <span id="pdf-close" class="close">&times;</span>
            <div id="pdf-viewer-container">
                <div id="loading-indicator">
                    <div class="spinner"></div>
                    <p>Chargement du PDF...</p>
                </div>
                <div id="pdf-controls">
                    <button id="prev-page"><i class="fas fa-chevron-left"></i></button>
                    <input type="number" id="page-input" min="1" value="1">
                    <span id="page-count">/ 0</span>
                    <button id="next-page"><i class="fas fa-chevron-right"></i></button>
                    <button id="zoom-out"><i class="fas fa-search-minus"></i></button>
                    <span id="zoom-percent">100%</span>
                    <button id="zoom-in"><i class="fas fa-search-plus"></i></button>
                </div>
                <div id="pdf-pages-container"></div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.min.js"></script>
    <script>
        // Configuration PDF.js
        pdfjsLib.GlobalWorkerOptions.workerSrc = 'https://cdnjs.cloudflare.com/ajax/libs/pdf.js/2.11.338/pdf.worker.min.js';
        
        // Gestion du lecteur PDF
        <?php if ($pdf_valid): ?>
        document.querySelector('.action-btn.read').addEventListener('click', function(e) {
            e.preventDefault();
            window.open(this.href, '_blank');
        });
        <?php endif; ?>
        
        // Vérification de session pour le téléchargement
        document.querySelector('.action-btn[download]')?.addEventListener('click', function(e) {
            fetch('check_session.php')
                .then(response => response.json())
                .then(data => {
                    if (!data.logged_in) {
                        e.preventDefault();
                        if (confirm('Vous devez être connecté pour télécharger ce livre. Voulez-vous vous connecter maintenant ?')) {
                            window.location.href = 'login.php?redirect=' + encodeURIComponent(window.location.href);
                        }
                    }
                });
        });
        
        
        
        
        
        
    </script>
    
</body>
</html>