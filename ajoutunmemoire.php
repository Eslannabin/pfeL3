<?php
ob_start();
require 'PDFPreviewGenerator.php';
require 'classe.php';

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = null;
$success = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $obj = new Bibliotheque();
    
    try {
        $required = ['universite', 'filiere', 'specialite', 'diplome', 'titre', 'encadreur', 'auteur', 'annee'];
        foreach ($required as $field) {
            if (empty($_POST[$field])) {
                throw new Exception("Le champ $field est requis.");
            }
        }

        if (!isset($_FILES['fichier_pdf']) || $_FILES['fichier_pdf']['error'] !== UPLOAD_ERR_OK) {
            throw new Exception("Veuillez télécharger un fichier PDF valide.");
        }

        // Nettoyage des données
        $universite = htmlspecialchars(trim($_POST['universite']));
        $filiere = intval($_POST['filiere']);
        $specialite = intval($_POST['specialite']);
        $diplome = htmlspecialchars(trim($_POST['diplome']));
        $titre = htmlspecialchars(trim($_POST['titre']));
        $encadreur = htmlspecialchars(trim($_POST['encadreur']));
        $auteur = htmlspecialchars(trim($_POST['auteur']));
        $annee = intval($_POST['annee']);
        $resume = isset($_POST['resume']) ? htmlspecialchars(trim($_POST['resume'])) : '';

        // Traitement du fichier PDF
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            if (!mkdir($uploadDir, 0755, true)) {
                throw new Exception("Impossible de créer le dossier uploads.");
            }
        }

        $fileInfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $fileInfo->file($_FILES['fichier_pdf']['tmp_name']);

        if ($mime !== 'application/pdf') {
            throw new Exception("Seuls les fichiers PDF sont acceptés.");
        }

        $filename = uniqid('mem_', true) . '.pdf';
        $uploadFile = $uploadDir . $filename;

        if (move_uploaded_file($_FILES['fichier_pdf']['tmp_name'], $uploadFile)) {
            $previewDir = 'previews/';
            if (!is_dir($previewDir)) {
                mkdir($previewDir, 0755, true);
            }

            $previewFile = PDFPreviewGenerator::createPreview($uploadFile, $previewDir);

            $result = $obj->ajouterMemoire(
                $universite,
                $filiere,
                $specialite,
                $diplome,
                $titre,
                $encadreur,
                $auteur,
                $annee,
                $resume,
                $uploadFile,
                $previewFile
            );

            if ($result) {
                $obj->closeConnection();
                ob_end_clean();
                header('Location: pagedememoire.php');
                exit();
            } else {
                unlink($uploadFile);
                if ($previewFile && file_exists($previewFile)) {
                    unlink($previewFile);
                }
                throw new Exception("Erreur lors de l'ajout en base de données.");
            }
        } else {
            throw new Exception("Erreur lors de l'enregistrement du fichier.");
        }
    } catch (Exception $e) {
        $error = $e->getMessage();
        if (isset($obj)) {
            $obj->closeConnection();
        }
    }
}

