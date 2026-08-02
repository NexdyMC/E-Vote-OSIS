<?php
include "conn.php";
header('Content-Type: application/json; charset=utf-8');
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
    break;

  // api mode : delete
  case 'delete':
    $id = intval($inputData['id'] ?? 0);
    $file = $conn->select_kandidat("id = $id", "image");

    foreach ($file as $row) {
      @unlink("../upload/photo/" . $row['image']);
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
    break;

  // api mode : statistik live chart
  case 'statistik':

    // Pakai method yang sama dengan yang dipakai dashboard.php & hasil.php
    // saat render pertama kali, supaya struktur datanya (nama, suara, warna,
    // no_urut, persen) konsisten dengan yang dibaca oleh JavaScript.
    $suaraKandidat = $conn->get_paslon_results();
    $statistikSiswa = $conn->persen_voting_siswa();

    $totalDPT   = $statistikSiswa['total_siswa'] ?? 0;
    $totalMasuk = $statistikSiswa['sudah_voting'] ?? 0;

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

