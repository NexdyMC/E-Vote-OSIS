<?php
require_once __DIR__ . "/api/conn.php";
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit;
}

$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

$totalSiswa = $conn->persen_voting_siswa();

$total_pemilih_terdaftar= $totalSiswa['total_siswa'];
$total_suara_masuk      = $totalSiswa['sudah_voting'];
$suara_belum_memilih    = $total_pemilih_terdaftar - $total_suara_masuk;
$persentase_partisipasi = round(($total_suara_masuk / $total_pemilih_terdaftar) * 100, 1);

$activePage = 'hasil'; 

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

    <?php  if (!$is_ajax) {
        require_once __DIR__ . '/layout/partials/topbar.php'; 
    } ?>

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
                    <span class="text-sm font-semibold text-teal-600">Live Update <span id="syncTime" class="ml-1 text-teal-500">5s</span></span>        
                    <i data-lucide="refresh-cw" id="syncIcon" class="w-3.5 h-3.5 text-teal-600 transition-all"></i>
                </div>
            </div>
        </div>
    </header>

    <!-- section : statis -->
    <main class="max-w-7xl mx-auto px-4  sm:px-6 w-full space-y-12 my-10">
        <!-- statis : jumlah voting -->
        <section>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5">
                
                <!-- card : total suara -->
                <div class="relative overflow-hidden bg-gradient-to-br from-cyan-400 to-blue-500 rounded-2xl p-6 text-white shadow-lg shadow-cyan-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-cyan-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Total Suara</span>
                            <!-- Ditambahkan class animate-number dan data-value -->
                            <div id="val-total-suara" class="text-4xl font-extrabold text-white animate-number" data-value="<?= $totalSiswa['sudah_voting']; ?>" data-is-percent="false">0</div>
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
                            <div id="val-partisipasi" class="text-4xl font-extrabold text-white animate-number" data-value="<?= $totalSiswa['persen_sudah']; ?>" data-is-percent="true">0%</div>
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
                            <div id="val-belum-voting" class="text-4xl font-extrabold text-white animate-number" data-value="<?= $totalSiswa['persen_belum']; ?>" data-is-percent="true">0%</div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="check-circle-2" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>

                <!-- card : total kandidat -->
                <div class="relative overflow-hidden bg-gradient-to-br from-green-500 to-emerald-700 rounded-2xl p-6 text-white shadow-lg shadow-green-500/30 transition-all duration-300 hover:-translate-y-1 hover:shadow-green-500/50">
                    <div class="absolute -right-6 -top-6 w-24 h-24 rounded-full bg-white/20 blur-2xl"></div>
                    <div class="relative z-10 flex justify-between items-start">
                        <div>
                            <span class="text-sm font-semibold tracking-wider">Kandidat</span>
                            <div class="text-4xl font-extrabold text-white animate-number" data-value="<?= $totalSiswa['kandidat']; ?>" data-is-percent="false">0</div>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl backdrop-blur-sm border border-white/20">
                            <i data-lucide="award" class="w-10 h-10 stroke-[2]"></i>
                        </div>
                    </div>
                </div>
        
            </div>
        </section>

        <!-- statis : kandidat diagram -->
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

        <!-- statis : kandidat progress -->
        <section class="space-y-4">
            <h3 class="text-xl font-extrabold text-navy-800">Progress Perolehan Kandidat</h3>

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
                                <!-- Ditambahkan class animate-number dan ID dinamis -->
                                <span id="val-suara-<?= $paslon['no_urut'] ?>" class="text-2xl font-extrabold text-brand-yellow animate-number" data-value="<?= $paslon['suara'] ?>" data-is-percent="false">0</span>
                                <span class="text-xs text-slate-400 block">Suara</span>
                            </div>
                        </div>
                    </div>

                    <!-- Progress Bar -->
                    <div class="w-full bg-slate-950 rounded-full h-5.5 p-0.5 border border-slate-800 overflow-hidden">
                        <div id="bar-paslon-<?= $paslon['no_urut'] ?>" class="h-3.5 rounded-full transition-all duration-1000 text-xs font-bold text-right px-3" style="width: <?= $paslon['persen'] ?>%; background-color: <?= $paslon['warna'] ?>;">
                            <span id="val-persen-<?= $paslon['no_urut'] ?>" class="animate-number" data-value="<?= $paslon['persen'] ?>" data-is-percent="true">0%</span>
                        </div>
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

    lucide.createIcons();

    function logout() {
        window.location.href = "logout.php";
    }
    
    function animateValue(obj, start, end, duration, isPercent = false) {
        let startTimestamp = null;
        const step = (timestamp) => {
            if (!startTimestamp) startTimestamp = timestamp;
        
            const progress = Math.min((timestamp - startTimestamp) / duration, 1);
        
            const easeOut = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
            let currentVal = Math.floor(easeOut * (end - start) + start);
            
        
            obj.innerHTML = currentVal.toLocaleString('id-ID') + (isPercent ? '%' : '');
            
            if (progress < 1) {
                window.requestAnimationFrame(step);
            } else {
            
                obj.innerHTML = end.toLocaleString('id-ID') + (isPercent ? '%' : '');
            }
        };
        window.requestAnimationFrame(step);
    }


    document.addEventListener("DOMContentLoaded", () => {
        document.querySelectorAll('.animate-number').forEach(elem => {
            let endVal = parseFloat(elem.getAttribute('data-value'));
            let isPercent = elem.getAttribute('data-is-percent') === 'true';
            animateValue(elem, 0, endVal, 1500, isPercent);
        });
    });


    const paslonLabels = <?= json_encode(array_column($paslon_results, 'nama')); ?>;
    const paslonSuara  = <?= json_encode(array_column($paslon_results, 'suara'), JSON_NUMERIC_CHECK); ?>;

    const ctxDonut = document.getElementById('voteChart').getContext('2d');
    const ctxBar   = document.getElementById('barChart').getContext('2d');

    const gradDonut = [<?php foreach ($paslon_results as $row) { echo "'" . $row['warna'] . "',"; } ?>];
    const gradBar   = [<?php foreach ($paslon_results as $row) { echo "'" . $row['warna'] . "',"; } ?>];


    const chartDonut = new Chart(ctxDonut, {
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
            responsive: true, maintainAspectRatio: false,
            plugins: {
                legend: { position: 'bottom', labels: { usePointStyle: true, padding: 20, color: '#475569', font: { family: "'Inter', sans-serif", size: 13, weight: 'bold' } } }
            }, cutout: '60%'
        }
    });

    const chartBar = new Chart(ctxBar, {
        type: 'bar',
        data: {
            labels: paslonLabels,
            datasets: [{
                label: 'Jumlah Suara',
                data: paslonSuara,
                backgroundColor: gradBar, borderRadius: 8, barThickness: 60, borderColor: '#ffffff', borderWidth: 4, hoverOffset: 12
            }]
        },
        options: {
            responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } },
            scales: {
                x: { ticks: { color: '#64748B', font: { family: "'Inter', sans-serif", weight: '500' } }, grid: { display: false } },
                y: { beginAtZero: true, ticks: { color: '#64748B', font: { family: "'Inter', sans-serif" }, stepSize: 1 }, grid: { color: '#F1F5F9' } }
            }
        }
    });

    let seconds = 5;
    const syncElem = document.getElementById('syncTime');
    const syncIcon = document.getElementById('syncIcon');

    function fetchLiveData() {
        if (syncIcon) syncIcon.classList.add('animate-spin');

        fetch('api/kandidat.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ type: 'statistik' }) 
        })
        .then(response => response.json())
        .then(result => {
            if (result.status === 'success') {
                const dataBaru = result.suaraKandidat; 
                const suaraBaru = dataBaru.map(k => k.suara);

                chartDonut.data.datasets[0].data = suaraBaru;
                chartDonut.update();
                chartBar.data.datasets[0].data = suaraBaru;
                chartBar.update();

                dataBaru.forEach((k) => {
                    let elSuara = document.getElementById('val-suara-' + k.no_urut);
                    if (elSuara) {
                        let currentVal = parseFloat(elSuara.getAttribute('data-value'));
                        if (currentVal !== k.suara) {
                            elSuara.setAttribute('data-value', k.suara);
                            animateValue(elSuara, 0, k.suara, 1500, false); 
                            
                            if (result.totalMasuk) {
                                let persenVal = ((k.suara / result.totalMasuk) * 100).toFixed(1);
                                if (isNaN(persenVal)) persenVal = 0;
                                
                                let elPersen = document.getElementById('val-persen-' + k.no_urut);
                                let elBar = document.getElementById('bar-paslon-' + k.no_urut);
                                
                                if (elPersen) {
                                    elPersen.setAttribute('data-value', persenVal);
                                    animateValue(elPersen, 0, persenVal, 1500, true);
                                    if (elBar) elBar.style.width = persenVal + '%';
                                }
                            }
                        }
                    }
                });

                if (result.totalMasuk && result.totalDPT) {
                    let elTotalSuara = document.getElementById('val-total-suara');
                    let elPartisipasi = document.getElementById('val-partisipasi');
                    let elBelumVoting = document.getElementById('val-belum-voting');

                    let pSudah = ((result.totalMasuk / result.totalDPT) * 100).toFixed(1);
                    let pBelum = (((result.totalDPT - result.totalMasuk) / result.totalDPT) * 100).toFixed(1);

                    if (elTotalSuara && elTotalSuara.getAttribute('data-value') != result.totalMasuk) {
                        elTotalSuara.setAttribute('data-value', result.totalMasuk);
                        animateValue(elTotalSuara, 0, result.totalMasuk, 1500, false);
                    }
                    if (elPartisipasi && elPartisipasi.getAttribute('data-value') != pSudah) {
                        elPartisipasi.setAttribute('data-value', pSudah);
                        animateValue(elPartisipasi, 0, pSudah, 1500, true);
                    }
                    if (elBelumVoting && elBelumVoting.getAttribute('data-value') != pBelum) {
                        elBelumVoting.setAttribute('data-value', pBelum);
                        animateValue(elBelumVoting, 0, pBelum, 1500, true);
                    }
                }
            }
        })
        .catch(error => console.error('Gagal mengambil data live:', error))
        .finally(() => {
            setTimeout(() => {
                if (syncIcon) syncIcon.classList.remove('animate-spin');
            }, 500);
        });
    }

    if (syncElem) {
        setInterval(() => {
            seconds--;
            if (seconds <= 0) {
                seconds = 5;       
                fetchLiveData();   
            }
            syncElem.innerText = seconds + 's';
        }, 1000);
    }
</script>
</body>
</html>