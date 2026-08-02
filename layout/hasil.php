<?php
session_start();

// Simulasi Data Hasil Voting
$total_pemilih_terdaftar = 1200;
$total_suara_masuk      = 850;
$suara_belum_memilih    = $total_pemilih_terdaftar - $total_suara_masuk;
$persentase_partisipasi = round(($total_suara_masuk / $total_pemilih_terdaftar) * 100, 1);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Quick Count Hasil Voting</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            dark: '#0F172A',
                            yellow: '#FACC15',
                            yellowhover: '#EAB308'
                        }
                    }
                }
            }
        }
    </script>
    <!-- Chart.js & Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-brand-dark text-slate-100 min-h-screen flex flex-col justify-between pb-20">

    <!-- ============================================================
         1. HEADER / NAVBAR SECTION
         ============================================================ -->
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

            <!-- Navigation Links & Status -->
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

    <!-- ============================================================
         1. SECTION HEADER (TEXT CENTER)
         ============================================================ -->
    <header class="h-[400px] grid items-center py-10 px-4 border-b border-slate-800 bg-slate-950/50 backdrop-blur-md">
        <div class="max-w-4xl mx-auto text-center space-y-3">
            <span class="inline-block px-4 py-1.5 rounded-full bg-brand-yellow/10 border border-brand-yellow/30 text-brand-yellow text-xs font-bold uppercase tracking-widest">
                E-Voting Resmi
            </span>
            <h1 class="text-3xl sm:text-5xl font-extrabold text-white tracking-tight">
                Hasil Pemungutan Suara OSIS
            </h1>
            <p class="text-slate-400 text-sm sm:text-base max-w-xl mx-auto">
                SMK Informatika Sumedang — Seluruh data dihitung secara otomatis dan transparan.
            </p>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 sm:px-6 w-full space-y-12 my-10">

        <!-- ============================================================
             2. SECTION TOTAL VOTES CARD / STATIS CARD
             ============================================================ -->
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- DPT Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex items-center justify-between text-slate-400 mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider">Total DPT</span>
                        <i data-lucide="users" class="w-5 h-5 text-blue-500"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-white"><?= number_format($total_pemilih_terdaftar) ?></div>
                    <p class="text-xs text-slate-500 mt-1">Siswa Terdaftar</p>
                </div>

                <!-- Total Votes Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex items-center justify-between text-slate-400 mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider">Total Votes</span>
                        <i data-lucide="check-circle-2" class="w-5 h-5 text-emerald-400"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-white"><?= number_format($total_suara_masuk) ?></div>
                    <p class="text-xs text-emerald-400 font-semibold mt-1"><?= $persentase_partisipasi ?>% Partisipasi</p>
                </div>

                <!-- Belum Voting Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex items-center justify-between text-slate-400 mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider">Belum Voting</span>
                        <i data-lucide="clock" class="w-5 h-5 text-amber-400"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-white"><?= number_format($suara_belum_memilih) ?></div>
                    <p class="text-xs text-amber-400 font-semibold mt-1"><?= round(100 - $persentase_partisipasi, 1) ?>% Belum Memilih</p>
                </div>

                <!-- Total Candidate Card -->
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex items-center justify-between text-slate-400 mb-3">
                        <span class="text-xs font-semibold uppercase tracking-wider">Total Kandidat</span>
                        <i data-lucide="award" class="w-5 h-5 text-brand-yellow"></i>
                    </div>
                    <div class="text-3xl font-extrabold text-white"><?= count($paslon_results) ?></div>
                    <p class="text-xs text-slate-500 mt-1">Pasangan Calon</p>
                </div>

            </div>
        </section>


        <!-- ============================================================
             3. SECTION CHARTS (DONAT & DIAGRAM BATANG)
             ============================================================ -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- Chart Donat -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl flex flex-col items-center">
                <h3 class="text-base font-bold text-white self-start">Persentase Suara</h3>
                <p class="text-xs text-slate-400 self-start mb-6">Diagram Donat / Doughnut Chart</p>
                
                <div class="relative w-full max-w-[280px] aspect-square flex items-center justify-center">
                    <canvas id="donutChart"></canvas>
                </div>
            </div>

            <!-- Diagram Batang (Bar Chart) -->
            <div class="bg-slate-900/90 border border-slate-800 rounded-3xl p-6 shadow-xl flex flex-col justify-between">
                <div>
                    <h3 class="text-base font-bold text-white">Perbandingan Perolehan Suara</h3>
                    <p class="text-xs text-slate-400 mb-6">Diagram Batang / Bar Chart</p>
                </div>
                
                <div class="relative w-full h-[280px]">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

        </section>


        <!-- ============================================================
             4. SECTION CANDIDATE PROGRESS
             ============================================================ -->
        <section class="space-y-4">
            <h3 class="text-xl font-extrabold text-white">Progress Perolehan Kandidat</h3>

            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($paslon_results as $paslon): ?>
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-dark font-extrabold text-sm flex items-center justify-center shrink-0 shadow-md">
                                <?= $paslon['no_urut'] ?>
                            </span>
                            <div>
                                <h4 class="text-base font-bold text-white"><?= $paslon['nama'] ?></h4>
                                <p class="text-xs text-slate-400">Paslon Nomor Urut <?= $paslon['no_urut'] ?></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-4 text-right">
                            <div>
                                <span class="text-xl font-extrabold text-brand-yellow"><?= $paslon['persen'] ?>%</span>
                                <span class="text-xs text-slate-400 block"><?= number_format($paslon['suara']) ?> Suara</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-950 rounded-full h-4 p-0.5 border border-slate-800 overflow-hidden">
                        <div class="h-full rounded-full transition-all duration-1000" 
                             style="width: <?= $paslon['persen'] ?>%; background-color: <?= $paslon['warna'] ?>;"></div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>


    <!-- ============================================================
         5. INFO "REAL TIME" FLOATING BADGE
         ============================================================ -->
    <div class="fixed bottom-5 right-5 z-50 bg-slate-900/95 border border-slate-700/80 backdrop-blur-md px-4 py-2.5 rounded-full shadow-2xl flex items-center gap-3">
        <span class="relative flex h-3 w-3">
            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
            <span class="relative inline-flex rounded-full h-3 w-3 bg-emerald-500"></span>
        </span>
        <div class="text-xs">
            <span class="font-bold text-emerald-400 block leading-none">REAL TIME</span>
            <span class="text-[10px] text-slate-400">Sync: <strong id="syncTime" class="text-slate-200">5s</strong></span>
        </div>
    </div>


    <!-- ============================================================
         3. FOOTER SECTION
         ============================================================ -->
    <footer class="bg-slate-950 border-t border-slate-900 py-6 mt-12 text-center text-xs text-slate-500">
        <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <p>&copy; <?= date('Y') ?> Pemilihan Ketua OSIS — SMK Informatika Sumedang.</p>
            <p class="text-slate-600">Sistem E-Voting Real-Time v2.0</p>
        </div>
    </footer>

    <!-- ============================================================
         JAVASCRIPT CHART.JS & REAL-TIME TIMER
         ============================================================ -->
    <script>
        lucide.createIcons();

        // Data Paslon dari PHP
        const paslonLabels = [<?php foreach($paslon_results as $p) echo "'Paslon " . $p['no_urut'] . "',"; ?>];
        const paslonSuara  = [<?php foreach($paslon_results as $p) echo $p['suara'] . ","; ?>];
        const paslonWarna  = [<?php foreach($paslon_results as $p) echo "'" . $p['warna'] . "',"; ?>];

        // 1. Chart Donat (Doughnut)
        new Chart(document.getElementById('donutChart').getContext('2d'), {
            type: 'doughnut',
            data: {
                labels: paslonLabels,
                datasets: [{
                    data: paslonSuara,
                    backgroundColor: paslonWarna,
                    borderColor: '#0F172A',
                    borderWidth: 2
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#94A3B8', font: { family: 'Inter' } } }
                },
                cutout: '70%'
            }
        });

        // 2. Diagram Batang (Bar Chart)
        new Chart(document.getElementById('barChart').getContext('2d'), {
            type: 'bar',
            data: {
                labels: paslonLabels,
                datasets: [{
                    label: 'Jumlah Suara',
                    data: paslonSuara,
                    backgroundColor: paslonWarna,
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { display: false }
                },
                scales: {
                    x: { ticks: { color: '#94A3B8' }, grid: { display: false } },
                    y: { ticks: { color: '#94A3B8' }, grid: { color: '#1E293B' } }
                }
            }
        });

        // Timer Real Time Hitung Mundur
        let seconds = 5;
        const syncElem = document.getElementById('syncTime');
        setInterval(() => {
            seconds--;
            if (seconds <= 0) seconds = 5;
            syncElem.innerText = seconds + 's';
        }, 1000);
    </script>
</body>
</html>