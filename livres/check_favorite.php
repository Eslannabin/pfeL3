<?php
require 'classe.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false]);
    exit();
}

$user_id = $_SESSION['user_id'];
$memoire_id = $_GET['memoire_id'];

try {
    $biblio = new Bibliotheque();
    $isFavorite = $biblio->checkIfFavorite($user_id, $memoire_id);
    
    echo json_encode([
        'success' => true,
        'isFavorite' => $isFavorite
    ]);
} catch (Exception $e) {
    echo json_encode(['success' => false]);
}