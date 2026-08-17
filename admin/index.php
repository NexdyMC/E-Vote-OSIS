<?php

session_start();
require_once __DIR__ . "/../api/conn.php";

if (isset($_SESSION['login'])) {
    header("Location: dashboard.php");
    exit;
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
	$user = trim($_POST['input-username'] ?? '');
	$pass = trim($_POST['input-password'] ?? '');
	if (empty($pass)) {
		$pesan_error = 'Username dan Password tidak boleh kosong';
	} else {
		
		$siswa = $conn->login_admin($user, $pass);
		$admin = $conn->get_admin();
		$settings = $conn->get_settings();
		
		if (!$siswa) {
				$pesan_error = 'Username dan Password tidak ditemukan';
		} else {
			$_SESSION['id_admin'] = $admin['id_admin'];
			$_SESSION['admin'] = $admin['admin'];
			$_SESSION['kelas'] = $admin['kelas'];
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
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Login Token — E-Voting OSIS</title>
	<!-- link : CDN -->
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="https://unpkg.com/lucide@latest"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
	<script src="../assets/js/tailwind.config.js"></script>
</head>

<body class="bg-[#0F172A] min-h-screen flex flex-col justify-between items-center p-4 font-sans text-slate-800">
	<!-- Main Container Card (Tengah Layar) -->
	<main class="w-full max-w-md py-6 my-auto">
		<div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border-t-8 border-[#FACC15] relative overflow-hidden">

			<div class="flex flex-col items-center mb-2 text-center">
				<div class="flex items-center justify-center gap-5 mb-4">

					<!-- Logo : SMK  -->
					<img src="../assets/images/logo-osis.png" alt="Logo SMK"
						class="object-contain w-auto h-20 p-2 duration-300 bg-gray-200 rounded-full drop-shadow-sm hover:scale-110"
						onerror="this.onerror=null; this.src='https://placehold.co/100x100/1E3A8A/FFFFFF?text=SMK';">

					<!-- Logo : IFSU  -->
					<img src="../assets/images/logo-smk.png" alt="Logo IFSU"
						class="object-contain w-auto h-24 p-2 duration-300 scale-105 bg-gray-200 rounded-full drop-shadow-md hover:scale-110"
						onerror="this.onerror=null; this.src='https://placehold.co/120x120/FACC15/1E3A8A?text=IFSU';">

					<!-- Logo : OSIS  -->
					<img src="../assets/images/logo-mpk.png" alt="Logo OSIS"
						class="object-contain w-auto h-20 p-2 duration-300 bg-gray-200 rounded-full drop-shadow-sm hover:scale-110"
						onerror="this.onerror=null; this.src='https://placehold.co/100x100/1E3A8A/FFFFFF?text=OSIS';">

				</div>

				<div>
					<h1 class="font-display font-extrabold text-2xl text-[#0F172A]">Login Sebagai Admin</h1>
				</div>
			</div>

			<p class="mb-2 text-xs text-center sm:text-sm text-slate-600">
				Masukkan Username dan Password Anda.
			</p>
			<div>

				<?php
				if (!empty($pesan_error)): ?>
				<div
					class="flex items-center justify-center gap-2 bg-red-50 border border-red-200 text-red-600 text-sm font-semibold p-3.5 rounded-xl mb-4 shadow-sm text-center">
					<i data-lucide="alert-circle" class="w-4 h-4 text-red-500 shrink-0"></i>
					<span><?= htmlspecialchars($pesan_error) ?></span>
				</div>
				<?php endif; ?>

				<!-- Form Input Token -->
				<form action="" method="POST" class="space-y-5">
					<div>
						<label for="token"
							class="block mb-2 text-xs tracking-wider uppercase font-display font-smallbold text-slate-700">
							Username
						</label>
						<div class="relative">
							<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
								<i data-lucide="user" class="w-5 h-5"></i>
							</div>
							<input type="text" id="input-username" name="input-username" placeholder="Masukan Username" required
								autocomplete="off"
								class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-display font-smallbold tracking-wider placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:bg-white transition-all">
						</div>
					</div>

					<div>
						<label for="token"
							class="block mb-2 text-xs tracking-wider uppercase font-display font-smallbold text-slate-700">
							Password
						</label>
						<div class="relative">
							<div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
								<i data-lucide="key" class="w-5 h-5"></i>
							</div>
							<input type="password" id="input-password" name="input-password" placeholder="Masukan Password" required
								autocomplete="off"
								class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-display font-smallbold tracking-wider placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:bg-white transition-all">
						</div>
					</div>

					<!-- Tombol Submit -->
					<button type="submit" name="login"
						class="w-full py-3.5 px-4 bg-[#FACC15] hover:bg-[#EAB308] text-[#1E3A8A] font-display font-extrabold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 group">
						<span class="text-white">Masuk ke Halaman Admin</span>
						<i data-lucide="arrow-right" class="w-4 h-4 transition-transform group-hover:translate-x-1"></i>
					</button>
				</form>

				<!-- Info Keamanan -->
				<div class="pt-5 mt-6 text-center border-t border-slate-100">
					<p class="text-xs text-slate-500 flex items-center justify-center gap-1.5">
						<i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
						<span>Satu token untuk akses memilih seluruh siswa.</span>
					</p>
				</div>
			</div>
	</main>

	<!-- Footer -->
	<footer class="py-2 text-xs text-center text-slate-500">
		&copy; 2026 Febri Pratama — All rights reserved.
	</footer>

	<script>
		lucide.createIcons();
	</script>
</body>
</html>