<?php
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';
require_once __DIR__ . "/../api/conn.php"; 

if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $current_settings = $conn->get_settings();
    $logo_lama        = $current_settings['logo_sekolah'] ?? '';

    $nama_sekolah    = trim($_POST['nama_sekolah'] ?? '');
    $tahun_ajaran    = trim($_POST['tahun_ajaran'] ?? '');
    $judul_pemilihan = trim($_POST['judul_pemilihan'] ?? '');

    $status_voting_input = $_POST['status_voting'] ?? '0';
    $status_voting       = ($status_voting_input == '1') ? '1' : '0';

    $waktu_mulai_raw   = $_POST['waktu_mulai'] ?? '';
    $waktu_selesai_raw = $_POST['waktu_selesai'] ?? '';

    $waktu_mulai   = !empty($waktu_mulai_raw) ? date('Y-m-d H:i:s', strtotime($waktu_mulai_raw)) : null;
    $waktu_selesai = !empty($waktu_selesai_raw) ? date('Y-m-d H:i:s', strtotime($waktu_selesai_raw)) : null;

    $logo_sekolah = null;
    if (isset($_FILES['logo_sekolah']) && $_FILES['logo_sekolah']['error'] === UPLOAD_ERR_OK) {
        $folder_tujuan = __DIR__ . "/../upload/logo/";

        if (!file_exists($folder_tujuan)) {
            mkdir($folder_tujuan, 0777, true);
        }

        $file_tmp  = $_FILES['logo_sekolah']['tmp_name'];
        $file_name = $_FILES['logo_sekolah']['name'];
        $file_ext  = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));

        $allowed_extensions = ['png', 'jpg', 'jpeg', 'webp'];
        if (in_array($file_ext, $allowed_extensions)) {
            $nama_logo_baru = 'logo_' . time() . '.' . $file_ext;
            
            // Pindahkan file baru
            if (move_uploaded_file($file_tmp, $folder_tujuan . $nama_logo_baru)) {
                $logo_sekolah = $nama_logo_baru;

                // HAPUS FILE LOGO LAMA DARI SERVER
                if (!empty($logo_lama) && file_exists($folder_tujuan . $logo_lama)) {
                    @unlink($folder_tujuan . $logo_lama);
                }
            }
        }
    }


    $update_status = $conn->update_settings(
        $nama_sekolah,
        $judul_pemilihan,
        $tahun_ajaran,
        $status_voting,
        $waktu_mulai,
        $waktu_selesai,
        $logo_sekolah
    );

    // Redirect Kembali ke Halaman Settings
    if ($update_status) {
        header("Location: settings.php?v=true");
    } else {
        header("Location: settings.php?v=false");
    }
    exit;
}




$settings = $conn->get_settings();
$logoUrl = !empty($settings['logo_sekolah']) 
    ? '../upload/logo/' . $settings['logo_sekolah'] 
    : 'https://placehold.co/150x150/EEF3FF/1E3A8A?text=Logo';



$settings = $conn->get_settings();
$admin = $conn->get_admin();

$admin = [
  'nama' => $admin['admin'],
  'foto' => $settings['logo_sekolah'],
  'role' => 'Admin Pemilu',
] ?? [
  'nama' => 'Bu Rina Marlina, S.Kom', 
  'foto' => 'https://i.pravatar.cc/150?img=47', 
  'role' => 'Admin Pemilu', 
];

$waktu_mulai_html   = !empty($settings['waktu_mulai']) ? date('Y-m-d\TH:i', strtotime($settings['waktu_mulai'])) : '';
$waktu_selesai_html = !empty($settings['waktu_selesai']) ? date('Y-m-d\TH:i', strtotime($settings['waktu_selesai'])) : '';


// Render Alert Status
$pesan_alert = "";
if (isset($_GET["v"])) {
  $status = $_GET["v"]; 
  if ($status == "true") { 
    $pesan_alert = "
    <div class='flex items-center gap-3 p-4 mb-6 text-sm font-semibold border shadow-sm text-emerald-800 rounded-2xl bg-emerald-50 border-emerald-200'>
        <i data-lucide='check-circle' class='w-5 h-5 text-emerald-600 shrink-0'></i>
        <span>Pengaturan sistem berhasil diperbarui!</span>
    </div>";
  } elseif ($status == "false") { 
    $pesan_alert = "
    <div class='flex items-center gap-3 p-4 mb-6 text-sm font-semibold text-red-800 border border-red-200 shadow-sm rounded-2xl bg-red-50'>
        <i data-lucide='alert-circle' class='w-5 h-5 text-red-600 shrink-0'></i>
        <span>Gagal memperbarui pengaturan sistem!</span>
    </div>";
  }
}

