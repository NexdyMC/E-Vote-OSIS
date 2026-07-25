<?php
require_once __DIR__ . "/config/conn.php";

header('Content-Type: application/json');
$inputData = json_decode(file_get_contents('php://input'), true);
$id_kardidat = $inputData['id_kardidat'] ?? null;
$button = $inputData['button'] ?? false;
session_start();
$token = $_SESSION['token'];

// 3. Validate and process the vote
if ($button && !empty($id_kardidat)) {

    $stmt = $conn->voting_kardidat($token, $id_kardidat);

    if ($stmt) {
        echo json_encode([
            'status' => 'success',
            'message' => 'Vote successfully recorded.'
        ]);
        session_destroy();
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid request or missing candidate ID.'
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request or missing candidate ID.'
    ]);
}