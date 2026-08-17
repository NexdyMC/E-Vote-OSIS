<?php
/* =========================================================
   PARTIAL: layout/admin/navbar.php
   ========================================================= */
   
$pageTitle  = $pageTitle ?? 'Dashboard';
$breadcrumb = $breadcrumb ?? [$pageTitle];
?>
<div id="main-wrapper" class="flex flex-col flex-1 min-w-0 min-h-screen">
  <header class="sticky top-0 z-30 border-b bg-white/90 backdrop-blur-md border-slate-100">
    <div class="flex items-center justify-between h-20 gap-4 px-4 sm:px-8">

      <div class="flex items-center min-w-0 gap-3">
        <!-- Hamburger: mobile only -->
        <button onclick="toggleSidebar(true)" class="flex items-center justify-center border rounded-lg lg:hidden shrink-0 w-9 h-9 border-slate-200 text-navy-700 hover:bg-slate-50">
          <i data-lucide="menu" class="w-5 h-5"></i>
        </button>

        <div class="min-w-0">
          <h1 id="pageTitleText" class="text-lg font-semibold truncate font-display sm:text-xl text-navy-900"><?= htmlspecialchars($pageTitle) ?></h1>
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
        <img src="<?= "../upload/logo/".htmlspecialchars($admin['foto'] ?? 'https://i.pravatar.cc/150?img=47') ?>" alt="Foto Admin" class="object-cover w-10 h-10 border-2 rounded-full border-primary-100">
        <div class="hidden text-right sm:block">
          <p class="text-sm font-semibold leading-tight text-navy-900"><?= htmlspecialchars($admin['nama'] ?? 'Admin') ?></p>
          <p class="text-xs text-slate-500"><?= htmlspecialchars($admin['role'] ?? 'Administrator') ?></p>
        </div>
        <i data-lucide="chevron-down" class="hidden w-4 h-4 sm:block text-slate-400"></i>
      </div>
    </div>
  </header>