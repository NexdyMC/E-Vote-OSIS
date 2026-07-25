<?php
header('Content-Type: application/json');

// 1. Read the raw POST data sent from JavaScript fetch()
$inputData = json_decode(file_get_contents('php://input'), true);

// 2. Extract the data sent from the frontend
$id_kardidat = $inputData['id_kardidat'] ?? null;
$button = $inputData['button'] ?? false;

// 3. Validate and process the vote
if ($button && !empty($id_kardidat)) {
    // TODO: Add your database connection and update/insert query here
    // Example: 
    // $stmt = $pdo->prepare("UPDATE candidates SET votes = votes + 1 WHERE id = ?");
    // $stmt->execute([$id_kardidat]);

    // Send back a success response
    echo json_encode([
        'status' => 'success',
        'message' => 'Vote successfully recorded.'
    ]);
} else {
    // Send back an error response if data is missing
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request or missing candidate ID.'
    ]);
}