function loadData() {
  fetch('api/siswa.php', {
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
      console.log(data);

      // tampilkan pesan error
      if (data.status !== 'success') {
        document.getElementById('responseArea').textContent =
          data.data || data.message || 'Terjadi kesalahan';
        return;
      }

      // start tabel 
      let html = `
            <table>
                <tr>
                    <th>Token</th>
                    <th>Nama</th>
                    <th>Kelas</th>
                    <th>Status</th>
                    <th>Voted</th>
                </tr>
                `;

      data.data.forEach(siswa => {
        html += `
                <tr>
                    <td>${siswa.id}</td>
                    <td>${siswa.nama}</td>
                    <td>${siswa.visi}</td>
                    <td>${siswa.misi}</td>
                    <td class="status-${siswa.status}">${siswa.status == 1 ? 'Sudah Vote' : 'Belum Vote'}</td>
                </tr>
            `;
      });
      html += `</table>`;
      // end table

      document.getElementById('responseArea').innerHTML = html;
    })
    .catch(error => {
      console.error(error);
      document.getElementById('responseArea').textContent =
        'Terjadi kesalahan';
    });
}

loadData();
setInterval(loadData, 5000);
