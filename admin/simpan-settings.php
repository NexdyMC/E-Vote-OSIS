<?php
session_start();
require_once __DIR__ . "/../api/conn.php";

if (!isset($_SESSION['login'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: settings.php");
    exit;
}

// 1. Ambil & Bersihkan Input Text
$nama_sekolah    = trim($_POST['nama_sekolah'] ?? '');
$tahun_ajaran    = trim($_POST['tahun_ajaran'] ?? '');
$judul_pemilihan = trim($_POST['judul_pemilihan'] ?? '');

// 2. Format status_voting secara eksplisit sebagai String '1' atau '0'
$status_voting_input = $_POST['status_voting'] ?? '0';
$status_voting       = ($status_voting_input == '1') ? '1' : '0';

// 3. Konversi Waktu dari datetime-local ke format MySQL (YYYY-MM-DD HH:MM:SS)
$waktu_mulai_raw   = $_POST['waktu_mulai'] ?? '';
$waktu_selesai_raw = $_POST['waktu_selesai'] ?? '';

$waktu_mulai   = !empty($waktu_mulai_raw) ? date('Y-m-d H:i:s', strtotime($waktu_mulai_raw)) : null;
$waktu_selesai = !empty($waktu_selesai_raw) ? date('Y-m-d H:i:s', strtotime($waktu_selesai_raw)) : null;

// 4. Cek Upload Logo
$logo_sekolah = null;
if (isset($_FILES['logo_sekolah']) && $_FILES['logo_sekolah']['error'] === UPLOAD_ERR_OK) {
    $folder_tujuan = __DIR__ . "/../upload/logo/";

    if (!file_exists($folder_tujuan)) {
        mkdir($folder_tujuan, 0777, true);
    }

    $file_tmp  = $_FILES['logo_sekolah']['tmp_name'];
    $file_name = $_FILES['logo_sekolah']['name'];
    $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

    $allowed_extensions = ['png', 'jpg', 'jpeg', 'webp'];
    if (in_array($file_ext, $allowed_extensions)) {
        $nama_logo_baru = 'logo_' . time() . '.' . $file_ext;
        if (move_uploaded_file($file_tmp, $folder_tujuan . $nama_logo_baru)) {
            $logo_sekolah = $nama_logo_baru;
        }
    }
}

// 5. Eksekusi Update Settings
$update_status = $conn->update_settings(
    $nama_sekolah,
    $judul_pemilihan,
    $tahun_ajaran,
    $status_voting,
    $waktu_mulai,
    $waktu_selesai,
    $logo_sekolah
);

// Redirect dengan Query Parameter
if ($update_status) {
    header("Location: settings.php?v=true");
} else {
    header("Location: settings.php?v=false");
}
exit;