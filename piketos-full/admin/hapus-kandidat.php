<?php
/* =========================================================
   ADMIN/HAPUS-KANDIDAT.PHP
   ---------------------------------------------------------
   Menangani submit form Hapus dari kandidat.php.
   delete_kardidat() di conn.php sudah otomatis me-reset
   voted/status siswa yang sempat memilih kandidat ini.
   ========================================================= */
require_once __DIR__ . '/../api/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['id'])) {
    $conn->delete_kardidat((int) $_POST['id']);
}

header('Location: kandidat.php');
exit;
