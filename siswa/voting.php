<?php
require_once __DIR__ . "/../api/conn.php";
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

$paslon_list = $conn->mysql_select("tb_kandidat");
$activePage = "voting";
?>

<!DOCTYPE html>
<html lang="id">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Voting kandidat | E-Voting OSIS</title>
	<!-- Link : CDN & css/js -->
	<script src="https://cdn.tailwindcss.com"></script>
	<script src="assets/scripts/sweetalert.2.11.js"></script>
	<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
	<script src="https://unpkg.com/lucide@latest"></script>
	<script src="../assets/scripts/tailwind.config.js"></script>
	<link rel="stylesheet" href="../assets/css/voting.css">
</head>

<body>

	<?php if (!$is_ajax) {
		require_once __DIR__ . '/../layout/partials/topbar.php'; 
  }?>

	<!-- section : main  -->
	<main class="py-8 px-4 sm:px-6 max-w-6xl mx-auto w-full flex-1 flex flex-col justify-center space-y-3">
		<div class="text-center space-y-4">
			<div class="max-w-4xl mx-auto text-center space-y-3">
				<div class="py-6 space-y-4">

					<div class="flex justify-center">
						<div
							class="flex justify-center items-center text-white bg-gradient-to-br from-amber-500 to-amber-300 rounded-xl shadow-md transition-all w-20 h-20">
							<i data-lucide="users" class="w-10 h-10 stroke-[3]"></i>
						</div>
					</div>

					<h1 class="text-5xl font-extrabold text-center mb-4 text-slate-800">E-Vote <span
							class="text-[#FACC15]">OSIS</span></h1>
					<p class="text-gray-600">Pilih calon ketua OSIS yang menurut Anda paling tepat</p>

					<div
						class="bg-amber-300/20 border-amber-300/80 border-l-[5px] border-l-amber-300 rounded-2xl p-4 sm:p-5 shadow-[0_4px_20px_rgb(30,58,138,0.05)] flex items-start sm:items-center gap-4 my-6 transition-all">

						<!-- Icon Badge (Square Soft-Rounded) -->
						<div
							class="w-10 h-10 rounded-xl bg-amber-400 text-white flex items-center justify-center shrink-0 shadow-md shadow-blue-600/20">
							<i data-lucide="info" class="w-5 h-5"></i>
						</div>

						<!-- Content Text -->
						<div class="flex-1 min-w-0">
							<div class="flex items-center gap-2">
								<h4 class="font-display font-bold text-navy-900 text-sm sm:text-base leading-snug">
									Penting Diperhatikan!
								</h4>
							</div>

							<p class="text-xs sm:text-sm text-slate-600 mt-0.5 font-medium leading-relaxed text-left">
								Anda hanya dapat memilih satu kali dan tidak dapat mengubah pilihan setelahnya!
							</p>
						</div>

					</div>
				</div>
			</div>
		</div>

		<div class="relative flex items-center justify-center gap-4">

			<!--  main : select kandidat -->
			<div class="relative min-w-[320px] w-full max-w-[600px]  rounded-xl overflow-hidden shadow-2xl ">

				<!-- TRACK CAROUSEL -->
				<div id="scroll-container" class="flex w-full h-full transition-transform duration-500 ease-in-out">
					<?php
						$kandidat = $conn->mysql_select("tb_kandidat");
						foreach ($kandidat as $row):
					?>

					<div class="w-full h-full flex-none p-3">
						<div
							class="w-full h-full bg-white rounded-3xl overflow-hidden hover:border-blue-500 shadow-[0_8px_30px_rgb(15,23,42,0.06)] border-2 border-slate-300/80 flex flex-col  group relative">
							<!-- kandidat : image -->
							<div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-4 shrink-0">
								<img src="../upload/photo/<?=  $row['image']; ?>" alt="Kandidat <?= $row['nama'];?>"
									class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
							</div>

							<!-- kandidat : data -->
							<div class="flex-1 p-4 scrollbar-thin scrollbar-thumb-slate-300 scrollbar-track-transparent">

								<!-- kandidat : nama siswa -->
								<p class="text-2xl text-center font-bold mb-2 line-clamp-1 text-slate-800 shrink-0">
									<?= $row['nama'] ?>
								</p>

								<!-- kandidat : jenis -->
								<div class="flex justify-center mb-6 shrink-0">
									<span
										class="text-sm font-bold tracking-widest text-brand-yellow bg-yellow-50 px-3 py-1 rounded-full border border-brand-yellow/20">
										Calon Ketua OSIS
									</span>
								</div>

								<!-- kandidat : visi & misi -->
								<div class="space-y-4">
									<!-- kandidat : Visi -->
									<div class="bg-slate-50 p-3 rounded-xl border-slate-200 border-2">
										<h4 class="text-md font-bold uppercase text-blue-600 mb-1 flex items-center gap-1">
											<i data-lucide="compass" class="w-5 h-5"></i> Visi
										</h4>
										<p class="text-sm text-slate-600 leading-relaxed">
											<?= nl2br($row['visi']); ?>
										</p>
									</div>

									<!-- kandidat : Misi -->
									<div class="bg-slate-50 p-3 rounded-xl border-slate-200 border-2">
										<h4 class="text-md font-bold uppercase text-blue-600 mb-1 flex items-center gap-1">
											<i data-lucide="compass" class="w-5 h-5"></i> Misi
										</h4>
										<p class="text-sm text-slate-600 leading-relaxed">
											<?= nl2br($row['misi']); ?>
										</p>
									</div>
								</div>
							</div>

							<!-- kandidat : button voting -->
							<div class="p-4 bg-white border-t overflow-hidden border-slate-100 shrink-0 z-10">
								<button type="button" onclick="selectkandidat(<?= $row['id'];?>, '<?= $row['nama'];?>')"
									class="w-full font-semibold text-sm px-5 py-3 rounded-xl border-2 border-blue-600 text-blue-600 bg-white hover:bg-blue-600 hover:text-white transition-colors flex items-center justify-center gap-2">
									<i data-lucide="vote" class="w-4 h-4"></i>
									Pilih Kandidat Ini
								</button>
							</div>
						</div>
					</div>
					<?php endforeach; ?>
				</div>
			</div>

			<!-- button : Kiri -->
			<button id="btn-prev"
				class="absolute left-0 top-1/2 w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center hover:bg-slate-700 hover:scale-110 transition-transform active:scale-95 z-10 shadow-lg">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="m15 18-6-6 6-6" /></svg>
			</button>

			<!-- button : Kanan -->
			<button id="btn-next"
				class="absolute right-0 top-1/2 w-10 h-10 rounded-full bg-slate-800 text-white flex items-center justify-center hover:bg-slate-700 hover:scale-110 transition-transform active:scale-95 z-10 shadow-lg">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="m9 18 6-6-6-6" /></svg>
			</button>
		</div>

	</main>

	<!-- section : footer -->
	<footer class="bg-slate-950 border-t border-slate-900 py-6 text-center text-sm text-slate-500">
		&copy; 2026 Febri Pratama — All rights reserved.
	</footer>

	<!-- script : js -->
	<script src="../assets/scripts/voting.js"></script>
	<script>
		function logout() {
			window.location.href = "logout.php";
		}

		lucide.createIcons();

		const scrollContainer = document.getElementById('scroll-container');
		const btnLeft = document.getElementById('btn-prev');
		const btnRigth = document.getElementById('btn-next');
		const totalCards = scrollContainer.children.length;

		let currentIndex = 0;

		const updateCarousel = (index) => {
			const offset = -index * 100;
			scrollContainer.style.transform = `translateX(${offset}%)`;
		};

		btnLeft.addEventListener('click', () => {
			if (currentIndex === 0) {
				currentIndex = totalCards - 1;
			} else {
				currentIndex--;
			}
			updateCarousel(currentIndex);
		});

		btnRigth.addEventListener('click', () => {
			if (currentIndex === totalCards - 1) {
				currentIndex = 0;
			} else {
				currentIndex++;
			}
			updateCarousel(currentIndex);
		});
	</script>
</body>

</html>