<?php
include "conn.php";
session_start();
header('Content-Type: application/json');
$inputData = json_decode(file_get_contents('php://input'), true);
$token = $_SESSION['token'] ?? 0;

switch ($inputData['type'] ?? '')
{
  case 'select':
    $stmt = $conn->select_siswa();
    
    if ($stmt) {
      echo json_encode([
        'status' => 'success',
        'data' => $stmt
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'data' => 'Invalid request.'
      ]);

    }
    break;
  case 'voting':
    $id_kardidat = $inputData['id_kardidat'];
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
    break;

  default:
    echo json_encode([
        'status' => 'error',
        'message' => 'Unknown type'
    ]);
}