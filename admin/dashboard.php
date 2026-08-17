<?php
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';
require_once __DIR__ . "/../api/conn.php"; 

if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit;
}

if (isset($_POST["submit_kandidat"])) {

    // PENTING: sesuaikan "text-nama" dengan atribut name= input nama
    // kandidat di form HTML kamu, kalau berbeda.
    $nama = $_POST["text-nama"] ?? '';
    $visi = $_POST["text-visi"];
    $misi = $_POST["text-misi"];

    $nama_file_baru = random_id(8);
    // Disamakan dengan folder yang dipakai api/kandidat.php ("../upload/photo/")
    // supaya foto kandidat yang diupload lewat dashboard maupun lewat API
    // tersimpan di folder yang sama.
    $folder_tujuan = "../upload/photo/";

    $upload_foto = $conn->upload_image($folder_tujuan, $nama_file_baru, 'photo');

    if ($upload_foto) {
        $simpan = $conn->add_kandidat($nama, $visi, $misi, $nama_file_baru);
        if ($simpan) {
            header("Location: dashboard.php?v=true");
            exit;
        }
    }
    
    header("Location: dashboard.php?v=false");
    exit;
}

$pesan_alert = "";
if (isset($_GET["v"])) {
  $status = $_GET["v"]; 
  if ($status  == "true") { 
    $pesan_alert = "<div class='p-4 mb-4 text-sm text-green-800 rounded-lg bg-green-50 font-bold'>Data Kandidat berhasil disimpan!</div>";
  } 
  if ($status == "false") { 
    $pesan_alert = "<div class='p-4 mb-4 text-sm text-red-800 rounded-lg bg-red-50 font-bold'>Gagal menyimpan data kandidat!</div>";
  }
}

$admin = $_SESSION['admin'] ?? [
    'nama' => 'Bu Rina Marlina, S.Kom', 
    'foto' => 'https://i.pravatar.cc/150?img=47', 
    'role' => 'Admin Pemilu', 
];

$statistik = $conn->persen_voting_siswa();
$totalDPT = $statistik['total_siswa'];
$totalSuaraMasuk = $statistik['sudah_voting'];
$partisipasi = $statistik['persen_sudah'];

$suaraKandidat = $conn->get_paslon_results();

$pageTitle  = 'Statistik Voting'; 
$breadcrumb = ['Admin', 'Statistik Voting']; 
$activePage = 'dashboard'; 


