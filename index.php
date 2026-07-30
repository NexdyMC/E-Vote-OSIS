<?php

require_once __DIR__ . '/api/conn.php';
session_start();

$isLoggedIn = isset($_SESSION['user']);
$namaSiswa  = $isLoggedIn ? $_SESSION['user']['nama'] : null;


// $kandidat = [
//     [
//         'nomor' => 1,
//         'nama'  => 'Aditya Pratama & Salsa Nabila',
//         'foto'  => 'https://placehold.co/400x400/1E3A8A/F8FAFC?text=Paslon+01',
//         'visi'  => 'Mewujudkan OSIS yang inklusif, kolaboratif, dan berbasis teknologi untuk seluruh warga sekolah.',
//     ],
//     [
//         'nomor' => 2,
//         'nama'  => 'Bima Nugraha & Keisya Aulia',
//         'foto'  => 'https://placehold.co/400x400/2563EB/F8FAFC?text=Paslon+02',
//         'visi'  => 'OSIS yang mendengar, bergerak cepat, dan membangun ekosistem organisasi yang transparan.',
//     ],
//     [
//         'nomor' => 3,
//         'nama'  => 'Citra Ramadhani & Farrel Hidayat',
//         'foto'  => 'https://placehold.co/400x400/0F172A/FACC15?text=Paslon+03',
//         'visi'  => 'Sinergi siswa dan sekolah melalui program kerja yang nyata, kreatif, dan berkelanjutan.',
//     ],
// ];

// --- WAKTU BATAS AKHIR VOTING (ganti sesuai jadwal sekolah) ---
$waktuVotingBerakhir = strtotime('2026-09-26 08:00:00'); // format: Y-m-d H:i:s

// --- ID VIDEO YOUTUBE TUTORIAL VOTING (ganti dengan ID video asli) ---
$idVideoTutorial = 'ID_VIDEO_YOUTUBE_ANDA';
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Pemilihan Ketua OSIS — SMK Informatika Sumedang</title>

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy: {
            950: '#0B1424',
            900: '#0F172A',
            800: '#152238',
          },
          primary: {
            50:  '#EEF3FF',
            100: '#DCE7FF',
            500: '#2563EB',
            600: '#1D4ED8',
            700: '#1E3A8A',
          },
          accent: {
            300: '#FDE68A',
            400: '#FACC15',
            500: '#EAB308',
          },
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

