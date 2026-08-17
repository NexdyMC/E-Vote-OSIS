<?php
/* =========================================================
   ADMIN/SISWA.PHP — Data Siswa / Data Pemilih Tetap (DPT)
   ---------------------------------------------------------
   Kolom yang dipakai (sesuai tb_siswa di conn.php):
   token, nama, kelas, status (0/1 = belum/sudah voting), voted
   ========================================================= */
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';
require_once __DIR__ . '/../api/conn.php';

if (!isset($_SESSION['id_admin'])) {
    header("Location: index.php");
    exit;
}

$pesan_alert = '';
if (isset($_GET['v']) && $_GET['v'] === 'false') {
    $pesan_alert = "<div class='  p-4 mb-6 text-sm text-red-800 rounded-xl bg-red-50 border border-red-100 font-medium'>Gagal menambahkan siswa. Pastikan nama &amp; kelas terisi.</div>";
}

$tokenBaru = $_GET['new_token'] ?? null;
$namaBaru  = $_GET['nama'] ?? null;

$admin = $_SESSION['admin'] ?? [
    'nama' => 'Bu Rina Marlina, S.Kom',
    'foto' => 'https://i.pravatar.cc/150?img=47',
    'role' => 'Admin Pemilu',
];

// --- Data siswa & statistik langsung dari database ---
$siswa_list = $conn->select_siswa('1 ORDER BY nama ASC');
$statistik  = $conn->persen_voting_siswa();
$pageTitle  = 'Data Siswa / Data Pemilih Tetap (DPT)';
$breadcrumb = ['Admin', 'Siswa / Data DPT'];
$activePage = 'siswa';

