<!-- AOS JS -->
<script src="https://unpkg.com/aos@2.3.4/dist/aos.js"></script>

<script>
  // Render semua icon Lucide di halaman
  lucide.createIcons();

  // Inisialisasi animasi scroll AOS
  AOS.init({ duration: 550, once: true, offset: 40 });

  // Buka/tutup sidebar mobile
  function toggleSidebar(open) {
    const sidebar = document.getElementById('sidebar');
    const overlay = document.getElementById('sidebarOverlay');
    if (open) {
      sidebar.classList.add('open');
      overlay.classList.remove('hidden');
    } else {
      sidebar.classList.remove('open');
      overlay.classList.add('hidden');
    }
  }
</script>
