<?php

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

</body>
</html>