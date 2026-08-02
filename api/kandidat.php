<?php
include "conn.php";
header('Content-Type: multipart/form-data');
$inputData = json_decode(file_get_contents('php://input'), true);

switch ($inputData['type'] ?? '')
{
  // api mode : get
  case 'select':
    $stmt = $conn->select_kandidat();
    
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
    $file = $conn->select_kandidat("id = $id","image");
    
    foreach ($file as $row) {
      echo $row['image'];
      $status  = unlink("../upload/photo/" . $row['image']);
    }
    $stmt = $conn->delete_kandidat($id);
    
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
    
  // api mode : statistik live chart
  case 'statistik':
    
    $suaraKandidat = $conn->select_suara_kandidat(); 
    $totalDPT      = $conn->get_total_dpt();      
    $totalMasuk    = $conn->get_total_suara_masuk();

    echo json_encode([
      'status' => 'success',
      'suaraKandidat' => $suaraKandidat,
      'totalDPT'      => $totalDPT,
      'totalMasuk'    => $totalMasuk
    ]);
    break;
  default:
    echo json_encode([
        'status' => 'error',
        'message' => 'Unknown type'
    ]);
}

