<?php
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';
require_once __DIR__ . "/../api/conn.php"; 

$settings = $conn->get_settings();

// 2. Format tanggal untuk input type="datetime-local" (wajib format YYYY-MM-DDThh:mm)
$waktu_mulai_html   = date('Y-m-d\TH:i', strtotime($settings['waktu_mulai']));
$waktu_selesai_html = date('Y-m-d\TH:i', strtotime($settings['waktu_selesai']));

// 3. Setup logo default jika kosong
$logoUrl = !empty($settings['logo_sekolah']) 
    ? '../upload/logo/' . $settings['logo_sekolah'] 
    : 'https://placehold.co/150x150/EEF3FF/1E3A8A?text=Logo';

if (isset($_POST["submit_kandidat"])) {
        
    $visi = $_POST["text-visi"]; 
    $misi = $_POST["text-misi"]; 
    
    $nama_file_baru = random_id(8); 
    $folder_tujuan = "../upload/"; 
    
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
$activePage = 'settings'; 


if (!$is_ajax) {
    require_once __DIR__ . '/../layout/partials/header.php';
    require_once __DIR__ . '/../layout/partials/sidebar.php';
    require_once __DIR__ . '/../layout/partials/navbar.php';
    ?>
    <main id="main-content" class="flex-1 p-4 sm:p-8 overflow-y-auto">
<?php }; ?>

<div class="mb-6">
  <h2 class="font-display font-semibold text-navy-900 text-2xl">Pengaturan Sistem</h2>
  <p class="text-sm text-slate-500 mt-1">Konfigurasi identitas sekolah dan jadwal E-Voting OSIS.</p>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
  <div class="lg:col-span-2">
    <form action="simpan-settings.php" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(15,23,42,0.06)] border border-slate-100 space-y-6">
      
      <h3 class="text-lg font-bold text-navy-900 border-b border-slate-100 pb-3 mb-4">Informasi Umum</h3>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-2 block">Logo Sekolah</label>
        <div class="flex items-center gap-5">
          <img id="previewLogo" src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo Sekolah" class="w-20 h-20 rounded-2xl object-cover border border-slate-200 shrink-0 bg-slate-50">
          
          <div id="dropzoneLogo" class="flex-1 border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-primary-50 hover:border-primary-400 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer transition-colors text-center group">
            <i data-lucide="image" class="w-5 h-5 text-slate-400 group-hover:text-primary-500 mb-1"></i>
            <span class="text-sm font-semibold text-navy-900">Ubah Logo</span>
            <span class="text-[11px] text-slate-500 mt-0.5">Abaikan jika tidak ingin diganti</span>
            <input type="file" name="logo_sekolah" id="inputLogo" accept="image/png, image/jpeg, image/webp" class="hidden">
          </div>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" value="<?= htmlspecialchars($settings['nama_sekolah']) ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Tahun Ajaran</label>
          <input type="text" name="tahun_ajaran" value="<?= htmlspecialchars($settings['tahun_ajaran']) ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Judul Pemilihan</label>
        <input type="text" name="judul_pemilihan" value="<?= htmlspecialchars($settings['judul_pemilihan']) ?>" required 
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
      </div>

      <h3 class="text-lg font-bold text-navy-900 border-b border-slate-100 pb-3 mt-8 mb-4">Jadwal & Status Pemilihan</h3>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Waktu Mulai Voting</label>
          <input type="datetime-local" name="waktu_mulai" id="inputWaktuMulai" value="<?= $waktu_mulai_html ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Waktu Selesai Voting</label>
          <input type="datetime-local" name="waktu_selesai" id="inputWaktuSelesai" value="<?= $waktu_selesai_html ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Status Sistem Voting</label>
        <select name="status_voting" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm bg-white">
          <option value="1" <?= $settings['status_voting'] == 1 ? 'selected' : '' ?>>Aktif (Siswa bisa login)</option>
          <option value="0" <?= $settings['status_voting'] == 0 ? 'selected' : '' ?>>Ditutup / Maintenance</option>
        </select>
      </div>

      <div class="pt-4 flex justify-end">
        <button type="submit" class="px-6 py-3 rounded-xl bg-primary-700 text-white text-sm font-semibold hover:bg-primary-600 transition shadow-lg shadow-primary-500/30 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengaturan
        </button>
      </div>
    </form>
  </div>

  <div class="lg:col-span-1 space-y-6">
    <div class="bg-slate-900 rounded-3xl p-6 shadow-xl relative overflow-hidden">
      <!-- Ornamen Background -->
      <div class="absolute -right-6 -top-6 w-32 h-32 bg-primary-500/20 rounded-full blur-2xl"></div>
      
      <h3 class="text-white font-display font-semibold mb-6 flex items-center gap-2 relative z-10">
        <i data-lucide="clock" class="w-5 h-5 text-primary-400"></i> Timeline Siswa
      </h3>

      <div class="relative border-l-2 border-slate-700 ml-3 space-y-8 z-10">
        
        <!-- Step 1: Persiapan -->
        <div class="relative pl-6">
          <div class="absolute -left-[9px] top-1 w-4 h-4 bg-slate-700 rounded-full border-4 border-slate-900"></div>
          <h4 class="text-sm font-bold text-slate-300">Sistem Belum Dibuka</h4>
          <p class="text-xs text-slate-500 mt-1">Sebelum tanggal:</p>
          <p id="teksMulai" class="text-xs font-mono text-primary-400 mt-1 bg-slate-800 inline-block px-2 py-1 rounded">
            <?= date('d M Y, H:i', strtotime($settings['waktu_mulai'])) ?>
          </p>
        </div>

        <!-- Step 2: Voting Berlangsung -->
        <div class="relative pl-6">
          <div class="absolute -left-[11px] top-1 w-5 h-5 bg-primary-500 rounded-full border-4 border-slate-900 shadow-[0_0_10px_rgb(59,130,246,0.5)] flex items-center justify-center">
             <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
          </div>
          <h4 class="text-sm font-bold text-white">Voting Berlangsung</h4>
          <p class="text-xs text-slate-400 mt-1 leading-relaxed">Siswa dapat login menggunakan token dan melakukan pemilihan kandidat.</p>
        </div>

        <!-- Step 3: Selesai -->
        <div class="relative pl-6">
          <div class="absolute -left-[9px] top-1 w-4 h-4 bg-slate-700 rounded-full border-4 border-slate-900"></div>
          <h4 class="text-sm font-bold text-slate-300">Sistem Ditutup</h4>
          <p class="text-xs text-slate-500 mt-1">Lewat dari tanggal:</p>
          <p id="teksSelesai" class="text-xs font-mono text-red-400 mt-1 bg-slate-800 inline-block px-2 py-1 rounded">
            <?= date('d M Y, H:i', strtotime($settings['waktu_selesai'])) ?>
          </p>
        </div>

      </div>
    </div>
  </div>

