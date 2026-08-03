<?php
/* =========================================================
   ADMIN/HAPUS-SISWA.PHP
   ---------------------------------------------------------
   Menghapus data siswa berdasarkan token (unik per siswa).

   Catatan: sengaja TIDAK memakai $conn->mysql_delete() bawaan
   conn.php, karena method itu selalu mengikat parameter sebagai
   integer ("i") — cocok untuk kolom id, tapi token di sini
   berupa string acak. Jadi query dibuat langsung di sini lewat
   $conn->conn (koneksi mysqli publik dari class MySQL).
   ========================================================= */
require_once __DIR__ . '/../api/conn.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && !empty($_POST['token'])) {
    $token = $_POST['token'];

    $stmt = $conn->conn->prepare('DELETE FROM tb_siswa WHERE token = ?');
    $stmt->bind_param('s', $token);
    $stmt->execute();
    $stmt->close();
}

header('Location: siswa.php');
exit;
