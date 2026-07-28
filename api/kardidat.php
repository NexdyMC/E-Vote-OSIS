<?php
include "conn.php";
header('Content-Type: multipart/form-data');
$inputData = json_decode(file_get_contents('php://input'), true);

switch ($inputData['type'] ?? '')
{
  // api mode : get
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

  // api mode : push
  case 'add':
    $nama = $inputData['nama'] ?? '';
    $visi = $inputData['visi'] ?? '';
    $misi = $inputData['misi'] ?? '';
    $image = $inputData['image'] ?? '';
    $rand = random_id(10);

    $stmt  = $conn->add_kandidat($nama, $visi, $misi, $image);
    $upload = $conn->upload_image('../upload/photo/', $rand ,'photo');
  

    if ($stmt and $upload) {
      echo json_encode([
        'status' => 'success',
        'message' => 'data berhasil dikirim'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'data gagal dikirim'
      ]);
    }
  // api mode : delete
  case 'delete':
    $id = $inputData['id'] ?? null;
    $file = $conn->select_kardidat("id = $id","image");
    
    foreach ($file as $row) {
      echo $row['image'];
      $status  = unlink("../upload/photo/" . $row['image']);
    }
    $stmt = $conn->delete_kardidat($id);
    
    if ($stmt) {
      echo json_encode([
        'status' => 'success',
        'message' => 'data berhasil dikirim'
      ]);
    } else {
      echo json_encode([
        'status' => 'error',
        'message' => 'data gagal dikirim'
      ]);
    }

  default:
    echo json_encode([
        'status' => 'error',
        'message' => 'Unknown type'
    ]);
}