if (!$is_ajax) {
    require_once __DIR__ . '/../layout/admin/header.php';
    require_once __DIR__ . '/../layout/admin/sidebar.php';
    require_once __DIR__ . '/../layout/admin/navbar.php';
    ?>
    <main id="main-content" class="flex-1 p-4 sm:p-8 overflow-y-auto">
<?php }; ?>
    
    <div class="p-4 sm:p-8 space-y-8">
      <div class="mb-6">
        <h2 class="font-display font-semibold text-navy-900 text-2xl">Statistik Voting</h2>
        <p class="text-sm text-slate-500 mt-1">Pantau perolehan suara sementara dan tingkat partisipasi pemilih secara real-time.</p>
      </div>
      <!-- Tampilkan Alert Jika Ada -->
      <?= $pesan_alert ?>

      <!-- 4 KARTU STATISTIK ATAS -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <div class="bg-white rounded-2xl p-6 border shadow-sm">
          <!-- Ditambahkan class animate-number dan ID val-dpt -->
          <p id="val-dpt" class="text-2xl font-display font-bold text-navy-900 animate-number" data-value="<?= $totalDPT ?>" data-is-percent="false">0</p>
          <p class="text-sm text-slate-500">Total Siswa Voting</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border shadow-sm">
          <!-- Ditambahkan class animate-number dan ID val-suara-masuk -->
          <p id="val-suara-masuk" class="text-2xl font-display font-bold text-navy-900 animate-number" data-value="<?= $totalSuaraMasuk ?>" data-is-percent="false">0</p>
          <p class="text-sm text-slate-500">Suara Masuk</p>
        </div>
        <div class="bg-white rounded-2xl p-6 border shadow-sm">
          <!-- Ditambahkan class animate-number dan ID val-partisipasi -->
          <p id="val-partisipasi" class="text-2xl font-display font-bold text-navy-900 animate-number" data-value="<?= $partisipasi ?>" data-is-percent="true">0%</p>
          <p class="text-sm text-slate-500">Tingkat Partisipasi</p>
        </div>
        <div class="bg-navy-900 rounded-2xl p-6">
          <p id="sisaWaktuText" class="text-2xl font-display font-bold text-white">LIVE</p>
          <p class="text-sm text-slate-400">Status Pemilihan</p>
        </div>
      </div>

      <!-- CHART AREA -->
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-navy-900 rounded-3xl p-6 sm:p-8 text-white">
          <h3 class="font-display font-semibold mb-6">Perolehan Suara per Kandidat</h3>
          <div class="h-72"><canvas id="chartSuara"></canvas></div>
        </div>
        <div class="bg-white rounded-3xl p-6 sm:p-8 border shadow-sm">
          <h3 class="font-display font-semibold mb-6">Partisipasi Pemilih</h3>
          <div class="h-56"><canvas id="chartPartisipasi"></canvas></div>
        </div>
      </div>

      <hr class="my-8">
      <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border overflow-x-auto">
          <h3 class="font-display font-semibold text-lg mb-4">Data Pemilih (Siswa)</h3>
          <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-slate-600">
              <tr>
                <th class="p-3 rounded-l-lg">Token</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Kelas</th>
                <th class="p-3">Status</th>
              </tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
              <?php
              $hasil = $conn->mysql_select("tb_siswa");
              foreach ($hasil as $row){ ?>
              <tr class="hover:bg-slate-50">
                <td class="p-3 font-mono text-primary-600"><?= $row["token"] ?></td>
                <td class="p-3 font-medium text-navy-900"><?= $row["nama"] ?></td>
                <td class="p-3"><?= $row["kelas"] ?></td>
                <td class="p-3">
                    <?php if($row["status"] == 1): ?>
                        <span class="bg-green-100 text-green-700 px-2 py-1 rounded text-xs font-bold">Sudah Memilih</span>
                    <?php else: ?>
                        <span class="bg-red-100 text-red-700 px-2 py-1 rounded text-xs font-bold">Belum</span>
                    <?php endif; ?>
                </td>
              </tr>
              <?php }; ?>
            </tbody>  
          </table>
        </div>
      </div>
    </div>
  <?php if (!$is_ajax): ?>
    </main>
  <?php endif; ?>

