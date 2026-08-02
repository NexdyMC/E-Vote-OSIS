
(function () {
  const form          = document.getElementById('formKandidat');
  const previewFoto    = document.getElementById('previewFotoKandidat');
  const dropzone       = document.getElementById('dropzoneFoto');
  const inputFoto      = document.getElementById('inputFotoKandidat');
  const PLACEHOLDER    = 'https://placehold.co/120x120/EEF3FF/1E3A8A?text=Foto';

  function openModalKandidat(mode, data) {
    form.reset();
    previewFoto.src = PLACEHOLDER;

    if (mode === 'edit' && data) {
      document.getElementById('modalKandidatTitle').textContent = 'Edit Kandidat';
      document.getElementById('inputKandidatId').value = data.id;
      document.getElementById('inputNamaKandidat').value = data.nama;
      document.getElementById('inputVisiKandidat').value = data.visi;
      document.getElementById('inputMisiKandidat').value = data.misi;
      if (data.image) previewFoto.src = '../upload/photo/' + data.image;
    } else {
      document.getElementById('modalKandidatTitle').textContent = 'Tambah Kandidat Baru';
      document.getElementById('inputKandidatId').value = '';
    }

    document.getElementById('modalWrapKandidat').classList.remove('modal-hidden');
    document.body.style.overflow = 'hidden';
  }

  function closeModalKandidat() {
    document.getElementById('modalWrapKandidat').classList.add('modal-hidden');
    document.body.style.overflow = '';
  }

  function tampilkanPreview(file) {
    if (!file) return;
    if (!file.type.startsWith('image/')) {
      alert('Tolong unggah file berupa gambar (PNG/JPG/WEBP).');
      return;
    }
    const reader = new FileReader();
    reader.onload = (e) => { previewFoto.src = e.target.result; };
    reader.readAsDataURL(file);
  }

  // Klik dropzone -> buka file explorer
  dropzone.addEventListener('click', () => inputFoto.click());

  // Drag & drop
  dropzone.addEventListener('dragover', (e) => {
    e.preventDefault();
    dropzone.classList.add('border-primary-500', 'bg-primary-50');
  });
  dropzone.addEventListener('dragleave', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50');
  });
  dropzone.addEventListener('drop', (e) => {
    e.preventDefault();
    dropzone.classList.remove('border-primary-500', 'bg-primary-50');
    if (e.dataTransfer.files && e.dataTransfer.files.length > 0) {
      inputFoto.files = e.dataTransfer.files;
      tampilkanPreview(e.dataTransfer.files[0]);
    }
  });

  // Pilih file lewat file explorer
  inputFoto.addEventListener('change', function () {
    if (this.files && this.files.length > 0) tampilkanPreview(this.files[0]);
  });

  // Tutup modal dengan Escape
  document.addEventListener('keydown', (e) => { if (e.key === 'Escape') closeModalKandidat(); });

  // Ekspor ke global scope supaya bisa dipanggil dari atribut onclick di HTML
  window.openModalKandidat  = openModalKandidat;
  window.closeModalKandidat = closeModalKandidat;
})();
