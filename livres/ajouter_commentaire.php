<?php
require 'classe.php';
session_start();

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'Non connecté']);
    exit();
}

$data = json_decode(file_get_contents('php://input'), true);
$memoire_id = $data['memoire_id'] ?? null;
$comment = $data['comment'] ?? null;

if (!$memoire_id || !$comment) {
    echo json_encode(['success' => false, 'message' => 'Données manquantes']);
    exit();
}

try {
    $obj = new Bibliotheque();
    $result = $obj->ajouterCommentaire(
        $memoire_id,
        $_SESSION['user_id'],
        $_SESSION['username'],
        $comment
    );
    
    echo json_encode(['success' => $result, 'message' => 'Commentaire ajouté']);
} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}