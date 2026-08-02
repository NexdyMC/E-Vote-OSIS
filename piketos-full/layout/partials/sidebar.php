<?php
/* =========================================================
   PARTIAL: layout/partials/sidebar.php
   ---------------------------------------------------------
   Variabel yang harus tersedia sebelum include:
   $activePage  ('dashboard' | 'kandidat' | 'siswa')

   Catatan penting:
   - Setiap <a> menu utama diberi class "ajax-link" — ini yang
     ditangkap oleh script fetch di footer.php.
   - data-title & data-breadcrumb dipakai JS untuk memperbarui
     judul halaman & breadcrumb di navbar.php secara instan
     setiap kali konten di-load lewat SPA (karena navbar.php
     sendiri TIDAK ikut di-render ulang saat navigasi AJAX).
   - Link "Keluar" sengaja TIDAK diberi class ajax-link supaya
     logout tetap memicu reload/redirect penuh seperti biasa.
   ========================================================= */
if (!isset($activePage)) { $activePage = ''; }
?>
<div id="sidebarOverlay" onclick="toggleSidebar(false)"
     class="hidden fixed inset-0 bg-navy-950/60 z-40 lg:hidden"></div>

<aside id="sidebar" class="thin-scroll w-72 shrink-0 h-screen sticky top-0 bg-navy-900 border-r border-white/5 flex flex-col overflow-y-auto">

  <!-- Logo & Nama Sistem -->
  <div class="flex items-center gap-3 px-6 h-20 border-b border-white/5 shrink-0">
    <div class="w-10 h-10 rounded-xl bg-primary-700 flex items-center justify-center font-display font-bold text-accent-400 shrink-0">SI</div>
    <div class="min-w-0">
      <p class="font-display font-semibold text-sm text-white leading-tight truncate">E-Voting OSIS</p>
      <p class="text-[11px] text-slate-400 truncate">SMK Informatika Sumedang</p>
    </div>
  </div>

  <!-- Menu Navigasi Utama -->
  <nav class="flex-1 px-3 py-6 space-y-1.5">
    <p class="px-3 text-[11px] font-semibold tracking-widest text-slate-500 uppercase mb-2">Menu Utama</p>

    <a href="dashboard.php"
       class="ajax-link nav-item <?= $activePage === 'dashboard' ? 'active' : 'text-slate-300' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium"
       data-title="Statistik Voting" data-breadcrumb="Admin,Statistik Voting">
      <i data-lucide="bar-chart-3" class="w-[18px] h-[18px] shrink-0"></i>
      Statistik Voting
    </a>

    <a href="kandidat.php"
       class="ajax-link nav-item <?= $activePage === 'kandidat' ? 'active' : 'text-slate-300' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium"
       data-title="Kelola Pasangan Calon / Kandidat" data-breadcrumb="Admin,Kandidat">
      <i data-lucide="award" class="w-[18px] h-[18px] shrink-0"></i>
      Kandidat
    </a>

    <a href="siswa.php"
       class="ajax-link nav-item <?= $activePage === 'siswa' ? 'active' : 'text-slate-300' ?> flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium"
       data-title="Data Siswa / DPT" data-breadcrumb="Admin,Siswa / Data DPT">
      <i data-lucide="graduation-cap" class="w-[18px] h-[18px] shrink-0"></i>
      Siswa / Data DPT
    </a>
  </nav>

  <!-- Footer sidebar -->
  <div class="px-4 py-5 border-t border-white/5 shrink-0">
    <a href="logout.php" class="flex items-center gap-3 px-3 py-2.5 rounded-xl text-sm font-medium text-slate-400 hover:bg-white/5 hover:text-white transition">
      <i data-lucide="log-out" class="w-[18px] h-[18px]"></i>
      Keluar
    </a>
  </div>
</aside>
