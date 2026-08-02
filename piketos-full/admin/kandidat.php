<?php
/* =========================================================
   ADMIN/KANDIDAT.PHP — Kelola Pasangan Calon
   ---------------------------------------------------------
   $is_ajax menentukan apakah file ini dipanggil lewat fetch()
   dari footer.php (SPA) atau dibuka penuh (refresh / ketik URL).
   ========================================================= */
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

require_once __DIR__ . '/../api/conn.php';

// --- Pesan alert dari redirect simpan-kandidat.php (?v=true/false) ---
$pesan_alert = '';
if (isset($_GET['v'])) {
    if ($_GET['v'] === 'true') {
        $pesan_alert = "<div class='p-4 mb-6 text-sm text-green-800 rounded-xl bg-green-50 border border-green-100 font-medium'>Data kandidat berhasil disimpan.</div>";
    } elseif ($_GET['v'] === 'false') {
        $pesan_alert = "<div class='p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-100 font-medium'>Gagal menyimpan data kandidat.</div>";
    }
}

$admin = $_SESSION['admin'] ?? [
    'nama' => 'Bu Rina Marlina, S.Kom',
    'foto' => 'https://i.pravatar.cc/150?img=47',
    'role' => 'Admin Pemilu',
];

// --- Data kandidat asli dari database, urut berdasarkan id ---
// ("Nomor Urut" TIDAK disimpan sebagai kolom terpisah — conn.php
//  menghitungnya otomatis dari urutan baris (lihat get_paslon_results()),
//  jadi di sini nomor urut juga dihitung dari posisi loop supaya konsisten.)
$kandidat_list = $conn->select_kandidat('1 ORDER BY id ASC');

$pageTitle  = 'Kelola Pasangan Calon / Kandidat';
$breadcrumb = ['Admin', 'Kandidat'];
$activePage = 'kandidat';

