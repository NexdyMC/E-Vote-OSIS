<?php
/* =========================================================
   ADMIN/SIMPAN-SISWA.PHP
   ---------------------------------------------------------
   Menangani submit form "Tambah Siswa Baru" dari siswa.php.
   Token TIDAK diinput manual oleh admin — dibuat otomatis
   lewat random_id() (fungsi bawaan conn.php) supaya selalu
   unik dan tidak bisa ditebak.
   ========================================================= */
require_once __DIR__ . '/../api/conn.php';


if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: siswa.php');
    exit;
}

$nama  = trim($_POST['nama'] ?? '');
$kelas = trim($_POST['kelas'] ?? '');

if ($nama === '' || $kelas === '') {
    header('Location: siswa.php?v=false');
    exit;
}

$token    = random_id(4);
$berhasil = $conn->add_siswa($token, $nama, $kelas);

if ($berhasil) {
    header('Location: siswa.php?new_token=' . urlencode($token) . '&nama=' . urlencode($nama));
} else {
    header('Location: siswa.php?v=false');
}
exit;
