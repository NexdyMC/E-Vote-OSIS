<?php
session_start();

// Cek apakah siswa sudah validasi token
// if (!isset($_SESSION['voter_logged_in']) || $_SESSION['voter_logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Data Contoh Paslon
$paslon_list = [
    [
        'id' => 1,
        'no_urut' => '01',
        'ketua' => 'Ahmad Fauzi',
        'wakil' => 'Siti Nurhaliza',
        'kelas' => 'XI RPL 1 & XI TKJ 2',
        'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Inovasi Digital untuk Sekolah Berprestasi',
        'visi' => 'Mewujudkan OSIS SMK Informatika Sumedang sebagai wadah aspirasi siswa yang adaptif terhadap teknologi, berintegritas, dan berprestasi.',
        'misi' => [
            'Mengembangkan kegiatan eskul berbasis teknologi.',
            'Menciptakan forum komunikasi terbuka antara siswa & sekolah.',
            'Meningkatkan kedisiplinan dan rasa kepedulian sosial.'
        ]
    ],
    [
        'id' => 2,
        'no_urut' => '02',
        'ketua' => 'Rian Ardianto',
        'wakil' => 'Dina Permata',
        'kelas' => 'XI DKV 2 & XI RPL 3',
        'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Kreatif, Kolaboratif, dan Berkarakter',
        'visi' => 'Menjadikan SMK Informatika Sumedang pusat kreativitas siswa yang aktif, berbudaya, serta mampu bersaing di industri kreatif.',
        'misi' => [
            'Menyelenggarakan pentas seni dan kompetisi desain/coding berkala.',
            'Mengoptimalkan media sosial OSIS sebagai sarana edukasi.',
            'Membangun kerja sama dengan alumni untuk mentoring karir.'
        ]
    ],
    [
        'id' => 3,
        'no_urut' => '03',
        'ketua' => 'Muhammad Zaki',
        'wakil' => 'Aulia Putri',
        'kelas' => 'XI MM 1 & XI RPL 2',
        'foto' => 'https://images.unsplash.com/photo-1517841905240-472988babdf9?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Bersatu, Beraksi, Berdampak Nyata',
        'visi' => 'Mewujudkan lingkungan sekolah yang religius, ramah siswa, serta aktif menyalurkan bakat non-akademik ke tingkat provinsi.',
        'misi' => [
            'Mengadakan turnamen e-sports dan olahraga antar kelas.',
            'Mengaktifkan kembali kotak saran fisik dan digital.',
            'Program kepedulian lingkungan dan kebersihan sekolah.'
        ]
    ]
];
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bilik Suara — E-Voting OSIS SMK Informatika</title>
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            blue: '#0047AB',
                            darkblue: '#0F172A',
                            yellow: '#FACC15',
                            yellowhover: '#EAB308'
                        }
                    }
                }
            }
        }
    </script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <style>
        body { font-family: 'Inter', sans-serif; }
        /* Sembunyikan Scrollbar Bawaan Browser agar UI Bersih */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
