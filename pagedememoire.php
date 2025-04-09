        <?php
 require 'PDFPreviewGenerator.php';
 require 'generate_cover.php';

// Initialisation
require 'classe.php';
$obj = new bibliotaque();
$obj->connect();
$memoires = $obj->getAllMemoires();
$previewDir = __DIR__.'/previews';
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bibliothèque Numérique - Mémoires</title>
    <link rel="stylesheet" href="pagedememoire.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>
        :root {
            --primary: #3498db;
            --secondary: #2ecc71;
            --dark: #2c3e50;
            --light: #f8f9fa;
        }
        
        .memoires-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
            gap: 25px;
            padding: 20px;
        }
        
        .memoire-card {
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
            transition: transform 0.3s;
            background: white;
        }
        
        .memoire-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }
        
        .memoire-image {
            height: 300px;
            background:rgb(175, 219, 241);
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .memoire-image img {
            max-width: 100%;
            max-height: 100%;
            object-fit: contain;
        }
        
        .default-preview {
            text-align: center;
            padding: 20px;
            color: #5f6368;
        }
        
        .memoire-content {
            padding: 15px;
        }
    </style>
</head>
<body>
    <?php include 'header.html'; ?>

    <div class="container">
        <h1>Bibliothèque de Mémoires</h1>
        
        <div class="search-filter">
            <input type="text" id="search-input" placeholder="Rechercher...">
            <select id="filter-diplome">
                <option value="">Tous les diplômes</option>
                <option value="master">Master</option>
                <option value="doctorat">Doctorat</option>
                <option value="licence">Licence</option>
            </select>
        </div>
    <div class="memoires-container">
        <?php foreach ($memoires as $memoire): 
            $previewFile = !empty($memoire['image_path']) ? $memoire['image_path'] : 
                          PDFPreviewGenerator::createPreview($memoire['fichier_pdf'], $previewDir);
        ?>
        <div class="memoire-card">
            <div class="memoire-image">
                <?php if ($previewFile): ?>
                    <img src="<?= htmlspecialchars($previewFile) ?>" 
                         alt="Aperçu: <?= htmlspecialchars($memoire['titre']) ?>"
                         loading="lazy">
                <?php else: ?>
                    <div class="default-preview">
                        <i class="fas fa-file-pdf fa-4x" style="color:#e74c3c;"></i>
                        <p>Aperçu non disponible</p>
                    </div>
                <?php endif; ?>
            </div>
            <div class="memoire-content">
                <h3><?= htmlspecialchars($memoire['titre']) ?></h3>
                <p><i class="fas fa-user"></i> <?= htmlspecialchars($memoire['auteur']) ?></p>
                <p><i class="fas fa-calendar-alt"></i> <?= htmlspecialchars($memoire['annee']) ?></p>
                <a href="<?= htmlspecialchars($memoire['fichier_pdf']) ?>" class="btn-download" download>
                    <i class="fas fa-download"></i> Télécharger
                </a>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
    <?php include 'footer.html'; ?>
    <script src="pagedememoire.js"></script>
</body>
</html>
<?php $obj->closeConnection(); ?>