</div>

<?php if (!$is_ajax): ?>
    </main>
  <?php endif; ?>
<!-- Script untuk Interaksi Preview Logo & Timeline Interaktif -->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // 1. Script Drag & Drop Logo
  const dropzoneLogo = document.getElementById('dropzoneLogo');
  const inputLogo    = document.getElementById('inputLogo');
  const previewLogo  = document.getElementById('previewLogo');

  dropzoneLogo.addEventListener('click', () => inputLogo.click());

  dropzoneLogo.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.add('border-primary-500', 'bg-primary-50');
  });

  dropzoneLogo.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.remove('border-primary-500', 'bg-primary-50');
  });

  dropzoneLogo.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.remove('border-primary-500', 'bg-primary-50');
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      inputLogo.files = e.dataTransfer.files;
      previewImage(e.dataTransfer.files[0]);
    }
  });

  inputLogo.addEventListener('change', function() {
    if (this.files && this.files.length > 0) previewImage(this.files[0]);
  });

  function previewImage(file) {
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (e) => previewLogo.src = e.target.result;
      reader.readAsDataURL(file);
    }
  }

  // 2. Script Update Timeline Interaktif
  const inputMulai   = document.getElementById('inputWaktuMulai');
  const inputSelesai = document.getElementById('inputWaktuSelesai');
  const teksMulai    = document.getElementById('teksMulai');
  const teksSelesai  = document.getElementById('teksSelesai');

  function formatTanggalIndo(dateString) {
    if(!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
      day: '2-digit', month: 'short', year: 'numeric', 
      hour: '2-digit', minute: '2-digit'
    }).replace(/\./g, ':'); // mengubah separator jam default JS ke titik dua
  }

  inputMulai.addEventListener('input', (e) => {
    teksMulai.textContent = formatTanggalIndo(e.target.value);
  });

  inputSelesai.addEventListener('input', (e) => {
    teksSelesai.textContent = formatTanggalIndo(e.target.value);
  });
});
</script>


<?php if (!$is_ajax): ?>
  <?php require_once __DIR__ . '/../layout/partials/footer.php'; ?>
<?php endif; ?>
