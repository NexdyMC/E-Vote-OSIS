<?php

if (!isset($activePage)) { $activePage = ''; }
?>
<!-- Overlay khusus mobile, muncul saat sidebar dibuka -->
<div id="sidebarOverlay" onclick="toggleSidebar(false)" class="hidden fixed inset-0 bg-navy-950/60 z-40 lg:hidden"></div>

  <aside id="sidebar" class="thin-scroll w-72 shrink-0 h-screen sticky top-0 bg-navy-900 border-r border-white/5 flex flex-col overflow-y-auto">
    <div class="flex items-center gap-3 px-6 h-20 border-b border-white/5 shrink-0">
      <div class="w-10 h-10 rounded-xl bg-primary-700 flex items-center justify-center font-display font-bold text-accent-400 shrink-0">SI</div>
      <div class="min-w-0">
        <p class="font-display font-semibold text-sm text-white leading-tight truncate">E-Voting OSIS</p>
        <p class="text-[11px] text-slate-400 truncate">SMK Informatika Sumedang</p>
      </div>
    </div>
    
    <nav class="flex-1 px-3 py-6 space-y-1.5">
      <p class="px-3 text-[11px] font-semibold tracking-widest text-slate-500 uppercase mb-2">Menu Utama</p>
      
      <!-- menu : dashboard -->
      <a href="dashboard.php"
        class="<?= $activePage === 'dashboard' ? 'text-brand-yellow' : 'text-slate-500' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
        <i data-lucide="bar-chart-3" class="w-[18px] h-[18px] shrink-0"></i> Statistik Voting
      </a>

      <!-- menu : kardidat -->
      <a href="kandidat.php"
        class="<?= $activePage === 'kardidat' ? 'text-brand-yellow' : 'text-slate-500' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
        <i data-lucide="award" class="w-[18px] h-[18px] shrink-0"></i> Kandidat
      </a>

      <!-- menu : siswa -->
      <a href="siswa.php"
        class="<?= $activePage === 'siswa' ? 'text-brand-yellow' : 'text-slate-500' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium">
        <i data-lucide="graduation-cap" class="w-[18px] h-[18px] shrink-0"></i> Siswa / Data DPT
      </a>
    </nav>
    <!-- menu : logout -->
    <div class="px-4 py-5 border-t border-white/5 shrink-0">
      <a href="../logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition">
        <i data-lucide="log-out" class="w-[18px] h-[18px]"></i> Keluar
      </a>
    </div>
  </aside>