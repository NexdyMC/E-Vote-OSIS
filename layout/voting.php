<?php
session_start();

// Cek apakah siswa sudah validasi token
// if (!isset($_SESSION['voter_logged_in']) || $_SESSION['voter_logged_in'] !== true) {
//     header('Location: login.php');
//     exit;
// }

// Data Contoh Paslon (Bisa kamu ambil dari Database MySQL / API PHP kamu)
$paslon_list = [
    [
        'id' => 1,
        'no_urut' => '01',
        'ketua' => 'Ahmad Fauzi',
        'wakil' => 'Siti Nurhaliza',
        'kelas' => 'XI RPL 1 & XI TKJ 2',
        'foto' => 'https://images.unsplash.com/photo-1534528741775-53994a69daeb?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Inovasi Digital untuk Sekolah Berprestasi & Inklusif',
        'visi' => 'Mewujudkan OSIS SMK Informatika Sumedang sebagai wadah aspirasi siswa yang adaptif terhadap teknologi, berintegritas, dan berprestasi di tingkat nasional.',
        'misi' => [
            'Mengembangkan kegiatan ekstrakurikuler berbasis teknologi dan ekosistem digital.',
            'Menciptakan forum komunikasi terbuka antara siswa, pengurus OSIS, dan pihak sekolah.',
            'Meningkatkan kedisiplinan dan rasa kepedulian sosial antar sesama siswa.'
        ]
    ],
    [
        'id' => 2,
        'no_urut' => '02',
        'ketua' => 'Rian Ardianto',
        'wakil' => 'Dina Permata',
        'kelas' => 'XI DKV 2 & XI RPL 3',
        'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Kreatif, Kolaboratif, dan Berkarakter Juara',
        'visi' => 'Menjadikan SMK Informatika Sumedang pusat kreativitas siswa yang aktif, berbudaya, serta mampu bersaing di era industri kreatif.',
        'misi' => [
            'Menyelenggarakan pentas seni dan kompetisi desain/coding berkala.',
            'Mengoptimalkan media sosial OSIS sebagai sarana edukasi dan promosi karya siswa.',
            'Membangun kerja sama dengan alumni untuk program *mentoring* karir.'
        ]
    ],
    [
        'id' => 3,
        'no_urut' => '03',
        'ketua' => 'Rian Ardianto',
        'wakil' => 'Dina Permata',
        'kelas' => 'XI DKV 2 & XI RPL 3',
        'foto' => 'https://images.unsplash.com/photo-1507003211169-0a1dd7228f2d?auto=format&fit=crop&w=600&q=80',
        'tagline' => 'Kreatif, Kolaboratif, dan Berkarakter Juara',
        'visi' => 'Menjadikan SMK Informatika Sumedang pusat kreativitas siswa yang aktif, berbudaya, serta mampu bersaing di era industri kreatif.',
        'misi' => [
            'Menyelenggarakan pentas seni dan kompetisi desain/coding berkala.',
            'Mengoptimalkan media sosial OSIS sebagai sarana edukasi dan promosi karya siswa.',
            'Membangun kerja sama dengan alumni untuk program *mentoring* karir.'
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
    </style>
</head>
<body class="bg-[#0F172A] text-slate-100 min-h-screen flex flex-col justify-between relative overflow-x-hidden">

    <!-- HEADER / NAVBAR RINGKAS -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800 px-6 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="vote"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">Bilik Suara Digital</h1>
                    <p class="text-[11px] text-slate-400">SMK Informatika Sumedang</p>
                </div>
            </div>
            <div class="flex items-center gap-2 bg-slate-800 px-3 py-1.5 rounded-full border border-slate-700">
                <span class="w-2 h-2 rounded-full bg-emerald-400 animate-pulse"></span>
                <span class="text-xs font-semibold text-slate-300">Siswa Terverifikasi</span>
            </div>
        </div>
    </header>

    <!-- MAIN CONTENT: LIST PASLON ZIG-ZAG -->
    <main class="py-12 px-6 max-w-6xl mx-auto w-full space-y-20">

        <!-- TITLE SECTION -->
        <div class="text-center max-w-2xl mx-auto">
            <span class="text-xs font-bold tracking-widest text-brand-yellow uppercase bg-brand-yellow/10 px-4 py-1.5 rounded-full border border-brand-yellow/20">
                Langkah Terakhir
            </span>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-white mt-4">Pilih Paslon Ketua & Wakil OSIS</h2>
            <p class="text-slate-400 text-sm mt-2">
                Pelajari visi &amp; misi tiap paslon di bawah ini. Suaramu hanya bisa dikirim <span class="text-brand-yellow font-semibold">1 kali</span> dan tidak dapat diubah.
            </p>
        </div>

        <!-- LOOPING PASLON (BERSELANG-SELING / ZIG-ZAG) -->
        <?php foreach ($paslon_list as $index => $paslon): 
            // Cek ganjil-genap untuk menentukan posisi kiri/kanan
            $is_even = $index % 2 === 1; 
        ?>
        <section class="bg-slate-900/80 border border-slate-800 rounded-3xl p-6 sm:p-10 shadow-2xl relative overflow-hidden backdrop-blur-sm">
            
            <!-- Badge Nomor Urut -->
            <div class="absolute top-6 left-6 sm:top-8 sm:left-8 z-10">
                <span class="bg-brand-yellow text-brand-darkblue text-lg sm:text-xl font-extrabold px-4 py-2 rounded-2xl shadow-lg flex items-center gap-1.5">
                    <span class="text-xs font-bold opacity-75">PASLON</span> <?= $paslon['no_urut'] ?>
                </span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8 items-center mt-8 lg:mt-0">
                
                <!-- FOTO PASLON (Berganti Posisi Kiri / Kanan) -->
                <div class="lg:col-span-5 <?= $is_even ? 'lg:order-2' : 'lg:order-1' ?>">
                    <div class="relative group">
                        <div class="absolute -inset-1 bg-gradient-to-r from-brand-blue to-brand-yellow rounded-2xl blur opacity-30 group-hover:opacity-60 transition duration-500"></div>
                        <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/5]">
                            <img src="<?= $paslon['foto'] ?>" alt="Foto Paslon" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <div class="absolute inset-0 bg-gradient-to-t from-slate-950 via-transparent to-transparent opacity-80"></div>
                            
                            <!-- Overlay Nama di Atas Foto (Mobile friendly) -->
                            <div class="absolute bottom-4 left-4 right-4">
                                <span class="text-xs font-semibold text-brand-yellow bg-brand-darkblue/80 px-2.5 py-1 rounded-md border border-brand-yellow/30 mb-2 inline-block">
                                    <?= $paslon['kelas'] ?>
                                </span>
                                <h3 class="text-xl font-bold text-white leading-tight"><?= $paslon['ketua'] ?></h3>
                                <p class="text-sm text-slate-300">&amp; <?= $paslon['wakil'] ?></p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- INFORMASI & VISI MISI (Berganti Posisi Kanan / Kiri) -->
                <div class="lg:col-span-7 <?= $is_even ? 'lg:order-1' : 'lg:order-2' ?> flex flex-col justify-between h-full">
                    
                    <div>
                        <!-- Tagline -->
                        <div class="mb-4">
                            <span class="text-xs font-semibold uppercase tracking-wider text-slate-400">Tagline Kampanye</span>
                            <blockquote class="text-lg font-bold text-brand-yellow italic mt-1">
                                "<?= $paslon['tagline'] ?>"
                            </blockquote>
                        </div>

                        <!-- Visi -->
                        <div class="mb-6 bg-slate-950/50 p-4 rounded-xl border border-slate-800">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-brand-blue mb-1 flex items-center gap-1.5">
                                <i data-lucide="compass" class="w-4 h-4 text-brand-yellow"></i> Visi Utama
                            </h4>
                            <p class="text-sm text-slate-300 leading-relaxed">
                                <?= $paslon['visi'] ?>
                            </p>
                        </div>

                        <!-- Misi (List) -->
                        <div class="mb-8">
                            <h4 class="text-xs font-bold uppercase tracking-wider text-brand-blue mb-3 flex items-center gap-1.5">
                                <i data-lucide="list-checks" class="w-4 h-4 text-brand-yellow"></i> Misi &amp; Program Kerja
                            </h4>
                            <ul class="space-y-2.5">
                                <?php foreach ($paslon['misi'] as $m): ?>
                                    <li class="flex items-start gap-2.5 text-xs sm:text-sm text-slate-300">
                                        <i data-lucide="check-circle-2" class="w-4 h-4 text-emerald-400 shrink-0 mt-0.5"></i>
                                        <span><?= $m ?></span>
                                    </li>
                                <?php endforeach; ?>
                            </ul>
                        </div>
                    </div>

                    <!-- Tombol Eksekusi Voting -->
                    <div>
                        <button type="button" 
                            onclick="openVoteModal('<?= $paslon['id'] ?>', '<?= $paslon['no_urut'] ?>', '<?= $paslon['ketua'] ?> & <?= $paslon['wakil'] ?>')"
                            class="w-full py-4 px-6 rounded-2xl bg-brand-yellow hover:bg-brand-yellowhover text-brand-darkblue font-extrabold text-base shadow-lg shadow-brand-yellow/20 hover:shadow-xl transition-all duration-300 flex items-center justify-center gap-2 group">
                            <i data-lucide="check-square" class="w-5 h-5"></i>
                            <span>COBLOS PASLON <?= $paslon['no_urut'] ?></span>
                        </button>
                    </div>

                </div>

            </div>
        </section>
        <?php endforeach; ?>

    </main>

    <!-- FOOTER RINGKAS -->
    <footer class="bg-slate-950 border-t border-slate-900 py-6 text-center text-xs text-slate-500">
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

    <!-- SCRIPT POPUP & LUCIDE -->
    <script>
        lucide.createIcons();

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