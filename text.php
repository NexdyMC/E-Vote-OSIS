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
            // 1. Get the value from the input field
            const inputValue = document.getElementById('userInput').value;

            // 2. Send the data to api.php using Fetch API (POST method)
            fetch('vote.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify({ message: inputValue })
            })
            .then(response => response.json()) // Parse the incoming JSON response
            .then(data => {
                // 3. Display the returned value in index.php
                document.getElementById('responseArea').textContent = data.reply;
            })
            .catch(error => {
                console.error('Error:', error);
                document.getElementById('responseArea').textContent = 'An error occurred.';
            });
        });
    </script>

</body>
</html>