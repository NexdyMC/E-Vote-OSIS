<?php
/* =========================================================
   DASHBOARD.PHP — Statistik Voting (Admin Panel)
   SMK Informatika Sumedang — Sistem E-Voting OSIS
   ---------------------------------------------------------
   Di aplikasi nyata, seluruh angka di bawah ini diambil dari
   database / API perhitungan suara (contoh: SELECT COUNT(*)
   FROM suara, dsb). Di sini memakai data dummy agar tampilan
   bisa langsung dicoba.
   ========================================================= */
session_start();

// --- Data admin (fallback dummy bila belum ada session login admin) ---
$admin = $_SESSION['admin'] ?? [
    'nama' => 'Bu Rina Marlina, S.Kom',
    'foto' => 'https://i.pravatar.cc/150?img=47',
    'role' => 'Admin Pemilu',
];

// --- Data dummy statistik (ganti dengan query DB / hasil API) ---
$totalDPT = 1240;

$suaraKandidat = [
    ['nomor' => 1, 'nama' => 'Aditya Pratama & Salsa Nabila',     'suara' => 356],
    ['nomor' => 2, 'nama' => 'Bima Nugraha & Keisya Aulia',       'suara' => 289],
    ['nomor' => 3, 'nama' => 'Citra Ramadhani & Farrel Hidayat',  'suara' => 201],
];

// --- Logika PHP sederhana: hitung total & persentase ---
$totalSuaraMasuk = array_sum(array_column($suaraKandidat, 'suara'));
$partisipasi     = $totalDPT > 0 ? round(($totalSuaraMasuk / $totalDPT) * 100, 1) : 0;
$belumMemilih    = $totalDPT - $totalSuaraMasuk;

foreach ($suaraKandidat as &$k) {
    $k['persen'] = $totalSuaraMasuk > 0 ? round(($k['suara'] / $totalSuaraMasuk) * 100, 1) : 0;
}
unset($k);
// urutkan peringkat dari suara terbanyak
usort($suaraKandidat, fn($a, $b) => $b['suara'] <=> $a['suara']);

// Target waktu voting berakhir (untuk penghitung mundur ringkas di kartu gelap)
$waktuVotingBerakhir = strtotime('+1 day +6 hours');

$pageTitle  = 'Statistik Voting';
$breadcrumb = ['Admin', 'Statistik Voting'];
$activePage = 'dashboard';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<title>Statistik Voting — Admin E-Voting OSIS</title>
<?php require __DIR__ . '/partials/head-assets.php'; ?>
</head>
<body class="bg-[#F8FAFC]">

