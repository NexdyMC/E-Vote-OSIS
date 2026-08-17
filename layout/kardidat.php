<?php
/* =========================================================
   KANDIDAT.PHP — Kelola Pasangan Calon (Admin Panel)
   SMK Informatika Sumedang — Sistem E-Voting OSIS
   ---------------------------------------------------------
   $kandidat_list di bawah ini adalah data dummy. Di aplikasi
   nyata, array ini diganti dengan hasil query database, misal:
   $kandidat_list = $pdo->query("SELECT * FROM kandidat ORDER BY nomor_urut")->fetchAll();
   ========================================================= */
session_start();

$admin = $_SESSION['admin'] ?? [
    'nama' => 'Bu Rina Marlina, S.Kom',
    'foto' => 'https://i.pravatar.cc/150?img=47',
    'role' => 'Admin Pemilu',
];

// --- DATA DUMMY: minimal 3 pasangan calon ---
$kandidat_list = [
    [
        'id'         => 1,
        'nomor_urut' => 1,
        'foto'       => 'https://images.unsplash.com/photo-1633332755192-727a05c4013d?w=400&h=400&fit=crop&auto=format',
        'nama_ketua' => 'Aditya Pratama',
        'nama_wakil' => 'Salsa Nabila',
        'visi_misi'  => 'Mewujudkan OSIS yang inklusif, kolaboratif, dan berbasis teknologi untuk seluruh warga sekolah melalui program kerja yang nyata dan terukur.',
    ],
    [
        'id'         => 2,
        'nomor_urut' => 2,
        'foto'       => 'https://images.unsplash.com/photo-1500648767791-00dcc994a43e?w=400&h=400&fit=crop&auto=format',
        'nama_ketua' => 'Bima Nugraha',
        'nama_wakil' => 'Keisya Aulia',
        'visi_misi'  => 'OSIS yang mendengar, bergerak cepat, dan membangun ekosistem organisasi yang transparan bagi seluruh siswa SMK Informatika Sumedang.',
    ],
    [
        'id'         => 3,
        'nomor_urut' => 3,
        'foto'       => 'https://images.unsplash.com/photo-1531123897727-8f129e1688ce?w=400&h=400&fit=crop&auto=format',
        'nama_ketua' => 'Citra Ramadhani',
        'nama_wakil' => 'Farrel Hidayat',
        'visi_misi'  => 'Sinergi siswa dan sekolah melalui program kerja yang nyata, kreatif, dan berkelanjutan di bidang akademik maupun non-akademik.',
    ],
];

$pageTitle  = 'Kelola Pasangan Calon / Kandidat';
$breadcrumb = ['Admin', 'Kandidat'];
$activePage = 'kandidat';
?>
<!DOCTYPE html>
<html lang="id">
<head>
<title>Kelola Kandidat — Admin E-Voting OSIS</title>
<?php require __DIR__ . '/partials/head-assets.php'; ?>
</head>
<body class="bg-[#F8FAFC]">

<div class="flex min-h-screen">
  <?php require __DIR__ . '/partials/sidebar.php'; ?>

  <main class="flex-1 min-w-0">
    <?php require __DIR__ . '/partials/topbar.php'; ?>

    <div class="p-4 sm:p-8">

      <div class="flex items-center justify-between mb-6">
        <div>
          <h2 class="font-display font-semibold text-navy-900">Daftar Pasangan Calon</h2>
          <p class="text-sm text-slate-500 mt-1"><?= count($kandidat_list) ?> kandidat terdaftar untuk periode ini</p>
        </div>
      </div>

      <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">

        <!-- ===== Kartu: Tambah Kandidat Baru ===== -->
        <button type="button" onclick="openModal('add')" data-aos="fade-up"
                class="card-dashed rounded-3xl min-h-[360px] flex flex-col items-center justify-center gap-3 p-6 text-center">
          <div class="w-16 h-16 rounded-full bg-primary-50 flex items-center justify-center">
            <i data-lucide="plus" class="w-8 h-8 text-primary-600"></i>
          </div>
          <p class="font-display font-semibold text-navy-900">Tambah Kandidat Baru</p>
          <p class="text-xs text-slate-500 max-w-[190px] leading-relaxed">Daftarkan pasangan calon ketua &amp; wakil ketua OSIS</p>
        </button>

        <!-- ===== Kartu: Data Kandidat (foreach) ===== -->
        <?php foreach ($kandidat_list as $i => $k): ?>
        <div data-aos="fade-up" data-aos-delay="<?= min(($i + 1) * 80, 320) ?>"
             class="card-hover bg-white rounded-3xl border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)] overflow-hidden">

          <div class="relative">
            <span class="absolute top-4 left-4 z-10 w-10 h-10 rounded-full bg-accent-400 text-navy-900 font-display font-bold flex items-center justify-center shadow-md shadow-accent-500/30">
              <?= $k['nomor_urut'] ?>
            </span>
            <img src="<?= htmlspecialchars($k['foto']) ?>" alt="Foto Paslon <?= $k['nomor_urut'] ?>" class="w-full h-48 object-cover">
          </div>

          <div class="p-5">
            <h3 class="font-display font-semibold text-navy-900 leading-snug">
              <?= htmlspecialchars($k['nama_ketua']) ?> <span class="text-slate-400 font-normal">&amp;</span> <?= htmlspecialchars($k['nama_wakil']) ?>
            </h3>
            <p class="text-sm text-slate-500 mt-2 line-clamp-2"><?= htmlspecialchars($k['visi_misi']) ?></p>

            <div class="flex items-center gap-2 mt-5">
              <!-- Edit: buka modal yang sama, terisi otomatis dari data PHP -->
              <button type="button"
                      data-kandidat='<?= htmlspecialchars(json_encode($k), ENT_QUOTES, 'UTF-8') ?>'
                      onclick="openModal('edit', JSON.parse(this.dataset.kandidat))"
                      class="btn-cta flex-1 flex items-center justify-center gap-1.5 text-sm font-medium px-3 py-2.5 rounded-xl bg-primary-50 text-primary-700 hover:bg-primary-100">
                <i data-lucide="pencil" class="w-4 h-4"></i> Edit
              </button>

              <!-- Hapus: form POST sungguhan ke endpoint hapus-kandidat.php -->
              <form action="hapus-kandidat.php" method="POST" class="flex-1"
                    onsubmit="return confirm('Hapus <?= htmlspecialchars(addslashes($k['nama_ketua'] . ' & ' . $k['nama_wakil'])) ?> dari daftar kandidat?');">
                <input type="hidden" name="id" value="<?= $k['id'] ?>">
                <button type="submit" class="btn-cta w-full flex items-center justify-center gap-1.5 text-sm font-medium px-3 py-2.5 rounded-xl bg-red-50 text-red-600 hover:bg-red-100">
                  <i data-lucide="trash-2" class="w-4 h-4"></i> Hapus
                </button>
              </form>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>
  </main>
