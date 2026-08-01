<?php
require_once __DIR__ . "/api/conn.php";
session_start();

if (!isset($_SESSION['token'])) {
    header("Location: index.php");
    exit;
}

$paslon_list = $conn->mysql_select("tb_kardidat");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Voting Kardidat | E-Voting OSIS</title>
    <!-- Tailwind CSS CDN -->
    <!-- <script src="https://cdn.tailwindcss.com"></script> -->
    <script src="assets/scripts/sweetalert.2.11.js"></script>
    <script src="assets/scripts/tailwind.js"></script>
    <script src="assets/scripts/tailwind.config.js"></script>
    <!-- link : font google -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <!-- link : style css -->
    <link rel="stylesheet" href="assets/css/voting.css">
</head>
<body>

    <!-- section : header -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800 px-6 py-4">
        <div class="max-w-7xl mx-auto flex items-center justify-center">

            <!-- navbar : logo & brand -->
            <div class="absolute left-20 flex items-center gap-3">
                <div
                    class="w-10 h-10 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="vote"></i>
                </div>
                <div>
                    <h1 class="font-bold text-sm tracking-wide uppercase text-brand-yellow">E-Vote</h1>
                    <p class="text-[11px] text-slate-400">SMK Informatika Sumedang</p>
                </div>
            </div>

            <!-- navbar : navigation -->
            <div class="flex items-center gap-4">
                <a href="voting.php"
                    class="hidden sm:inline-flex items-center gap-1.5 text-sm font-semibold text-slate-300 hover:text-brand-yellow transition-colors">
                    <i data-lucide="vote" class="w-4 h-4"></i> Voting
                </a>
                <a href="live.php"
                    class="inline-flex items-center gap-1.5 text-sm font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-3.5 py-2 rounded-xl shadow-md transition-all">
                    <i data-lucide="bar-chart-3" class="w-4 h-4"></i> Hasil
                </a>
            </div>

            <div class="absolute right-20 flex items-center gap-4">
                <div class="text-right">
                    <p class="text-sm font-semibold text-white">
                        <?= $_SESSION['nama']; ?>
                    </p>
                    <p class="text-xs text-slate-400">
                        <?= $_SESSION['kelas']; ?>
                    </p>
                </div>
                <a href="logout.php"
                    class="inline-flex items-center gap-1.5 text-md font-bold text-white bg-red-500 hover:bg-red-500/80 px-4 py-2 rounded-lg transition-all">
                    <i data-lucide="logout" class="w-4 h-4"></i>
                    Logout
                </a>
            </div>
        </div>
    </header>

    <!-- section : main  -->
    <main class="py-8 px-4 sm:px-6 max-w-6xl mx-auto w-full flex-1 flex flex-col justify-center">

        <!--  main : select kardidat -->
        <div class="flex gap-4 overflow-x-auto py-2 no-scrollbar scroll-smooth">
            <?php
            $kardidat = $conn->mysql_select("tb_kardidat");
            foreach ($kardidat as $row) :?>

            <div class="max-w-96 w-full card-kandidat shrink-0 flex flex-col justify-between relative group bg-white rounded-3xl shadow-[0_8px_30px_rgb(15,23,42,0.06)] overflow-hidden border-2 border-slate-300/80 ">
                <div class="text-left">

                    <!-- kardidat : image -->
                    <div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-5">
                        <img src="upload/photo/<?=  $row['image']; ?>" alt="Kardidat <?= $row['nama'];?>"
                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                    </div>

                    <!-- kardidat : nama siswa -->
                    <p class="text-2xl text-center font-bold  my-4 line-clamp-1">
                        <?= $row['nama'] ?>
                    </p>

                    <!-- kardidat : jenis -->
                    <p class="flex justify-center mb-6">
                        <span class="text-xs font-bold tracking-widest text-brand-yellow uppercase bg-brand-yellow/10 px-3 py-1 rounded-full border border-brand-yellow/20">
                        Ketua OSIS
                        </span>
                    </p>

                    <!-- kardidat : visi & misi -->
                    <div class="px-4 space-y-4 scrollbar-thin scrollbar-thumb-slate-700">

                        <!-- kardidat : Visi -->
                        <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                            <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-blue"></i> Visi
                            </h4>
                            <p class="text-sm text-bland-blue leading-relaxed ">
                                <?= nl2br($row['visi']); ?>
                            </p>
                        </div>

                        <!-- kardidat : Misi -->
                        <div class="bg-slate-100/60 p-3 rounded-xl border-slate-200/80 border-2">
                            <h4 class="text-md font-bold uppercase text-brand-blue mb-1 flex items-center gap-1">
                                <i data-lucide="compass" class="w-3.5 h-3.5 text-brand-blue"></i> Misi
                            </h4>
                            <p class="text-sm text-bland-blue leading-relaxed ">
                                <?= nl2br($row['misi']); ?>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- kardidat : button voting -->
                <div class="px-4 py-4 space-y-4 text-center">
                    <button type="button" onclick="selectKardidat(<?= $row['id'];?>, '<?= $row['nama'];?>')" class="btn-cta w-full font-display font-semibold text-sm px-5 py-3 rounded-xl border-2 border-primary-700 text-primary-700 bg-slate-100 text-navy-500 hover:bg-primary-700 hover:text-white flex items-center justify-center gap-2">
                        <i data-lucide="vote" class="w-4 h-4"></i>
                        Pilih Kardidat Ini
                    </button>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </main>

    <!-- section : footer -->
    <footer class="bg-slate-950 border-t border-slate-900 py-4 text-center text-xs text-slate-500">
        &copy; <?= date('Y') ?> Pemilihan Ketua OSIS — SMK Informatika Sumedang
    </footer>

    <!-- script : js -->
    <script src="assets/scripts/voting.js"></script>
    <script>lucide.createIcons();</script>
</body>
</html>