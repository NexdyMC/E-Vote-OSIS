<?php

require_once __DIR__ . "/../config/rand.php";
require_once __DIR__ . "/../config/conn.php";

if (isset($_POST['btn-upload'])) {
  
  $file_enc = random(10);
  $conn->upload_image('../assets/photo/', $file_enc ,'photo');
  echo "foto sudah tersimpan";
  
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>upload image</title>
</head>
<body>

  <form method="post" enctype="multipart/form-data">
    <input type="file" id="cover" name="photo" required>

    <button type="submit" name="btn-upload">upload image</button>
  </form>
  
</body>
</html>