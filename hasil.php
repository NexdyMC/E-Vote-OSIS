<?php

include 'api/conn.php';
// if (!isset($_SESSION['token'])) {
//     header("Location: index.php");
//     exit;
// }

$hasil = $conn->mysql_select("tb_kardidat", "id" );

echo $hasil[0]['id'];
foreach ($hasil as $row) {

    $vored =  $row['id'];

    $siswa = $conn->mysql_select("tb_siswa", "COUNT(*)", "voted = $vored ");

    foreach ($siswa as $count) {
        
        echo $count['token'];
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Voting</title>
</head>
<body>
    
</body>
</html>

