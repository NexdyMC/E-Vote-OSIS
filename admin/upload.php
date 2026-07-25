<?php

require_once __DIR__ . "/../config/rand.php";
require_once __DIR__ . "/../config/conn.php";

if (isset($_POST['btn-upload'])) {
  
  $file_enc = random(10);
  $conn->upload_image('../assets/photo/', $file_enc ,'photo');
  // $image_size = $_FILES['photo']['size'];
  // $image_name = $_FILES['photo']['name'];
  // $image_type = $_FILES['photo']['type'];
  // $image_tmp = $_FILES['photo']['tmp_name'];

  // $local = "../assets/photo/";
  // $name = random(10). ".$image_type[6]$image_type[7]$image_type[8]$image_type[9]";
  // move_uploaded_file($image_tmp, $local . $name);
  

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