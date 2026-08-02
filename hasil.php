<?php
require_once __DIR__ . "/api/conn.php";

$totalSiswa = $conn->persen_voting_siswa();

session_start();

$total_pemilih_terdaftar= $totalSiswa['total_siswa'];
$total_suara_masuk      = $totalSiswa['sudah_voting'];
$suara_belum_memilih    = $total_pemilih_terdaftar - $total_suara_masuk;
$persentase_partisipasi = round(($total_suara_masuk / $total_pemilih_terdaftar) * 100, 1);


// $voted_kardidat = $conn->get_data_grafik_voting();

$paslon_results = $conn->get_paslon_results();
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Live Quick Count Hasil Voting</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="assets/scripts/tailwind.config.js"></script>
    <!-- Chart.js & Lucide Icons -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://unpkg.com/lucide@latest"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style> body { font-family: 'Inter', sans-serif; } </style>
</head>
<body class="bg-slate-100 text-slate-100 min-h-screen flex flex-col justify-between">

    <!-- header  : desktop -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 py-4">
            
            <!-- Navbar : Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="vote" class="w-8 h-8"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xl tracking-wide uppercase text-brand-yellow">E-Vote OSIS</h1>
                    <p class="text-xs text-slate-400 hidden md:block">SMK Informatika Sumedang</p>
                    <p class="text-xs text-slate-400 block md:hidden uppercase"><?= $_SESSION['nama'];?></p>
                </div>
            </div>

            <!-- Navbar : Navigation desktop & mobile top -->
            <div class="hidden md:flex justify-center items-center gap-4">
                <a href="voting.php" class="inline-flex items-center gap-1.5 px-4 py-2 text-md font-semibold text-slate-300 hover:text-brand-yellow transition-colors">
                    <i data-lucide="bar-chart-3" class="w-6 h-6"></i>Voting
                </a>
                <a href="hasil.php" class="inline-flex items-center gap-1.5 text-md font-bold text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 px-4 py-2 rounded-lg shadow-md transition-all">
                    <i data-lucide="vote" class="w-6 h-6"></i>Hasil
                </a>
            </div>

            <!-- Navbar : User Info & Logout -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm text-white font-semibold uppercase"><?= $_SESSION['nama'];?></p>
                    <p class="text-xs text-slate-400 uppercase"><?= $_SESSION['kelas'];?></p>
                </div>
                
                <button type="button" onclick="logout()" class="flex items-center bg-red-500 hover:bg-red-600 p-2 md:p-3 text-sm md:text-base text-white font-semibold rounded-lg transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4 md:w-5 md:h-5"></i>
                    <span class="hidden sm:block ml-2">Logout</span>
                </button>
            </div>
            
        </div>
    </header>

    <!-- navbar : mobile bottom -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-t border-slate-800 px-4 py-3">
        
        <!-- Navbar : Navigation mobile bottom -->
        <div class="flex justify-center items-center gap-4 w-full">
            <a href="voting.php" class="inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-slate-300 hover:text-brand-yellow transition-colors px-5 py-2.5 w-1/2">
                <i data-lucide="vote" class="w-6 h-6"></i> Voting
            </a>
            <a href="hasil.php" class="inline-flex items-center justify-center gap-1.5 text-sm font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-5 py-2.5 rounded-xl shadow-md transition-all w-1/2">
                <i data-lucide="bar-chart-3" class="w-6 h-6"></i> Hasil
            </a>
        </div>
    </nav>

    <!-- section : hero section -->
    <header class=" grid items-center py-10 px-4 border-b border-slate-100 bg-slate-100 backdrop-blur-md">
        <div class="max-w-4xl mx-auto text-center space-y-3">
            <div class="py-6 space-y-4">
                
                <!-- hero : icon -->
                <div class="flex justify-center">
                    <div class="flex justify-center items-center bg-gradient-to-br from-amber-500 to-amber-300 rounded-xl shadow-md transition-all w-20 h-20">
                        <i data-lucide="bar-chart-3" class="w-10 h-10 stroke-[3]"></i>
                    </div>
                </div>
        
                <!-- hero : heading -->
                <h1 class="text-navy-900 text-3xl sm:text-5xl font-extrabold text- tracking-tight">
                    Hasil Voting OSIS
                </h1>
                
                <!-- hero : description -->
                <p class="text-slate-600 text-sm sm:text-base max-w-xl mx-auto">
                    Data diperbarui secara real-time setiap 5 detik
                </p>

                <!-- label : live -->
                <div class="inline-flex items-center gap-2.5 px-4 py-1.5 bg-white border border-green-300 rounded-full shadow-sm">
                    <div class="relative flex h-3.5 w-3.5 items-center justify-center">
                        <span class="absolute inline-flex h-full w-full animate-ping rounded-full bg-green-400 opacity-75"></span>
                        <span class="relative inline-flex h-2.5 w-2.5 rounded-full bg-green-500"></span>       
                    </div>
                    <span class="text-sm font-semibold text-teal-600">Live Update</span>        
                </div>
            </div>
        </div>
    </header>

    <!-- section : statis -->
    <main class="max-w-7xl mx-auto px-4  sm:px-6 w-full space-y-12 my-10">
        <!-- statis : jumlah voting -->
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                
            <!-- card : totak suara -->
                <div class="relative overflow-hidden bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl p-6 text-white shadow-lg shadow-cyan-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Total Suara</span>
                            <div class="text-4xl font-extrabold text-white"><?= number_format($totalSiswa['sudah_voting']); ?></div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="bar-chart-3" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>
                
                <!-- card : partisipasi -->
                <div class="relative overflow-hidden bg-gradient-to-br from-emerald-400 to-teal-600 rounded-2xl p-6 text-white shadow-lg shadow-emerald-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-emerald-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Partisipasi</span>
                            <div class="text-4xl font-extrabold text-white"><?= number_format($totalSiswa['persen_sudah']); ?>%</div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="users" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>
                
                <!-- card : belum voting -->
                <div class="relative overflow-hidden bg-gradient-to-br from-amber-400 to-orange-500 rounded-2xl p-6 text-white shadow-lg shadow-amber-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-amber-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Belum Voting</span>
                            <div class="text-4xl font-extrabold text-white"><?= number_format($totalSiswa['persen_belum']); ?>%</div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="check-circle-2" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>

                <!-- card : total kardidat -->
                <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-700 rounded-2xl p-6 text-white shadow-lg shadow-green-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-green-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Kandidat</span>
                            <div class="text-4xl font-extrabold text-white"><?= $totalSiswa['kardidat']; ?></div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="award" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>
        
            </div>
        </section>

        <!-- statis : kardidat diagram -->
        <section class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            
            <!-- 1. Chart Donat -->
            <div class="bg-white border  border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-shadow hover:shadow-md">
                <div class="w-full">
                    <h3 class="text-base font-bold text-slate-800">Persentase Suara</h3>
                    <p class="text-xs text-slate-500 mb-6">Diagram Donat / Doughnut Chart</p>
                </div>
                
                <div class="relative w-full max-w-[280px] aspect-square flex items-center justify-center mx-auto">
                    <canvas id="voteChart"></canvas>
                </div>
            </div>

            <!-- 2. Diagram Batang (Bar Chart) -->
            <div class="bg-white border border-slate-200 rounded-3xl p-6 shadow-sm flex flex-col justify-between transition-shadow hover:shadow-md">
                <div class="w-full">
                    <h3 class="text-base font-bold text-slate-800">Perbandingan Perolehan Suara</h3>
                    <p class="text-xs text-slate-500 mb-6">Diagram Batang / Bar Chart</p>
                </div>
                
                <div class="relative w-full h-[280px]">
                    <canvas id="barChart"></canvas>
                </div>
            </div>

        </section>

        <!-- statis : kardidat progress -->
        <section class="space-y-4">
            <h3 class="text-xl font-extrabold text-white">Progress Perolehan Kandidat</h3>

            <div class="grid grid-cols-1 gap-4">
                <?php foreach ($paslon_results as $paslon): ?>
                <div class="bg-slate-900/90 border border-slate-800 rounded-2xl p-5 shadow-xl">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-3">
                        <div class="flex items-center gap-3">
                            <span class="w-10 h-10 rounded-xl bg-[<?= $paslon['warna'] ?>] text-brand-dark font-extrabold text-sm flex items-center justify-center shrink-0 shadow-md">
                                <?= $paslon['no_urut'] ?>
                            </span>
                            <div>
                                <h4 class="text-base font-bold text-white"><?= $paslon['nama'] ?></h4>
                                <p class="text-xs text-slate-400">Paslon Nomor Urut <?= $paslon['no_urut'] ?></p>
                            </div>
                        </div>

                        <div class="flex items-center justify-between sm:justify-end gap-4 text-right">
                            <div>
                                <span class="text-2xl font-extrabold text-brand-yellow"><?= number_format($paslon['suara']) ?></span>
                                <span class="text-xs text-slate-400 block">Suara</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-950 rounded-full h-5.5 p-0.5 border border-slate-800 overflow-hidden">
                        <div class="h-3.5 rounded-full transition-all duration-1000 text-xs font-bold text-right px-3" style="width: <?= $paslon['persen'] ?>%; background-color: <?= $paslon['warna'] ?>;"><?= number_format($paslon['persen']);?>%</div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </section>

    </main>


    <!-- section : footer -->
    <footer class="bg-slate-950 border-t border-slate-900 py-6 text-center text-sm text-slate-500">
        &copy; 2026 Febri Pratama — All rights reserved. 
    </footer>

    <!-- script : js -->
