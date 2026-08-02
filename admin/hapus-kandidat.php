<?php
/* =========================================================
   ADMIN/HAPUS-KANDIDAT.PHP
   ---------------------------------------------------------
   Menangani submit form Hapus dari kandidat.php.
   delete_kandidat() di conn.php sudah otomatis me-reset
   voted/status siswa yang sempat memilih kandidat ini.
   ========================================================= */
require_once __DIR__ . '/../api/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $id = (int) $_POST['id'];
    $name_file = $conn->select_kandidat("id = $id", 'image');
    
    foreach ($name_file as $key => $value) {
        $status = unlink("../upload/photo/". $key['image']);
    }

    $conn->delete_kandidat($id);
}

header('Location: kandidat.php');
exit;
