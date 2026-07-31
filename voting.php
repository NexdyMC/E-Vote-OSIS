<?php
require_once __DIR__ . "/api/conn.php";
session_start();


// if (!isset($_SESSION['token'])) {
//     header("Location: index.php");
//     exit;
// }

$paslon_list = $conn->mysql_select("tb_kardidat");

?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilik Suara — E-Voting OSIS SMK Informatika</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <!-- <script src="assets/scripts/tailwind.js"></script> -->
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0047AB',
                            darkblue: '#0F172A',
                            yellow: '#FACC15',
                            yellowhover: '#EAB308'
                        },
                        navy: {
                            950: '#0B1424',
                            900: '#0F172A',
                            800: '#152238',
                        },
                        primary: {
                            50:  '#EEF3FF',
                            100: '#DCE7FF',
                            500: '#2563EB',
                            600: '#1D4ED8',
                            700: '#1E3A8A',
                        },
                        accent: {
                            300: '#FDE68A',
                            400: '#FACC15',
                            500: '#EAB308',
                        },
                    },
                    fontFamily: {
                        display: ['Poppins', 'sans-serif'],
                        body: ['Inter', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Sembunyikan Scrollbar Bawaan Browser agar UI Bersih */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* ---------- Candidate card hover ---------- */
        .card-kandidat { transition: transform .35s ease, box-shadow .35s ease; }
        .card-kandidat:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(30,58,138,0.25); }

        /* ---------- Button hover shine ---------- */
        .btn-cta { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease; }
        .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -6px rgba(37,99,235,0.45); }
        .btn-accent:hover { box-shadow: 0 10px 25px -6px rgba(234,179,8,0.5); }

    </style>
</head>
<body>
    <!-- section : header -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">

            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="vote"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">Live Quick Count</h1>
                    <p class="text-[11px] text-slate-400">SMK Informatika Sumedang</p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-4">
                <a href="index.php"
                    class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-brand-yellow transition-colors">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <a href="login.php"
                    class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-3.5 py-2 rounded-xl shadow-md transition-all">
                    <i data-lucide="vote" class="w-4 h-4"></i> Bilik Suara
                </a>
            </div>
        </div>
    </header>

    <!-- section : main  -->
    <main class="py-8 px-4 sm:px-6 max-w-6xl mx-auto w-full flex-1 flex flex-col justify-center">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span
                    class="text-xs font-bold tracking-widest text-brand-yellow uppercase bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                    Langkah Terakhir
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Pilih Paslon Ketua OSIS</h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-1">Geser untuk melihat seluruh kandidat sebelum memilih.
                </p>
            </div>

            <!-- TOMBOL SCROLL KIRI & KANAN -->
            <div class="flex items-center gap-3 self-end sm:self-auto">
                <button id="scrollLeft"
                    class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="scrollRight"
                    class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- select : kardidat -->
        <!-- <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8"> -->
        <div class="flex gap-4 overflow-x-auto py-2 no-scrollbar scroll-smooth">
            <?php
            $kardidat = $conn->mysql_select("tb_kardidat");
            foreach ($kardidat as $row) :?>

            <div class="max-w-96 w-full card-kandidat shrink-0 flex flex-col justify-between relative group bg-white rounded-3xl shadow-[0_8px_30px_rgb(15,23,42,0.06)] overflow-hidden border border-2 border-slate-300/80 ">
                <div class="text-left">

                    <!-- kardidat : image -->
                    <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
                        <img src="upload/photo/<?=  $row['image']; ?>" alt="Kardidat <?= $row['nama'];?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- kardidat : nama siswa -->
                    <p class="text-2xl text-center font-bold  my-4 line-clamp-1">
                        <?= $row['nama'] ?>
                    </p>
                    <div class="px-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-700">

                        <!-- kardidat : Visi -->
                        <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                            <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-blue"></i> Visi
                            </h4>
                            <p class="text-sm text-bland-blue leading-relaxed ">
                                <?= nl2br($row['visi']); ?>
                            </p>
                        </div>

                        <!-- kardidat : Misi -->
                        <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                            <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-blue"></i> Misi
                            </h4>
                            <p class="text-sm text-bland-blue leading-relaxed ">
                                <?= nl2br($row['misi']); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- kardidat : button -->
                <div class="px-4 py-4 space-y-4 text-center">
                    <a href="login.php"
                        class="btn-cta w-full font-display font-semibold text-sm px-5 py-3 rounded-xl border-2 border-primary-700 text-primary-700 bg-slate-100 text-navy-500 hover:bg-primary-700 hover:text-white flex items-center justify-center gap-2">
                        <i data-lucide="vote" class="w-4 h-4"></i>
                        Pilih Kardidat Ini
                    </a>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- section : footer -->
    <footer class="bg-slate-950 border-t border-slate-900 py-4 text-center text-xs text-slate-500">
        &copy; <?= date('Y') ?> Pemilihan Ketua OSIS — SMK Informatika Sumedang
    </footer>
    <script src="assets/scripts/script.js"></script>
    <script>
        lucide.createIcons();
    </script>
</body>
</html>