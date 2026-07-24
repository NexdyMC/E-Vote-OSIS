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
        foreach ($data as $row) {
            echo "<hr>";
            echo $row["nama"] . "<br>";
            echo $row["visi"] . "<br>";
            echo $row["misi"] . "<br>";
            echo "<hr>";
            }
        
    ?>

</body>
</html>