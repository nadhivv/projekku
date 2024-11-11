<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Laporan Transaksi Saham Januari 2023</title>
    <!-- jQuery CDN -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- jsPDF untuk membuat file PDF --><!-- jsPDF dan autoTable CDN -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/2.4.0/jspdf.umd.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf-autotable/3.5.25/jspdf.plugin.autotable.min.js"></script>


    <style>
        /* CSS untuk memperindah tampilan */
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid #ddd;
        }
        th, td {
            padding: 8px;
            text-align: center;
        }
        button {
            margin-top: 20px;
            padding: 10px 20px;
            font-size: 16px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Laporan Transaksi Saham Bulan Januari 2023</h2>
        <table id="stockTable">
            <thead>
                <tr>
                    <th>Stock Code</th>
                    <th>Date Transaction: Month</th>
                    <th>Sum of Volume</th>
                    <th>Sum of Value</th>
                    <th>Sum of Frequency</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>ANTM</td>
                    <td>January 2023</td>
                    <td>2,002,386,700</td>
                    <td>4,354,048,869,000</td>
                    <td>272,070</td>
                </tr>
                <tr>
                    <td>BBCA</td>
                    <td>January 2023</td>
                    <td>1,851,380,400</td>
                    <td>15,438,041,255,000</td>
                    <td>398,350</td>
                </tr>
                <tr>
                    <td>BBRI</td>
                    <td>January 2023</td>
                    <td>3,402,389,400</td>
                    <td>15,617,348,532,000</td>
                    <td>461,900</td>
                </tr>
                <tr>
                    <td>BRIS</td>
                    <td>January 2023</td>
                    <td>696,781,000</td>
                    <td>956,160,927,000</td>
                    <td>146,065</td>
                </tr>
                <tr>
                    <td>GOTO</td>
                    <td>January 2023</td>
                    <td>63,898,683,300</td>
                    <td>6,911,588,060,500</td>
                    <td>555,121</td>
                </tr>
            </tbody>
        </table>
        <button id="downloadPDF">Download Report as PDF</button>
    </div>

    <script>
        $(document).ready(function () {
            $("#downloadPDF").click(function () {
                // Cek apakah jsPDF dan autoTable tersedia
                const { jsPDF } = window.jspdf;
                if (!jsPDF) {
                    alert("jsPDF gagal dimuat. Silakan periksa kembali koneksi atau library.");
                    return;
                }

                // Membuat dokumen PDF baru
                const doc = new jsPDF();
                doc.setFontSize(14);
                doc.text("Laporan Transaksi Saham Bulan Januari 2023", 14, 20);

                // Ambil data tabel
                let rows = [];
                $("#stockTable tbody tr").each(function () {
                    let row = [];
                    $(this).find("td").each(function () {
                        row.push($(this).text());
                    });
                    rows.push(row);
                });

                // Gunakan autoTable untuk menambahkan tabel ke PDF
                doc.autoTable({
                    head: [['Stock Code', 'Date Transaction: Month', 'Sum of Volume', 'Sum of Value', 'Sum of Frequency']],
                    body: rows,
                    startY: 30,
                });

                // Simpan file PDF
                doc.save("Laporan_Transaksi_Saham_Januari_2023.pdf");
            });
        });
    </script>

</body>
</html>
