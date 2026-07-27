<?php

include "conn.php";

header('Content-Type: application/json');

$inputData = json_decode(file_get_contents('php://input'), true);
session_start();
$token = $_SESSION['token'];

switch($inputData['type'] ?? '')
{
    case 'select':

        $data = $conn->select_siswa();

        echo json_encode([
            'status' => 'success',
            'data' => $data
        ]);

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