<script>
    // 1. Inisialisasi Icon Lucide
    lucide.createIcons();

    // 2. Mengambil Data Paslon dari PHP dengan Aman
    const paslonLabels = <?= json_encode(array_column($paslon_results, 'nama')); ?>;
    const paslonSuara  = <?= json_encode(array_column($paslon_results, 'suara'), JSON_NUMERIC_CHECK); ?>;

    // 3. Timer Real-Time Hitung Mundur (Sinkronisasi Data)
    let seconds = 5;
    const syncElem = document.getElementById('syncTime');
    if (syncElem) {
        setInterval(() => {
            seconds--;
            if (seconds <= 0) seconds = 5;
            syncElem.innerText = seconds + 's';
        }, 1000);
    }

    // 4. Konfigurasi Chart.js
    const ctxDonut = document.getElementById('voteChart').getContext('2d');
    const ctxBar   = document.getElementById('barChart').getContext('2d');

    // Fungsi untuk membuat warna gradien
    function createGradient(ctx, colorStart, colorEnd) {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400); 
        gradient.addColorStop(0, colorStart);
        gradient.addColorStop(1, colorEnd);
        return gradient;
    }

    // Meracik warna gradien sesuai dengan gambar (Pastel Neon)
    // Dibuat terpisah untuk Canvas Donut dan Canvas Bar agar warnanya tidak error
    const gradDonut = [
        <?php foreach ($paslon_results as $row) { ?>
            "<?= $row['warna']; ?>",
        <?php } ?>
    ];

    const gradBar = [
        <?php foreach ($paslon_results as $row) { ?>
            "<?= $row['warna']; ?>",
        <?php } ?>
    ];

    // --- A. Eksekusi Chart Donat ---
    new Chart(ctxDonut, {
        type: 'doughnut', 
        data: {
            labels: paslonLabels,
            datasets: [{
                data: paslonSuara,
                backgroundColor: gradDonut,
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 12,
                borderRadius: 6
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    position: 'bottom',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        color: '#475569',
                        font: { family: "'Inter', sans-serif", size: 13, weight: 'bold' }
                    }
                },
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 14, family: "'Inter', sans-serif" },
                    bodyFont: { size: 13, family: "'Inter', sans-serif" },
                    padding: 12,
                    cornerRadius: 8,
                    displayColors: true,
                    boxPadding: 4
                }
            },
            cutout: '60%'
        }
    });

    // --- B. Eksekusi Diagram Batang ---
    new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: paslonLabels,
            datasets: [{
                label: 'Jumlah Suara',
                data: paslonSuara,
                backgroundColor: gradBar, // Menggunakan gradien khusus Bar
                borderRadius: 8,
                barThickness: 60,
                borderColor: '#ffffff',
                borderWidth: 4,
                hoverOffset: 12
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { display: false }, // Legend disembunyikan
                tooltip: {
                    backgroundColor: 'rgba(15, 23, 42, 0.9)',
                    titleFont: { size: 14, family: "'Inter', sans-serif" },
                    bodyFont: { size: 13, family: "'Inter', sans-serif" },
                    padding: 12,
                    cornerRadius: 8
                }
            },
            scales: {
                x: { 
                    ticks: { color: '#64748B', font: { family: "'Inter', sans-serif", weight: '500' } }, 
                    grid: { display: false } 
                },
                y: { 
                    beginAtZero: true,
                    ticks: { 
                        color: '#64748B', 
                        font: { family: "'Inter', sans-serif" },
                        stepSize: 1 // Angka tidak berbentuk desimal (misal 1.5)
                    }, 
                    grid: { color: '#F1F5F9' } 
                }
            }
        }
    });
</script>
</body>
</html>