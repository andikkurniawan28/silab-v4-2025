<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Cetak Sample {{ $sample->id }}</title>
    <style>
        @page {
            size: 88mm auto;
            margin: 5mm;
        }
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
            text-align: center;
        }
        .barcode-container {
            margin: 10px 0;
        }
        .sample-info {
            text-align: left;
            margin-top: 10px;
        }
        ul {
            list-style: none;
            padding: 0;
        }
        li {
            margin: 3px 0;
        }
    </style>
</head>
<body onload="window.print()">

    <h3>Data Sample</h3>

    <div class="barcode-container">
        <canvas id="barcode"></canvas>
    </div>

    <div class="sample-info">
        <ul>
            <li><strong>ID:</strong> {{ $sample->id }}</li>
            <li><strong>Material:</strong> {{ $sample->material->name }}</li>
            <li><strong>User:</strong> {{ $sample->user->name }}</li>
            <li><strong>Timestamp:</strong> {{ $sample->created_at }}</li>
        </ul>
    </div>

    <!-- bwip-js CDN -->
    <script src="https://unpkg.com/bwip-js/dist/bwip-js-min.js"></script>
    <script>
        try {
            bwipjs.toCanvas('barcode', {
                bcid:        'datamatrix',   // atau 'pdf417'
                text:        '{{ $sample->id }}',
                scale:       3,
                height:      10,
                includetext: false,
            });
        } catch (e) {
            console.error(e);
        }
    </script>
</body>
</html>
