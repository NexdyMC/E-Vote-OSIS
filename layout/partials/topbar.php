    <!-- header  : desktop -->
    <header class="sticky top-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-b border-slate-800">
        <div class="max-w-7xl mx-auto flex items-center justify-between px-4 md:px-6 py-4">
            
            <!-- Navbar : Logo & Brand -->
            <div class="flex items-center gap-3">
                <div class="w-12 h-12 rounded-xl bg-brand-yellow text-brand-darkblue font-bold flex items-center justify-center text-lg shadow-md">
                    <i data-lucide="vote" class="w-8 h-8"></i>
                </div>
                <div>
                    <h1 class="font-bold text-xl tracking-wide uppercase text-brand-yellow">E-Vote OSIS</h1>
                    <p class="text-xs text-slate-400 hidden md:block">SMK Informatika Sumedang</p>
                    <p class="text-xs text-slate-400 block md:hidden uppercase"><?= $_SESSION['nama'];?></p>
                </div>
            </div>

            <!-- Navbar : Navigation desktop & mobile top -->
            <div class="hidden md:flex justify-center items-center gap-4">
                 
                <a href="voting.php" 
                  class="inline-flex items-center gap-1.5 px-4 py-2 text-md font-bold transition-all <?= $activePage === 'voting' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
                  <i data-lucide="bar-chart-3" class="w-6 h-6"></i>Voting
                </a>
                <a href="hasil.php"  
                  class="inline-flex items-center gap-1.5 px-4 py-2 text-md font-bold transition-all <?= $activePage === 'hasil' ? 'text-brand-darkblue bg-gradient-to-br to-amber-500 from-amber-300 rounded-lg shadow-md' : 'text-slate-300 hover:text-brand-yellow' ?>">
                  <i data-lucide="vote" class="w-6 h-6"></i>Hasil
                </a>
            </div>

            <!-- Navbar : User Info & Logout -->
            <div class="flex items-center gap-4">
                <div class="text-right hidden md:block">
                    <p class="text-sm text-white font-semibold uppercase"><?= $_SESSION['nama'];?></p>
                    <p class="text-xs text-slate-400 uppercase"><?= $_SESSION['kelas'];?></p>
                </div>
                
                <button type="button" onclick="logout()" class="flex items-center bg-red-500 hover:bg-red-600 p-2 md:p-3 text-sm md:text-base text-white font-semibold rounded-lg transition-colors">
                    <i data-lucide="log-out" class="w-4 h-4 md:w-5 md:h-5"></i>
                    <span class="hidden sm:block ml-2">Logout</span>
                </button>
            </div>
            
        </div>
    </header>

    <!-- navbar : mobile bottom -->
    <nav class="md:hidden fixed bottom-0 left-0 right-0 z-40 bg-brand-darkblue/90 backdrop-blur-md border-t border-slate-800 px-4 py-3">
        
        <!-- Navbar : Navigation mobile bottom -->
        <div class="flex justify-center items-center gap-4 w-full">
            <a href="voting.php" class="inline-flex items-center justify-center gap-1.5 text-sm font-semibold text-slate-300 hover:text-brand-yellow transition-colors px-5 py-2.5 w-1/2">
                <i data-lucide="vote" class="w-6 h-6"></i> Voting
            </a>
            <a href="hasil.php" class="inline-flex items-center justify-center gap-1.5 text-sm font-bold text-brand-darkblue bg-brand-yellow hover:bg-brand-yellowhover px-5 py-2.5 rounded-xl shadow-md transition-all w-1/2">
                <i data-lucide="bar-chart-3" class="w-6 h-6"></i> Hasil
            </a>
        </div>
    </nav>