<div class="flex min-h-screen">
  <?php require __DIR__ . '/partials/sidebar.php'; ?>

  <main class="flex-1 min-w-0">
    <?php require __DIR__ . '/partials/topbar.php'; ?>

    <div class="p-4 sm:p-8 space-y-8">

      <!-- ============ STAT CARDS ============ -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">

        <div data-aos="fade-up" class="card-hover bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
          <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
            <i data-lucide="users" class="w-5 h-5 text-primary-700"></i>
          </div>
          <p class="text-2xl font-display font-bold text-navy-900"><?= number_format($totalDPT, 0, ',', '.') ?></p>
          <p class="text-sm text-slate-500 mt-1">Total Siswa (DPT)</p>
        </div>

        <div data-aos="fade-up" data-aos-delay="80" class="card-hover bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
          <div class="w-11 h-11 rounded-xl bg-accent-400/15 flex items-center justify-center mb-4">
            <i data-lucide="check-circle-2" class="w-5 h-5 text-accent-500"></i>
          </div>
          <p class="text-2xl font-display font-bold text-navy-900"><?= number_format($totalSuaraMasuk, 0, ',', '.') ?></p>
          <p class="text-sm text-slate-500 mt-1">Suara Masuk</p>
        </div>

        <div data-aos="fade-up" data-aos-delay="160" class="card-hover bg-white rounded-2xl p-6 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
          <div class="w-11 h-11 rounded-xl bg-primary-50 flex items-center justify-center mb-4">
            <i data-lucide="percent" class="w-5 h-5 text-primary-700"></i>
          </div>
          <p class="text-2xl font-display font-bold text-navy-900"><?= $partisipasi ?>%</p>
          <p class="text-sm text-slate-500 mt-1">Tingkat Partisipasi</p>
        </div>

        <!-- Kartu gelap: kontribusi tema dark di halaman terang -->
        <div data-aos="fade-up" data-aos-delay="240" class="card-hover bg-navy-900 rounded-2xl p-6 relative overflow-hidden">
          <div class="absolute -right-6 -top-6 w-28 h-28 bg-accent-400/10 rounded-full blur-2xl"></div>
          <div class="w-11 h-11 rounded-xl bg-white/10 flex items-center justify-center mb-4">
            <i data-lucide="timer" class="w-5 h-5 text-accent-400"></i>
          </div>
          <p id="sisaWaktuText" class="text-2xl font-display font-bold text-white">--</p>
          <p class="text-sm text-slate-400 mt-1">Sisa Waktu Voting</p>
        </div>
      </div>

      <!-- ============ CHARTS ============ -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        <!-- Bar chart: dark panel -->
        <div data-aos="fade-up" class="lg:col-span-2 bg-navy-900 rounded-3xl p-6 sm:p-8">
          <div class="flex items-center justify-between mb-6">
            <div>
              <h3 class="font-display font-semibold text-white">Perolehan Suara per Kandidat</h3>
              <p class="text-xs text-slate-400 mt-1">Diperbarui otomatis dari API perhitungan suara</p>
            </div>
            <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-sky-300 bg-sky-400/10 px-2.5 py-1 rounded-full shrink-0">
              <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span> LIVE
            </span>
          </div>
          <div class="h-72">
            <canvas id="chartSuara"></canvas>
          </div>
        </div>

        <!-- Doughnut chart: light panel -->
        <div data-aos="fade-up" data-aos-delay="120" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
          <h3 class="font-display font-semibold text-navy-900 mb-1">Partisipasi Pemilih</h3>
          <p class="text-xs text-slate-500 mb-6">Sudah memilih vs belum memilih</p>
          <div class="h-56">
            <canvas id="chartPartisipasi"></canvas>
          </div>
          <div class="flex items-center justify-center gap-6 mt-6 text-sm">
            <span class="flex items-center gap-2 text-navy-700"><span class="w-2.5 h-2.5 rounded-full bg-primary-700"></span>Sudah Memilih</span>
            <span class="flex items-center gap-2 text-navy-700"><span class="w-2.5 h-2.5 rounded-full bg-slate-200"></span>Belum Memilih</span>
          </div>
        </div>
      </div>

      <!-- ============ RANKING LIST ============ -->
      <div data-aos="fade-up" class="bg-white rounded-3xl p-6 sm:p-8 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
        <h3 class="font-display font-semibold text-navy-900 mb-6">Peringkat Perolehan Suara</h3>

        <div class="space-y-5">
          <?php foreach ($suaraKandidat as $i => $k): ?>
            <?php $warna = $i === 0 ? 'bg-accent-400' : 'bg-primary-600'; ?>
            <div>
              <div class="flex items-center justify-between mb-1.5 text-sm">
                <span class="font-medium text-navy-800">Paslon <?= $k['nomor'] ?> — <?= htmlspecialchars($k['nama']) ?></span>
                <span class="text-slate-500"><?= number_format($k['suara'], 0, ',', '.') ?> suara (<?= $k['persen'] ?>%)</span>
              </div>
              <div class="w-full h-2.5 rounded-full bg-slate-100 overflow-hidden">
                <div class="<?= $warna ?> h-full rounded-full transition-all duration-700" style="width: <?= $k['persen'] ?>%"></div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      </div>

    </div>
  </main>
</div>

<!-- Chart.js -->

<script>
  // Data dikirim dari PHP -> JS (di aplikasi nyata bisa lewat endpoint API/JSON)
  const dataSuara = <?= json_encode($suaraKandidat) ?>;
  const totalSuaraMasuk = <?= (int) $totalSuaraMasuk ?>;
  const belumMemilih = <?= (int) $belumMemilih ?>;

  // ---- Bar chart: perolehan suara per kandidat ----
  new Chart(document.getElementById('chartSuara'), {
    type: 'bar',
    data: {
      labels: dataSuara.map(k => 'Paslon ' + k.nomor),
      datasets: [{
        label: 'Jumlah Suara',
        data: dataSuara.map(k => k.suara),
        backgroundColor: ['#FACC15', '#2563EB', '#38BDF8'],
        borderRadius: 10,
        maxBarThickness: 60,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: {
        x: { ticks: { color: '#CBD5E1' }, grid: { display: false } },
        y: { ticks: { color: '#94A3B8' }, grid: { color: 'rgba(255,255,255,.06)' } },
      }
    }
  });

  // ---- Doughnut chart: partisipasi pemilih ----
  new Chart(document.getElementById('chartPartisipasi'), {
    type: 'doughnut',
    data: {
      labels: ['Sudah Memilih', 'Belum Memilih'],
      datasets: [{
        data: [totalSuaraMasuk, belumMemilih],
        backgroundColor: ['#1E3A8A', '#E2E8F0'],
        borderWidth: 0,
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '72%',
      plugins: { legend: { display: false } },
    }
  });

  // ---- Sisa waktu voting (ringkas) ----
  const targetWaktu = <?= $waktuVotingBerakhir ?> * 1000;
  function updateSisaWaktu() {
    const sisa = targetWaktu - Date.now();
    const el = document.getElementById('sisaWaktuText');
    if (sisa <= 0) { el.textContent = 'Selesai'; return; }
    const h = Math.floor(sisa / 3600000);
    const m = Math.floor((sisa % 3600000) / 60000);
    const s = Math.floor((sisa % 60000) / 1000);
    el.textContent = `${h}j ${m}m ${s}d`;
  }
  updateSisaWaktu();
  setInterval(updateSisaWaktu, 1000);
</script>

<?php require __DIR__ . '/partials/scripts-base.php'; ?>
</body>
</html>
