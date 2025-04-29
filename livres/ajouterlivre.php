<?php
ob_start();
session_start();
require 'class.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = null;
$success = false;



if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obj = new Bibliotheque();

    try {
        $required = ['titre', 'auteur', 'categorie', 'annee_publication', 'nombre_pages'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis.");
            }
        }

        // Nettoyage des données
        $titre = htmlspecialchars(trim($_POST['titre']));
        $auteur = htmlspecialchars(trim($_POST['auteur']));
        $categorie = intval($_POST['categorie']);
        $annee_publication = intval($_POST['annee_publication']);
        $nombre_pages = intval($_POST['nombre_pages']);
        $description = isset($_POST['description']) ? htmlspecialchars(trim($_POST['description'])) : '';
        $id_utilisateur = $_SESSION['user_id'];

        // Traitement du fichier PDF
        $pdf_path = null;
        if (isset($_FILES['fichier_pdf']) && $_FILES['fichier_pdf']['error'] === UPLOAD_ERR_OK) {
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $fileInfo->file($_FILES['fichier_pdf']['tmp_name']);

            if ($mime !== 'application/pdf') {
                throw new Exception("Seuls les fichiers PDF sont acceptés.");
            }

            $uploadDir = 'uploads/pdfs/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = uniqid('book_', true) . '.pdf';
            $pdf_path = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['fichier_pdf']['tmp_name'], $pdf_path)) {
                throw new Exception("Erreur lors de l'enregistrement du fichier PDF.");
            }
        }

        // Traitement de l'image de couverture
        $image_path = null;
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $allowed_types = ['image/jpeg', 'image/png', 'image/gif'];
            $fileInfo = new finfo(FILEINFO_MIME_TYPE);
            $mime = $fileInfo->file($_FILES['image']['tmp_name']);

            if (!in_array($mime, $allowed_types)) {
                throw new Exception("Seuls les fichiers JPG, PNG et GIF sont acceptés pour l'image.");
            }

            $uploadDir = 'uploads/covers/';
            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $filename = uniqid('cover_', true) . '.' . pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $image_path = $uploadDir . $filename;

            if (!move_uploaded_file($_FILES['image']['tmp_name'], $image_path)) {
                throw new Exception("Erreur lors de l'enregistrement de l'image.");
            }
        }

        $result = $obj->ajouterLivre(
            $titre,
            $auteur,
            $categorie,
            $annee_publication,
            $nombre_pages,
            $description,
            $pdf_path,
            $image_path,
            $id_utilisateur
        );

        if ($result) {
            $obj->closeConnection();
            ob_end_clean();
            header('Location: liv.php');
            exit();
        } else {
            if ($pdf_path && file_exists($pdf_path)) {
                unlink($pdf_path);
            }
            if ($image_path && file_exists($image_path)) {
                unlink($image_path);
            }
            throw new Exception("Erreur lors de l'ajout en base de données.");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        if (isset($obj)) {
            $obj->closeConnection();
        }
    }
}

// Récupérer toutes les catégories pour le select
$biblio = new Bibliotheque();
try {
    $categories = $biblio->getAllCategories();
} catch (Exception $e) {
    $categories = [];
    $error = $error ?: $e->getMessage();
}
$biblio->closeConnection();

ob_end_flush();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Livre</title>
    <link rel="stylesheet" href="ajoutunmemoire.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
    <?php include "header.html"; ?>

    <div class="ajout-livre">
        <div class="form-container">
            <h2>Ajouter un Livre à la Bibliothèque</h2>

            <?php if (isset($error)): ?>
            <div class="error-message">
                <?php echo htmlspecialchars($error); ?>
            </div>
            <?php endif; ?>

            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="titre">Titre du livre :</label>
                        <input type="text" id="titre" name="titre" placeholder="Entrez le titre du livre" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="auteur">Auteur :</label>
                        <input type="text" id="auteur" name="auteur" placeholder="Nom de l'auteur" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="categorie">Catégorie :</label>
                        <select id="categorie" name="categorie" required>
                            <option value="">-- Sélectionnez une catégorie --</option>
                            <?php foreach ($categories as $categorie): ?>
                            <option value="<?= $categorie['id'] ?>"><?= htmlspecialchars($categorie['nom']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label for="annee_publication">Année de publication :</label>
                        <input type="number" id="annee_publication" name="annee_publication" min="1900" max="<?= date('Y') ?>" placeholder="Ex: 2023" required>
                    </div>
                    
                    <div class="form-group">
                        <label for="nombre_pages">Nombre de pages :</label>
                        <input type="number" id="nombre_pages" name="nombre_pages" min="1" placeholder="Ex: 250" required>
                    </div>
                    
                    <div class="form-group full-width">
                        <label for="description">Description :</label>
                        <textarea id="description" name="description" rows="5" placeholder="Entrez une description du livre"></textarea>
                    </div>
                    
                    <div class="form-group">
                        <label for="fichier_pdf">Fichier PDF (optionnel) :</label>
                        <div class="file-upload">
                            <label for="fichier_pdf" class="upload-label">
                                <i class="fas fa-file-pdf"></i>
                                <span>Téléverser un PDF</span>
                            </label>
                            <input id="fichier_pdf" type="file" name="fichier_pdf" accept=".pdf">
                            <p id="pdf-file-name">Aucun fichier sélectionné</p>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="image">Image de couverture (optionnel) :</label>
                        <div class="file-upload">
                            <label for="image" class="upload-label">
                                <i class="fas fa-image"></i>
                                <span>Téléverser une image</span>
                            </label>
                            <input id="image" type="file" name="image" accept="image/*">
                            <p id="image-file-name">Aucun fichier sélectionné</p>
                        </div>
                    </div>
                    
                    <div class="form-group full-width">
                        <button type="submit" class="button-submit">Ajouter le livre</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php include "footer.html"; ?>

    <script>
    document.getElementById('fichier_pdf').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameElement = document.getElementById('pdf-file-name');

        if (file) {
            fileNameElement.textContent = file.name;
        } else {
            fileNameElement.textContent = "Aucun fichier sélectionné";
        }
    });

    document.getElementById('image').addEventListener('change', function(e) {
        const file = e.target.files[0];
        const fileNameElement = document.getElementById('image-file-name');

        if (file) {
            fileNameElement.textContent = file.name;
        } else {
            fileNameElement.textContent = "Aucun fichier sélectionné";
        }
    });
    </script>
    <script src="darkMode.js"></script>
</body>
</html>