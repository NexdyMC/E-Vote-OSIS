<?php $breadcrumb = $breadcrumb ?? [$pageTitle ?? '']; ?>
  <header class="sticky top-0 z-30 bg-white/90 backdrop-blur-md border-b border-slate-100 h-20 px-4 sm:px-8 flex items-center justify-between">
    <h1 class="font-display font-semibold text-xl text-navy-900"><?= $pageTitle ?></h1>
    <div class="flex items-center gap-3">
      <img src="<?= htmlspecialchars($admin['foto']) ?>" class="w-10 h-10 rounded-full border-2 border-primary-100">
      <div class="text-right">
        <p class="text-sm font-semibold text-navy-900"><?= htmlspecialchars($admin['nama']) ?></p>
        <p class="text-xs text-slate-500"><?= htmlspecialchars($admin['role']) ?></p>
      </div>
    </div>
  </header>