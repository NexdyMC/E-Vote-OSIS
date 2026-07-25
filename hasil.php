<?php
if (!isset($_SESSION['token'])) {
    header("Location: voting.php");
    exit;
}
?>