<script>
  lucide.createIcons();
  
  // Jika menggunakan library AOS
  if (typeof AOS !== 'undefined') {
      AOS.init({ duration: 550, once: true, offset: 40 });
  }

  // ==========================================
  // Fungsi Animasi Reload Nomor dari 0
  // ==========================================
  function animateValue(obj, start, end, duration, isPercent = false) {
      let startTimestamp = null;
      const step = (timestamp) => {
          if (!startTimestamp) startTimestamp = timestamp;
          const progress = Math.min((timestamp - startTimestamp) / duration, 1);
          // Efek melambat di akhir
          const easeOut = progress === 1 ? 1 : 1 - Math.pow(2, -10 * progress);
          
          let currentVal = isPercent 
              ? (easeOut * (end - start) + start).toFixed(1) 
              : Math.floor(easeOut * (end - start) + start);
          
          // Format sesuai tipe data
          if (isPercent) {
              obj.innerHTML = currentVal + '%';
          } else {
              obj.innerHTML = currentVal.toLocaleString('id-ID'); // Format ribuan
          }
          
          if (progress < 1) {
              window.requestAnimationFrame(step);
          } else {
              // Set hasil final secara presisi di akhir durasi
              obj.innerHTML = isPercent ? end + '%' : end.toLocaleString('id-ID');
          }
      };
      window.requestAnimationFrame(step);
  }

  // Animasi dijalankan pertama kali saat halaman dibuka
  document.addEventListener("DOMContentLoaded", () => {
      document.querySelectorAll('.animate-number').forEach(elem => {
          let endVal = parseFloat(elem.getAttribute('data-value'));
          let isPercent = elem.getAttribute('data-is-percent') === 'true';
          animateValue(elem, 0, endVal, 1500, isPercent); // 1.5 detik
      });
  });

  // 1. Inisialisasi awal Chart dengan data PHP bawaan pertama kali dimuat
  const initialDataKandidat = <?= json_encode($suaraKandidat) ?>;
  const initialTotalSuara   = <?= $totalSuaraMasuk ?>;
  const initialTotalDPT     = <?= $totalDPT ?>;

  // Render Chart Bar (Suara Kandidat)
  const chartSuara = new Chart(document.getElementById('chartSuara'), {
    type: 'bar',
    data: {
      labels: initialDataKandidat.map(k => k.nama),
      datasets: [{
        label: 'Jumlah Suara',
        data: initialDataKandidat.map(k => k.suara),
        backgroundColor: initialDataKandidat.map(k => k.warna),
        borderRadius: 8
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      plugins: { legend: { display: false } },
      scales: { 
          y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.1)' }, ticks: { color: '#94a3b8' } },
          x: { grid: { display: false }, ticks: { color: '#94a3b8' } }
      }
    }
  });

  // Render Chart Doughnut (Partisipasi)
  const chartPartisipasi = new Chart(document.getElementById('chartPartisipasi'), {
    type: 'doughnut',
    data: {
      labels: ['Sudah Memilih', 'Belum Memilih'],
      datasets: [{
        data: [initialTotalSuara, initialTotalDPT - initialTotalSuara],
        backgroundColor: ['#2563EB', '#E2E8F0'],
        borderWidth: 0
      }]
    },
    options: {
      responsive: true,
      maintainAspectRatio: false,
      cutout: '75%',
      plugins: { legend: { display: false } }
    }
  });

  // 2. Fungsi AJAX untuk mengambil data live secara berkala
  function updateLiveStatistik() {
    fetch('../api/kandidat.php', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({ type: 'statistik' })
    })
    .then(response => response.json())
    .then(result => {
      if (result.status === 'success') {
        const dataKand = result.suaraKandidat;
        const tSuara   = result.totalMasuk;
        const tDPT     = result.totalDPT;
        
        // Cek dan eksekusi Animasi Angka pada Kartu Statistik jika ada perubahan Suara
        let pSudah = tDPT > 0 ? ((tSuara / tDPT) * 100).toFixed(1) : 0;
        
        const elDPT = document.getElementById('val-dpt');
        const elSuaraMasuk = document.getElementById('val-suara-masuk');
        const elPartisipasi = document.getElementById('val-partisipasi');

        // Jika DPT berubah
        if (elDPT && parseFloat(elDPT.getAttribute('data-value')) !== tDPT) {
            elDPT.setAttribute('data-value', tDPT);
            animateValue(elDPT, 0, tDPT, 1500, false);
        }
        // Jika Suara Masuk berubah
        if (elSuaraMasuk && parseFloat(elSuaraMasuk.getAttribute('data-value')) !== tSuara) {
            elSuaraMasuk.setAttribute('data-value', tSuara);
            animateValue(elSuaraMasuk, 0, tSuara, 1500, false);
        }
        // Jika Partisipasi (%) berubah
        if (elPartisipasi && parseFloat(elPartisipasi.getAttribute('data-value')) !== parseFloat(pSudah)) {
            elPartisipasi.setAttribute('data-value', pSudah);
            animateValue(elPartisipasi, 0, parseFloat(pSudah), 1500, true);
        }

        // Update Data Chart Bar
        chartSuara.data.labels = dataKand.map(k => k.nama);
        chartSuara.data.datasets[0].data = dataKand.map(k => k.suara);
        chartSuara.update(); // Menggunakan animasi bawaan chart JS

        // Update Data Chart Doughnut
        chartPartisipasi.data.datasets[0].data = [tSuara, tDPT - tSuara];
        chartPartisipasi.update();
      }
    })
    .catch(error => console.error('Gagal memuat data live:', error));
  }

  // 3. Jalankan fungsi AJAX dalam 5 detik
  setInterval(updateLiveStatistik, 5000);
</script>

<?php if (!$is_ajax): ?>
  <?php require_once __DIR__ . '/../layout/admin/footer.php'; ?>
<?php endif; ?>