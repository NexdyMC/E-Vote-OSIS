<!-- =========================================================
     PARTIAL: head-assets.php
     Dipakai bersama oleh dashboard.php & kandidat.php agar
     konfigurasi Tailwind, font, dan style tidak duplikat.
     ========================================================= -->
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">

<!-- Tailwind CDN -->
<script src="https://cdn.tailwindcss.com"></script>
<script>
  tailwind.config = {
    theme: {
      extend: {
        colors: {
          navy:   { 950: '#0B1424', 900: '#0F172A', 800: '#152238', 700: '#1E293B' },
          primary:{ 50: '#EEF3FF', 100: '#DCE7FF', 500: '#2563EB', 600: '#1D4ED8', 700: '#1E3A8A' },
          accent: { 300: '#FDE68A', 400: '#FACC15', 500: '#EAB308' },
        },
        fontFamily: {
          display: ['Poppins', 'sans-serif'],
          body: ['Inter', 'sans-serif'],
        },
      }
    }
  }
</script>

<!-- Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&family=Poppins:wght@500;600;700;800&display=swap" rel="stylesheet">

<!-- AOS (Animate On Scroll) -->
<link href="https://unpkg.com/aos@2.3.4/dist/aos.css" rel="stylesheet">

<!-- Lucide Icons -->
<script src="https://unpkg.com/lucide@latest"></script>

<style>
  html, body { font-family: 'Inter', sans-serif; background:#F8FAFC; }
  h1, h2, h3, .font-display { font-family: 'Poppins', sans-serif; }

  /* ---------- Sidebar ---------- */
  #sidebar { transition: transform .3s ease; }
  @media (max-width: 1023px) {
    #sidebar { transform: translateX(-100%); position: fixed; z-index: 50; }
    #sidebar.open { transform: translateX(0); }
  }
  .nav-item { transition: background-color .2s ease, color .2s ease; }
  .nav-item.active {
    background: linear-gradient(90deg, rgba(250,204,21,.14), rgba(250,204,21,0));
    color: #FACC15;
    border-left: 3px solid #FACC15;
  }
  .nav-item:not(.active):hover { background: rgba(255,255,255,.06); }

  /* ---------- Overlay for mobile sidebar ---------- */
  #sidebarOverlay { transition: opacity .3s ease; }

  /* ---------- Cards ---------- */
  .card-hover { transition: transform .25s ease, box-shadow .25s ease; }
  .card-hover:hover { transform: translateY(-4px); box-shadow: 0 16px 32px -10px rgba(15,23,42,.15); }

  .card-dashed {
    border: 2px dashed #CBD5E1;
    transition: border-color .25s ease, background-color .25s ease, transform .25s ease;
  }
  .card-dashed:hover {
    border-color: #2563EB;
    background-color: #EEF3FF;
    transform: translateY(-4px);
  }

  .line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
  }

  /* ---------- Buttons ---------- */
  .btn-cta { transition: transform .2s ease, box-shadow .2s ease, background-color .2s ease; }
  .btn-cta:hover { transform: translateY(-2px); }

  /* ---------- Modal ---------- */
  #modalOverlay { transition: opacity .25s ease; }
  #modalPanel { transition: transform .25s ease, opacity .25s ease; }
  .modal-hidden #modalPanel { transform: translateY(16px) scale(.97); opacity: 0; }
  .modal-hidden #modalOverlay { opacity: 0; }
  .modal-hidden { pointer-events: none; }

  /* ---------- Scrollbar (sidebar) ---------- */
  .thin-scroll::-webkit-scrollbar { width: 5px; }
  .thin-scroll::-webkit-scrollbar-thumb { background: rgba(255,255,255,.15); border-radius: 10px; }
</style>
