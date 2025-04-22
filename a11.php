<?php
require 'a111.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $memoryId = filter_input(INPUT_POST, 'memory_id', FILTER_VALIDATE_INT);
    $action = filter_input(INPUT_POST, 'action', FILTER_SANITIZE_STRING);

    if ($memoryId && in_array($action, ['accept', 'reject'])) {
        try {
            $status = $action === 'accept' ? 'accepter' : 'refuser';
            
            $stmt = $pdo->prepare("UPDATE memoires 
                                  SET status = :status, date_edition = CURRENT_TIMESTAMP 
                                  WHERE id = :id");
            $stmt->execute([':status' => $status, ':id' => $memoryId]);
            
            header('Location: Gestion_memoires.php');
            exit();
        } catch (PDOException $e) {
            die("Error processing request: " . $e->getMessage());
        }
    }
}

header('Location: Gestion_memoires.php');
?>