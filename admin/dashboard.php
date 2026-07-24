<?php
require_once __DIR__ . "/../config/conn.php";

// $nama_kardidat  = $_POST['input-nama'];
// $visi_kardidat  = $_POST['text-visi'];
// $misi_kardidat  = $_POST['text-misi'];


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
  <div class=""></div>
  <form method="post" enctype="multipart/form-data">
    <input type="file" name="foto">

    <label>
      nama kardidat: 
      <input type="text" name="input-nama">
    </label>

    <label>
      Visi: 
      <textarea name="text-visi" id="text-visi"></textarea>
    </label>
    
    <label>
      Misi: 
      <textarea name="text-misi" id="text-misi"></textarea>
    </label>

    <button type="submit">Tambahkan Kardidat</button>
  </form>

</body>
</html>