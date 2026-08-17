// Global variabel untuk menyimpan instance chart agar bisa di-destroy saat ganti jenis chart
let currentChart = null;

function renderChart(name, value) {
    const ctx = document.getElementById('myChart').getContext('2d');
    
    // Hancurkan chart sebelumnya jika ada untuk menghindari bug overlapping
    if (currentChart) {
        currentChart.destroy();
    }

    let config = null;

    // --- 1. Line Chart Standar ---
    if (name === 'line') {
        config = {
            type: 'line',
            data: { labels: name, datasets: [{ label: 'Dataset Line', data: value, borderColor: '#36A2EB', tension: 0.3 }] }
        };
    }

    // --- 2. Bar Chart dengan Warna Batang Berbeda ---
    else if (name === 'bar') {
        config = {
            type: 'bar',
            data: {
                labels: name,
                datasets: [{
                    label: 'Dataset Bar',
                    data: value,
                    backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF']
                }]
            }
        };
    }

    // --- 3. Pie Chart ---
    else if (name === 'pie') {
        config = {
            type: 'pie',
            data: {
                labels: name,
                datasets: [{ data: value, backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF'] }]
            }
        };
    }

    // --- 4. Doughnut Chart (Donat) ---
    else if (name === 'doughnut') {
        config = {
            type: 'doughnut',
            data: {
                labels: name,
                datasets: [{ data: value, backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56'] }]
            }
        };
    }

    // --- 5. Radar Chart (Unik untuk Analisis Multi-Variabel) ---
    else if (name === 'radar') {
        config = {
            type: 'radar',
            data: {
                labels: name,
                datasets: [{
                    label: 'Skill/Metric',
                    data: value,
                    backgroundColor: 'rgba(54, 162, 235, 0.2)',
                    borderColor: '#36A2EB',
                    pointBackgroundColor: '#36A2EB'
                }]
            }
        };
    }

    // --- 6. Polar Area Chart ---
    else if (name === 'polarArea') {
        config = {
            type: 'polarArea',
            data: {
                labels: name,
                datasets: [{ data: value, backgroundColor: ['#FF6384', '#4BC0C0', '#FFCE56', '#E7E9ED', '#36A2EB'] }]
            }
        };
    }

    // --- 7. Scatter Chart (Grafik Sebar Koordinat X dan Y) ---
    else if (name === 'scatter') {
        // value diasumsikan array of object [{x: 1, y: 2}, {x: 2, y: 4}, ...]
        config = {
            type: 'scatter',
            data: {
                datasets: [{
                    label: 'Scatter Dataset',
                    data: value,
                    backgroundColor: '#FF6384'
                }]
            }
        };
    }

    // --- 8. Bubble Chart (Unik: Ada Nilai Ukuran / Radius Bubble 'r') ---
    else if (name === 'bubble') {
        // value diasumsikan [{x: 10, y: 20, r: 15}, ...]
        config = {
            type: 'bubble',
            data: {
                datasets: [{
                    label: 'Bubble Dataset',
                    data: value,
                    backgroundColor: 'rgba(255, 99, 132, 0.5)'
                }]
            }
        };
    }

    // --- 9. Line Chart dengan Area Gradient (Efek Visual Unik) ---
    else if (name === 'gradient-line') {
        const gradient = ctx.createLinearGradient(0, 0, 0, 400);
        gradient.addColorStop(0, 'rgba(54, 162, 235, 0.8)');
        gradient.addColorStop(1, 'rgba(54, 162, 235, 0)');

        config = {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei'],
                datasets: [{
                    label: 'Gradient Fill',
                    data: value,
                    borderColor: '#36A2EB',
                    backgroundColor: gradient,
                    fill: true,
                    tension: 0.4
                }]
            }
        };
    }

    // --- 10. Mixed Chart (Gabungan Bar dan Line dalam Satu Canvas) ---
    else if (name === 'mixed') {
        config = {
            type: 'bar',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr'],
                datasets: [
                    {
                        type: 'bar',
                        label: 'Target (Bar)',
                        data: value,
                        backgroundColor: '#FFCE56'
                    },
                    {
                        type: 'line',
                        label: 'Pencapaian (Line)',
                        data: value.map(v => v * 0.8), // Contoh manipulasi data
                        borderColor: '#FF6384',
                        fill: false
                    }
                ]
            }
        };
    }

    // Render Chart ke Canvas jika config valid
    if (config) {
        currentChart = new Chart(ctx, config);
    } else {
        console.warn('Nama chart tidak dikenali atau parameter salah!');
    }
}

