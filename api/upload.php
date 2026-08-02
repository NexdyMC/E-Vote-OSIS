<?php
include "conn.php";
header('Content-Type: application/json');

// pastikan ada file yang dikirim dengan field name "photo"
if (!isset($_FILES['photo']) || $_FILES['photo']['error'] !== UPLOAD_ERR_OK) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Tidak ada file yang dikirim atau upload gagal.'
    ]);
    exit;
}

// buat nama file unik supaya tidak saling menimpa
$uniqueName = random_id(10); // fungsi random() sudah ada di conn.php

// folder tujuan (relatif terhadap file ini, api/upload.php)
$targetFolder = '../upload/photo';

$result = $conn->upload_image($targetFolder, $uniqueName, 'photo');

if ($result) {
    echo json_encode([
        'status'   => 'success',
        'message'  => 'Upload berhasil.',
        'filename' => $result   // ini yang dipakai buat kolom `image` di tb_kandidat
    ]);
} else {
    echo json_encode([
        'status'  => 'error',
        'message' => 'Upload gagal. Pastikan format jpg/jpeg/png/webp dan ukuran di bawah 2MB.'
    ]);
}