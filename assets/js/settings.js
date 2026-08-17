document.addEventListener('DOMContentLoaded', () => {
  // 1. Script Drag & Drop Logo
  const dropzoneLogo = document.getElementById('dropzoneLogo');
  const inputLogo    = document.getElementById('inputLogo');
  const previewLogo  = document.getElementById('previewLogo');

  dropzoneLogo.addEventListener('click', () => inputLogo.click());

  dropzoneLogo.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.add('border-primary-500', 'bg-primary-50');
  });

  dropzoneLogo.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.remove('border-primary-500', 'bg-primary-50');
  });

  dropzoneLogo.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzoneLogo.classList.remove('border-primary-500', 'bg-primary-50');
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      inputLogo.files = e.dataTransfer.files;
      previewImage(e.dataTransfer.files[0]);
    }
  });

  inputLogo.addEventListener('change', function() {
    if (this.files && this.files.length > 0) previewImage(this.files[0]);
  });

  function previewImage(file) {
    if (file && file.type.startsWith('image/')) {
      const reader = new FileReader();
      reader.onload = (e) => previewLogo.src = e.target.result;
      reader.readAsDataURL(file);
    }
  }

  // 2. Script Update Timeline Interaktif
  const inputMulai   = document.getElementById('inputWaktuMulai');
  const inputSelesai = document.getElementById('inputWaktuSelesai');
  const teksMulai    = document.getElementById('teksMulai');
  const teksSelesai  = document.getElementById('teksSelesai');

  function formatTanggalIndo(dateString) {
    if(!dateString) return '-';
    const date = new Date(dateString);
    return date.toLocaleDateString('id-ID', { 
      day: '2-digit', month: 'short', year: 'numeric', 
      hour: '2-digit', minute: '2-digit'
    }).replace(/\./g, ':'); // mengubah separator jam default JS ke titik dua
  }

  inputMulai.addEventListener('input', (e) => {
    teksMulai.textContent = formatTanggalIndo(e.target.value);
  });

  inputSelesai.addEventListener('input', (e) => {
    teksSelesai.textContent = formatTanggalIndo(e.target.value);
  });
});