<?php
require_once __DIR__ . "/config/conn.php";
session_start();


if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit;
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Voting PIKETOS</title>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="assets/scripts/sweetalert.2.11.js"></script>
</head>
<body>

    <h2>Selamat Datang</h2>

    <p>
        Nama:
        <?= htmlspecialchars($_SESSION['nama']) ?>
    </p>

    <p>
        Kelas:
        <?= htmlspecialchars($_SESSION['kelas']) ?>
    </p>

    <h3>Silakan pilih kandidat</h3>

    <?php 
        $data = $conn->mysql_select("tb_kardidat");
        foreach ($data as $row) {?>

            <?= "<hr>"; ?>
            <?= $row["nama"] . "<br>"; ?>
            <?= $row["visi"] . "<br>"; ?>
            <?= $row["misi"] . "<br>"; ?>
            <button class="" onclick="selectKardidat(<?= $row['id'] ?>, '<?= $row['nama'] ?>')">Pilih Kardidat Ini</button>
        <?php }; ?>
    <script src="assets/scripts/script.js"></script>
</body>
</html>