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
    document.getElementById('sendBtn').addEventListener('click', function() {

        fetch('api/siswa.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({
                type: 'voting',
                id_kardidat: 8
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

    });
    </script>

</body>
</html>