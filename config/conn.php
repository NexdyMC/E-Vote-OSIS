<?php
require_once __DIR__ . '/class.php';
require_once __DIR__ . '/rand.php';

$host = "localhost";
$user = "root";
$pass = "";
$base = "db_piketos";

$conn = new MySQL($host, $user, $pass, $base);

// $siswa = $conn->mysql_select("tb_siswa" );

// foreach ($siswa as $row) {
//     echo $row["token"];
//     echo $row["nama"];
//     echo $row["kelas"];
//     echo $row["status"];
//     echo $row["voted"];
// }
// $random = random(4);
// $conn->mysql_insert("tb_siswa", "token, nama, kelas, status, voted", "'$random', 'Nexdy experiment', '11 RPL 1', '0', '0'" );


// $conn->add_kandidat("Febri Pratama", "menjadikan smk informatika menjadi maju", "mengubah menjadi smk dengan gaya profesional religius");

// $conn->update_kardidat(1, "Febri", "menjadikan smk informatika menjadi maju", "mengubah menjadi smk dengan gaya profesional religius");

// $conn->voting_kardidat("0206", 1);