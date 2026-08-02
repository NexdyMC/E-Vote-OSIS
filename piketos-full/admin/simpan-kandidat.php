<?php
/* =========================================================
   ADMIN/SIMPAN-KANDIDAT.PHP
   ---------------------------------------------------------
   Menangani submit form modal Tambah/Edit dari kandidat.php.
   ========================================================= */
require_once __DIR__ . '/../api/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: kandidat.php');
    exit;
}

$id   = (int) ($_POST['id'] ?? 0);
$nama = trim($_POST['nama'] ?? '');
$visi = trim($_POST['visi'] ?? '');
$misi = trim($_POST['misi'] ?? '');

if ($nama === '' || $visi === '' || $misi === '') {
    header('Location: kandidat.php?v=false');
    exit;
}

// --- Upload foto (opsional saat edit, wajib secara logis saat tambah baru) ---
$namaFileBaru = null;
if (!empty($_FILES['foto']['name'])) {
    $folderTujuan = __DIR__ . '/uploads/kandidat';
    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0755, true);
    }
    $namaFileBaru = $conn->upload_image($folderTujuan, 'kandidat_' . uniqid(), 'foto');
}

$berhasil = false;

if ($id > 0) {
    // --- Mode Edit ---
    // Catatan: update_kardidat() bawaan conn.php belum mendukung kolom
    // image (hanya nama/visi/misi). Jadi kalau admin upload foto baru
    // saat edit, foto lama di DB TIDAK ikut berubah kecuali method
    // update_kardidat() di conn.php ditambah parameter $image.
    $berhasil = $conn->update_kardidat($id, $nama, $visi, $misi);
} else {
    // --- Mode Tambah ---
    $berhasil = $conn->add_kandidat($nama, $visi, $misi, $namaFileBaru ?? '');
}

header('Location: kandidat.php?v=' . ($berhasil ? 'true' : 'false'));
exit;
