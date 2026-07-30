<?php
session_start();

// Token rahasia yang ditentukan panitia (bebas kamu ganti)
define('VOTING_TOKEN', 'SMKINFO2026'); 

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // $input_token = trim($_POST['token'] ?? '');

    // if (empty($input_token)) {
    //     $error = 'Token voting wajib diisi!';
    // } else if (strtoupper($input_token) === VOTING_TOKEN) {
    //     // Simpan status login di session
    //     $_SESSION['voter_logged_in'] = true;
        
    //     // Redirect langsung ke beranda/halaman voting
    //     header('Location: index.php');
    //     exit;
    // } else {
    //     $error = 'Token tidak valid! Silahkan tanyakan panitia OSIS.';
    // }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Akses Voting — Pemilihan Ketua OSIS</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0047AB',     // Biru Utama SMK Informatika
                            darkblue: '#0F172A', // Midnight Navy
                            yellow: '#FACC15',   // Kuning Aksen
                            yellowhover: '#EAB308'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Font Inter & Lucide Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
    </style>
</head>
<body class="bg-brand-darkblue text-slate-100 min-h-screen flex items-center justify-center p-4 relative overflow-hidden">

    <!-- Ambient Glow / Blobs -->
    <div class="absolute top-1/3 -left-20 w-80 h-80 bg-brand-blue/30 rounded-full blur-3xl pointer-events-none"></div>
    <div class="absolute bottom-1/3 -right-20 w-80 h-80 bg-brand-yellow/20 rounded-full blur-3xl pointer-events-none"></div>

    <!-- Main Container Card -->
    <div class="relative w-full max-w-4xl bg-white text-slate-800 rounded-3xl shadow-2xl overflow-hidden grid grid-cols-1 md:grid-cols-12 border border-slate-100">
        
        <!-- SIDEBAR KIRI: Gelap (Visual & Brand) -->
        <div class="md:col-span-5 bg-gradient-to-br from-brand-darkblue via-slate-900 to-brand-blue p-8 md:p-10 text-white flex flex-col justify-between relative">
            <div class="absolute top-0 right-0 w-2 h-full bg-brand-yellow"></div>
            
            <div>
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-12 h-12 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-xl shadow-md">
                        <i data-lucide="key-round"></i>
                    </div>
                    <div>
                        <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">E-Voting OSIS</h1>
                        <p class="text-xs text-slate-300">SMK Informatika Sumedang</p>
                    </div>
                </div>

                <h2 class="text-2xl font-extrabold leading-tight mb-3">Masukkan Token Masuk</h2>
                <p class="text-xs text-slate-300 leading-relaxed">
                    Minta kode token ke panitia atau guru pengawas di kelas/lab untuk membuka akses bilik suara digital.
                </p>
            </div>

            <div class="mt-8 pt-6 border-t border-slate-700/50">
                <div class="flex items-center gap-3">
                    <i data-lucide="shield-check" class="w-5 h-5 text-brand-yellow shrink-0"></i>
                    <p class="text-[11px] text-slate-300">
                        Satu token untuk akses bersama seluruh siswa.
                    </p>
                </div>
            </div>
        </div>

        <!-- FORM KANAN: Terang (1 Input Token + 1 Button) -->
        <div class="md:col-span-7 bg-white p-8 md:p-12 flex flex-col justify-center">
            
            <div class="mb-8">
                <a href="index.php" class="inline-flex items-center gap-1.5 text-xs font-semibold text-brand-blue hover:underline mb-4">
                    <i data-lucide="arrow-left" class="w-4 h-4"></i> Kembali ke Beranda
                </a>
                <h2 class="text-2xl font-bold text-slate-900">Validasi Token 🔑</h2>
                <p class="text-sm text-slate-500 mt-1">Ketik kode token untuk mulai menentukan pilihanmu.</p>
            </div>

            <!-- Alert Error PHP -->
            <?php if (!empty($error)): ?>
                <div class="mb-6 p-4 rounded-xl bg-rose-50 border border-rose-200 text-rose-700 text-xs flex items-center gap-3">
                    <i data-lucide="alert-circle" class="w-5 h-5 shrink-0 text-rose-500"></i>
                    <span><?= htmlspecialchars($error) ?></span>
                </div>
            <?php endif; ?>

            <!-- Form 1 Input -->
            <form action="voting-card.php" method="POST" class="space-y-6">
                
                <!-- Single Input: TOKEN -->
                <div>
                    <label for="token" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Kode Token Voting</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <i data-lucide="ticket" class="w-5 h-5"></i>
                        </div>
                        <input type="text" id="token" name="token" required placeholder="Contoh: SMKINFO2026" autocomplete="off"
                            class="w-full pl-12 pr-4 py-4 bg-slate-50 border-2 border-slate-200 rounded-2xl text-base font-bold tracking-widest uppercase text-slate-900 placeholder:normal-case placeholder:font-normal placeholder:tracking-normal placeholder-slate-400 focus:outline-none focus:border-brand-blue focus:bg-white focus:ring-4 focus:ring-brand-blue/10 transition-all">
                    </div>
                </div>

                <!-- Single Button: SUBMIT -->
                <button type="submit" 
                    class="w-full py-4 px-6 rounded-2xl bg-brand-yellow hover:bg-brand-yellowhover text-brand-darkblue font-extrabold text-base shadow-lg shadow-brand-yellow/30 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 group">
                    <span>Masuk ke Bilik Suara</span>
                    <i data-lucide="arrow-right" class="w-5 h-5 group-hover:translate-x-1 transition-transform"></i>
                </button>

            </form>

            <div class="mt-8 text-center border-t border-slate-100 pt-5">
                <p class="text-xs text-slate-400">
                    Belum punya token? Minta langsung ke Panitia OSIS di lokasi.
                </p>
            </div>

        </div>

    </div>

    <script>
        lucide.createIcons();
    </script>
</body>
</html>