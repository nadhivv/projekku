<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
    <title>Earthquake Data</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        #dataContainer {
            margin-top: 20px;
        }
        .gempa-item {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
            border-radius: 5px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <button id="loadData">Get Earthquake Data</button>
    <div id="dataContainer"></div>

    <script>
        $(document).ready(function() {
            $("#loadData").click(function() {
                $.ajax({
                    url: 'https://data.bmkg.go.id/DataMKG/TEWS/gempaterkini.json',
                    type: 'GET',
                    dataType: 'json',
                    success: function(data) {
                        if (data.Infogempa && data.Infogempa.gempa) {
                            let gempaList = data.Infogempa.gempa;
                            let info = '';

                            // Iterate through each earthquake record
                            gempaList.forEach(function(gempa) {
                                info += "<div class='gempa-item'>";
                                info += "<strong>Tanggal:</strong> " + gempa.Tanggal + "<br>" +
                                        "<strong>Jam:</strong> " + gempa.Jam + "<br>" +
                                        "<strong>DateTime:</strong> " + gempa.DateTime + "<br>" +
                                        "<strong>Koordinat:</strong> " + gempa.Coordinates + "<br>" +
                                        "<strong>Lintang:</strong> " + gempa.Lintang + "<br>" +
                                        "<strong>Bujur:</strong> " + gempa.Bujur + "<br>" +
                                        "<strong>Magnitude:</strong> " + gempa.Magnitude + "<br>" +
                                        "<strong>Kedalaman:</strong> " + gempa.Kedalaman + "<br>" +
                                        "<strong>Wilayah:</strong> " + gempa.Wilayah + "<br>" +
                                        "<strong>Potensi:</strong> " + gempa.Potensi + "<br>" +
                                        "</div>";
                            });

                            $('#dataContainer').html(info);
                        } else {
                            $('#dataContainer').text('Tidak ada data gempa terbaru.');
                        }
                    },
                    error: function(error) {
                        $('#dataContainer').text('Terjadi kesalahan dalam memuat data');
                    }
                });
            });
        });
    </script>
</body>
</html>
