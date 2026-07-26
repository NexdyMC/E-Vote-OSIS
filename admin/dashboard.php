<?php
require_once __DIR__ . "/../config/conn.php";

if (isset($_POST['submit'])) {

    $nama_kardidat = $_POST['input-nama'];
    $visi_kardidat = $_POST['text-visi'];
    $misi_kardidat = $_POST['text-misi'];
    $image_kardidat = $_FILES['photo']['name'];
    $extension = strtolower(pathinfo($image_kardidat, PATHINFO_EXTENSION));
    $randon = random(10);
    $file_enc = $randon .  ".$extension";

    $status = $conn->add_kandidat(
        $nama_kardidat,
        $visi_kardidat,
        $misi_kardidat,
        $file_enc 
    );

    $upload = $conn->upload_image('../assets/photo/', $randon ,'photo');
  
    if ($status && $upload) {
        header("Location: dashboard.php?v=true");
        exit;
    } else {
        header("Location: dashboard.php?v=false");
        exit;
    }
}

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
  $file = $conn->mysql_select("tb_kardidat", "id = $id", "image");
  foreach ($file as $row) {
    $status  = unlink("../assets/photo/" . $row['image']);
    if ($status) {
      echo "delete file done";
    } else {
      echo "delete file don't ";
    }
    $conn->delete_kardidat($id);
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
  <nav>
    <ul class="flex">
      <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="add_siswa.php">New Siswa</a></li>
      <li class="text-blue-600 hover:text-blue-400 p-2 "><a href="add_kardidat.php">New Kardidat</a></li>
    </ul>
  </nav>
  <div class="flex bg-gray-300">
    <form method="post" enctype="multipart/form-data" class="grid">
      
      <!-- input kardidat : photo -->
      <label>
        <input type="file" name="photo" require>
      </label>

      <!-- input kardidat : nama -->
      <label class="grid">
        nama kardidat: 
        <input type="text" name="input-nama" required>
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
  
      <button type="submit" name="submit" class="border bg-blue-200 px-4 py-2 hover:scale-105">Tambahkan Kardidat</button>
    </form>

    <div class=" flex bg-cyan-100">
      <?php
      $hasil = $conn->mysql_select("tb_kardidat");
      foreach ($hasil as $row) { ?> 
        
      <div class="card border rounded-md text-center w-64">
        <div class="flex justify-center items-center">
          <img src="../assets/photo/<?=  $row['image']; ?>" alt="Kardidat <?= $row["nama"];  ?>" class="w-32 h-32 object-cover object-center">
        </div>
        <p><?= $row["nama"];  ?></p>
        <p><?= $row["visi"];  ?></p>
        <p><?= $row["misi"];  ?></p>
        <a href="dashboard.php?u=<?= $row["id"]; ?>" class="text-blue-500 hover:text-blue-600">update</a>
        <a href="dashboard.php?d=<?= $row["id"]; ?>" class="text-red-500 hover:text-red-600">delete</a>
      </div>

      <?php }; ?>
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
  <!-- <script src="../assets/scripts/dashboard.js"></script> -->
</body>
</html>