$pageTitle  = 'Pengaturan Sistem'; 
$breadcrumb = ['Admin', 'Pengaturan']; 
$activePage = 'settings'; 

if (!$is_ajax) {
    require_once __DIR__ . '/../layout/admin/header.php';
    require_once __DIR__ . '/../layout/admin/sidebar.php';
    require_once __DIR__ . '/../layout/admin/navbar.php';
    ?>
    <main id="main-content" class="flex-1 p-4 overflow-y-auto sm:p-8">
<?php } ?>

<!-- Header Title -->
<div data-aos="fade-up" class="mb-6">
  <h2 class="text-2xl font-semibold font-display text-navy-900">Pengaturan Sistem</h2>
  <p class="mt-1 text-sm text-slate-500">Konfigurasi identitas sekolah dan jadwal E-Voting OSIS.</p>
</div>

<!-- Render Pesan Alert -->
<?= $pesan_alert ?>

<div class="grid grid-cols-1 gap-8 lg:grid-cols-3">
  
  <!-- Form Pengaturan (Action diosongkan agar kirim ke halaman ini sendiri) -->
  <div data-aos="fade-up" data-aos-delay="200" class="lg:col-span-2">
    <form action="" method="POST" enctype="multipart/form-data" class="bg-white rounded-3xl p-6 sm:p-8 shadow-[0_8px_30px_rgb(15,23,42,0.06)] border border-slate-100 space-y-6">
      
      <h3 class="pb-3 mb-4 text-lg font-bold border-b text-navy-900 border-slate-100">Informasi Umum</h3>
    
      <!-- Input Logo Sekolah -->
      <div>
        <label class="block mb-2 text-sm font-medium text-navy-700">Logo Sekolah</label>
        <div class="flex items-center gap-5">
          <img id="previewLogo" src="<?= htmlspecialchars($logoUrl) ?>" alt="Logo Sekolah" class="object-cover w-20 h-20 border rounded-2xl border-slate-200 shrink-0 bg-slate-50">
          
          <div id="dropzoneLogo" class="flex flex-col items-center justify-center flex-1 p-4 text-center transition-colors border-2 border-dashed cursor-pointer border-slate-300 bg-slate-50 hover:bg-blue-50 hover:border-blue-400 rounded-xl group">
            <i data-lucide="image" class="w-5 h-5 mb-1 text-slate-400 group-hover:text-blue-500"></i>
            <span class="text-sm font-semibold text-navy-900">Ubah Logo</span>
            <span class="text-[11px] text-slate-500 mt-0.5">Klik atau drag gambar ke sini (PNG, JPG, WEBP)</span>
            <input type="file" name="logo_sekolah" id="inputLogo" accept="image/png, image/jpeg, image/webp" class="hidden">
          </div>
        </div>
      </div>

      <!-- Nama Sekolah & Tahun Ajaran -->
      <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Sekolah</label>
          <input type="text" name="nama_sekolah" value="<?= htmlspecialchars($settings['nama_sekolah'] ?? '') ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-sm">
        </div>
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Tahun Ajaran</label>
          <input type="text" name="tahun_ajaran" value="<?= htmlspecialchars($settings['tahun_ajaran'] ?? '') ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-sm">
        </div>
      </div>

      <!-- Judul Pemilihan -->
      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Judul Pemilihan</label>
        <input type="text" name="judul_pemilihan" value="<?= htmlspecialchars($settings['judul_pemilihan'] ?? '') ?>" required 
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-sm">
      </div>

      <h3 class="pb-3 mt-8 mb-4 text-lg font-bold border-b text-navy-900 border-slate-100">Jadwal & Status Pemilihan</h3>

      <!-- Waktu Mulai & Selesai -->
      <div class="grid grid-cols-1 gap-5 md:grid-cols-2">
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Waktu Mulai Voting</label>
          <input type="datetime-local" name="waktu_mulai" id="inputWaktuMulai" value="<?= $waktu_mulai_html ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-sm">
        </div>
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Waktu Selesai Voting</label>
          <input type="datetime-local" name="waktu_selesai" id="inputWaktuSelesai" value="<?= $waktu_selesai_html ?>" required 
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-100 outline-none text-sm">
        </div>
      </div>

      <div class="flex justify-end pt-4">
        <button type="submit" class="px-6 py-3 rounded-xl bg-[#1E3A8A] text-white text-sm font-semibold hover:bg-blue-800 transition shadow-lg shadow-blue-900/20 flex items-center gap-2">
          <i data-lucide="save" class="w-4 h-4"></i> Simpan Pengaturan
        </button>
      </div>
    </form>
  </div>

  <!-- Sidebar Info Timeline -->
  <div data-aos="fade-up" data-aos-delay="300" class="space-y-6 lg:col-span-1">
    <div class="relative p-6 overflow-hidden shadow-xl bg-slate-900 rounded-3xl">
      <div class="absolute w-32 h-32 rounded-full -right-6 -top-6 bg-blue-500/20 blur-2xl"></div>
      
      <h3 class="relative z-10 flex items-center gap-2 mb-6 font-semibold text-white font-display">
        <i data-lucide="clock" class="w-5 h-5 text-blue-400"></i> Timeline Siswa
      </h3>

      <div class="relative z-10 ml-3 space-y-8 border-l-2 border-slate-700">
        
        <!-- Step 1: Persiapan -->
        <div class="relative pl-6">
          <div class="absolute -left-[9px] top-1 w-4 h-4 bg-slate-700 rounded-full border-4 border-slate-900"></div>
          <h4 class="text-sm font-bold text-slate-300">Sistem Belum Dibuka</h4>
          <p class="mt-1 text-xs text-slate-500">Sebelum tanggal:</p>
          <p id="teksMulai" class="inline-block px-2 py-1 mt-1 font-mono text-xs text-blue-400 rounded bg-slate-800">
            <?= !empty($settings['waktu_mulai']) ? date('d M Y, H:i', strtotime($settings['waktu_mulai'])) : '-' ?>
          </p>
        </div>

        <!-- Step 2: Voting Berlangsung -->
        <div class="relative pl-6">
          <div class="absolute -left-[11px] top-1 w-5 h-5 bg-blue-500 rounded-full border-4 border-slate-900 shadow-[0_0_10px_rgb(59,130,246,0.5)] flex items-center justify-center">
             <div class="w-1.5 h-1.5 bg-white rounded-full animate-pulse"></div>
          </div>
          <h4 class="text-sm font-bold text-white">Voting Berlangsung</h4>
          <p class="mt-1 text-xs leading-relaxed text-slate-400">Siswa dapat login menggunakan token dan melakukan pemilihan kandidat.</p>
        </div>

        <!-- Step 3: Selesai -->
        <div class="relative pl-6">
          <div class="absolute -left-[9px] top-1 w-4 h-4 bg-slate-700 rounded-full border-4 border-slate-900"></div>
          <h4 class="text-sm font-bold text-slate-300">Sistem Ditutup</h4>
          <p class="mt-1 text-xs text-slate-500">Lewat dari tanggal:</p>
          <p id="teksSelesai" class="inline-block px-2 py-1 mt-1 font-mono text-xs text-red-400 rounded bg-slate-800">
            <?= !empty($settings['waktu_selesai']) ? date('d M Y, H:i', strtotime($settings['waktu_selesai'])) : '-' ?>
          </p>
        </div>

      </div>
    </div>
  </div>

