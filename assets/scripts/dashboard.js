
function load_kandidat() 
{
  fetch('../api/kandidat.php', {
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
      document.getElementById('card-kandidat').innerHTML =
        `<p>${data.message || data.data || 'Gagal memuat data.'}</p>`;
      return;
    }

    let html = '';

    data.data.forEach(kandidat => {
      html += `
        <div class="card border rounded-md text-center w-64">
          <div class="flex justify-center items-center">
            <img src="../upload/photo/${kandidat.image}" alt="kandidat ${kandidat.image}" class="w-32 h-32 object-cover object-center">
          </div>
          <p>${kandidat.nama}</p>
          <p>${kandidat.visi}</p>
          <p>${kandidat.misi}</p>
          <a href="dashboard.php?u=${kandidat.id}" class="text-blue-500 hover:text-blue-600">update</a>
          <button onclick="delete_kandidat(${kandidat.id})" class="text-red-500 hover:text-red-600">delete</a>
        </div>
      `;
    });

    document.getElementById('card-kandidat').innerHTML = html;
  })
  .catch(error => {
    console.error(error);
    document.getElementById('card-kandidat').innerHTML =
      '<p>Terjadi kesalahan.</p>';
  });
}
load_kandidat();
setInterval(load_kandidat, 10000); 

async function add_kandidat(nama, visi, misi, imageFile) 
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
  const res = await fetch('../api/kandidat.php', {
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
    load_kandidat(); // refresh daftar card
  } else {
    alert(data.message || 'Gagal menambahkan kandidat.');
  }
}

async function delete_kandidat(id_kandidat) {
  const res = await fetch('../api/kandidat.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/json'},
    body: JSON.stringify({
      type: 'delete',
      id: id_kandidat
    })
  });

  const data = await res.json();

  if (data.status == 'success') {
    alert('Kandidat berhasil dihapus!');
    load_kandidat(); // refresh daftar card
  } else {
    alert(data.message || 'Gagal menghapus kandidat.');
  }
}

const input_nama = document.getElementById('text-nama');
const input_visi = document.getElementById('text-visi');
const input_misi = document.getElementById('text-misi');
const input_image = document.getElementById('photo');

document.getElementById('btn-add-kandidat').addEventListener('click', () => {
  if (!input_nama.value.trim() || !input_visi.value.trim() || !input_misi.value.trim()) {
    alert('Semua field wajib diisi!');
    return;
  }
  const file = input_image.files[0] || null;
  add_kandidat(input_nama.value, input_visi.value, input_misi.value, file);
  
  input_nama.value = '';
  input_visi.value = '';
  input_misi.value = '';
  input_image.value = '';
});