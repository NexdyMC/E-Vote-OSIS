<?php
require_once __DIR__ . "/../api/conn.php";
session_start();
$is_ajax = isset($_GET['ajax']) && $_GET['ajax'] == '1';

if (!isset($_SESSION['token'])) {
    header("Location: login.php");
    exit;
}

$paslon_list = $conn->mysql_select("tb_kandidat");
$pageTitle = "Voting";
?>
<!DOCTYPE html>
<html lang="id">
<?php  if (!$is_ajax) require_once __DIR__ . '/../layout/siswa/head.php'; ?>
<body>
	<?php if (!$is_ajax) require_once __DIR__ . '/../layout/siswa/navbar.php'; ?>

	<!-- section : main  -->
	<main class="flex flex-col justify-center flex-1 w-full max-w-6xl px-4 py-8 mx-auto space-y-3 sm:px-6">
		<div class="space-y-4 text-center">
			<div class="max-w-4xl mx-auto space-y-3 text-center">
				<div class="py-6 space-y-4">

					<div class="flex justify-center">
						<div
							class="flex items-center justify-center w-20 h-20 text-white transition-all shadow-md bg-gradient-to-br from-amber-500 to-amber-300 rounded-xl">
							<i data-lucide="users" class="w-10 h-10 stroke-[3]"></i>
						</div>
					</div>

					<h1 class="mb-4 text-5xl font-extrabold text-center text-slate-800">E-Vote <span class="text-[#FACC15]">OSIS</span></h1>
					<p class="text-gray-600">Pilih calon ketua OSIS yang menurut Anda paling tepat</p>
					<div class="bg-amber-300/20 border-amber-300/80 border-l-[5px] border-l-amber-300 rounded-2xl p-4 sm:p-5 shadow-[0_4px_20px_rgb(30,58,138,0.05)] flex items-start sm:items-center gap-4 my-6 transition-all">

						<!-- Icon Badge (Square Soft-Rounded) -->
						<div
							class="flex items-center justify-center w-10 h-10 text-white shadow-md rounded-xl bg-amber-400 shrink-0 shadow-blue-600/20">
							<i data-lucide="info" class="w-5 h-5"></i>
						</div>

						<!-- Content Text -->
						<div class="flex-1 min-w-0">
							<div class="flex items-center gap-2">
								<h4 class="text-sm font-bold leading-snug font-display text-navy-900 sm:text-base">
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

					<div class="flex-none w-full h-full p-3">
						<div
							class="w-full h-full bg-white rounded-3xl overflow-hidden hover:border-blue-500 shadow-[0_8px_30px_rgb(15,23,42,0.06)] border-2 border-slate-300/80 flex flex-col  group relative">
							<!-- kandidat : image -->
							<div class="relative rounded-2xl overflow-hidden bg-slate-800 aspect-[4/3] mb-4 shrink-0">
								<img src="../upload/photo/<?=  $row['image']; ?>" alt="Kandidat <?= $row['nama'];?>"
									class="object-cover w-full h-full transition-transform duration-500 group-hover:scale-105">
							</div>

							<!-- kandidat : data -->
							<div class="flex-1 p-4 scrollbar-thin scrollbar-thumb-slate-300 scrollbar-track-transparent">

								<!-- kandidat : nama siswa -->
								<p class="mb-2 text-2xl font-bold text-center line-clamp-1 text-slate-800 shrink-0">
									<?= $row['nama'] ?>
								</p>

								<!-- kandidat : jenis -->
								<div class="flex justify-center mb-6 shrink-0">
									<span
										class="px-3 py-1 text-sm font-bold tracking-widest border rounded-full text-brand-yellow bg-yellow-50 border-brand-yellow/20">
										Calon Ketua OSIS
									</span>
								</div>

								<!-- kandidat : visi & misi -->
								<div class="space-y-4">
									<!-- kandidat : Visi -->
									<div class="p-3 border-2 bg-slate-50 rounded-xl border-slate-200">
										<h4 class="flex items-center gap-1 mb-1 font-bold text-blue-600 uppercase text-md">
											<i data-lucide="compass" class="w-5 h-5"></i> Visi
										</h4>
										<p class="text-sm leading-relaxed text-slate-600">
											<?= nl2br($row['visi']); ?>
										</p>
									</div>

									<!-- kandidat : Misi -->
									<div class="p-3 border-2 bg-slate-50 rounded-xl border-slate-200">
										<h4 class="flex items-center gap-1 mb-1 font-bold text-blue-600 uppercase text-md">
											<i data-lucide="compass" class="w-5 h-5"></i> Misi
										</h4>
										<p class="text-sm leading-relaxed text-slate-600">
											<?= nl2br($row['misi']); ?>
										</p>
									</div>
								</div>
							</div>

							<!-- kandidat : button voting -->
							<div class="z-10 p-4 overflow-hidden bg-white border-t border-slate-100 shrink-0">
								<button type="button" onclick="selectkandidat(<?= $row['id'];?>, '<?= $row['nama'];?>')"
									class="flex items-center justify-center w-full gap-2 px-5 py-3 text-sm font-semibold text-blue-600 transition-colors bg-white border-2 border-blue-600 rounded-xl hover:bg-blue-600 hover:text-white">
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
				class="absolute left-0 z-10 flex items-center justify-center w-10 h-10 text-white transition-transform rounded-full shadow-lg top-1/2 bg-slate-800 hover:bg-slate-700 hover:scale-110 active:scale-95">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="m15 18-6-6 6-6" /></svg>
			</button>

			<!-- button : Kanan -->
			<button id="btn-next"
				class="absolute right-0 z-10 flex items-center justify-center w-10 h-10 text-white transition-transform rounded-full shadow-lg top-1/2 bg-slate-800 hover:bg-slate-700 hover:scale-110 active:scale-95">
				<svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
					stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
					<path d="m9 18 6-6-6-6" /></svg>
			</button>
		</div>

	</main>

	<!-- section : footer -->
	<footer class="py-6 text-sm text-center border-t bg-slate-950 border-slate-900 text-slate-500">
		&copy; 2026 Febri Pratama — All rights reserved.
	</footer>

	<!-- script : js -->
	<script src="../assets/js/voting.js"></script>
	<script>
		lucide.createIcons();
		
		function logout() {
			window.location.href = "logout.php";
		}
		
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