</div>

<!-- JavaScript Live Preview & Drag Drop Logo -->
<script>
  document.addEventListener('DOMContentLoaded', () => {
      const dropzone = document.getElementById('dropzoneLogo');
      const inputLogo = document.getElementById('inputLogo');
      const previewLogo = document.getElementById('previewLogo');

      if (!dropzone || !inputLogo || !previewLogo) return;

      // Klik Dropzone untuk buka file picker
      dropzone.addEventListener('click', () => inputLogo.click());

      function processAndPreviewFile(file) {
          if (!file || !file.type.startsWith('image/')) {
              alert('Format file tidak didukung! Harap unggah file gambar (PNG, JPG, WEBP).');
              return;
          }
          const reader = new FileReader();
          reader.onload = (e) => { previewLogo.src = e.target.result; };
          reader.readAsDataURL(file);
      }

      inputLogo.addEventListener('change', (e) => {
          const file = e.target.files[0];
          if (file) processAndPreviewFile(file);
      });

      // Event Drag & Drop
      ['dragenter', 'dragover'].forEach(evt => {
          dropzone.addEventListener(evt, (e) => {
              e.preventDefault();
              e.stopPropagation();
              dropzone.classList.add('border-blue-500', 'bg-blue-100/50');
          });
      });

      ['dragleave', 'drop'].forEach(evt => {
          dropzone.addEventListener(evt, (e) => {
              e.preventDefault();
              e.stopPropagation();
              dropzone.classList.remove('border-blue-500', 'bg-blue-100/50');
          });
      });

      dropzone.addEventListener('drop', (e) => {
          const files = e.dataTransfer.files;
          if (files.length > 0) {
              inputLogo.files = files;
              processAndPreviewFile(files[0]);
          }
      });
  });
</script>

<?php if (!$is_ajax): ?>
    </main>
    <?php require_once __DIR__ . '/../layout/admin/footer.php'; ?>
<?php endif; ?>