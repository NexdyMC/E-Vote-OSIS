<?php
include 'api/conn.php';
$hasil = $conn->get_data_grafik_voting();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Simple PHP API Request</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body>

    <h2>Send Data to API</h2>
    <?php
    $data = $conn->persen_voting_siswa();

    echo $data['persen_sudah'] . "%";
    ?>
    <!-- Input and Button -->
    <input type="text" id="userInput" placeholder="Type something here...">
    <button id="sendBtn">Send to API</button>

    <!-- Response display area -->
    <p><strong>Response from API:</strong> <span id="responseArea">None</span></p>

    

    <!-- Canvas untuk Grafik -->
     <div class="flex">
         <div style="width: 400px; display: inline-block;"><canvas id="barChart"></canvas></div>
         <div style="width: 400px; display: inline-block;"><canvas id="doughnutChart"></canvas></div>
     </div>

<!-- Script Chart.js -->
<script src="assets/scripts/text.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Langsung tangkap array dari PHP ke Javascript
    const namaKandidat = <?php echo json_encode($hasil['nama']); ?>;
    const valueVoted = <?php echo json_encode($hasil['value']); ?>;

    const warnaPilihan = ['#36a2eb', '#ff6384', '#ffce56', '#4bc0c0', '#9966ff', '#ff9f40'];

    // 1. Grafik Batang
    new Chart(document.getElementById('barChart'), {
        type: 'bar',
        data: {
            labels: namaKandidat,
            datasets: [{
                label: 'Jumlah Suara',
                data: valueVoted,
                backgroundColor: warnaPilihan
            }]
        }
    });

    // 2. Grafik Donat
    new Chart(document.getElementById('doughnutChart'), {
        type: 'doughnut',
        data: {
            labels: namaKandidat,
            datasets: [{
                data: valueVoted,
                backgroundColor: warnaPilihan
            }]
        }
    });
</script>
</body>
</html>