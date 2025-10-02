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
    @for($i = 0; $i < $loop; $i++)
    <div class="sample-info">
        <ul>
            <li><strong>ID:</strong> {{ $sample->id }}</li>
            <li><strong>Material:</strong> {{ $sample->material->name }}</li>
            <li><strong>User:</strong> {{ $sample->user->name }}</li>
            <li><strong>Timestamp:</strong> {{ $sample->created_at }}</li>
            <li>
                {!! DNS1D::getBarcodeHTML(strval($sample->id), 'C128', 5, 150) !!}
            </li>
        </ul>
    </div>
    @endfor
</body>
</html>