// Récupérer toutes les filières pour le select
$biblio = new Bibliotheque();
try {
    $filieres = $biblio->getAllFilieres();
} catch (Exception $e) {
    $filieres = [];
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
    <title>Ajouter un Mémoire</title>
    <link rel="stylesheet" href="ajoutunmemoire.css">
</head>
<body>
    <?php include "header.html"; ?>

    <div class="ajout-memoire">
        <div class="form-container">
            <h2>Ajouter un Mémoire à la Bibliothèque</h2>
            <form action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST" enctype="multipart/form-data">
                <div class="form-grid">
                    <div class="form-group">
                        <label for="universite">Université :</label>
                        <input type="text" id="universite" name="universite" placeholder="Entrez l'université" required>
                    </div>
                    <div class="form-group">
                        <label for="filiere">Filière :</label>
                        <select id="filiere" name="filiere" required>
                            <option value="">-- Sélectionnez une filière --</option>
                            <?php foreach ($filieres as $filiere): ?>
                                <option value="<?= $filiere['id'] ?>"><?= htmlspecialchars($filiere['nom_filiere']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="specialite">Spécialité :</label>
                        <select id="specialite" name="specialite" required disabled>
                            <option value="">-- Sélectionnez d'abord une filière --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="diplome">Diplôme :</label>
                        <select id="diplome" name="diplome" required>
                            <option value="">Sélectionnez un diplôme</option>
                            <option value="licence">Licence</option>
                            <option value="master">Master</option>
                            <option value="doctorat">Doctorat</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="titre">Titre du mémoire :</label>
                        <input type="text" id="titre" name="titre" placeholder="Entrez le titre du mémoire" required>
                    </div>
                    <div class="form-group">
                        <label for="encadreur">Encadreur :</label>
                        <input type="text" id="encadreur" name="encadreur" placeholder="Nom de l'encadreur" required>
                    </div>
                    <div class="form-group">
                        <label for="auteur">Auteur du mémoire :</label>
                        <input type="text" id="auteur" name="auteur" placeholder="Nom de l'auteur" required>
                    </div>
                    <div class="form-group">
                        <label for="annee">Année d'écriture :</label>
                        <input type="number" id="annee" name="annee" min="1990" max="2099" placeholder="Ex: 2023" required>
                    </div>
                    <div class="form-group full-width">
                        <label for="resume">Résumé (optionnel) :</label>
                        <textarea id="resume" name="resume" rows="5" placeholder="Entrez un résumé du mémoire"></textarea>
                    </div>
                    <div class="form-group full-width">
                        <label for="fichier_pdf">Téléverser un fichier PDF :</label>
                        <div class="file-upload">
                            <label for="fichier_pdf" class="upload-label">
                                <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M7 10V9C7 6.23858 9.23858 4 12 4C14.7614 4 17 6.23858 17 9V10C19.2091 10 21 11.7909 21 14C21 15.4806 20.1956 16.8084 19 17.5M7 10C4.79086 10 3 11.7909 3 14C3 15.4806 3.8044 16.8084 5 17.5M7 10C7.43285 10 7.84965 10.0688 8.24006 10.1959M12 12V21M12 12L15 15M12 12L9 15" stroke="#000000" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"></path>
                                </svg>
                                <span>Téléverser un PDF</span>
                            </label>
                            <input id="fichier_pdf" type="file" name="fichier_pdf" accept=".pdf" required>
                            <p id="file-name">Aucun fichier sélectionné</p>
                        </div>
                    </div>
                    <div class="form-group full-width">
                        <button type="submit" class="button-submit">Ajouter le mémoire</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <?php if (isset($error)): ?>
        <div class="error-message" style="color: red; text-align: center; margin: 20px; padding: 10px; border: 1px solid red; background-color: #ffeeee;">
            <?php echo htmlspecialchars($error); ?>
        </div>
    <?php endif; ?>

    <?php include "footer.html"; ?>

    <script>
        // Gestion de l'affichage du nom du fichier
        document.getElementById('fichier_pdf').addEventListener('change', function(e) {
            const file = e.target.files[0];
            const fileNameElement = document.getElementById('file-name');

            if (file) {
                fileNameElement.textContent = file.name;
            } else {
                fileNameElement.textContent = "Aucun fichier sélectionné";
            }
        });

        // Gestion de la sélection dynamique des spécialités
        document.addEventListener('DOMContentLoaded', function() {
            const filiereSelect = document.getElementById('filiere');
            const specialiteSelect = document.getElementById('specialite');

            filiereSelect.addEventListener('change', function() {
                const filiereId = this.value;
                
                if (!filiereId) {
                    specialiteSelect.innerHTML = '<option value="">-- Sélectionnez d\'abord une filière --</option>';
                    specialiteSelect.disabled = true;
                    return;
                }

                // Requête AJAX pour récupérer les spécialités
                fetch('get_specialites.php?filiere_id=' + filiereId)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Erreur réseau');
                        }
                        return response.json();
                    })
                    .then(data => {
                        specialiteSelect.innerHTML = '<option value="">-- Sélectionnez une spécialité --</option>';
                        data.forEach(specialite => {
                            const option = document.createElement('option');
                            option.value = specialite.id;
                            option.textContent = specialite.nom_specialite;
                            specialiteSelect.appendChild(option);
                        });
                        specialiteSelect.disabled = false;
                    })
                    .catch(error => {
                        console.error('Erreur:', error);
                        specialiteSelect.innerHTML = '<option value="">Erreur de chargement</option>';
                    });
            });
        });
    </script>
</body>
</html>
