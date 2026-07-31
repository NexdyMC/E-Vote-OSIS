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
    <script src="assets/scripts/tailwind.js"></script>
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
                        }
                    }
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
    </style>
</head>
<body>
    <!-- section : header -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="bar-chart-3"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">Live Quick Count</h1>
                    <p class="text-[11px] text-slate-400">SMK Informatika Sumedang</p>
                </div>
            </div>

            <!-- Navigation -->
            <div class="flex items-center gap-4">
                <a href="index.php" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-brand-yellow transition-colors">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <a href="login.php" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-3.5 py-2 rounded-xl shadow-md transition-all">
                    <i data-lucide="vote" class="w-4 h-4"></i> Bilik Suara
                </a>
            </div>
        </div>
    </header>
    
    <!-- section : main  -->
    <main class="py-8 px-4 sm:px-6 max-w-6xl mx-auto w-full flex-1 flex flex-col justify-center">
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-brand-yellow uppercase bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                    Langkah Terakhir
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Pilih Paslon Ketua OSIS</h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-1">Geser untuk melihat seluruh kandidat sebelum memilih.</p>
            </div>

            <!-- TOMBOL SCROLL KIRI & KANAN -->
            <div class="flex items-center gap-3 self-end sm:self-auto">
                <button id="scrollLeft" class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="scrollRight" class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- CONTAINER SCROLL HORIZONTAL (CAROUSEL) -->
        <div id="cardContainer" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar pb-6 pt-2">

            <?php 
            $no = 1;
            foreach ($paslon_list as $paslon): 
            ?>
            <!-- INDIVIDUAL CARD PASLON -->
            <div class="snap-center shrink-0 w-[300px] sm:w-[380px] bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-2xl flex flex-col justify-between relative group hover:border-slate-700 transition-all">
                
                <!-- Badge Nomor Urut -->
                <div class="absolute top-8 left-8 z-10">
                    <span class="bg-brand-yellow text-brand-darkblue text-sm font-extrabold px-3 py-1.5 rounded-xl shadow-md flex items-center gap-1">
                        <span class="text-[10px] font-bold opacity-75">NO</span> <?= $no++; ?>
                    </span>
                </div>

                <div>
                    <!-- Foto Paslon -->
                    <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
                        <img src="upload/photo/<?= $paslon['image'] ?>" alt="Foto Paslon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-90"></div>
                    </div>

                    <!-- Tagline -->
                    <!-- <p class="text-xs italic font-medium text-brand-yellow mb-4 line-clamp-1">
                        "<?= $paslon['tagline'] ?>"
                    </p> -->

                    <!-- Box Visi & Misi (Bisa di-scroll vertikal di dalam card jika teks panjang) -->
                    <div class="space-y-4 pr-1 text-left scrollbar-thin scrollbar-thumb-slate-700">
                        <!-- Visi -->
                        <div class="bg-slate-950/60 p-3 rounded-xl border border-slate-800/80">
                            <h4 class="text-[11px] font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-yellow"></i> Visi
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                <?= $paslon['visi'] ?>
                            </p>
                        </div>

                        <!-- Misi -->
                        <div class="bg-slate-950/60 p-3 rounded-xl border border-slate-800/80">
                            <h4 class="text-[11px] font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-yellow"></i> Visi
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                <?= nl2br($paslon['misi']); ?>
                            </p>
                        </div>

                    </div>
                </div>

                <!-- Tombol Coblos -->
                <div class="mt-6 pt-4 border-t border-slate-800">
                    <button type="button" 
                        onclick="selectKardidat(<?= $row['id'] ?>, '<?= $row['nama'] ?>')" 
                        class="w-full py-3.5 px-4 rounded-xl bg-brand-yellow hover:bg-brand-yellowhover text-brand-darkblue font-extrabold text-sm shadow-lg shadow-brand-yellow/20 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                        <span>Pilih Kardidat Ini</span>
                    </button>
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
</body>
</html>