</div>

<!-- =========================================================
     MODAL: Tambah / Edit Kandidat (hidden by default)
     ========================================================= -->
<div id="modalWrap" class="modal-hidden fixed inset-0 z-50 flex items-center justify-center p-4">
  <div id="modalOverlay" onclick="closeModal()" class="absolute inset-0 bg-navy-950/60 backdrop-blur-sm"></div>

  <div id="modalPanel" class="relative bg-white w-full max-w-lg rounded-3xl shadow-2xl p-6 sm:p-8 max-h-[90vh] overflow-y-auto">
    <div class="flex items-center justify-between mb-6">
      <h3 id="modalTitle" class="font-display font-semibold text-lg text-navy-900">Tambah Kandidat Baru</h3>
      <button type="button" onclick="closeModal()" class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400">
        <i data-lucide="x" class="w-5 h-5"></i>
      </button>
    </div>

    <!-- action mengarah ke endpoint API/PHP yang menyimpan ke database -->
    <form id="formKandidat" action="simpan-kandidat.php" method="POST" enctype="multipart/form-data" class="space-y-5">
      <input type="hidden" name="id" id="inputId" value="">

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Foto Paslon</label>
        <div class="flex items-center gap-4">
          <img id="previewFoto" src="https://placehold.co/100x100/EEF3FF/1E3A8A?text=Foto" alt="Preview" class="w-16 h-16 rounded-xl object-cover border border-slate-200 shrink-0">
          <input type="file" name="foto" id="inputFoto" accept="image/*" onchange="previewFotoFile(this)"
                 class="text-xs text-slate-600 file:mr-3 file:py-2 file:px-4 file:rounded-lg file:border-0 file:bg-primary-50 file:text-primary-700 file:font-medium file:text-sm hover:file:bg-primary-100">
        </div>
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nomor Urut</label>
        <input type="number" name="nomor_urut" id="inputNomor" min="1" required
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Calon Ketua</label>
        <input type="text" name="nama_ketua" id="inputKetua" required placeholder="cth. Aditya Pratama"
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Calon Wakil Ketua</label>
        <input type="text" name="nama_wakil" id="inputWakil" required placeholder="cth. Salsa Nabila"
               class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
      </div>

      <div>
        <label class="text-sm font-medium text-navy-700 mb-1.5 block">Visi &amp; Misi</label>
        <textarea name="visi_misi" id="inputVisi" rows="4" required placeholder="Tuliskan ringkasan visi dan misi..."
                  class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm resize-none"></textarea>
      </div>

      <div class="flex items-center gap-3 pt-2">
        <button type="button" onclick="closeModal()" class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-navy-700 hover:bg-slate-50">Batal</button>
        <button type="submit" class="btn-cta flex-1 px-5 py-3 rounded-xl bg-primary-700 text-white text-sm font-semibold hover:bg-primary-600">Simpan Kandidat</button>
      </div>
    </form>
  </div>
</div>

<script>
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

<?php require __DIR__ . '/partials/js-base.php'; ?>
</body>
</html>