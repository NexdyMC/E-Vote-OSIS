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
  <link rel="shortcut icon" href="favicon.ico" type="image/x-icon">
  <title>E-Vote OSIS</title>

  <!-- link : CDN  -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script src="assets/js/tailwind.config.js"></script>
  <script src="https://unpkg.com/lucide@latest"></script>
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

  <!-- link : style css -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="antialiased bg-white text-navy-900">

  <!-- navbar -->
  <header class="fixed inset-x-0 top-0 z-50 border-b bg-white/80 backdrop-blur-md border-slate-100">
    <nav class="flex items-center justify-between h-16 max-w-6xl px-6 mx-auto">

      <!-- navbar : title -->
      <div class="flex items-center gap-2">
        <img src="assets/images/logo-smk.png" alt="Logo IFSU" class="w-12 h-12">
        <p class="text-xl font-semibold font-display text-navy-900">E-Vote<span class="text-primary-600"> OSIS</span>
        </p>
      </div>

      <!-- navbar : menu -->
      <div class="items-center hidden gap-8 font-medium md:flex text-md text-navy-800">
        <a href="#beranda" class="transition hover:text-primary-600">Beranda</a>
        <a href="#tahapan" class="transition hover:text-primary-600">Tahapan</a>
        <a href="#kandidat" class="transition hover:text-primary-600">Kandidat</a>
        <a href="#countdown" class="transition hover:text-primary-600">Countdown</a>
        <a href="#tips" class="transition hover:text-primary-600">Tips</a>
        <a href="#video" class="transition hover:text-primary-600">Video</a>
      </div>

      <!-- navbar : login -->
      <?php if ($isLoggedIn): ?>
      <div class="flex items-center gap-3">
        <span class="hidden sm:block text-md text-navy-700">Hai, <span
            class="font-semibold"><?= htmlspecialchars($namaSiswa) ?></span></span>
        <a href="siswa/logout.php"
          class="px-4 py-2 font-medium transition border rounded-full text-md border-slate-200 hover:bg-slate-50">Keluar</a>
      </div>
      <?php else: ?>
      <a href="siswa/login.php"
        class="flex items-center btn-cta text-md font-semibold px-5 py-2.5 rounded-full bg-primary-700 text-white hover:bg-primary-600">
        Login<i data-lucide="log-in" class="w-4 h-4 ml-2"></i>
      </a>
      <?php endif; ?>
    </nav>
  </header>

  <!-- section : hero -->
  <section id="beranda" class="relative overflow-hidden bg-[#F8FAFC] pt-44 pb-32">
    <div class="absolute rounded-full pointer-events-none blur-3xl opacity-35 w-72 h-72 bg-primary-500 -top-10 -left-10"></div>
    <div class="absolute right-0 rounded-full pointer-events-none blur-3xl opacity-35 w-80 h-80 bg-accent-400 top-24"></div>

    <div class="relative max-w-6xl px-6 mx-auto text-center">
      <h1 class="mt-6 text-4xl font-extrabold leading-tight font-display sm:text-5xl lg:text-6xl text-navy-900">
        Satu Suara <span class="text-primary-700">Satu Arah</span> 
        <br>untuk
        <span class="relative inline-block text-[#FACC15]">
          OSIS
        </span> yang Lebih Baik.
      </h1>

      <p class="max-w-2xl mx-auto mt-6 text-base sm:text-lg text-navy-700">
        Gunakan hak pilihmu secara digital, aman, dan transparan. Kenali calon pemimpinmu, ikuti setiap tahapan, dan pantau hasil suara secara real-time.
      </p>

      <div class="flex flex-col items-center justify-center gap-4 mt-10 sm:flex-row">
        <a href="#kandidat" class="btn-cta btn-accent font-display font-semibold px-8 py-3.5 rounded-full bg-accent-400 text-navy-900 hover:bg-accent-500">
          Lihat Kandidat
        </a>
        <a href="#tahapan" class="btn-cta font-display font-semibold px-8 py-3.5 rounded-full border-2 border-primary-700 text-primary-700 hover:bg-primary-700 hover:text-white">
          Jadwal Tahapan
        </a>
      </div>
    </div>

    <!-- Wave divider: light to dark -->
    <div class="absolute bottom-0 left-0 -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
      </svg>
    </div>
  </section>

  <!-- section : time line -->
  <section id="tahapan" class="relative pb-32 overflow-hidden bg-navy-900 pt-28">
    <div class="absolute rounded-full pointer-events-none blur-3xl opacity-35 w-96 h-96 bg-primary-600 top-1/3 -right-20 "></div>

    <div class="relative max-w-5xl px-6 mx-auto">
      <div class="mb-20 text-center">
        <span class="text-xs font-semibold tracking-widest uppercase sm:text-sm text-accent-400">Alur Pemilihan</span>
        <h2 class="mt-3 text-3xl font-bold text-white font-display sm:text-4xl">Tahapan Pemilu OSIS</h2>
        <p class="max-w-xl mx-auto mt-3 text-slate-400">Empat tahap resmi menuju terpilihnya Ketua OSIS periode berikutnya.</p>
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
            <div class="p-6 border bg-navy-800/70 border-white/5 rounded-2xl backdrop-blur-sm">
              <div class="flex items-center gap-3 mb-2">
                <span class="text-xs font-semibold tracking-widest text-accent-400"><?= $t['label'] ?></span>
                <?php if ($t['live']): ?>
                  <span class="inline-flex items-center gap-1.5 text-[11px] font-bold text-sky-300 bg-sky-400/10 px-2.5 py-0.5 rounded-full">
                    <span class="w-1.5 h-1.5 rounded-full bg-sky-400 animate-pulse"></span> LIVE
                  </span>
                <?php endif; ?>
              </div>
              <h3 class="font-display font-semibold text-lg text-white mb-1.5"><?= $t['judul'] ?></h3>
              <p class="text-sm leading-relaxed text-slate-400"><?= $t['desc'] ?></p>
            </div>
          </div>
        </div>
        <?php endforeach; ?>
      </div>
    </div>

    <!-- Wave divider: dark to light -->
    <div class="absolute bottom-0 left-0 -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
      </svg>
    </div>
  </section>

  <!-- section : kandidat -->
  <section id="kandidat" class="relative bg-[#F8FAFC] pt-28 pb-28">
    <div class="max-w-6xl px-6 mx-auto">
      <div class="mb-16 text-center">
        <span class="text-xs font-semibold tracking-widest uppercase sm:text-sm text-primary-700">Kenali Mereka</span>
        <h2 class="mt-3 text-3xl font-bold font-display sm:text-4xl text-navy-900">Calon Ketua &amp; Wakil Ketua OSIS</h2>
        <p class="max-w-xl mx-auto mt-3 text-navy-600">Pelajari visi dan misi setiap paslon sebelum menentukan pilihanmu.</p>
      </div>

      <div class="grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">
        <?php
          $kandidat = $conn->mysql_select("tb_kandidat");
          foreach ($kandidat as $row) :?>

          <div class="card-kandidat shrink-0 flex flex-col justify-between relative group bg-white rounded-3xl shadow-[0_8px_30px_rgb(15,23,42,0.06)] overflow-hidden border-2 border-slate-300/80 ">
            <div class="text-left">

              <!-- kandidat : image -->
              <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
                <img src="upload/photo/<?=  $row['image']; ?>" alt="kandidat <?= $row['nama'];?>" class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
              </div>

              <!-- kandidat : nama siswa -->
              <p class="my-4 text-2xl font-bold text-center line-clamp-1">
                  <?= $row['nama'] ?>
              </p> 
              <div class="px-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-700">

                <!-- kandidat : Visi -->
                <div class="p-3 border-2 bg-slate-100/60 rounded-xl border-slate-200/80">
                  <h4 class="flex items-center gap-1 mb-1 font-bold uppercase text-md text-brand-blue">
                      <i data-lucide="compass" class="w-5 h-5 text-brand-blue"></i> Visi
                  </h4>
                  <p class="text-sm leading-relaxed text-bland-blue ">
                      <?= nl2br($row['visi']); ?>
                  </p>
                </div>

                <!-- kandidat : Misi -->
                <div class="p-3 border-2 bg-slate-100/60 rounded-xl border-slate-200/80">
                  <h4 class="flex items-center gap-1 mb-1 font-bold uppercase text-md text-brand-blue">
                      <i data-lucide="compass" class="w-5 h-5 text-brand-blue"></i> Misi
                  </h4>
                  <p class="text-sm leading-relaxed text-bland-blue ">
                      <?= nl2br($row['misi']); ?>
                  </p>
                </div>
              </div>
            </div>

            <!-- kandidat : button -->
            <div class="px-4 py-4 space-y-4 text-center">
              <a href="login.php"
                class="flex items-center justify-center w-full gap-2 px-5 py-3 font-semibold border-2 btn-cta font-display text-md rounded-xl border-primary-700 text-primary-700 bg-slate-100 text-navy-500 hover:bg-primary-700 hover:text-white">
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
    <div class="absolute bottom-0 left-0 -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
      </svg>
    </div>
  </section>

  <!-- section : countdown voting -->
  <section id="countdown" class="relative pb-32 overflow-hidden bg-navy-900 pt-28">
    <div class="absolute rounded-full pointer-events-none blur-3xl opacity-35 w-96 h-96 bg-primary-600 -top-16 -left-16"></div>
    <div class="absolute bottom-0 right-0 rounded-full pointer-events-none blur-3xl opacity-35 w-72 h-72 bg-accent-400"></div>

    <div class="relative max-w-4xl px-6 mx-auto text-center">
      <span class="text-xs font-semibold tracking-widest uppercase sm:text-sm text-accent-400">Jangan Sampai Terlewat</span>
      <h2 class="mt-3 text-3xl font-bold text-white font-display sm:text-4xl">Waktu Tersisa untuk Voting</h2>
      <p class="max-w-xl mx-auto mt-3 text-slate-400">Pastikan kamu memilih sebelum waktu pemungutan suara resmi ditutup.</p>

      <div class="relative grid max-w-2xl grid-cols-4 gap-3 mx-auto mt-14 sm:gap-6">
        <div class="countdown-line absolute left-6 right-6 top-1/2 -translate-y-1/2 h-[3px] rounded-full -z-0"></div>

        <div class="relative z-10 py-5 border countdown-box bg-navy-800/80 border-white/5 rounded-2xl sm:py-8">
          <div id="cd-hari" class="text-3xl font-extrabold countdown-number font-display sm:text-5xl text-accent-400">00</div>
          <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Hari</div>
        </div>
        <div class="relative z-10 py-5 border countdown-box bg-navy-800/80 border-white/5 rounded-2xl sm:py-8">
          <div id="cd-jam" class="text-3xl font-extrabold text-white countdown-number font-display sm:text-5xl">00</div>
          <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Jam</div>
        </div>
        <div class="relative z-10 py-5 border countdown-box bg-navy-800/80 border-white/5 rounded-2xl sm:py-8">
          <div id="cd-menit" class="text-3xl font-extrabold text-white countdown-number font-display sm:text-5xl">00</div>
          <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Menit</div>
        </div>
        <div class="relative z-10 py-5 border countdown-box bg-navy-800/80 border-white/5 rounded-2xl sm:py-8">
          <div id="cd-detik" class="text-3xl font-extrabold countdown-number font-display sm:text-5xl text-sky-300">00</div>
          <div class="text-[11px] sm:text-xs font-semibold tracking-widest text-slate-400 uppercase mt-2">Detik</div>
        </div>
      </div>

      <p id="cd-selesai" class="hidden mt-8 text-sm font-semibold text-accent-400">Waktu pemungutan suara telah berakhir.</p>
    </div>

    <!-- Wave divider: dark to light -->
    <div class="absolute bottom-0 left-0 -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
      </svg>
    </div>
  </section>

  <!-- section : tips voting -->
  <section id="tips" class="relative bg-[#F8FAFC] pt-28 pb-32 overflow-hidden">
    <div class="absolute rounded-full pointer-events-none blur-3xl opacity-35 w-72 h-72 bg-primary-500 top-10 -right-10"></div>
    <div class="absolute rounded-full pointer-events-none blur-3xl opacity-35 w-80 h-80 bg-accent-400 bottom-10 -left-10"></div>

    <div class="relative px-6 mx-auto max-w-7xl">
      <div class="mb-16 text-center">
        <span class="text-xs font-semibold tracking-widest uppercase sm:text-sm text-primary-700">Panduan Singkat</span>
        <h2 class="mt-3 text-3xl font-bold font-display sm:text-4xl text-navy-900">Tips Voting Cepat &amp; Efisien</h2>
        <p class="max-w-xl mx-auto mt-3 text-navy-600">Ikuti 5 langkah ini agar suaramu tercatat dalam hitungan menit.</p>
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
        <div class="relative z-10 grid grid-cols-1 gap-6 md:grid-cols-3 lg:grid-cols-5">
          <?php foreach ($tips as $i => $tp): ?>
            <div class="flex flex-col h-full">
              
              <!-- Horizontal Dot/Badge Langkah -->
              <div class="flex items-center gap-3 mb-4 lg:flex-col lg:items-start">
                <span class="flex items-center justify-center text-sm font-bold text-white shadow-lg w-11 h-11 rounded-xl bg-primary-600 font-display shadow-primary-500/20 shrink-0">
                  <?= $i + 1 ?>
                </span>
                <span class="text-xs font-semibold tracking-wider uppercase text-primary-700">
                  Langkah <?= $i + 1 ?>
                </span>
              </div>

              <!-- Card Konten -->
              <div class="bg-white border-2 border-slate-300 rounded-2xl p-6 shadow-[0_8px_30px_rgb(15,23,42,0.05)] flex-1 flex flex-col justify-between hover:-translate-y-1 transition-transform duration-300">
                <div>
                  <h3 class="mb-2 text-base font-semibold font-display text-navy-900">
                    <?= $tp['judul'] ?>
                  </h3>
                  <p class="text-xs leading-relaxed sm:text-sm text-navy-600">
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
    <div class="absolute bottom-0 left-0 w-full -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none" class="w-full">
        <path d="M0,32 C240,90 480,0 720,24 C960,48 1200,90 1440,40 L1440,90 L0,90 Z" fill="#0F172A"/>
      </svg>
    </div>
  </section>

  <!-- section : video tutorial -->
  <section id="video" class="relative pb-32 overflow-hidden bg-navy-900 pt-28">
    <div class="absolute top-0 right-0 rounded-full pointer-events-none blur-3xl opacity-35 w-96 h-96 bg-primary-600"></div>

    <div class="relative max-w-3xl px-6 mx-auto">
      <div class="text-center mb-14">
        <span class="text-xs font-semibold tracking-widest uppercase sm:text-sm text-accent-400">Tonton &amp; Praktikkan</span>
        <h2 class="mt-3 text-3xl font-bold text-white font-display sm:text-4xl">Cara Voting di Website Ini</h2>
        <p class="max-w-xl mx-auto mt-3 text-slate-400">Video singkat berikut menunjukkan alur voting langkah demi langkah.</p>
      </div>

      <div id="videoFacade"
          class="relative overflow-hidden border shadow-2xl cursor-pointer video-facade aspect-video rounded-2xl border-white/10 group bg-navy-800"
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
    <div class="absolute bottom-0 left-0 -mb-px divider">
      <svg viewBox="0 0 1440 90" preserveAspectRatio="none">
        <path d="M0,40 C240,0 480,90 720,56 C960,24 1200,0 1440,48 L1440,90 L0,90 Z" fill="#F8FAFC"/>
      </svg>
    </div>
  </section>

  <!-- footer -->
  <footer class="py-8 bg-white border-t border-slate-100">
    <div class="max-w-6xl px-6 mx-auto text-sm text-center text-navy-500">
      &copy; 2026 Febri Pratama — All Right Reserved.
    </div>
  </footer>

  <!-- script : js -->
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