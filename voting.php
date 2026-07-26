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
    <!-- script : tailwind css -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script> -->
    <script src="assets/scripts/sweetalert.2.11.js"></script>
    <script src="assets/scripts/tailwind.js"></script>
</head>
<body>
    <nav>
        <ul class="flex">
            <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="hasil.php">Live Voting</a></li>
            <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="logout.php">Logout</a></li>
        </ul>
    </nav>
    <p>
        Nama:
        <?= htmlspecialchars($_SESSION['nama']) ?>
    </p>

    <p>
        Kelas:
        <?= htmlspecialchars($_SESSION['kelas']) ?>
    </p>

    <h3>Silakan pilih kandidat</h3>
    <div class="flex">        
        <?php 
        $data = $conn->mysql_select("tb_kardidat");
        foreach ($data as $row) {?>
        <div class="grid justify-items-center w-48 bg-cyan-100 border text-center">
            <div class="flex justify-center items-center w-32 h-32">
                <img src="assets/photo/<?=  $row['image']; ?>" alt="<?= $row['nama'];?>" class="w-32 h-32 object-cover">
            </div>
            <?= $row["nama"] . "<br>"; ?>
            <?= $row["visi"] . "<br>"; ?>
            <?= $row["misi"] . "<br>"; ?>
            <button class="bg-cyan-300 hover:bg-cyan-400 py-2 px-4" onclick="selectKardidat(<?= $row['id'] ?>, '<?= $row['nama'] ?>')">Pilih Kardidat Ini</button>
        </div>
        <?php }; ?>
    </div>
    <script src="assets/scripts/script.js"></script>
</body>
</html>