<?php
/* =========================================================
   PARTIAL: layout/partials/footer.php
   ---------------------------------------------------------
   Menutup wrapper dari navbar.php (#main-wrapper) & header.php
   (.flex), lalu memuat library JS + script SPA (Fetch API).
   HANYA di-include saat non-AJAX (full page load).

   Variabel yang tersedia di sini (sudah didefinisikan di file
   halaman sebelum require footer.php ini): $pageTitle, $breadcrumb
   ========================================================= */
?>
  </div><!-- /#main-wrapper (dibuka di navbar.php) -->
</div><!-- /.flex (dibuka di header.php) -->

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.4/dist/chart.umd.min.js"></script>
<!-- AOS JS (CSS-nya sudah di head lewat header.php) -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script src="../assets/scripts/kandidat.js"></script>


<script>
  lucide.createIcons();
  AOS.init({ duration: 550, once: true, offset: 40 });

  // Buka/tutup sidebar mobile
  function toggleSidebar(open) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (!sidebar || !overlay) return;
    if (open) { sidebar.classList.add('open'); overlay.classList.remove('hidden'); }
    else { sidebar.classList.remove('open'); overlay.classList.add('hidden'); }
  }


  // Skeleton loading (efek pulse) selagi konten baru diambil
  function loadingSkeleton() {
    return `
      <div class="p-4 sm:p-8 space-y-6 animate-pulse">
        <div class="h-6 w-56 bg-slate-200 rounded-lg"></div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
          <div class="h-28 bg-slate-200 rounded-2xl"></div>
          <div class="h-28 bg-slate-200 rounded-2xl"></div>
          <div class="h-28 bg-slate-200 rounded-2xl"></div>
          <div class="h-28 bg-slate-200 rounded-2xl"></div>
        </div>
        <div class="h-64 bg-slate-200 rounded-3xl"></div>
      </div>`;
  }

  function escapeHtml(str) {
    const div = document.createElement('div');
    div.textContent = str;
    return div.innerHTML;
  }

  // Navbar (topbar.php) tidak ikut di-fetch ulang saat navigasi AJAX,
  // jadi judul halaman & breadcrumb-nya diperbarui manual lewat JS ini.
  function updateTopbar(title, breadcrumbArr) {
    const titleEl = document.getElementById('pageTitleText');
    const crumbEl = document.getElementById('breadcrumbText');
    if (titleEl && title) titleEl.textContent = title;
    if (crumbEl && Array.isArray(breadcrumbArr) && breadcrumbArr.length) {
      crumbEl.innerHTML = breadcrumbArr.map(function (c, i) {
        const sep = i > 0 ? '<i data-lucide="chevron-right" class="w-3 h-3 shrink-0"></i>' : '';
        const cls = i === breadcrumbArr.length - 1 ? 'text-primary-600 font-medium' : '';
        return sep + '<span class="truncate ' + cls + '">' + escapeHtml(c) + '</span>';
      }).join('');
      lucide.createIcons();
    }
  }

  // Sidebar juga tidak ikut di-fetch ulang, jadi highlight menu aktif
  // disinkronkan manual berdasarkan url tujuan.
  function setActiveLink(url) {
    document.querySelectorAll('.ajax-link').forEach(function (link) {
      const isActive = link.getAttribute('href') === url;
      link.classList.toggle('active', isActive);
      link.classList.toggle('text-slate-300', !isActive);
    });
  }

  // <script> yang ikut terbawa dalam HTML hasil fetch tidak otomatis
  // dieksekusi browser saat disisipkan lewat innerHTML — jadi dibuat
  // ulang secara manual di sini agar chart/modal tiap halaman tetap jalan.
  function executeInlineScripts(container) {
    container.querySelectorAll('script').forEach(function (oldScript) {
      const newScript = document.createElement('script');
      Array.from(oldScript.attributes).forEach(function (attr) {
        newScript.setAttribute(attr.name, attr.value);
      });
      newScript.textContent = oldScript.textContent;
      oldScript.replaceWith(newScript);
    });
  }

  async function loadContent(url, push, title, breadcrumb) {
    const main = document.getElementById('main-content');
    if (!main) return;
    main.innerHTML = loadingSkeleton();

    try {
      const sep = url.indexOf('?') !== -1 ? '&' : '?';
      const res = await fetch(url + sep + 'ajax=1', { headers: { 'X-Requested-With': 'XMLHttpRequest' } });
      if (!res.ok) throw new Error('HTTP ' + res.status);
      const html = await res.text();

      main.innerHTML = html;
      executeInlineScripts(main);
      lucide.createIcons();
      AOS.refresh();
      updateTopbar(title, breadcrumb);
      setActiveLink(url);

      if (push) {
        window.history.pushState({ url: url, title: title, breadcrumb: breadcrumb }, '', url);
      }
      window.scrollTo({ top: 0, behavior: 'instant' });
    } catch (err) {
      main.innerHTML = '<div class="p-8 text-center text-sm text-red-600">Gagal memuat halaman. Silakan coba lagi.</div>';
      console.error('SPA load error:', err);
    }
  }

  // Tangkap semua klik pada .ajax-link (menu sidebar)
  document.addEventListener('click', function (e) {
    const link = e.target.closest('.ajax-link');
    if (!link) return;
    e.preventDefault();

    const url = link.getAttribute('href');
    const title = link.dataset.title || '';
    const breadcrumb = (link.dataset.breadcrumb || '').split(',').map(function (s) { return s.trim(); }).filter(Boolean);

    loadContent(url, true, title, breadcrumb);
    toggleSidebar(false);
  });

  // Tombol Back/Forward browser
  window.addEventListener('popstate', function (e) {
    const state = e.state;
    const url = (state && state.url) ? state.url : window.location.pathname;
    const title = (state && state.title) ? state.title : '';
    const breadcrumb = (state && state.breadcrumb) ? state.breadcrumb : [];
    loadContent(url, false, title, breadcrumb);
  });

  // Simpan state halaman pertama supaya tombol Back tetap benar
  window.history.replaceState(
    {
      url: window.location.pathname.split('/').pop() + window.location.search,
      title: <?= json_encode($pageTitle ?? '') ?>,
      breadcrumb: <?= json_encode($breadcrumb ?? []) ?>
    },
    '',
    window.location.href
  );
</script>



</body>
</html>
