<?php
require 'a111.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize and validate input
    $universite = filter_input(INPUT_POST, 'universite', FILTER_SANITIZE_STRING);
    $filiere = filter_input(INPUT_POST, 'filiere', FILTER_SANITIZE_STRING);
    $specialite = filter_input(INPUT_POST, 'specialite', FILTER_SANITIZE_STRING);
    $diplome = filter_input(INPUT_POST, 'diplome', FILTER_SANITIZE_STRING);
    $titre = filter_input(INPUT_POST, 'titre', FILTER_SANITIZE_STRING);
    $encadreur = filter_input(INPUT_POST, 'encadreur', FILTER_SANITIZE_STRING);
    $auteur = filter_input(INPUT_POST, 'auteur', FILTER_SANITIZE_STRING);
    $annee = filter_input(INPUT_POST, 'annee', FILTER_VALIDATE_INT);
    $resume = filter_input(INPUT_POST, 'resume', FILTER_SANITIZE_STRING);
    
    // Handle file upload
    $pdfPath = '';
    if (isset($_FILES['fichier_pdf']) && $_FILES['fichier_pdf']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = 'uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }
        
        $fileName = basename($_FILES['fichier_pdf']['name']);
        $targetPath = $uploadDir . uniqid() . '_' . $fileName;
        
        if (move_uploaded_file($_FILES['fichier_pdf']['tmp_name'], $targetPath)) {
            $pdfPath = $targetPath;
        }
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO memoires 
                              (universite, filiere, specialite, diplome, titre, 
                               encadreur, auteur, annee, resume, fichier_pdf) 
                              VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([
            $universite, $filiere, $specialite, $diplome, $titre,
            $encadreur, $auteur, $annee, $resume, $pdfPath
        ]);
        
        header('Location: Gestion_memoires_admin.php');
        exit();
    } catch (PDOException $e) {
        die("Error adding memory: " . $e->getMessage());
    }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ajouter un Mémoire</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ddd;
            border-radius: 5px;
        }
        h1 {
            color: #333;
            text-align: center;
        }
        .form-group {
            margin-bottom: 15px;
        }
        label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        input[type="text"],
        input[type="number"],
        input[type="file"],
        select, textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }
        textarea {
            height: 100px;
        }
        button {
            background-color: #4CAF50;
            color: white;
            padding: 10px 15px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        button:hover {
            background-color: #45a049;
        }
        .back-link {
            display: block;
            margin-top: 20px;
            text-align: center;
            color: #0066cc;
            text-decoration: none;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Ajouter un Nouveau Mémoire</h1>
        <form method="post" enctype="multipart/form-data">
            <div class="form-group">
                <label for="universite">Université:</label>
                <input type="text" id="universite" name="universite" required>
            </div>
            
            <div class="form-group">
                <label for="filiere">Filière:</label>
                <input type="text" id="filiere" name="filiere" required>
            </div>
            
            <div class="form-group">
                <label for="specialite">Spécialité:</label>
                <input type="text" id="specialite" name="specialite" required>
            </div>
            
            <div class="form-group">
                <label for="diplome">Diplôme:</label>
                <select id="diplome" name="diplome" required>
                    <option value="">-- Sélectionner --</option>
                    <option value="doctorat">Doctorat</option>
                    <option value="master">Master</option>
                    <option value="licence">Licence</option>
                </select>
            </div>
            
            <div class="form-group">
                <label for="titre">Titre du Mémoire:</label>
                <input type="text" id="titre" name="titre" required>
            </div>
            
            <div class="form-group">
                <label for="encadreur">Encadreur:</label>
                <input type="text" id="encadreur" name="encadreur" required>
            </div>
            
            <div class="form-group">
                <label for="auteur">Auteur:</label>
                <input type="text" id="auteur" name="auteur" required>
            </div>
            
            <div class="form-group">
                <label for="annee">Année:</label>
                <input type="number" id="annee" name="annee" min="1900" max="<?= date('Y') ?>" required>
            </div>
            
            <div class="form-group">
                <label for="resume">Résumé:</label>
                <textarea id="resume" name="resume" required></textarea>
            </div>
            
            <div class="form-group">
                <label for="fichier_pdf">Fichier PDF:</label>
                <input type="file" id="fichier_pdf" name="fichier_pdf" accept=".pdf" required>
            </div>
            
            <button type="submit">Enregistrer le Mémoire</button>
        </form>
        
        <a href="Gestion_memoires.php" class="back-link">Retour à la liste des mémoires</a>
    </div>
</body>
</html>