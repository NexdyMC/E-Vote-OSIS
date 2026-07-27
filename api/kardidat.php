<?php
include "conn.php";

header('Content-Type: application/json');
$inputData = json_decode(file_get_contents('php://input'), true);

switch ($inputData['type'] ?? '') 
{
  case 'select':
    $stmt = $conn->select_kardidat();
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
  default:
    echo json_encode([
      'status' => 'error',
      'message' => 'data tersebut tidak dapat diakses Unknown type'
    ]);

}