<?php
/* =========================================================
   PARTIAL: layout/partials/header.php
   ---------------------------------------------------------
   Dipakai bersama oleh admin/dashboard.php, admin/kandidat.php,
   admin/siswa.php. HANYA di-include saat non-AJAX (full page
   load pertama / refresh manual) — lihat blok if (!$is_ajax)
   di masing-masing file halaman.

   Variabel yang harus sudah didefinisikan sebelum include ini:
   $pageTitle (string)
   ========================================================= */
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — E-Voting OSIS</title>
<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script src="../assets/scripts/tailwind.config.js"></script>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

<!-- AOS (Animate On Scroll) — CSS di head, JS runtime dimuat di footer.php -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<!-- link style css -->
<link rel="stylesheet" href="../assets/css/dashboard.css">
</head>
<body class="bg-[#F8FAFC]">
<div class="flex min-h-screen">
