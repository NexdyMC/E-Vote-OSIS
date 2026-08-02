<?php
/* =========================================================
   PARTIAL: layout/partials/navbar.php
   ---------------------------------------------------------
   Variabel yang harus tersedia sebelum include:
   $pageTitle   (string)
   $breadcrumb  (array)
   $admin       (array: nama, foto, role)

   Membuka <div id="main-wrapper"> dan <header> topbar, TAPI
   SENGAJA TIDAK menutup keduanya di sini — supaya file halaman
   (dashboard.php / kandidat.php / siswa.php) bisa menyisipkan
   <main id="main-content"> tepat setelah topbar ini. Penutupnya
   ada di footer.php.

   #pageTitleText & #breadcrumbText diberi id supaya JS di
   footer.php bisa memperbaruinya secara instan tiap kali
   navigasi SPA terjadi (navbar ini sendiri tidak ikut di-fetch
   ulang saat pindah halaman via AJAX).
   ========================================================= */
$breadcrumb = $breadcrumb ?? [$pageTitle ?? ''];
?>
<div id="main-wrapper" class="flex-1 min-w-0 flex flex-col min-h-screen">
  <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-100">
    <div class="h-20 px-4 sm:px-8 flex items-center justify-between gap-4">

      <div class="flex items-center gap-3 min-w-0">
        <!-- Hamburger: mobile only -->
        <button onclick="toggleSidebar(true)" class="lg:hidden shrink-0 w-9 h-9 rounded-lg border border-slate-200 flex items-center justify-center text-navy-700 hover:bg-slate-50">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div class="min-w-0">
          <h1 id="pageTitleText" class="font-display font-semibold text-lg sm:text-xl text-navy-900 truncate"><?= htmlspecialchars($pageTitle ?? '') ?></h1>
          <div id="breadcrumbText" class="flex items-center gap-1.5 text-xs text-slate-500 mt-0.5 truncate">
            <?php foreach ($breadcrumb as $i => $crumb): ?>
              <?php if ($i > 0): ?><i data-lucide="chevron-right" class="w-3 h-3 shrink-0"></i><?php endif; ?>
              <span class="truncate <?= $i === count($breadcrumb) - 1 ? 'text-primary-600 font-medium' : '' ?>"><?= htmlspecialchars($crumb) ?></span>
            <?php endforeach; ?>
          </div>
        </div>
      </div>

      <!-- Profil Admin -->
      <div class="flex items-center gap-3 shrink-0">
        <img src="<?= htmlspecialchars($admin['foto']) ?>" alt="Foto Admin" class="w-10 h-10 rounded-full object-cover border-2 border-primary-100">
        <div class="hidden sm:block text-right">
          <p class="text-sm font-semibold text-navy-900 leading-tight"><?= htmlspecialchars($admin['nama']) ?></p>
          <p class="text-xs text-slate-500"><?= htmlspecialchars($admin['role']) ?></p>
        </div>
        <i data-lucide="chevron-down" class="hidden sm:block w-4 h-4 text-slate-400"></i>
      </div>
    </div>
  </header>
