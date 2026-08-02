<?php
require_once __DIR__ . '/../api/conn.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header('Location: setting.php');
    exit;
}

$nama_sekolah    = $_POST['nama_sekolah'] ?? '';
$judul_pemilihan = $_POST['judul_pemilihan'] ?? '';
$tahun_ajaran    = $_POST['tahun_ajaran'] ?? '';
$status_voting   = (int) ($_POST['status_voting'] ?? 1);
$waktu_mulai     = date('Y-m-d H:i:s', strtotime($_POST['waktu_mulai']));
$waktu_selesai   = date('Y-m-d H:i:s', strtotime($_POST['waktu_selesai']));

$namaLogoBaru = null;
$folderTujuan = __DIR__ . '/../upload/logo';

// Cek apakah ada file logo yang diunggah
if (!empty($_FILES['logo_sekolah']['name']) && $_FILES['logo_sekolah']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0755, true);
    }

    $settingLama = $conn->get_settings();
    if (!empty($settingLama['logo_sekolah'])) {
        $conn->delete_image($folderTujuan, $settingLama['logo_sekolah']);
    }

    // Upload logo baru
    $namaLogoBaru = $conn->upload_image($folderTujuan, 'logo_' . time(), 'logo_sekolah');
}

// Update ke database menggunakan fungsi yang kamu kirimkan
$berhasil = $conn->update_settings(
    $nama_sekolah, 
    $judul_pemilihan, 
    $tahun_ajaran, 
    $status_voting, 
    $waktu_mulai, 
    $waktu_selesai, 
    $namaLogoBaru
);

header('Location: settings.php?v=' . ($berhasil ? 'true' : 'false'));
exit;