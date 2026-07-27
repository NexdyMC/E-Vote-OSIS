<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP API Request</title>
</head>
<body>

    <h2>Send Data to API</h2>
    
    <!-- Input and Button -->
    <input type="text" id="userInput" placeholder="Type something here...">
    <button id="sendBtn">Send to API</button>

    <!-- Response display area -->
    <p><strong>Response from API:</strong> <span id="responseArea">None</span></p>

    <script>
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
    // .then(data => {

    //     let html = `
    //         <table border="1">
    //             <tr>
    //                 <th>ID</th>
    //                 <th>Nama</th>
    //                 <th>Visi</th>
    //                 <th>Misi</th>
    //             </tr>
    //     `;

    //     data.data.forEach(siswa => {
    //         html += `
    //             <tr>
    //                 <td>${siswa.id}</td>
    //                 <td>${siswa.nama}</td>
    //                 <td>${siswa.visi}</td>
    //                 <td>${siswa.misi}</td>
    //             </tr>
    //         `;
    //     });

    //     html += `</table>`;

    //     document.getElementById('responseArea').innerHTML = html;

    // })
    .catch(error => {
        console.error(error);
        document.getElementById('responseArea').textContent =
            'Terjadi kesalahan';
    });

}
loadData();
// document.getElementById('sendBtn').addEventListener('click', function() {});
// setInterval(loadData, 5000);
    
    </script>

</body>
</html>