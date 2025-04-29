<?php
session_start();
header('Content-Type: application/json');

$response = [
    'logged_in' => isset($_SESSION['user_id'])
];

echo json_encode($response);
?>