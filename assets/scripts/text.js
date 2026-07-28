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

        document.getElementById('responseArea').textContent =
            JSON.stringify(data, null, 2);

    })
    .catch(error => {
        console.error(error);
        document.getElementById('responseArea').textContent =
            'Terjadi kesalahan';
    });

}
loadData();
setInterval(loadData, 5000);
    