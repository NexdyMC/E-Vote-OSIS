<?php

session_start();
require_once __DIR__ . "/api/conn.php";


if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $token = trim($_POST['token'] ?? '');

    if (empty($token)) {
        $error = "Token tidak boleh kosong";
    } else {

        $siswa = $conn->login_siswa($token);

        if (!$siswa) {

            $error = "Token tidak ditemukan";

        } elseif ($siswa['voted'] != 0) {

            $error = "Anda sudah melakukan voting";

        } else {

            $_SESSION['token'] = $siswa['token'];
            $_SESSION['nama'] = $siswa['nama'];
            $_SESSION['kelas'] = $siswa['kelas'];

            header("Location: voting.php");
            exit;
        }
    }
}



if (isset($_SESSION['token'])) {
    header("Location: voting.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Token — E-Voting OSIS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- Google Fonts: Poppins & Inter -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Poppins:wght@600;700;800&display=swap" rel="stylesheet">
    <script>
      tailwind.config = {
        theme: {
          extend: {
            colors: {
              primary: { 700: '#1E3A8A', 500: '#2563EB' },
              navy: { 900: '#0F172A' },
              accent: { 400: '#FACC15', 500: '#EAB308' }
            },
            fontFamily: {
              display: ['Poppins', 'sans-serif'],
              sans: ['Inter', 'sans-serif'],
            }
          }
        }
      }
    </script>
</head>
<body class="bg-[#0F172A] min-h-screen flex flex-col justify-between items-center p-4 font-sans text-slate-800">


    <!-- Main Container Card (Tengah Layar) -->
    <main class="w-full max-w-md my-auto py-6">
        <div class="bg-white rounded-3xl p-6 sm:p-8 shadow-2xl border-t-8 border-[#FACC15] relative overflow-hidden">

            <!-- Branding 3 Logo (SMK, IFSU [Tengah Besar], OSIS) -->
            <div class="flex flex-col items-center text-center mb-6">
                <div class="flex items-center justify-center gap-5 mb-4">
                    <!-- 1. Logo SMK (Kiri - Ukuran Sedang) -->
                    <img src="assets/images/logo-osis.png" alt="Logo SMK"
                        class="h-20 w-auto bg-gray-200 p-2 rounded-full object-contain drop-shadow-sm hover:scale-110 duration-300"
                        onerror="this.onerror=null; this.src='https://placehold.co/100x100/1E3A8A/FFFFFF?text=SMK';">

                    <!-- 2. Logo IFSU (Tengah - Ukuran Lebih Besar) -->
                    <img src="assets/images/logo-smk.png" alt="Logo IFSU"
                        class="h-24 w-auto bg-gray-200 p-2 rounded-full object-contain drop-shadow-md scale-105 hover:scale-110 duration-300"
                        onerror="this.onerror=null; this.src='https://placehold.co/120x120/FACC15/1E3A8A?text=IFSU';">

                    <!-- 3. Logo OSIS (Kanan - Ukuran Sedang) -->
                    <img src="assets/images/logo-mpk.png" alt="Logo OSIS"
                        class="h-20 w-auto bg-gray-200 p-2 rounded-full object-contain drop-shadow-sm hover:scale-110 duration-300"
                        onerror="this.onerror=null; this.src='https://placehold.co/100x100/1E3A8A/FFFFFF?text=OSIS';">

                </div>

                <div>
                    <h1 class="font-display font-extrabold text-2xl text-[#0F172A]">Login Pemilihan Osis</h1>
                </div>
            </div>

            <p class="text-xs sm:text-sm text-slate-600 text-center mb-6">
                Masukkan Token Anda untuk memulai votin.
            </p>

            <!-- Form Input Token -->
            <form action="" method="POST" class="space-y-5">
                <div>
                    <label for="token" class="block text-xs font-bold text-slate-700 tracking-wider uppercase mb-2">
                        Kode Token Voting
                    </label>
                    <div class="relative">
                        <div
                            class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="ticket" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="token" name="token" placeholder="Contoh: SMKINFO2026" required
                            autocomplete="off"
                            class="w-full pl-11 pr-4 py-3.5 bg-slate-50 border border-slate-200 rounded-xl text-slate-900 font-mono font-bold tracking-wider placeholder-slate-400 focus:outline-none focus:ring-2 focus:ring-[#1E3A8A] focus:bg-white transition-all uppercase">
                    </div>
                </div>

                <!-- Tombol Submit -->
                <button type="submit" name="login"
                    class="w-full py-3.5 px-4 bg-[#FACC15] hover:bg-[#EAB308] text-[#1E3A8A] font-display font-extrabold text-sm rounded-xl shadow-md transition-all flex items-center justify-center gap-2 group">
                    <span>Masuk ke Bilik Suara</span>
                    <i data-lucide="arrow-right" class="w-4 h-4 group-hover:translate-x-1 transition-transform"></i>
                </button>
            </form>

            <!-- Info Keamanan di dalam Card -->
            <div class="mt-6 pt-5 border-t border-slate-100 text-center">
                <p class="text-xs text-slate-500 flex items-center justify-center gap-1.5">
                    <i data-lucide="shield-check" class="w-4 h-4 text-emerald-600"></i>
                    <span>Satu token untuk akses memilih seluruh siswa.</span>
                </p>
            </div>
        </div>
    </main>

    <!-- Footer -->
    <footer class="py-2 text-center text-xs text-slate-500">
        &copy; 2026 SMK Informatika Sumedang
    </footer>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>