if (!$is_ajax) {
    require_once __DIR__ . '/../layout/partials/header.php';
    require_once __DIR__ . '/../layout/partials/sidebar.php';
    require_once __DIR__ . '/../layout/partials/navbar.php';
    ?>
    <main id="main-content" class="flex-1 p-4 sm:p-8 overflow-y-auto">
<?php endif; ?>

  <?= $pesan_alert ?>

  <div class="flex items-center justify-between mb-6">
    <div>
      <h2 class="font-display font-semibold text-navy-900">Daftar Pasangan Calon</h2>
      <p class="text-sm text-slate-500 mt-1"><?= count($kandidat_list) ?> kandidat terdaftar untuk periode ini</p>
    </div>
  </div>

  <!-- ===== Tombol Tambah Kandidat (banner penuh) ===== -->
  <button type="button" onclick="openModalKandidat('add')" data-aos="fade-up"
          class="w-full border-2 border-dashed border-slate-300 hover:border-primary-500 bg-white hover:bg-primary-50/40 rounded-2xl min-h-[120px] flex flex-col items-center justify-center gap-2 p-6 text-center transition-all duration-300 transform hover:-translate-y-1 group mb-6">
    <div class="w-14 h-14 rounded-full bg-primary-50 group-hover:bg-primary-100 flex items-center justify-center transition-colors">
      <i data-lucide="plus" class="w-7 h-7 text-primary-600"></i>
    </div>
    <p class="font-display font-semibold text-navy-900">Tambah Kandidat Baru</p>
    <p class="text-xs text-slate-500 max-w-[220px] leading-relaxed">Daftarkan pasangan calon ketua &amp; wakil ketua OSIS</p>
  </button>

  <!-- ===== Grid Kartu Kandidat ===== -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <?php foreach ($kandidat_list as $i => $row): ?>
      <?php
        $noUrut  = str_pad($i + 1, 2, '0', STR_PAD_LEFT);
        $fotoUrl = !empty($row['image'])
            ? 'uploads/kandidat/' . $row['image']
            : 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?w=400&h=400&fit=crop&auto=format';
      ?>
      <div data-aos="fade-up" data-aos-delay="<?= min(($i + 1) * 80, 320) ?>"
           class="bg-white rounded-3xl overflow-hidden shadow-[0_8px_30px_rgb(15,23,42,0.06)] border border-slate-100 card-hover flex flex-col">

        <!-- Foto -->
        <div class="relative aspect-[4/3] bg-slate-800 shrink-0">
          <img src="<?= htmlspecialchars($fotoUrl) ?>" alt="Kandidat <?= htmlspecialchars($row['nama']) ?>"
               class="w-full h-full object-cover">
        </div>

        <div class="flex-1 p-5">
          <p class="text-xl text-center font-display font-bold mb-2 line-clamp-1 text-navy-900"><?= htmlspecialchars($row['nama']) ?></p>

          <div class="flex justify-center mb-5">
            <span class="text-xs font-bold tracking-widest text-accent-500 bg-accent-400/15 px-3 py-1 rounded-full border border-accent-400/30">
              PASLON NO. <?= $noUrut ?>
            </span>
          </div>

          <div class="space-y-3">
            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
              <h4 class="text-xs font-bold uppercase text-primary-600 mb-1 flex items-center gap-1.5">
                <i data-lucide="compass" class="w-3.5 h-3.5"></i> Visi
              </h4>
              <p class="text-sm text-slate-600 leading-relaxed line-clamp-2"><?= nl2br(htmlspecialchars($row['visi'])) ?></p>
            </div>

            <div class="bg-slate-50 p-3 rounded-xl border border-slate-200">
              <h4 class="text-xs font-bold uppercase text-primary-600 mb-1 flex items-center gap-1.5">
                <i data-lucide="target" class="w-3.5 h-3.5"></i> Misi
              </h4>
              <p class="text-sm text-slate-600 leading-relaxed line-clamp-2"><?= nl2br(htmlspecialchars($row['misi'])) ?></p>
            </div>
          </div>

          <div class="flex items-center gap-2 mt-5">
            <button type="button"
                    data-kandidat='<?= htmlspecialchars(json_encode($row), ENT_QUOTES, 'UTF-8') ?>'
                    onclick="openModalKandidat('edit', JSON.parse(this.dataset.kandidat))"
                    class="btn-cta flex-1 flex items-center justify-center gap-1.5 text-sm font-medium px-3 py-2.5 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-100">
              <i data-lucide="pencil" class="w-4 h-4"></i> Edit
            </button>

            <!-- Hapus: form POST sungguhan (bukan fungsi JS yang tidak pernah didefinisikan) -->
            <form action="hapus-kandidat.php" method="POST" class="flex-1"
                  onsubmit="return confirm('Hapus <?= htmlspecialchars(addslashes($row['nama'])) ?> dari daftar kandidat?');">
              <input type="hidden" name="id" value="<?= (int) $row['id'] ?>">
              <button type="submit" class="btn-cta w-full flex items-center justify-center gap-1.5 text-sm font-medium px-3 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
              </button>
            </form>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- ===== Modal Tambah/Edit Kandidat ===== -->
  <div id="modalWrapKandidat" class="modal-hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="modal-overlay-bg absolute inset-0 bg-navy-950/60 backdrop-blur-sm" onclick="closeModalKandidat()"></div>

    <div class="modal-panel relative bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
      <div class="flex items-center justify-between mb-6">
        <h3 id="modalKandidatTitle" class="font-display font-semibold text-lg text-navy-900">Tambah Kandidat Baru</h3>
        <button type="button" onclick="closeModalKandidat()" class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <form id="formKandidat" action="simpan-kandidat.php" method="POST" enctype="multipart/form-data" class="space-y-5">
        <input type="hidden" name="id" id="inputKandidatId" value="">

        <!-- Foto: drag & drop + klik -->
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Foto Paslon</label>
          <div class="grid grid-cols-4 gap-4 items-center">
            <img id="previewFotoKandidat" src="https://placehold.co/120x120/EEF3FF/1E3A8A?text=Foto" alt="Preview"
                 class="w-full aspect-square rounded-xl object-cover border border-slate-200">

            <div id="dropzoneFoto"
                 class="col-span-3 border-2 border-dashed border-slate-300 bg-slate-50 hover:bg-primary-50 hover:border-primary-400 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer transition-colors text-center">
              <i data-lucide="upload-cloud" class="w-6 h-6 text-slate-400 mb-1.5"></i>
              <span class="text-sm font-semibold text-navy-900">Klik atau tarik foto ke sini</span>
              <span class="text-xs text-slate-500 mt-0.5">PNG, JPG, atau WEBP (maks 2MB)</span>
              <input type="file" name="foto" id="inputFotoKandidat" accept="image/png, image/jpeg, image/webp" class="hidden">
            </div>
          </div>
          <p class="text-[11px] text-slate-400 mt-1.5">Saat edit, kosongkan bagian ini jika tidak ingin mengganti foto.</p>
        </div>

        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Pasangan Calon</label>
          <input type="text" name="nama" id="inputNamaKandidat" required placeholder="cth. Aditya Pratama & Salsa Nabila"
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>

        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Visi</label>
          <textarea name="visi" id="inputVisiKandidat" rows="3" required placeholder="Tuliskan visi paslon..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm resize-none"></textarea>
        </div>

        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Misi</label>
          <textarea name="misi" id="inputMisiKandidat" rows="3" required placeholder="Tuliskan misi paslon..."
                    class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm resize-none"></textarea>
        </div>

        <div class="flex items-center gap-3 pt-2">
          <button type="button" onclick="closeModalKandidat()" class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-navy-700 hover:bg-slate-50 transition">Batal</button>
          <button type="submit" class="btn-cta flex-1 px-5 py-3 rounded-xl bg-primary-700 text-white text-sm font-semibold hover:bg-primary-600 transition">Simpan</button>
        </div>
      </form>
    </div>
  </div>

<?php if (!$is_ajax): ?>
    </main>
<?php endif; ?>

<!--
  Script khusus halaman ini. Dibungkus IIFE (function(){...})() supaya
  variabel const/let di dalamnya tidak bentrok "already declared" saat
  script ini dieksekusi ulang oleh footer.php setiap kali halaman Kandidat
  dibuka lagi lewat navigasi SPA. Fungsi yang dipanggil dari atribut
  onclick di HTML (openModalKandidat, closeModalKandidat) sengaja
  ditempel ke `window` supaya tetap bisa diakses dari luar IIFE.
-->
<script>
(function () {
  const form          = document.getElementById('formKandidat');
  const previewFoto    = document.getElementById('previewFotoKandidat');
  const dropzone       = document.getElementById('dropzoneFoto');
  const inputFoto      = document.getElementById('inputFotoKandidat');
  const PLACEHOLDER    = 'https://placehold.co/120x120/EEF3FF/1E3A8A?text=Foto';

  function openModalKandidat(mode, data) {
    form.reset();
    previewFoto.src = PLACEHOLDER;

    if (mode === 'edit' && data) {
      document.getElementById('modalKandidatTitle').textContent = 'Edit Kandidat';
      document.getElementById('inputKandidatId').value = data.id;
      document.getElementById('inputNamaKandidat').value = data.nama;
      document.getElementById('inputVisiKandidat').value = data.visi;
      document.getElementById('inputMisiKandidat').value = data.misi;
      if (data.image) previewFoto.src = 'uploads/kandidat/' + data.image;
    } else {
      document.getElementById('modalKandidatTitle').textContent = 'Tambah Kandidat Baru';
      document.getElementById('inputKandidatId').value = '';
    }

    document.getElementById('modalWrapKandidat').classList.remove('modal-hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeModalKandidat() {
    document.getElementById('modalWrapKandidat').classList.add('modal-hidden');
    document.body.style.overflow = '';
  }

  function tampilkanPreview(file) {
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      alert('Tolong unggah file berupa gambar (PNG/JPG/WEBP).');
      return;
    }
    const reader = new FileReader();
    reader.onload = (e) => { previewFoto.src = e.target.result; };
    reader.readAsDataURL(file);
  }

  // Klik dropzone -> buka file explorer
  dropzone.addEventListener('click', () => inputFoto.click());

  // Drag & drop
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-primary-500', 'bg-primary-50');
  });
  dropzone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50');
  });
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50');
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      inputFoto.files = e.dataTransfer.files;
      tampilkanPreview(e.dataTransfer.files[0]);
    }
  });

  // Pilih file lewat file explorer
  inputFoto.addEventListener('change', function () {
    if (this.files && this.files.length > 0) tampilkanPreview(this.files[0]);
  });

  // Tutup modal dengan Escape
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModalKandidat(); });

  // Ekspor ke global scope supaya bisa dipanggil dari atribut onclick di HTML
  window.openModalKandidat  = openModalKandidat;
  window.closeModalKandidat = closeModalKandidat;
})();
</script>

<?php if (!$is_ajax): ?>
  <?php require_once __DIR__ . '/../layout/partials/footer.php'; ?>
<?php endif; ?>
