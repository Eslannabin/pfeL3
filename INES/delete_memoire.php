<?php
require 'a111.php'; // Your database connection file

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['action']) && $_POST['action'] === 'delete' && isset($_POST['livre_id'])) {
        $livre_id = $_POST['livre_id'];
        
        try {
            // First, you might want to get the file path to delete the PDF file as well
            $stmt = $pdo->prepare("SELECT fichier_pdf FROM memoires WHERE id = ?");
            $stmt->execute([$livre_id]);
            $livre = $stmt->fetch(PDO::FETCH_ASSOC);
            
            // Delete the database DELrecord
            $stmt = $pdo->prepare("ETE FROM memoires WHERE id = ?");
            $stmt->execute([$livre_id]);
            
            // If you want to delete the PDF file as well
            if ($livre && !empty($livre['fichier_pdf']) && file_exists($livre['fichier_pdf'])) {
                unlink($livre['fichier_pdf']);
            }
            
            // Redirect back with success message
            header("Location: liste_de_memoire.php?success=1");
            exit();
        } catch (PDOException $e) {
            // Redirect back with error message
            header("Location: liste_de_memoire.php?error=1");
            exit();
        }
    }
}

// If not a POST request or invalid parameters, redirect back
header("Location: liste_de_memoire.php");
exit();