if (!$is_ajax) {
    require_once __DIR__ . '/../layout/admin/header.php';
    require_once __DIR__ . '/../layout/admin/sidebar.php';
    require_once __DIR__ . '/../layout/admin/navbar.php';
    ?>
    <main id="main-content" class="flex-1 p-4 sm:p-8 overflow-y-auto">
<?php } ?>

  <?= $pesan_alert ?>

  <?php if ($tokenBaru): ?>
  <div data-aos="fade-up" class="mb-6 p-5 rounded-2xl bg-primary-50 border border-primary-100 flex flex-col sm:flex-row sm:items-center gap-4">
    <div class="w-11 h-11 rounded-xl bg-primary-700 flex items-center justify-center shrink-0">
      <i data-lucide="check-circle-2" class="w-5 h-5 text-accent-400"></i>
    </div>
    <div class="flex-1 min-w-0">
      <p class="text-sm font-semibold text-navy-900"><?= htmlspecialchars($namaBaru) ?> berhasil ditambahkan</p>
      <p class="text-xs text-slate-500 mt-0.5">Berikan token berikut ke siswa untuk login voting:</p>
    </div>
    <div class="flex items-center gap-2 shrink-0">
      <code id="tokenBaruText" class="px-3 py-2 rounded-lg bg-white border border-primary-200 font-display font-bold tracking-widest text-primary-700 text-sm"><?= htmlspecialchars($tokenBaru) ?></code>
      <button type="button" onclick="salinToken()" title="Salin token" class="w-9 h-9 rounded-lg border border-primary-200 bg-white hover:bg-primary-100 flex items-center justify-center text-primary-700">
        <i data-lucide="copy" class="w-4 h-4"></i>
      </button>
    </div>
  </div>
  <?php endif; ?>

  <!-- ============ MINI STAT ============ -->
  <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-6">
    <div data-aos="fade-up" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
      <p class="text-2xl font-display font-bold text-navy-900"><?= number_format($statistik['total_siswa'], 0, ',', '.') ?></p>
      <p class="text-sm text-slate-500 mt-1">Total Siswa</p>
    </div>
    <div data-aos="fade-up" data-aos-delay="80" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
      <p class="text-2xl font-display font-bold text-emerald-600"><?= number_format($statistik['sudah_voting'], 0, ',', '.') ?></p>
      <p class="text-sm text-slate-500 mt-1">Sudah Memilih</p>
    </div>
    <div data-aos="fade-up" data-aos-delay="160" class="bg-white rounded-2xl p-5 border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)]">
      <p class="text-2xl font-display font-bold text-slate-400"><?= number_format($statistik['belum_voting'], 0, ',', '.') ?></p>
      <p class="text-sm text-slate-500 mt-1">Belum Memilih</p>
    </div>
  </div>

  <!-- ============ HEADER + TOMBOL TAMBAH ============ -->
  <div data-aos="fade-up" class="flex items-center justify-between mb-6 gap-4">
    <div>
      <h2 class="font-display font-semibold text-navy-900">Daftar Siswa</h2>
      <p class="text-sm text-slate-500 mt-1"><?= count($siswa_list) ?> siswa terdaftar</p>
    </div>
    <button type="button" onclick="openModalSiswa()" data-aos="fade-up" class="btn-cta flex items-center gap-2 px-5 py-2.5 rounded-xl bg-primary-700 text-white text-sm font-semibold hover:bg-primary-600 shrink-0">
      <i data-lucide="user-plus" class="w-4 h-4"></i>
      <span class="hidden sm:inline">Tambah Siswa</span>
    </button>
  </div>

  <!-- ============ TABEL SISWA ============ -->
  <div data-aos="fade-up" class="bg-white rounded-3xl border border-slate-100 shadow-[0_8px_24px_rgb(15,23,42,0.05)] overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-sm">
        <thead>
          <tr class="border-b border-slate-100 bg-slate-50/60">
            <th class="text-left font-semibold text-slate-500 px-5 py-3 w-12">No</th>
            <th class="text-left font-semibold text-slate-500 px-5 py-3">Token</th>
            <th class="text-left font-semibold text-slate-500 px-5 py-3">Nama</th>
            <th class="text-left font-semibold text-slate-500 px-5 py-3">Kelas</th>
            <th class="text-left font-semibold text-slate-500 px-5 py-3">Status Voting</th>
            <th class="text-right font-semibold text-slate-500 px-5 py-3">Aksi</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($siswa_list)): ?>
          <tr>
            <td colspan="6" class="text-center text-slate-400 px-5 py-10">Belum ada data siswa.</td>
          </tr>
          <?php else: foreach ($siswa_list as $i => $s): ?>
          <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50/60">
            <td class="px-5 py-3.5 text-slate-500"><?= $i + 1 ?></td>
            <td class="px-5 py-3.5">
              <code class="px-2 py-1 rounded-md bg-slate-100 text-navy-700 text-xs font-semibold tracking-wider"><?= htmlspecialchars($s['token']) ?></code>
            </td>
            <td class="px-5 py-3.5 font-medium text-navy-900"><?= htmlspecialchars($s['nama']) ?></td>
            <td class="px-5 py-3.5 text-slate-600"><?= htmlspecialchars($s['kelas']) ?></td>
            <td class="px-5 py-3.5">
              <?php if ((int) $s['status'] === 1): ?>
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-emerald-700 bg-emerald-50 px-2.5 py-1 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-emerald-500"></span> Sudah Memilih
                </span>
              <?php else: ?>
                <span class="inline-flex items-center gap-1.5 text-xs font-semibold text-slate-500 bg-slate-100 px-2.5 py-1 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-slate-400"></span> Belum Memilih
                </span>
              <?php endif; ?>
            </td>
            <td class="px-5 py-3.5 text-right">
              <form action="hapus-siswa.php" method="POST" class="inline"
                    onsubmit="return confirm('Hapus <?= htmlspecialchars(addslashes($s['nama'])) ?> dari data siswa?');">
                <input type="hidden" name="token" value="<?= htmlspecialchars($s['token']) ?>">
                <button type="submit" title="Hapus" class="w-9 h-9 rounded-lg bg-red-50 text-red-600 hover:bg-red-100 flex items-center justify-center ml-auto">
                  <i data-lucide="trash-2" class="w-4 h-4"></i>
                </button>
              </form>
            </td>
          </tr>
          <?php endforeach; endif; ?>
        </tbody>
      </table>
    </div>
  </div>

  <!-- ============ MODAL TAMBAH SISWA ============ -->
  <div id="modalWrapSiswa" class="modal-hidden fixed inset-0 z-50 flex items-center justify-center p-4">
    <div class="modal-overlay-bg absolute inset-0 bg-navy-950/60 backdrop-blur-sm" onclick="closeModalSiswa()"></div>

    <div class="modal-panel relative bg-white w-full max-w-md rounded-3xl shadow-2xl p-6 sm:p-8">
      <div class="flex items-center justify-between mb-6">
        <h3 class="font-display font-semibold text-lg text-navy-900">Tambah Siswa Baru</h3>
        <button type="button" onclick="closeModalSiswa()" class="w-9 h-9 rounded-full hover:bg-slate-100 flex items-center justify-center text-slate-400">
          <i data-lucide="x" class="w-5 h-5"></i>
        </button>
      </div>

      <form action="simpan-siswa.php" method="POST" class="space-y-5">
        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Nama Siswa</label>
          <input type="text" name="nama" required placeholder="cth. Putri Ayu Lestari"
                 class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
        </div>

        <div>
          <label class="text-sm font-medium text-navy-700 mb-1.5 block">Kelas</label>
          <select name="kelas" id="input-kelas" require class="w-full px-4 py-2.5 rounded-xl border border-slate-200 focus:border-primary-500 focus:ring-2 focus:ring-primary-100 outline-none text-sm">
            <option value="">Pilih Kelas</option>
            <!-- option : 10 RPL -->
            <option value="10 RPL 1">10 RPL 1</option>
            <option value="10 RPL 2">10 RPL 2</option>
            <option value="10 RPL 3">10 RPL 3</option>
            <option value="10 RPL 4">10 RPL 4</option>
            <option value="10 RPL 5">10 RPL 5</option>
            <option value="10 RPL 6">10 RPL 6</option>
            <option value="10 RPL 7">10 RPL 7</option>
            <option value="10 RPL 8">10 RPL 8</option>
            <option value="10 RPL 9">10 RPL 9</option>
            <!--  Kelas : 10 DKV -->
            <option value="10 DKV 1">10 DKV 1</option>
            <option value="10 DKV 2">10 DKV 2</option>
            <option value="10 DKV 3">10 DKV 3</option>
            <!-- option : 11 RPL -->
            <option value="11 RPL 1">11 RPL 1</option>
            <option value="11 RPL 2">11 RPL 2</option>
            <option value="11 RPL 3">11 RPL 3</option>
            <option value="11 RPL 4">11 RPL 4</option>
            <option value="11 RPL 5">11 RPL 5</option>
            <option value="11 RPL 6">11 RPL 6</option>
            <option value="11 RPL 7">11 RPL 7</option>
            <option value="11 RPL 8">11 RPL 8</option>
            <option value="11 RPL 9">11 RPL 9</option>
            <!--  Kelas : 11 DKV -->
            <option value="11 DKV 1">11 DKV 1</option>
            <option value="11 DKV 2">11 DKV 2</option>
            <option value="11 DKV 3">11 DKV 3</option>
            <!-- option : 12 RPL -->
            <option value="12 RPL 1">12 RPL 1</option>
            <option value="12 RPL 2">12 RPL 2</option>
            <option value="12 RPL 3">12 RPL 3</option>
            <option value="12 RPL 4">12 RPL 4</option>
            <option value="12 RPL 5">12 RPL 5</option>
            <option value="12 RPL 6">12 RPL 6</option>
            <option value="12 RPL 7">12 RPL 7</option>
            <option value="12 RPL 8">12 RPL 8</option>
            <option value="12 RPL 9">12 RPL 9</option>
            <!--  Kelas : 12 DKV -->
            <option value="12 DKV 1">12 DKV 1</option>
            <option value="12 DKV 2">12 DKV 2</option>
            <option value="12 DKV 3">12 DKV 3</option>
          </select>
        </div>

        <p class="text-xs text-slate-400 -mt-2">Token voting dibuat otomatis oleh sistem setelah data disimpan.</p>

        <div class="flex items-center gap-3 pt-2">
          <button type="button" onclick="closeModalSiswa()" class="flex-1 px-5 py-3 rounded-xl border border-slate-200 text-sm font-semibold text-navy-700 hover:bg-slate-50 transition">Batal</button>
          <button type="submit" class="btn-cta flex-1 px-5 py-3 rounded-xl bg-primary-700 text-white text-sm font-semibold hover:bg-primary-600 transition">Simpan</button>
        </div>
      </form>
    </div>
  </div>

<?php if (!$is_ajax): ?>
    </main>
<?php endif; ?>

<!-- Script khusus halaman ini — dibungkus IIFE, fungsi dipakai onclick di-ekspor ke window -->
<script>
(function () {
  function openModalSiswa() {
    document.getElementById('modalWrapSiswa').classList.remove('modal-hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeModalSiswa() {
    document.getElementById('modalWrapSiswa').classList.add('modal-hidden');
    document.body.style.overflow = '';
  }

  document.addEventListener('keydown', function (e) {
    if (e.key === 'Escape') closeModalSiswa();
  });

  window.openModalSiswa  = openModalSiswa;
  window.closeModalSiswa = closeModalSiswa;

  window.salinToken = function () {
    const el = document.getElementById('tokenBaruText');
    if (!el || !navigator.clipboard) return;
    navigator.clipboard.writeText(el.textContent.trim()).catch(function () {});
  };
})();
</script>

<?php if (!$is_ajax): ?>
  <?php require_once __DIR__ . '/../layout/admin/footer.php'; ?>
<?php endif; ?>
