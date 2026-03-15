<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta</title>
    <style>
        body {
            font-family: 'Helvetica', sans-serif;
            font-size: 12px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #333;
            padding-bottom: 10px;
        }

        .header h1 {
            margin: 0;
            text-transform: uppercase;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #fafafa;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2 style="text-transform: uppercase">LEMBAGA KURSUS {{ $site_settings['site_name'] }}</h2>
        <p> {{ $site_settings['address'] }} | Telp: {{ $site_settings['whatsapp_number'] }}</p>
    </div>

    @yield('content')
</body>

</html>
