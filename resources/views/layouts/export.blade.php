




<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Daftar Peserta</title>
    <style>
        @page {
            margin: 1cm;
        }

        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            font-size: 12px;
            color: #333;
            line-height: 1.4;
        }

        /* Kop Surat Menggunakan Tabel agar lebih stabil di DomPDF */
        .kop-surat {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 2px;
            margin-bottom: 2px;
        }

        .kop-surat table {
            width: 100%;
            border: none;
        }

        .kop-surat td {
            border: none;
            vertical-align: middle;
            padding: 0;
        }

        .logo-container {
            width: 100px;
            /* Area logo sedikit lebih besar */
        }

        .logo-container img {
            max-width: 89px;
            height: auto;
            margin-bottom: 7px;
        }

        .brand-container {
            text-align: center;
        }

        .brand-container h1 {
            margin: 0;
            font-size: 20px;
            color: #000;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        .brand-container h2 {
            margin: 2px 0;
            font-size: 14px;
            font-weight: normal;
            color: #444;
        }

        .brand-container p {
            margin: 0;
            font-size: 10px;
            color: #666;
            font-style: italic;
        }

        /* Garis Ganda Khas Kop Surat */
        .line-double {
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }

        /* Style Tabel Data */
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

        /* Untuk pencetakan PDF, pastikan background warna muncul */
        @media print {
            th {
                background-color: #f2f2f2 !important;
                -webkit-print-color-adjust: exact;
            }
        }

        /* Penomoran otomatis untuk tabel jika diperlukan */
        .text-center {
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="kop-surat">
        <table>
            <tr>
                <td class="logo-container">
                    <img src="{{ public_path('storage/' . $site_settings['site_logo']) }}" alt="Logo">
                </td>
                <td class="brand-container">
                    <h1>LEMBAGA KURSUS {{ $site_settings['site_name'] }}</h1>
                    
                    <p>{{ $site_settings['address'] }}</p>
                    <p>Telepon/WA: {{ $site_settings['whatsapp_number'] }} | Email: {{ $site_settings['email'] ?? '-' }}
                    </p>
                </td>
                <td class="logo-container">
                </td>
            </tr>
        </table>
    </div>
    <div class="line-double"></div>

    @yield('content')
</body>

</html>
