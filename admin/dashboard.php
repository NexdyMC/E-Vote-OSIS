<?php
require_once __DIR__ . "/../config/conn.php";

if (isset($_POST['submit'])) {
  $nama_kardidat  = $_POST['input-nama'];
  $visi_kardidat  = $_POST['text-visi'];
  $misi_kardidat  = $_POST['text-misi'];
  
  $status = $conn->add_kandidat($nama_kardidat, $visi_kardidat, $misi_kardidat);

  if ($status) {
    echo "data tersimpan di database";
  } else {
    echo "data tidak tersimpan: " . die($status);
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
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>
  <div class="grid bg-gray-300 w-96">
    <form method="post">
      <!-- <input type="file" name="foto"> -->
  
      <label class="grid">
        nama kardidat: 
        <input type="text" name="input-nama" required>
      </label>
  
      <label class="grid">
        Visi: 
        <textarea name="text-visi" id="text-visi" required></textarea>
      </label>
      
      <label class="grid">
        Misi: 
        <textarea name="text-misi" id="text-misi" required></textarea>
      </label>
  
      <button type="submit" name="submit">Tambahkan Kardidat</button>
    </form>
  </div>

</body>
</html>