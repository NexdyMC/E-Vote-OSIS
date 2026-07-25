<?php
require_once __DIR__ . "/../config/conn.php";
require_once __DIR__ . "/../config/rand.php";

if (isset($_POST['add-siswa'])) {

  $siswa_nama = $_POST['input-nama'];
  $siswa_kelas = $_POST['input-kelas'];
  
  if (empty($siswa_kelas) && empty($siswa_kelas)) {
    echo "masukan nama dan kelas";  
  
    } else {

    $status = $conn->add_siswa(random(4), $siswa_nama, $siswa_kelas);
      
    if ($status) {
      header("Location: dashboard.php?v=true");
      exit;
    } else {
      header("Location: dashboard.php?v=false");
      exit;
    }
  }
}

if (isset($_GET["v"])) {
  $status = $_GET["v"];

  if ($status == "true") {
    echo "Data berhasil disimpan";
  }
  if ($status == "false") {
    echo "data tidak berhasil disimpan";
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>dashboard admin</title>
  <!-- CDN : tailwindcss v3 -->
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <script src="../assets/scripts/tailwind.js"></script>
</head>
<body>

  <form method="post">
    <!-- input : Name -->
    <label>
      Masukan Nama : 
      <input type="text" class="border" name="input-nama" require>
    </label>
    
    <!-- input : Kelas -->
    <label>
      Masukan Kelas : 
      <select name="input-kelas" class="border" id="input-kelas" require>
        <option value="">Pilih Kelas</option>
        <!-- option : 10 RPL -->
        <option value="10 RPL 1">10 RPL 1</option>
        <option value="10 RPL 2">10 RPL 2</option>
        <option value="10 RPL 3">10 RPL 3</option>
        <option value="10 RPL 4">10 RPL 4</option>
        <option value="10 RPL 5">10 RPL 5</option>
        <option value="10 RPL 6">10 RPL 6</option>
        <option value="10 RPL 7">10 RPL 7</option>
        <option value="10 RPL 8">10 RPL 8</option>
        <option value="10 RPL 9">10 RPL 9</option>
        <!--  Kelas : 10 DKV -->
        <option value="10 DKV 1">10 DKV 1</option>
        <option value="10 DKV 2">10 DKV 2</option>
        <option value="10 DKV 3">10 DKV 3</option>
        <!-- option : 11 RPL -->
        <option value="11 RPL 1">11 RPL 1</option>
        <option value="11 RPL 2">11 RPL 2</option>
        <option value="11 RPL 3">11 RPL 3</option>
        <option value="11 RPL 4">11 RPL 4</option>
        <option value="11 RPL 5">11 RPL 5</option>
        <option value="11 RPL 6">11 RPL 6</option>
        <option value="11 RPL 7">11 RPL 7</option>
        <option value="11 RPL 8">11 RPL 8</option>
        <option value="11 RPL 9">11 RPL 9</option>
        <!--  Kelas : 11 DKV -->
        <option value="11 DKV 1">11 DKV 1</option>
        <option value="11 DKV 2">11 DKV 2</option>
        <option value="11 DKV 3">11 DKV 3</option>
        <!-- option : 12 RPL -->
        <option value="12 RPL 1">12 RPL 1</option>
        <option value="12 RPL 2">12 RPL 2</option>
        <option value="12 RPL 3">12 RPL 3</option>
        <option value="12 RPL 4">12 RPL 4</option>
        <option value="12 RPL 5">12 RPL 5</option>
        <option value="12 RPL 6">12 RPL 6</option>
        <option value="12 RPL 7">12 RPL 7</option>
        <option value="12 RPL 8">12 RPL 8</option>
        <option value="12 RPL 9">12 RPL 9</option>
        <!--  Kelas : 12 DKV -->
        <option value="12 DKV 1">12 DKV 1</option>
        <option value="12 DKV 2">12 DKV 2</option>
        <option value="12 DKV 3">12 DKV 3</option>
      </select>
    </label>

    <button type="submit" name="add-siswa" class="add-siswa py-4 px-6 bg-green-300 hover:bg-green-400">Tambahkan siswa</button>
  </form>

</body>
</html>