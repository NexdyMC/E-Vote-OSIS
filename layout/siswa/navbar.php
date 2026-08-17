    <!-- Navigation  : Desktop Top -->
    <header class="sticky top-0 z-40 border-b bg-brand-darkblue/90 backdrop-blur-md border-slate-800">
    	<div class="flex items-center justify-between px-4 py-4 mx-auto max-w-7xl md:px-6">

    		<!-- Navigation : Logo & Brand -->
    		<div class="z-10 flex items-center gap-3">
    			<div class="flex items-center justify-center w-12 h-12 text-lg font-bold shadow-md rounded-xl bg-brand-yellow text-brand-darkblue">
    				<i data-lucide="vote" class="w-8 h-8"></i>
    			</div>
    			<div>
    				<h1 class="text-xl font-bold tracking-wide text-white uppercase">E-Vote <span class="text-brand-yellow">OSIS</span></h1>
    				<p class="hidden text-xs text-slate-400 md:block">SMK Informatika Sumedang</p>
    				<p class="block text-xs uppercase text-slate-400 md:hidden"><?= $_SESSION['nama'] ?? "User";?></p>
    			</div>
    		</div>

    		<!-- Navigation : Navigation desktop & mobile top -->
    		<div class="absolute left-0 right-0 items-center justify-center hidden gap-4 md:flex">

    			<a href="voting.php" class="inline-flex items-center gap-1.5 px-4 py-2 text-md font-bold transition-all <?= $activePage === 'voting' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
    				<i data-lucide="vote" class="w-6 h-6"></i>Voting
    			</a>
    			<a href="hasil.php" class="inline-flex items-center gap-1.5 px-4 py-2 text-md font-bold transition-all <?= $activePage === 'hasil' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
    				<i data-lucide="bar-chart-3" class="w-6 h-6"></i>Hasil
    			</a>
    		</div>

    		<!-- Navigation : User Info & Logout -->
    		<div class="z-10 flex items-center gap-4">
    			<div class="hidden text-right md:block">
    				<p class="text-sm font-semibold text-white uppercase"><?= $_SESSION['nama'] ?? "User";?></p>
    				<p class="text-xs uppercase text-slate-400"><?= $_SESSION['kelas'] ?? "kelas" ;?></p>
    			</div>

    			<button type="button" onclick="logout()"
    				class="flex items-center p-2 text-sm font-semibold text-white transition-colors bg-red-500 rounded-lg hover:bg-red-600 md:p-3 md:text-base">
    				<i data-lucide="log-out" class="w-4 h-4 md:w-5 md:h-5"></i>
    				<span class="hidden ml-2 sm:block">Logout</span>
    			</button>
    		</div>

    	</div>
    </header>

    <!-- Navigation : Mobile Bottom -->
    <nav class="fixed bottom-0 left-0 right-0 z-40 px-2 py-2 border-t md:hidden bg-brand-darkblue/90 backdrop-blur-md border-slate-800">

    	<!-- Navigation : Navigation Mobile Bottom -->
    	<div class="flex items-center justify-center w-full gap-2">
    		<a href="voting.php" class="inline-flex items-center gap-1.5 px-4 py-4 text-md w-1/2 justify-center font-bold transition-all <?= $activePage === 'voting' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
    			<i data-lucide="bar-chart-3" class="w-6 h-6"></i>Voting
    		</a>
    		<a href="hasil.php" class="inline-flex items-center gap-1.5 px-4 py-4 text-md w-1/2 justify-center font-bold transition-all <?= $activePage === 'hasil' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
    			<i data-lucide="vote" class="w-6 h-6"></i>Hasil
    		</a>
    	</div>
    </nav>