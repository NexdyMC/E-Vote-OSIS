<?php
session_start();

require_once __DIR__ . "/../api/conn.php"; 

if (isset($_POST["submit_kandidat"])) {
        
    $visi = $_POST["text-visi"]; 
    $misi = $_POST["text-misi"]; 
    
    $nama_file_baru = random_id(8); 
    $folder_tujuan = "../uploads/photo/"; 
    
    $upload_foto = $conn->upload_image($folder_tujuan, $nama_file_baru, 'photo');
    
    if ($upload_foto) {    
        $simpan = $conn->add_kandidat($nama, $visi, $misi, $upload_foto);
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
$activePage = 'siswa'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Dashboard Admin</title>
  
  <!-- <script src="https://cdn.tailwindcss.com"></script> -->
  <!-- <link rel="preconnect" href="https://fonts.googleapis.com"> -->
  <!-- <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet"> -->
  <!-- <link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet"> -->
  <!-- <script src="https://unpkg.com/lucide@latest"></script> -->
  <script src="../assets/scripts/tailwind.js"></script>
  <script src="../assets/scripts/tailwind.config.js"></script>
</head>
<body class="bg-slate-50 text-slate-800 font-body"> 

<div class="flex min-h-screen">

  <?php require __DIR__ . '/../layout/partials/sidebar.php'?>
  <main class="flex-1 min-w-0">

    <!-- Header Admin -->
    <?php require __DIR__ . '/../layout/partials/topbar.php'?>
    <div class="p-4 sm:p-8 space-y-8">

      <?= $pesan_alert ?>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-2 bg-white p-6 rounded-2xl shadow-sm border overflow-x-auto">
          <h3 class="font-display font-semibold text-lg mb-4">Data Pemilih (Siswa)</h3>
          <table class="w-full text-left text-sm">
            <thead class="bg-slate-100 text-slate-600">
              <tr>
                <th class="p-3 rounded-l-lg">Token</th>
                <th class="p-3">Nama</th>
                <th class="p-3">Kelas</th>
                <th class="p-3">Status</th>
                <th class="p-3 rounded-r-lg">Aksi</th>
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
                <td class="p-3 space-x-2">
                  <a href="update_siswa.php?token=<?= $row['token'] ?>" class="text-blue-600 hover:underline">Edit</a>
                  <a href="hapus_siswa.php?token=<?= $row['token'] ?>" class="text-red-600 hover:underline" onclick="return confirm('Hapus siswa ini?')">Hapus</a>
                </td>
              </tr>
              <?php }; ?>
            </tbody>  
          </table>
        </div>
      </div>
    </div>
  </main>
</div>



<!-- Scripts -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>


<script>
  // lucide.createIcons();
  AOS.init({ duration: 550, once: true, offset: 40 });

  // Parsing data PHP ke JS
  const dataKandidat = <?= json_encode($suaraKandidat) ?>;
  const labelKandidat = dataKandidat.map(k => k.nama);
  const nilaiKandidat = dataKandidat.map(k => k.suara);
  const warnaKandidat = dataKandidat.map(k => k.warna);

  // Chart Bar (Suara Kandidat)
  new Chart(document.getElementById('chartSuara'), {
    type: 'bar',
    data: {
      labels: labelKandidat,
      datasets: [{
        label: 'Jumlah Suara',
        data: nilaiKandidat,
        backgroundColor: warnaKandidat,
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

  // Chart Doughnut (Partisipasi)
  new Chart(document.getElementById('chartPartisipasi'), {
    type: 'doughnut',
    data: {
      labels: ['Sudah Memilih', 'Belum Memilih'],
      datasets: [{
        data: [<?= $totalSuaraMasuk ?>, <?= $totalDPT - $totalSuaraMasuk ?>],
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
  // Buka modal. mode: 'add' atau 'edit'. data: object kandidat (saat edit).
  function openModal(mode, data) {
    const form = document.getElementById('formKandidat');
    form.reset();
    document.getElementById('previewFoto').src = 'https://placehold.co/100x100/EEF3FF/1E3A8A?text=Foto';

    if (mode === 'edit' && data) {
      document.getElementById('modalTitle').textContent = 'Edit Kandidat';
      document.getElementById('inputId').value = data.id;
      document.getElementById('inputNomor').value = data.nomor_urut;
      document.getElementById('inputKetua').value = data.nama_ketua;
      document.getElementById('inputWakil').value = data.nama_wakil;
      document.getElementById('inputVisi').value = data.visi_misi;
      document.getElementById('previewFoto').src = data.foto;
    } else {
      document.getElementById('modalTitle').textContent = 'Tambah Kandidat Baru';
      document.getElementById('inputId').value = '';
    }

    document.getElementById('modalWrap').classList.remove('modal-hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeModal() {
    document.getElementById('modalWrap').classList.add('modal-hidden');
    document.body.style.overflow = '';
  }

  // Preview foto sebelum diunggah
  function previewFotoFile(input) {
    if (input.files && input.files[0]) {
      const reader = new FileReader();
      reader.onload = e => document.getElementById('previewFoto').src = e.target.result;
      reader.readAsDataURL(input.files[0]);
    }
  }

  // Tutup modal dengan tombol Escape
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModal(); });
</script>
<script>
  const dropzone = document.getElementById('dropzoneFoto');
  const inputFoto = document.getElementById('inputFoto');
  const previewFoto = document.getElementById('previewFoto');

  // 1. Jika dropzone diklik, buka file explorer
  dropzone.addEventListener('click', () => {
    inputFoto.click();
  });

  // 2. Mencegah browser membuka gambar di tab baru saat gambar di-drag
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-primary-500', 'bg-primary-50'); // Efek menyala saat di-drag
  });

  dropzone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50'); // Kembali normal
  });

  // 3. Menangkap file saat di-drop
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50');
    
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      inputFoto.files = e.dataTransfer.files; // Memasukkan file yang di-drop ke dalam input
      tampilkanPreview(e.dataTransfer.files[0]);
    }
  });

  // 4. Menangkap file jika dipilih menggunakan klik (File Explorer)
  inputFoto.addEventListener('change', function() {
    if (this.files && this.files.length > 0) {
      tampilkanPreview(this.files[0]);
    }
  });

  // Fungsi mengubah gambar placeholder menjadi gambar asli yang diupload
  function tampilkanPreview(file) {
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (e) => {
        previewFoto.src = e.target.result;
      };
      reader.readAsDataURL(file);
    } else {
      alert('Tolong upload file berupa gambar (PNG/JPG/WEBP)');
    }
  }
</script>
</body>
</html>