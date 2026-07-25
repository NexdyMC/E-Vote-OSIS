<?php

session_start();
require_once __DIR__ . "/../config/conn.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token = trim($_POST['token'] ?? '');

    if (empty($token)) {
        $error = "Token tidak boleh kosong";
    } else {

        $siswa = $conn->login_admin($token);

        if (!$siswa) {

            $error = "Token tidak ditemukan";

        } elseif ($siswa['voted'] != 0) {

            $error = "Anda sudah melakukan voting";

        } else {

            $_SESSION['token'] = $siswa['token'];
            $_SESSION['nama'] = $siswa['nama'];
            $_SESSION['kelas'] = $siswa['kelas'];

            header("Location: dashboard.php");
            exit;
        }
    }
}

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Login ADMIN</title>
</head>
<body>

    <h1>ADMIN </h1>

    <?php if (isset($error)) : ?>
        <p><?= htmlspecialchars($error) ?></p>
    <?php endif; ?>

    <form method="post">

        <input
            type="text"
            name="token"
            placeholder="Masukkan Token"
            required
        >

        <button type="submit">
            Masuk dan Mulai Voting
        </button>

    </form>
</body>
</html>