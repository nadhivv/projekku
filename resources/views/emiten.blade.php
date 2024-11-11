<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Stock Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" />
    <style>
        /* General Styling */
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f7fa;
            color: #333;
            margin: 0;
            padding: 0;
        }

        .dashboard {
            width: 90%;
            max-width: 1200px;
            margin: auto;
            padding-top: 20px;
        }

        .section-title {
            font-size: 1.8em;
            margin: 20px 0;
            text-align: center;
            color: #444;
        }

        /* KPI Card Styling */
        .kpi-section {
            display: flex;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 20px;
        }

        .kpi-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 220px;
            padding: 20px;
            text-align: center;
        }

        .kpi-card h3 {
            font-size: 1.5em;
            margin: 10px 0;
        }

        .kpi-card p {
            font-size: 1.2em;
            color: #777;
        }

        /* Table Styling */
        .transaction-table {
            width: 100%;
            max-width: 1000px;
            margin: 20px auto;
            border-collapse: collapse;
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .transaction-table thead {
            background-color: #4BC0C0;
            color: #fff;
        }

        .transaction-table th, .transaction-table td {
            padding: 12px 15px;
            text-align: center;
            border-bottom: 1px solid #ddd;
        }

        .transaction-table th {
            font-weight: bold;
        }

        /* Chart Container Styling */
        .charts-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            justify-content: center;
        }

        .chart-card {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 550px;
            padding: 20px;
            text-align: center;
        }

        /* Canvas Sizing */
        canvas {
            max-width: 100%;
            height: 300px;
        }
    </style>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body>
    <div class="dashboard">
        <div class="section-title">Stock Dashboard</div>

        <!-- KPI Cards Section -->
        <div class="kpi-section">
            <div class="kpi-card">
                <p>Jumlah Emiten</p>
                <h3 id="emiten-count">5</h3>
            </div>
            <div class="kpi-card">
                <p>Volume Transaksi</p>
                <h3 id="transaction-volume">293.1B</h3>
            </div>
            <div class="kpi-card">
                <p>Value Transaksi</p>
                <h3 id="transaction-value">83.9T</h3>
            </div>
            <div class="kpi-card">
                <p>Jumlah Frekuensi</p>
                <h3 id="transaction-frequency">3,379,895</h3>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="charts-container">
            <div class="chart-card">
                <h4>Pie Chart - Value Transaksi</h4>
                <canvas id="pieChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Bar Chart - Monthly Frequency</h4>
                <canvas id="barChart"></canvas>
            </div>
            <div class="chart-card">
                <h4>Line Chart - Closing Prices</h4>
                <canvas id="lineChart"></canvas>
            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            // Fetch dashboard data from backend
            $.getJSON('/dashboard-data', function(data) {
                // Update KPI values dynamically
                $('#emiten-count').text(data.emitenCount);
                $('#transaction-volume').text((data.totalVolume / 1e9).toFixed(1) + 'B');
                $('#transaction-value').text((data.totalValue / 1e12).toFixed(1) + 'T');
                $('#transaction-frequency').text(data.totalFrequency.toLocaleString());


                let tableBody = $('#transaction-summary-table-body');
                tableBody.empty(); // Clear existing table rows, if any
                if (data.transactionSummary && data.transactionSummary.length > 0) {
                    data.transactionSummary.forEach(item => {
                        const sumVolume = (item.volume / 1e9).toFixed(1) + 'B';
                        const sumValue = (item.value / 1e12).toFixed(1) + 'T';
                        const sumFrequency = item.sum_frequency.toLocaleString();

                        tableBody.append(`
                            <tr>
                                <td>${item.STOCK_CODE}</td>
                                <td>${sumVolume}</td>
                                <td>${sumValue}</td>
                                <td>${sumFrequency}</td>
                            </tr>
                        `);
                    });
                } else {
                    tableBody.append(`<tr><td colspan="4">No data available</td></tr>`);
                }

                // Pie Chart for Transaction Values
                const pieLabels = data.pieChartData.map(item => item.STOCK_CODE);
                const pieValues = data.pieChartData.map(item => item.sum_value);

                new Chart(document.getElementById('pieChart'), {
                    type: 'pie',
                    data: {
                        labels: pieLabels,
                        datasets: [{
                            data: pieValues,
                            backgroundColor: ['#4BC0C0', '#FF6384', '#36A2EB', '#FFCE56', '#9966FF'],
                        }]
                    }
                });

                // Bar Chart for Monthly Frequency
                const barLabels = Array.from(new Set(data.frequencyData.map(item => item.month)));
                const barDatasets = {};

                data.frequencyData.forEach(item => {
                    if (!barDatasets[item.STOCK_CODE]) {
                        barDatasets[item.STOCK_CODE] = {
                            label: item.STOCK_CODE,
                            data: Array(barLabels.length).fill(0),
                            backgroundColor: '#' + Math.floor(Math.random()*16777215).toString(16),
                        };
                    }
                    const index = barLabels.indexOf(item.month);
                    barDatasets[item.STOCK_CODE].data[index] = item.sum_frequency;
                });

                new Chart(document.getElementById('barChart'), {
                    type: 'bar',
                    data: {
                        labels: barLabels,
                        datasets: Object.values(barDatasets),
                    }
                });

                // Line Chart for Closing Prices
                const lineLabels = Array.from(new Set(data.lineChartData.map(item => item.date_transaction)));
                const lineDatasets = {};

                data.lineChartData.forEach(item => {
                    if (!lineDatasets[item.STOCK_CODE]) {
                        lineDatasets[item.STOCK_CODE] = {
                            label: item.STOCK_CODE,
                            data: Array(lineLabels.length).fill(null),
                            borderColor: '#' + Math.floor(Math.random()*16777215).toString(16),
                            fill: false
                        };
                    }
                    const index = lineLabels.indexOf(item.date_transaction);
                    lineDatasets[item.STOCK_CODE].data[index] = item.CLOSE;
                });

                new Chart(document.getElementById('lineChart'), {
                    type: 'line',
                    data: {
                        labels: lineLabels,
                        datasets: Object.values(lineDatasets),
                    }
                });
            }).fail(function() {
                alert('Failed to load data.');
            });
        });
    </script>
</body>
</html>
