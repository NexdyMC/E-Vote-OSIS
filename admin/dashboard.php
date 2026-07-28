<?php
require_once __DIR__ . "/../api/conn.php";

if (isset($_GET["v"])) {
  $status = $_GET["v"];

  if ($status  == "true") {
    echo "Data berhasil disimpan";
  } 
  if ($status == "false") {
    echo "data tidak berhasil disimpan";
  }
}

if (isset($_GET['d'])){
  $id = $_GET['d'];
  $file = $conn->select_kardidat("id = $id","image");
  foreach ($file as $row) {
    echo $row['image'];

    $status  = unlink("../upload/photo/" . $row['image']);
    if ($status) {
      echo "delete file done";
    } else {
      echo "delete file don't ";
    }
  }
  $conn->delete_kardidat($id);

  if ($status) {
    header("Location: dashboard.php?v=true");
    exit;
  } else {
    header("Location: dashboard.php?v=false");
    exit;
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
  <!-- <script src="../assets/scripts/tailwind.js"></script> -->
</head>
<body>
  <nav>
    <ul class="flex">
      <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="add_siswa.php">New Siswa</a></li>
      <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="add_kardidat.php">New Kardidat</a></li>
    </ul>
  </nav>
  <div class="flex bg-gray-300">

    <!-- start : form -->
    <!-- <form enctype="multipart/form-data" class="grid"> -->
    <div class="grid">
      <div class="grid">
      <!-- input kardidat : photo -->
      <label>
        <input type="file" name="photo" id="photo" required>
      </label>

      <!-- input kardidat : nama -->
      <label class="grid">
        nama kardidat: 
        <input type="text" name="input-nama" id="text-nama" required>
      </label>

      <!-- input kardidat : visi -->
      <label class="grid">
        Visi: 
        <textarea name="text-visi" id="text-visi" required></textarea>
      </label>

      <!-- input kardidat : misi -->
      <label class="grid">
        Misi: 
        <textarea name="text-misi" id="text-misi" required></textarea>
      </label>

      <button type="button" name="submit" id="btn-add-kardidat" class="border bg-blue-200 px-4 py-2 hover:scale-105">Tambahkan Kardidat</button>
    </div>
      <!-- <button type="submit" name="submit" id="btn-add-kardidat" class="border bg-blue-200 px-4 py-2 hover:scale-105">Tambahkan Kardidat</button> -->
    </div>
    <!-- </form> -->

    <div class=" flex bg-cyan-100 " id="card-kardidat">
      <!-- add a kardidat -->
    </div>
  </div>
  <section class="grid">

    
    <!-- table : siswa -->
    <div class="bg-emerald-200 ">
      <table class="border text-center">
        <thead>
          <tr>
            <td>token</td>
            <td>nama</td>
            <td>kelas</td>
            <td>status</td>
            <td>voted</td>
          </tr>
        </thead>
        <tbody>
          <?php
          $hasil = $conn->mysql_select("tb_siswa");
          foreach ($hasil as $row){ ?>
          <tr>
            <td>  <?= $row["token"] ;?> </td>
            <td>  <?= $row["nama"]  ;?> </td>
            <td>  <?= $row["kelas"] ;?> </td>
            <td>  <?= $row["status"];?> </td>
            <td>  <?= $row["voted"] ;?> </td>
            <td>
              <a href="update_siswa.php?token=<?= $row['token'];?>" class="text-blue-600 hover:text-blue-700">Update</a>
            </td>
            <td>
              <a href="update_siswa.php?token=<?= $row['token'];?>" class="text-red-600 hover:text-red-700">Delete</a>
            </td>
          </tr>
          <?php };?>
        </tbody>  
      </table>
      
    </div>
  </section>
  </div>

  <script src="../assets/scripts/dashboard.js"></script>
</body>
</html>