<style>
  html { font-family: 'Inter', sans-serif; }
  h1, h2, h3, .font-display { font-family: 'Poppins', sans-serif; }

  /* ---------- Wave / slanted dividers between sections ---------- */
  .divider { display: block; width: 100%; line-height: 0; }
  .divider svg { width: 100%; height: 90px; display: block; }

  /* ---------- Soft glow blobs on hero ---------- */
  .blob {
    position: absolute;
    border-radius: 9999px;
    filter: blur(60px);
    opacity: 0.35;
    pointer-events: none;
  }

  /* ---------- Timeline glowing connector ---------- */
  .timeline-line {
    background: linear-gradient(180deg, #FACC15 0%, #38BDF8 50%, #FACC15 100%);
    box-shadow: 0 0 12px 2px rgba(250, 204, 21, 0.55), 0 0 24px 6px rgba(56, 189, 248, 0.25);
    animation: pulseGlow 3s ease-in-out infinite;
  }
  @keyframes pulseGlow {
    0%, 100% { box-shadow: 0 0 10px 2px rgba(250,204,21,.45), 0 0 22px 6px rgba(56,189,248,.2); }
    50%      { box-shadow: 0 0 18px 4px rgba(250,204,21,.75), 0 0 32px 10px rgba(56,189,248,.4); }
  }
  .timeline-dot {
    box-shadow: 0 0 0 4px rgba(15,23,42,1), 0 0 14px 3px rgba(250,204,21,.8);
  }
  .timeline-dot.live {
    animation: livePulse 1.6s ease-in-out infinite;
  }
  @keyframes livePulse {
    0%, 100% { box-shadow: 0 0 0 4px rgba(15,23,42,1), 0 0 10px 2px rgba(56,189,248,.7); }
    50%      { box-shadow: 0 0 0 4px rgba(15,23,42,1), 0 0 22px 8px rgba(56,189,248,1); }
  }

  /* ---------- Candidate card hover ---------- */
  .card-kandidat { transition: transform .35s ease, box-shadow .35s ease; }
  .card-kandidat:hover { transform: translateY(-8px); box-shadow: 0 20px 40px -12px rgba(30,58,138,0.25); }

  /* ---------- Button hover shine ---------- */
  .btn-cta { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease; }
  .btn-cta:hover { transform: translateY(-2px); box-shadow: 0 10px 25px -6px rgba(37,99,235,0.45); }
  .btn-accent:hover { box-shadow: 0 10px 25px -6px rgba(234,179,8,0.5); }

  @media (prefers-reduced-motion: reduce) {
    .timeline-line, .timeline-dot.live { animation: none !important; }
  }

  /* ---------- Countdown: glowing horizontal connector ---------- */
  .countdown-line {
    background: linear-gradient(90deg, #FACC15 0%, #38BDF8 50%, #FACC15 100%);
    animation: pulseGlowH 3s ease-in-out infinite;
  }
  @keyframes pulseGlowH {
    0%, 100% { box-shadow: 0 0 10px 2px rgba(250,204,21,.45), 0 0 22px 6px rgba(56,189,248,.2); }
    50%      { box-shadow: 0 0 18px 4px rgba(250,204,21,.75), 0 0 32px 10px rgba(56,189,248,.4); }
  }
  .countdown-box {
    box-shadow: 0 0 0 4px rgba(15,23,42,1), 0 0 16px 2px rgba(250,204,21,.35);
  }
  .countdown-number {
    text-shadow: 0 0 18px rgba(250,204,21,.45);
    font-variant-numeric: tabular-nums;
  }

  /* ---------- Tips timeline (light) reuses glow dot/line, tuned for light bg ---------- */
  .timeline-dot-light {
    box-shadow: 0 0 0 4px #F8FAFC, 0 0 14px 3px rgba(37,99,235,.55);
  }

  /* ---------- Video facade play button ---------- */
  .play-btn {
    transition: transform .25s ease, box-shadow .25s ease;
    box-shadow: 0 0 0 0 rgba(250,204,21,.55);
    animation: playPulse 2.2s ease-in-out infinite;
  }
  @keyframes playPulse {
    0%, 100% { box-shadow: 0 0 0 0 rgba(250,204,21,.45); }
    50%      { box-shadow: 0 0 0 16px rgba(250,204,21,0); }
  }
  .video-facade:hover .play-btn { transform: scale(1.1); }

  @media (prefers-reduced-motion: reduce) {
    .countdown-line, .play-btn { animation: none !important; }
  }
</style>
</head>
<body class="bg-white text-navy-900 antialiased">

<!-- ================= NAVBAR ================= -->
<header class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
  <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
    <div class="flex items-center gap-2">
      <div class="w-9 h-9 rounded-xl bg-primary-700 flex items-center justify-center font-display font-bold text-accent-400">SI</div>
      <span class="font-display font-semibold text-sm sm:text-base text-navy-900">SMK Informatika <span class="text-primary-600">Sumedang</span></span>
    </div>
    <div class="hidden md:flex items-center gap-8 text-sm font-medium text-navy-800">
      <a href="#beranda" class="hover:text-primary-600 transition">Beranda</a>
      <a href="#tahapan" class="hover:text-primary-600 transition">Tahapan</a>
      <a href="#kandidat" class="hover:text-primary-600 transition">Kandidat</a>
      <a href="#countdown" class="hover:text-primary-600 transition">Countdown</a>
      <a href="#tips" class="hover:text-primary-600 transition">Tips</a>
      <a href="#video" class="hover:text-primary-600 transition">Video</a>
    </div>

    <?php if ($isLoggedIn): ?>
      <div class="flex items-center gap-3">
        <span class="hidden sm:block text-sm text-navy-700">Hai, <span class="font-semibold"><?= htmlspecialchars($namaSiswa) ?></span></span>
        <a href="logout.php" class="text-sm font-medium px-4 py-2 rounded-full border border-slate-200 hover:bg-slate-50 transition">Keluar</a>
      </div>
    <?php else: ?>
      <a href="login.php" class="btn-cta text-sm font-semibold px-5 py-2.5 rounded-full bg-primary-700 text-white hover:bg-primary-600">Masuk</a>
    <?php endif; ?>
  </nav>
</header>

<!-- section : hero -->
<section id="beranda" class="relative overflow-hidden bg-[#F8FAFC] pt-40 pb-32">
  <div class="blob w-72 h-72 bg-primary-500 -top-10 -left-10"></div>
  <div class="blob w-80 h-80 bg-accent-400 top-24 right-0"></div>

  <div class="relative max-w-6xl mx-auto px-6 text-center">
    <h1 class="font-display font-extrabold text-4xl sm:text-5xl lg:text-6xl leading-tight mt-6 text-navy-900">
      Satu Suara <span class="text-primary-700">Satu Arah</span> 
      <br>untuk
      <span class="relative inline-block text-[#FACC15]">
        OSIS
      </span> yang Lebih Baik.
    </h1>

    <p class="mt-6 text-base sm:text-lg text-navy-700 max-w-2xl mx-auto">
      Gunakan hak pilihmu secara digital, aman, dan transparan. Kenali calon pemimpinmu, ikuti setiap tahapan, dan pantau hasil suara secara real-time.
    </p>

    <div class="mt-10 flex flex-col sm:flex-row items-center justify-center gap-4">
      <a href="#kandidat" class="btn-cta btn-accent font-display font-semibold px-8 py-3.5 rounded-full bg-accent-400 text-navy-900 hover:bg-accent-500">
        Lihat Kandidat
      </a>
      <a href="#tahapan" class="btn-cta font-display font-semibold px-8 py-3.5 rounded-full border-2 border-primary-700 text-primary-700 hover:bg-primary-700 hover:text-white">
        Jadwal Tahapan
      </a>
    </div>
  </div>

  <!-- Wave divider: light to dark -->
  <div class="divider absolute bottom-0 left-0 -mb-px">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
    </svg>
  </div>
</section>

<!-- section : time line -->
<section id="tahapan" class="relative bg-navy-900 pt-28 pb-32 overflow-hidden">
  <div class="blob w-96 h-96 bg-primary-600 top-1/3 -right-20 opacity-20"></div>

  <div class="relative max-w-5xl mx-auto px-6">
    <div class="text-center mb-20">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-accent-400 uppercase">Alur Pemilihan</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-white mt-3">Tahapan Pemilu OSIS</h2>
      <p class="text-slate-400 mt-3 max-w-xl mx-auto">Empat tahap resmi menuju terpilihnya Ketua OSIS periode berikutnya.</p>
    </div>

    <div class="relative">
      <div class="timeline-line absolute left-[27px] md:left-1/2 md:-translate-x-1/2 top-0 bottom-0 w-[3px] rounded-full"></div>

      <?php
      $tahapan = [
        [
          'label' => 'Tahap 01',
          'judul' => 'Pendaftaran & Kampanye',
          'desc'  => 'Calon mendaftarkan diri dan menyampaikan visi-misi melalui poster digital serta media sosial sekolah.',
          'live'  => false,
        ],
        [
          'label' => 'Tahap 02',
          'judul' => 'Debat Terbuka',
          'desc'  => 'Seluruh kandidat memaparkan program kerja dan menjawab pertanyaan siswa secara langsung di aula sekolah.',
          'live'  => false,
        ],
        [
          'label' => 'Tahap 03',
          'judul' => 'Hari Pemungutan Suara',
          'desc'  => 'Siswa memilih melalui portal e-voting menggunakan akun siswa masing-masing, satu suara per akun.',
          'live'  => false,
        ],
        [
          'label' => 'Tahap 04',
          'judul' => 'Live Count Hasil (API)',
          'desc'  => 'Hasil suara ditayangkan secara real-time melalui API perhitungan suara langsung ke dashboard sekolah.',
          'live'  => true,
        ],
      ];
      foreach ($tahapan as $i => $t):
        $kanan = $i % 2 === 1; // untuk selang-seling di desktop
      ?>
      <div class="relative flex items-start md:items-center mb-14 last:mb-0 <?= $kanan ? 'md:flex-row-reverse' : '' ?>">
        <!-- dot -->
        <span class="timeline-dot <?= $t['live'] ? 'live' : '' ?> absolute left-[21px] md:left-1/2 md:-translate-x-1/2 top-1.5 w-3.5 h-3.5 rounded-full bg-accent-400 z-10"></span>

        <div class="w-full md:w-1/2 <?= $kanan ? 'md:pl-12' : 'md:pr-12' ?> pl-16 md:pl-0">
          <div class="bg-navy-800/70 border border-white/5 rounded-2xl p-6 backdrop-blur-sm">
            <div class="flex items-center gap-3 mb-2">
              <span class="text-xs font-semibold tracking-widest text-accent-400"><?= $t['label'] ?></span>
              <?php if ($t['live']): ?>
                <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-sky-300 bg-sky-400/10 px-2.5 py-0.5 rounded-full">
                  <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span> LIVE
                </span>
              <?php endif; ?>
            </div>
            <h3 class="font-display font-semibold text-lg text-white mb-1.5"><?= $t['judul'] ?></h3>
            <p class="text-sm text-slate-400 leading-relaxed"><?= $t['desc'] ?></p>
          </div>
        </div>
      </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Wave divider: dark to light -->
  <div class="divider absolute bottom-0 left-0 -mb-px">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
    </svg>
  </div>
</section>

<!-- section : kardidat -->
<section id="kandidat" class="relative bg-[#F8FAFC] pt-28 pb-28">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-primary-700 uppercase">Kenali Mereka</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-navy-900 mt-3">Calon Ketua &amp; Wakil Ketua OSIS</h2>
      <p class="text-navy-600 mt-3 max-w-xl mx-auto">Pelajari visi dan misi setiap paslon sebelum menentukan pilihanmu.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
        $kardidat = $conn->mysql_select("tb_kardidat");
        foreach ($kardidat as $row) :?>
        <div class="card-kandidat relative bg-white rounded-3xl shadow-[0_8px_30px_rgb(15,23,42,0.06)] overflow-hidden border border-slate-100">

          <img src="upload/photo/<?=  $row['image']; ?>" alt="<?= $row['nama'];?>" class="w-full h-56 object-cover">

          <div class="p-6">
            <h3 class="font-display font-semibold text-lg text-navy-900 mb-2"><?= htmlspecialchars($row['nama']) ?></h3>
            <p class="text-sm text-navy-600 leading-relaxed mb-6"><?= htmlspecialchars($row['visi']) ?></p>
              <a href="login.php"
                class="btn-cta w-full font-display font-semibold text-sm px-5 py-3 rounded-xl bg-slate-100 text-navy-500 hover:bg-slate-200 flex items-center justify-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                  <rect x="5" y="11" width="14" height="9" rx="2"/>
                  <path d="M8 11V7a4 4 0 0 1 8 0v4"/>
                </svg>
                Login untuk Voting
              </a>
          </div>
        </div>
      <?php endforeach; ?>
    </div>
  </div>

  <!-- Wave divider: light to dark -->
  <div class="divider absolute bottom-0 left-0 -mb-px">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
    </svg>
  </div>
</section>

<!-- section : countdown voting -->
<section id="countdown" class="relative bg-navy-900 pt-28 pb-32 overflow-hidden">
  <div class="blob w-96 h-96 bg-primary-600 -top-16 -left-16 opacity-20"></div>
  <div class="blob w-72 h-72 bg-accent-400 bottom-0 right-0 opacity-10"></div>

  <div class="relative max-w-4xl mx-auto px-6 text-center">
    <span class="text-xs sm:text-sm font-semibold tracking-widest text-accent-400 uppercase">Jangan Sampai Terlewat</span>
    <h2 class="font-display font-bold text-3xl sm:text-4xl text-white mt-3">Waktu Tersisa untuk Voting</h2>
    <p class="text-slate-400 mt-3 max-w-xl mx-auto">Pastikan kamu memilih sebelum waktu pemungutan suara resmi ditutup.</p>

    <div class="relative mt-14 grid grid-cols-4 gap-3 sm:gap-6 max-w-2xl mx-auto">
      <div class="countdown-line absolute left-6 right-6 top-1/2 -translate-y-1/2 h-[3px] rounded-full -z-0"></div>

      <div class="countdown-box relative z-10 bg-navy-800/80 border border-white/5 rounded-2xl py-5 sm:py-8">
        <div id="cd-hari" class="countdown-number font-display font-extrabold text-3xl sm:text-5xl text-accent-400">00</div>
        <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Hari</div>
      </div>
      <div class="countdown-box relative z-10 bg-navy-800/80 border border-white/5 rounded-2xl py-5 sm:py-8">
        <div id="cd-jam" class="countdown-number font-display font-extrabold text-3xl sm:text-5xl text-white">00</div>
        <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Jam</div>
      </div>
      <div class="countdown-box relative z-10 bg-navy-800/80 border border-white/5 rounded-2xl py-5 sm:py-8">
        <div id="cd-menit" class="countdown-number font-display font-extrabold text-3xl sm:text-5xl text-white">00</div>
        <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Menit</div>
      </div>
      <div class="countdown-box relative z-10 bg-navy-800/80 border border-white/5 rounded-2xl py-5 sm:py-8">
        <div id="cd-detik" class="countdown-number font-display font-extrabold text-3xl sm:text-5xl text-sky-300">00</div>
        <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Detik</div>
      </div>
    </div>

    <p id="cd-selesai" class="hidden mt-8 text-sm font-semibold text-accent-400">Waktu pemungutan suara telah berakhir.</p>
  </div>

  <!-- Wave divider: dark to light -->
  <div class="divider absolute bottom-0 left-0 -mb-px">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
    </svg>
  </div>
</section>

<!-- section : tips voting -->
<section id="tips" class="relative bg-[#F8FAFC] pt-28 pb-32 overflow-hidden">
  <div class="blob w-72 h-72 bg-primary-500 top-10 -right-10 opacity-10"></div>
  <div class="blob w-80 h-80 bg-accent-400 bottom-10 -left-10 opacity-10"></div>

  <div class="relative max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-primary-700 uppercase">Panduan Singkat</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-navy-900 mt-3">Tips Voting Cepat &amp; Efisien</h2>
      <p class="text-navy-600 mt-3 max-w-xl mx-auto">Ikuti 5 langkah ini agar suaramu tercatat dalam hitungan menit.</p>
    </div>

    <?php
    $tips = [
      [
        'judul' => 'Login dengan Akun Siswa',
        'desc'  => 'Masuk menggunakan NISN dan password sekolah — tidak perlu daftar akun baru.',
      ],
      [
        'judul' => 'Baca Visi-Misi Dulu',
        'desc'  => 'Luangkan 1-2 menit membaca ringkasan program tiap paslon di section Kandidat sebelum memilih.',
      ],
      [
        'judul' => 'Klik Pilih Sekali Saja',
        'desc'  => 'Tekan tombol "Pilih Paslon" satu kali, sistem otomatis mengunci suara agar tidak bisa diubah/diganda.',
      ],
      [
        'judul' => 'Tunggu Notifikasi Konfirmasi',
        'desc'  => 'Pastikan muncul pesan "Suara berhasil direkam" sebelum menutup atau me-refresh halaman.',
      ],
      [
        'judul' => 'Bisa Lewat HP Saat Istirahat',
        'desc'  => 'Website ini responsive — cukup buka browser dari HP di sela jam istirahat, tanpa perlu ke lab komputer.',
      ],
    ];
    ?>

    <div class="relative">
      <div class="hidden lg:block absolute top-[22px] left-8 right-8 h-[3px] bg-slate-200 rounded-full z-0"></div>

      <!-- Container Grid Horizontal -->
      <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-5 gap-6 relative z-10">
        <?php foreach ($tips as $i => $tp): ?>
          <div class="flex flex-col h-full">
            
            <!-- Horizontal Dot/Badge Langkah -->
            <div class="flex items-center gap-3 lg:flex-col lg:items-start mb-4">
              <span class="w-11 h-11 rounded-xl bg-primary-600 text-white font-display font-bold text-sm flex items-center justify-center shadow-lg shadow-primary-500/20 shrink-0">
                <?= $i + 1 ?>
              </span>
              <span class="text-xs font-semibold tracking-wider text-primary-700 uppercase">
                Langkah <?= $i + 1 ?>
              </span>
            </div>

            <!-- Card Konten -->
            <div class="bg-white border border-slate-100 rounded-2xl p-6 shadow-[0_8px_30px_rgb(15,23,42,0.05)] flex-1 flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300">
              <div>
                <h3 class="font-display font-semibold text-base text-navy-900 mb-2">
                  <?= $tp['judul'] ?>
                </h3>
                <p class="text-xs sm:text-sm text-navy-600 leading-relaxed">
                  <?= $tp['desc'] ?>
                </p>
              </div>
            </div>

          </div>
        <?php endforeach; ?>
      </div>

    </div>
  </div>

  <!-- Wave divider: light -> dark -->
  <div class="divider absolute bottom-0 left-0 -mb-px w-full">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full">
      <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
    </svg>
  </div>
</section>

<!-- section : video tutorial -->
<section id="video" class="relative bg-navy-900 pt-28 pb-32 overflow-hidden">
  <div class="blob w-96 h-96 bg-primary-600 top-0 right-0 opacity-15"></div>

  <div class="relative max-w-3xl mx-auto px-6">
    <div class="text-center mb-14">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-accent-400 uppercase">Tonton &amp; Praktikkan</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-white mt-3">Cara Voting di Website Ini</h2>
      <p class="text-slate-400 mt-3 max-w-xl mx-auto">Video singkat berikut menunjukkan alur voting langkah demi langkah.</p>
    </div>

    <div id="videoFacade"
         class="video-facade relative aspect-video rounded-2xl overflow-hidden border border-white/10 shadow-2xl cursor-pointer group bg-navy-800"
         onclick="muatVideoTutorial()">
      <iframe
          class="absolute inset-0 w-full h-full"
          src="https://www.youtube.com/embed/1rv1PjprD18?list=RD1rv1PjprD18"
          title="Video tutorial voting"
          frameborder="0"
          loading="lazy"
          allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
          allowfullscreen>
        </iframe>
      </div>
    </div>
  </div>

  <!-- Wave divider: dark to light -->
  <div class="divider absolute bottom-0 left-0 -mb-px">
    <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
      <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
    </svg>
  </div>
</section>

<!-- section : footer -->
<footer class="bg-white border-t border-slate-100 py-8">
  <div class="max-w-6xl mx-auto px-6 text-center text-sm text-navy-500">
    &copy; <?= date('Y') ?> Febri Pratama — All Right Reserved.
  </div>
</footer>

<script>
  // ===================== COUNTDOWN VOTING =====================
  const targetVoting = new Date(<?= $waktuVotingBerakhir ?> * 1000).getTime();

  function updateCountdown() {
    const sekarang = new Date().getTime();
    const sisa = targetVoting - sekarang;

    if (sisa <= 0) {
      document.getElementById('cd-hari').textContent   = '00';
      document.getElementById('cd-jam').textContent    = '00';
      document.getElementById('cd-menit').textContent  = '00';
      document.getElementById('cd-detik').textContent  = '00';
      document.getElementById('cd-selesai').classList.remove('hidden');
      clearInterval(cdInterval);
      return;
    }

    const hari  = Math.floor(sisa / (1000 * 60 * 60 * 24));
    const jam   = Math.floor((sisa % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
    const menit = Math.floor((sisa % (1000 * 60 * 60)) / (1000 * 60));
    const detik = Math.floor((sisa % (1000 * 60)) / 1000);

    document.getElementById('cd-hari').textContent  = String(hari).padStart(2, '0');
    document.getElementById('cd-jam').textContent   = String(jam).padStart(2, '0');
    document.getElementById('cd-menit').textContent = String(menit).padStart(2, '0');
    document.getElementById('cd-detik').textContent = String(detik).padStart(2, '0');
  }
  updateCountdown();
  const cdInterval = setInterval(updateCountdown, 1000);
</script>

</body>
</html>