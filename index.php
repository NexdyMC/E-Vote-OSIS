<?php

require_once __DIR__ . '/api/conn.php';
session_start();

$isLoggedIn = isset($_SESSION['user']);
$namaSiswa  = $isLoggedIn ? $_SESSION['user']['nama'] : null;

$waktuVotingBerakhir = strtotime('2026-09-26 08:00:00');
?>
<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>E-Vote OSIS</title>

  <!-- link : CDN  -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="assets/scripts/tailwind.config.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

  <!-- link : style css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-white text-navy-900 antialiased">

<!-- header : navbar -->
<header class="fixed top-0 inset-x-0 z-50 bg-white/80 backdrop-blur-md border-b border-slate-100">
  <nav class="max-w-6xl mx-auto px-6 h-16 flex items-center justify-between">
    
    <!-- navbar : title -->
    <div class="flex items-center gap-2">
      <img src="assets/images/logo-smk.png" alt="Logo IFSU" class="w-12 h-12">
      <p class="font-display font-semibold text-xl text-navy-900">E-Vote<span class="text-primary-600"> OSIS</span></p>
    </div>

    <!-- navbar : menu -->
    <div class="hidden md:flex items-center gap-8 text-md font-medium text-navy-800">
      <a href="#beranda" class="hover:text-primary-600 transition">Beranda</a>
      <a href="#tahapan" class="hover:text-primary-600 transition">Tahapan</a>
      <a href="#kandidat" class="hover:text-primary-600 transition">Kandidat</a>
      <a href="#countdown" class="hover:text-primary-600 transition">Countdown</a>
      <a href="#tips" class="hover:text-primary-600 transition">Tips</a>
      <a href="#video" class="hover:text-primary-600 transition">Video</a>
    </div>

    <!-- navbar : login -->
    <?php if ($isLoggedIn): ?>
      <div class="flex items-center gap-3">
        <span class="hidden sm:block text-md text-navy-700">Hai, <span class="font-semibold"><?= htmlspecialchars($namaSiswa) ?></span></span>
        <a href="siswa/logout.php" class="text-md font-medium px-4 py-2 rounded-full border border-slate-200 hover:bg-slate-50 transition">Keluar</a>
      </div>
    <?php else: ?>
      <a href="siswa/login.php" class="flex items-center btn-cta text-md font-semibold px-5 py-2.5 rounded-full bg-primary-700 text-white hover:bg-primary-600">
        Login<i data-lucide="log-in" class="ml-2 w-4 h-4"></i>
      </a>
    <?php endif; ?>
  </nav>
</header>

<!-- section : hero -->
<section id="beranda" class="relative overflow-hidden bg-[#F8FAFC] pt-44 pb-32">
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-72 h-72 bg-primary-500 -top-10 -left-10"></div>
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-80 h-80 bg-accent-400 top-24 right-0"></div>

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
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-96 h-96 bg-primary-600 top-1/3 -right-20 opacity-20"></div>

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

<!-- section : kandidat -->
<section id="kandidat" class="relative bg-[#F8FAFC] pt-28 pb-28">
  <div class="max-w-6xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-primary-700 uppercase">Kenali Mereka</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-navy-900 mt-3">Calon Ketua &amp; Wakil Ketua OSIS</h2>
      <p class="text-navy-600 mt-3 max-w-xl mx-auto">Pelajari visi dan misi setiap paslon sebelum menentukan pilihanmu.</p>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8">
      <?php
        $kandidat = $conn->mysql_select("tb_kandidat");
        foreach ($kandidat as $row) :?>

        <div class="card-kandidat shrink-0 flex flex-col justify-between relative group bg-white rounded-3xl shadow-[0_8px_30px_rgb(15,23,42,0.06)] overflow-hidden border border-2 border-slate-300/80 ">
          <div class="text-left">

            <!-- kandidat : image -->
            <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
              <img src="upload/photo/<?=  $row['image']; ?>" alt="kandidat <?= $row['nama'];?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            </div>

            <!-- kandidat : nama siswa -->
            <p class="text-2xl text-center font-bold my-4 line-clamp-1">
                <?= $row['nama'] ?>
            </p> 
            <div class="px-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-700">

              <!-- kandidat : Visi -->
              <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                    <i data-lucide="compass" class="w-5 h-5 text-brand-blue"></i> Visi
                </h4>
                <p class="text-sm text-bland-blue leading-relaxed ">
                    <?= nl2br($row['visi']); ?>
                </p>
              </div>

              <!-- kandidat : Misi -->
              <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                    <i data-lucide="compass" class="w-5 h-5 text-brand-blue"></i> Misi
                </h4>
                <p class="text-sm text-bland-blue leading-relaxed ">
                    <?= nl2br($row['misi']); ?>
                </p>
              </div>
            </div>
          </div>

          <!-- kandidat : button -->
          <div class="px-4 py-4 space-y-4 text-center">
            <a href="login.php"
              class="btn-cta w-full font-display font-semibold text-md px-5 py-3 rounded-xl border-2 border-primary-700 text-primary-700 bg-slate-100 text-navy-500 hover:bg-primary-700 hover:text-white flex items-center justify-center gap-2">
              <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
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
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-96 h-96 bg-primary-600 -top-16 -left-16 opacity-20"></div>
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-72 h-72 bg-accent-400 bottom-0 right-0 opacity-10"></div>

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
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-72 h-72 bg-primary-500 top-10 -right-10 opacity-10"></div>
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-80 h-80 bg-accent-400 bottom-10 -left-10 opacity-10"></div>

  <div class="relative max-w-7xl mx-auto px-6">
    <div class="text-center mb-16">
      <span class="text-xs sm:text-sm font-semibold tracking-widest text-primary-700 uppercase">Panduan Singkat</span>
      <h2 class="font-display font-bold text-3xl sm:text-4xl text-navy-900 mt-3">Tips Voting Cepat &amp; Efisien</h2>
      <p class="text-navy-600 mt-3 max-w-xl mx-auto">Ikuti 5 langkah ini agar suaramu tercatat dalam hitungan menit.</p>
    </div>

    <?php
    $tips = [
      [
        'judul' => 'Login dengan Token',
        'desc'  => 'Masuk menggunakan Token yang sudah diberikan kepada panitia OSIS',
      ],
      [
        'judul' => 'Baca Visi-Misi',
        'desc'  => 'Luangkan 1-2 menit membaca ringkasan program di section Kandidat sebelum memilih.',
      ],
      [
        'judul' => 'Pilih Kardiadat',
        'desc'  => 'Tekan tombol "Pilih Kardidat Ini" satu kali, sistem otomatis mengunci suara agar tidak bisa diubah/diganda.',
      ],
      [
        'judul' => 'Tunggu Konfirmasi',
        'desc'  => 'Pastikan muncul pesan "Vote berhasil disimpan." sebelum menutup atau me-refresh halaman.',
      ],
      [
        'judul' => 'Responsive',
        'desc'  => 'Website ini responsive cukup buka browser dari HP di sela jam istirahat, tanpa perlu ke lab komputer.',
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
            <div class="bg-white border-2 border-slate-300 rounded-2xl p-6 shadow-[0_8px_30px_rgb(15,23,42,0.05)] flex-1 flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300">
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
  <div class="absolute rounded-full blur-3xl opacity-35 pointer-events-none w-96 h-96 bg-primary-600 top-0 right-0 opacity-15"></div>

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
    &copy; 2026 Febri Pratama — All Right Reserved.
  </div>
</footer>

<script>
  lucide.createIcons();
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