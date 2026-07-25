<?php
require_once __DIR__ . '/class.php';
require_once __DIR__ . '/rand.php';

$host = "localhost";
$user = "root";
$pass = "";
$base = "db_piketos";

$conn = new MySQL($host, $user, $pass, $base);
?>