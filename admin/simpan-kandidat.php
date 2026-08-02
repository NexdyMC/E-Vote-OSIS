<?php
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

$namaFileBaru = null;
$folderTujuan = __DIR__ . '/../upload/photo';

// Cek apakah ada file foto baru yang diunggah
if (!empty($_FILES['foto']['name']) && $_FILES['foto']['error'] === UPLOAD_ERR_OK) {
    if (!is_dir($folderTujuan)) {
        mkdir($folderTujuan, 0755, true);
    }

    // --- CEK DAN HAPUS FOTO LAMA (JIKA DALAM MODE EDIT) ---
    if ($id > 0) {
        $kandidatLama = $conn->select_kandidat("id = $id LIMIT 1");
        if (!empty($kandidatLama[0]['image'])) {
            // Hapus file foto lama dari server menggunakan delete_image
            $conn->delete_image($folderTujuan, $kandidatLama[0]['image']);
        }
    }

    // Upload file foto yang baru
    $namaFileBaru = $conn->upload_image($folderTujuan, 'kandidat_' . uniqid(), 'foto');
}

$berhasil = false;

if ($id > 0) {
    // --- Mode Edit ---
    $berhasil = $conn->update_kandidat($id, $nama, $visi, $misi, $namaFileBaru);
} else {
    // --- Mode Tambah ---
    $berhasil = $conn->add_kandidat($nama, $visi, $misi, $namaFileBaru ?? '');
}

header('Location: kandidat.php?v=' . ($berhasil ? 'true' : 'false'));
exit;