</head>
<body class="bg-brand-darkblue text-slate-100 min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- ============================================================
         1. HEADER / NAVBAR SECTION
         ============================================================ -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-between">
            
            <!-- Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="bar-chart-3"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">Live Quick Count</h1>
                    <p class="text-[11px] text-slate-400">SMK Informatika Sumedang</p>
                </div>
            </div>

            <!-- Navigation Links & Status -->
            <div class="flex items-center gap-4">
                <a href="index.php" class="hidden sm:inline-flex items-center gap-1.5 text-xs font-semibold text-slate-300 hover:text-brand-yellow transition-colors">
                    <i data-lucide="home" class="w-4 h-4"></i> Beranda
                </a>
                <a href="login.php" class="inline-flex items-center gap-1.5 text-xs font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-3.5 py-2 rounded-xl shadow-md transition-all">
                    <i data-lucide="vote" class="w-4 h-4"></i> Bilik Suara
                </a>
            </div>

        </div>
    </header>

    <!-- MAIN CONTENT: CAROUSEL CARD PASLON -->
    <main class="py-8 px-4 sm:px-6 max-w-6xl mx-auto w-full flex-1 flex flex-col justify-center">

        <!-- TITLE & NAV BUTTONS HEADER -->
        <div class="flex flex-col sm:flex-row sm:items-end justify-between mb-8 gap-4">
            <div>
                <span class="text-xs font-bold tracking-widest text-brand-yellow uppercase bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                    Langkah Terakhir
                </span>
                <h2 class="text-2xl sm:text-3xl font-extrabold text-white mt-2">Pilih Paslon Ketua OSIS</h2>
                <p class="text-slate-400 text-xs sm:text-sm mt-1">Geser untuk melihat seluruh kandidat sebelum memilih.</p>
            </div>

            <!-- TOMBOL SCROLL KIRI & KANAN -->
            <div class="flex items-center gap-3 self-end sm:self-auto">
                <button id="scrollLeft" class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-left" class="w-6 h-6"></i>
                </button>
                <button id="scrollRight" class="w-12 h-12 rounded-2xl bg-slate-800 hover:bg-brand-blue border border-slate-700 hover:border-brand-blue text-white flex items-center justify-center transition-all shadow-lg active:scale-95">
                    <i data-lucide="chevron-right" class="w-6 h-6"></i>
                </button>
            </div>
        </div>

        <!-- CONTAINER SCROLL HORIZONTAL (CAROUSEL) -->
        <div id="cardContainer" class="flex gap-6 overflow-x-auto snap-x snap-mandatory scroll-smooth no-scrollbar pb-6 pt-2">
            
            <?php foreach ($paslon_list as $paslon): ?>
            <!-- INDIVIDUAL CARD PASLON -->
            <div class="snap-center shrink-0 w-[300px] sm:w-[380px] bg-slate-900 border border-slate-800 rounded-3xl p-5 shadow-2xl flex flex-col justify-between relative group hover:border-slate-700 transition-all">
                
                <!-- Badge Nomor Urut -->
                <div class="absolute top-8 left-8 z-10">
                    <span class="bg-brand-yellow text-brand-darkblue text-sm font-extrabold px-3 py-1.5 rounded-xl shadow-md flex items-center gap-1">
                        <span class="text-[10px] font-bold opacity-75">NO</span> <?= $paslon['no_urut'] ?>
                    </span>
                </div>

                <div>
                    <!-- Foto Paslon -->
                    <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
                        <img src="<?= $paslon['foto'] ?>" alt="Foto Paslon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-90"></div>
                        
                        <!-- Overlay Nama di Foto -->
                        <div class="absolute bottom-3 left-3 right-3">
                            <span class="text-[10px] font-semibold text-brand-yellow bg-brand-darkblue/80 px-2 py-0.5 rounded border border-brand-yellow/30 mb-1 inline-block">
                                <?= $paslon['kelas'] ?>
                            </span>
                            <h3 class="text-base font-bold text-white leading-tight"><?= $paslon['ketua'] ?></h3>
                            <p class="text-xs text-slate-300">&amp; <?= $paslon['wakil'] ?></p>
                        </div>
                    </div>

                    <!-- Tagline -->
                    <p class="text-xs italic font-medium text-brand-yellow mb-4 line-clamp-1">
                        "<?= $paslon['tagline'] ?>"
                    </p>

                    <!-- Box Visi & Misi (Bisa di-scroll vertikal di dalam card jika teks panjang) -->
                    <div class="space-y-4 pr-1 text-left scrollbar-thin scrollbar-thumb-slate-700">
                        <!-- Visi -->
                        <div class="bg-slate-950/60 p-3 rounded-xl border border-slate-800/80">
                            <h4 class="text-[11px] font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-yellow"></i> Visi
                            </h4>
                            <p class="text-xs text-slate-300 leading-relaxed">
                                <?= $paslon['visi'] ?>
                            </p>
                        </div>

                        <!-- Misi -->
                        <div class="bg-slate-950/60 p-3 rounded-xl border border-slate-800/80">
                            <h4 class="text-[11px] font-bold uppercase text-brand-blue mb-2 flex items-center gap-1">
                                <i data-lucide="list-checks" class="w-3.5 h-3.5 text-brand-yellow"></i> Misi
                            </h4>
                            <ul class="space-y-1.5">
                                <?php foreach ($paslon['misi'] as $m): ?>
                                    <li class="flex items-start gap-2 text-[11px] text-slate-300">
                                        <i data-lucide="check" class="w-3.5 h-3.5 text-emerald-400 shrink-0 mt-0.5"></i>
                                        <span><?= $m ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Tombol Coblos -->
                <div class="mt-6 pt-4 border-t border-slate-800">
                    <button type="button" 
                        onclick="openVoteModal('<?= $paslon['id'] ?>', '<?= $paslon['no_urut'] ?>', '<?= $paslon['ketua'] ?> & <?= $paslon['wakil'] ?>')"
                        class="w-full py-3.5 px-4 rounded-xl bg-brand-yellow hover:bg-brand-yellowhover text-brand-darkblue font-extrabold text-sm shadow-lg shadow-brand-yellow/20 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2">
                        <i data-lucide="check-square" class="w-4 h-4"></i>
                        <span>COBLOS PASLON <?= $paslon['no_urut'] ?></span>
                    </button>
                </div>

            </div>
            <?php endforeach; ?>

        </div>

    </main>

    <!-- FOOTER -->
    <footer class="bg-slate-950 border-t border-slate-900 py-4 text-center text-xs text-slate-500">
        &copy; <?= date('Y') ?> Pemilihan Ketua OSIS — SMK Informatika Sumedang
    </footer>

    <!-- MODAL KONFIRMASI COBLOS (POPUP) -->
    <div id="voteModal" class="fixed inset-0 z-50 hidden bg-slate-950/80 backdrop-blur-sm flex items-center justify-center p-4">
        <div class="bg-slate-900 border border-slate-800 text-white rounded-3xl max-w-md w-full p-6 shadow-2xl relative">
            
            <div class="w-12 h-12 rounded-2xl bg-brand-yellow/10 border border-brand-yellow/30 text-brand-yellow flex items-center justify-center mb-4 mx-auto">
                <i data-lucide="alert-triangle" class="w-6 h-6"></i>
            </div>

            <h3 class="text-xl font-bold text-center mb-1">Konfirmasi Pilihan Suara</h3>
            <p class="text-xs text-slate-400 text-center mb-6">Apakah kamu yakin ingin memilih paslon di bawah ini?</p>

            <div class="bg-slate-950 p-4 rounded-2xl border border-slate-800 text-center mb-6">
                <span id="modalNoUrut" class="text-xs font-bold text-brand-yellow uppercase tracking-wider block mb-1">PASLON --</span>
                <h4 id="modalNamaPaslon" class="text-base font-bold text-white">---</h4>
            </div>

            <form action="submit_vote.php" method="POST" class="space-y-3">
                <input type="hidden" name="paslon_id" id="inputPaslonId">
                
                <button type="submit" class="w-full py-3.5 rounded-xl bg-emerald-500 hover:bg-emerald-600 text-slate-950 font-extrabold text-sm transition-all flex items-center justify-center gap-2">
                    <i data-lucide="check" class="w-4 h-4"></i> Ya, Mantap Pilih Ini!
                </button>
                
                <button type="button" onclick="closeVoteModal()" class="w-full py-3 rounded-xl bg-slate-800 hover:bg-slate-700 text-slate-300 font-semibold text-sm transition-all">
                    Batal / Pikir-pikir Dulu
                </button>
            </form>

        </div>
    </div>

    <!-- SCRIPT JAVASCRIPT: SCROLL & POPUP -->
    <script>
        lucide.createIcons();

        // 1. Logika Scroll Kiri Kanan Carousel
        const container = document.getElementById('cardContainer');
        const scrollLeftBtn = document.getElementById('scrollLeft');
        const scrollRightBtn = document.getElementById('scrollRight');

        scrollLeftBtn.addEventListener('click', () => {
            container.scrollBy({ left: -340, behavior: 'smooth' });
        });

        scrollRightBtn.addEventListener('click', () => {
            container.scrollBy({ left: 340, behavior: 'smooth' });
        });

        // 2. Logika Modal Popup Konfirmasi
        function openVoteModal(id, noUrut, nama) {
            document.getElementById('inputPaslonId').value = id;
            document.getElementById('modalNoUrut').innerText = 'PASLON ' + noUrut;
            document.getElementById('modalNamaPaslon').innerText = nama;
            document.getElementById('voteModal').classList.remove('hidden');
        }

        function closeVoteModal() {
            document.getElementById('voteModal').classList.add('hidden');
        }
    </script>
</body>
</html>