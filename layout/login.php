<?php
/* =========================================================
   LOGIN.PHP — Validasi Token Voting
   SMK Informatika Sumedang — Sistem E-Voting OSIS
   ---------------------------------------------------------
   Di aplikasi nyata, $validTokens diganti dengan query ke
   database (cek token milik siswa, status "belum dipakai",
   lalu tandai sebagai "sudah dipakai" begitu berhasil login).
   Session yang diisi ($_SESSION['user']) memakai key yang
   sama dengan index.php, jadi begitu login di sini, tombol
   vote di halaman Kandidat otomatis ikut terbuka.
   ========================================================= */
session_start();

$error = null;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = strtoupper(trim($_POST['token'] ?? ''));

    // --- Contoh data dummy token yang valid (ganti dengan query DB) ---
    $validTokens = [
        'OSIS-2026-AB12' => ['nama' => 'Rangga Saputra', 'nis' => '2425.10.045'],
        'OSIS-2026-CD34' => ['nama' => 'Putri Ayu Lestari', 'nis' => '2425.10.078'],
        'OSIS-2026-EF56' => ['nama' => 'Fajar Nugroho', 'nis' => '2425.10.112'],
    ];

    if ($token === '') {
        $error = 'Token tidak boleh kosong.';
    } elseif (!array_key_exists($token, $validTokens)) {
        $error = 'Token tidak ditemukan atau sudah pernah digunakan.';
    } else {
        $_SESSION['user'] = [
            'nama'  => $validTokens[$token]['nama'],
            'nis'   => $validTokens[$token]['nis'],
            'token' => $token,
        ];
        header('Location: index.php#kandidat');
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Validasi Token Voting — E-Voting OSIS</title>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy:    { 950: '#0B1424', 900: '#0F172A' },
          primary: { 50: '#EEF3FF', 100: '#DCE7FF', 500: '#2563EB', 700: '#1E3A8A' },
          accent:  { 400: '#FACC15', 500: '#EAB308' },
        },
        fontFamily: {
          display: ['Poppins', 'sans-serif'],
          body: ['Inter', 'sans-serif'],
        },
      }
    }
  }
</script>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>

<style>
  html, body { font-family: 'Inter', sans-serif; }
  .font-display { font-family: 'Poppins', sans-serif; }
  .btn-cta { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease; }
  .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 12px 28px -8px rgba(234,179,8,0.45); }
  .token-input { transition: border-color .2s ease, box-shadow .2s ease; }
</style>
</head>

<body class="min-h-screen">

  <!-- ================= FULL BACKGROUND IMAGE ================= -->
  <div class="min-h-screen relative flex items-center justify-center p-4 sm:p-6 bg-cover bg-center"
       style="background-image:url('https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1600&q=80');">

    <!-- Overlay gelap transparan agar kartu tetap kontras -->
    <div class="absolute inset-0 bg-gradient-to-b from-navy-950/80 via-navy-900/70 to-navy-950/85 backdrop-blur-[2px]"></div>

    <!-- ================= KONTEN ================= -->
    <div class="relative z-10 w-full max-w-md">

      <!-- Deretan 3 Logo -->
      <div class="flex justify-center gap-4 mb-7">
        <img src="https://placehold.co/72x72/FFFFFF/1E3A8A?text=SMK" alt="Logo Sekolah"
             class="w-16 h-16 sm:w-16 sm:h-16 rounded-full bg-white/95 object-contain p-2 shadow-lg shadow-black/20">
        <img src="https://placehold.co/72x72/FFFFFF/1E3A8A?text=OSIS" alt="Logo OSIS"
             class="w-16 h-16 sm:w-16 sm:h-16 rounded-full bg-white/95 object-contain p-2 shadow-lg shadow-black/20">
        <img src="https://placehold.co/72x72/FFFFFF/1E3A8A?text=VOTE" alt="Logo E-Voting"
             class="w-16 h-16 sm:w-16 sm:h-16 rounded-full bg-white/95 object-contain p-2 shadow-lg shadow-black/20">
      </div>

      <!-- Kartu Login Utama -->
      <div class="bg-white/95 backdrop-blur-xl rounded-3xl shadow-2xl border border-white/40 p-7 sm:p-10">

        <div class="text-center mb-8">
          <div class="w-14 h-14 mx-auto rounded-2xl bg-primary-50 flex items-center justify-center mb-4">
            <i data-lucide="shield-check" class="w-7 h-7 text-primary-700"></i>
          </div>
          <h1 class="font-display font-bold text-xl sm:text-2xl text-navy-900">Login Pemilihan Osis</h1>
          <p class="text-sm text-slate-500 mt-2 leading-relaxed">Masukkan  <span class="font-bold">Token</span> Anda untuk memulai voting</p>
        </div>

        <?php if ($error): ?>
        <div class="mb-5 flex items-start gap-2 text-sm text-red-600 bg-red-50 border border-red-100 rounded-xl px-4 py-3">
          <i data-lucide="alert-circle" class="w-4 h-4 mt-0.5 shrink-0"></i>
          <span><?= htmlspecialchars($error) ?></span>
        </div>
        <?php endif; ?>

        <form method="POST" class="space-y-5">
          <!-- Satu-satunya input: Kode Token -->
          <div class="relative">
            <i data-lucide="ticket" class="w-5 h-5 text-primary-500 absolute left-4 top-1/2 -translate-y-1/2 pointer-events-none"></i>
            <input
              type="text"
              name="token"
              required
              autofocus
              autocomplete="off"
              placeholder="TOKEN VOTING"
              class="token-input w-full pl-12 pr-4 py-4 rounded-2xl border-2 border-slate-200 text-center text-lg sm:text-xl font-display font-bold tracking-[0.15em] text-navy-900 placeholder:text-slate-300 placeholder:font-normal placeholder:tracking-normal focus:border-primary-500 focus:ring-4 focus:ring-primary-100 outline-none"
            >
          </div>

          <button type="submit"
                  class="btn-cta w-full flex items-center justify-center gap-2 bg-accent-400 hover:bg-accent-500 text-navy-900 font-display font-bold text-base py-4 rounded-2xl">
            Masuk dan Mulai Voting
          </button>
        </form>
      </div>
    </div>
  </div>

<script>
  lucide.createIcons();
</script>
</body>
</html>