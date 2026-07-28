
function load_kardidat() 
{
  fetch('../api/siswa.php', {
    method: 'POST',
    headers: {
      'Content-Type': 'application/json'
    },
    body: JSON.stringify({
      type: 'select',
    })
  })
  .then(response => response.json())
  .then(data => {

    if (data.status !== 'success') {
      document.getElementById('card-kardidat').innerHTML =
        `<p>${data.message || data.data || 'Gagal memuat data.'}</p>`;
      return;
    }

    let html = '';

    data.data.forEach(kardidat => {
      html += `
        <div class="card border rounded-md text-center w-64">
          <div class="flex justify-center items-center">
            <img src="../upload/photo/${kardidat.image}" alt="Kardidat ${kardidat.image}" class="w-32 h-32 object-cover object-center">
          </div>
          <p>${kardidat.nama}</p>
          <p>${kardidat.visi}</p>
          <p>${kardidat.misi}</p>
          <a href="dashboard.php?u=${kardidat.id}" class="text-blue-500 hover:text-blue-600">update</a>
          <button onclick="delete_kardidat(${kardidat.id})" class="text-red-500 hover:text-red-600">delete</a>
        </div>
      `;
    });

    document.getElementById('card-kardidat').innerHTML = html;
  })
  .catch(error => {
    console.error(error);
    document.getElementById('card-kardidat').innerHTML =
      '<p>Terjadi kesalahan.</p>';
  });
}
load_kardidat();
setInterval(load_kardidat, 10000); 

async function add_kardidat(nama, visi, misi, imageFile) 
{
  let imageName = null;

  if (imageFile) {
    const formData = new FormData();
    formData.append('photo', imageFile);

    const uploadRes = await fetch('../api/upload.php', {
      method: 'POST',
      body: formData
    });
    const uploadData = await uploadRes.json();

    if (uploadData.status !== 'success') {
      alert(uploadData.message || 'Gagal upload gambar.');
      return;
    }
    imageName = uploadData.filename; // nama file hasil upload
  }

  // 2. Baru kirim data teks + nama file sebagai JSON
  const res = await fetch('../api/kardidat.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      type: 'add',
      nama: nama,
      visi: visi,
      misi: misi,
      image: imageName
    })
  });
  const data = await res.json();

  if (data.status === 'success') {
    alert('Kandidat berhasil ditambahkan!');
    load_kardidat(); // refresh daftar card
  } else {
    alert(data.message || 'Gagal menambahkan kandidat.');
  }
}

async function delete_kardidat(id_kardidat) {
  const res = await fetch('../api/kardidat.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      type: 'delete',
      id: id_kardidat
    })
  });

  const data = await res.json();

  if (data.status == 'success') {
    alert('Kandidat berhasil dihapus!');
    load_kardidat(); // refresh daftar card
  } else {
    alert(data.message || 'Gagal menghapus kandidat.');
  }
}

const input_nama = document.getElementById('text-nama');
const input_visi = document.getElementById('text-visi');
const input_misi = document.getElementById('text-misi');
const input_image = document.getElementById('photo');

document.getElementById('btn-add-kardidat').addEventListener('click', () => {
  if (!input_nama.value.trim() || !input_visi.value.trim() || !input_misi.value.trim()) {
    alert('Semua field wajib diisi!');
    return;
  }
  const file = input_image.files[0] || null;
  add_kardidat(input_nama.value, input_visi.value, input_misi.value, file);
  
  input_nama.value = '';
  input_visi.value = '';
  input_misi.value = '';
  input_image.value = '';
});