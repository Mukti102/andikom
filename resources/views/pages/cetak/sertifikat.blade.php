<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:ital,wght@0,300;0,400;0,500;0,600;1,300;1,400;1,500&family=Cinzel:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        :root {
            --gold: #b8963e;
            --gold-light: #d4af6a;
            --gold-pale: #f5ecd6;
            --crimson: #6b1a1a;
            --crimson-deep: #4a0f0f;
            --ink: #1c1410;
            --warm-white: #fdfaf5;
            --parchment: #f7f1e3;
            --shadow: rgba(107, 26, 26, 0.08);
        }

        body {
            font-family: 'Cormorant Garamond', serif;
            background: var(--warm-white);
            width: 297mm;
            height: 210mm;
            overflow: hidden;
        }

        /* ── Outer Shell ── */
        .cert-wrap {
            width: 297mm;
            height: 210mm;
            position: relative;
            background: var(--warm-white);
        }

        /* Watermark geometric background */
        .bg-pattern {
            position: absolute;
            inset: 0;
            opacity: 0.025;
            background-image:
                repeating-linear-gradient(45deg, var(--crimson) 0, var(--crimson) 1px, transparent 0, transparent 50%),
                repeating-linear-gradient(-45deg, var(--crimson) 0, var(--crimson) 1px, transparent 0, transparent 50%);
            background-size: 14px 14px;
        }

        /* Central watermark */
        .watermark {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            font-family: 'Cinzel', serif;
            font-size: 130pt;
            color: var(--crimson);
            opacity: 0.025;
            letter-spacing: 8px;
            font-weight: 600;
            pointer-events: none;
            white-space: nowrap;
        }

        /* ── Border System ── */
        .border-1 {
            position: absolute;
            top: 6mm; left: 6mm; right: 6mm; bottom: 6mm;
            border: 1px solid var(--gold);
        }
        .border-2 {
            position: absolute;
            top: 8.5mm; left: 8.5mm; right: 8.5mm; bottom: 8.5mm;
            border: 2.5px solid var(--crimson);
        }
        .border-3 {
            position: absolute;
            top: 11mm; left: 11mm; right: 11mm; bottom: 11mm;
            border: 0.5px solid var(--gold-light);
        }

        /* ── Corner Medallions ── */
        .corner {
            position: absolute;
            width: 18mm;
            height: 18mm;
        }
        .corner svg { width: 100%; height: 100%; }
        .corner-tl { top: 3mm; left: 3mm; }
        .corner-tr { top: 3mm; right: 3mm; transform: scaleX(-1); }
        .corner-bl { bottom: 3mm; left: 3mm; transform: scaleY(-1); }
        .corner-br { bottom: 3mm; right: 3mm; transform: scale(-1); }

        /* ── LEFT BAND ── */
        .left-band {
            position: absolute;
            top: 12mm;
            left: 12mm;
            bottom: 12mm;
            width: 52mm;
            background: linear-gradient(180deg, var(--crimson-deep) 0%, var(--crimson) 40%, #8b2020 100%);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            padding: 8mm 6mm;
        }

        .left-band::after {
            content: '';
            position: absolute;
            top: 0; right: 0; bottom: 0;
            width: 1px;
            background: linear-gradient(to bottom, transparent, var(--gold), var(--gold-light), var(--gold), transparent);
        }

        .band-logo-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            border: 1px solid rgba(212, 175, 106, 0.6);
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 5mm;
        }

        .band-logo-circle svg {
            width: 22px;
            height: 22px;
        }

        .band-title-vert {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            font-family: 'Cinzel', serif;
            font-size: 13pt;
            font-weight: 500;
            color: var(--gold-light);
            letter-spacing: 5px;
            text-transform: uppercase;
            margin-bottom: 5mm;
        }

        .band-divider {
            width: 1px;
            height: 12mm;
            background: linear-gradient(to bottom, transparent, var(--gold-light), transparent);
            margin: 3mm 0;
        }

        .band-subtitle {
            writing-mode: vertical-rl;
            text-orientation: mixed;
            transform: rotate(180deg);
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            color: rgba(212, 175, 106, 0.55);
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .band-year {
            font-family: 'Cormorant Garamond', serif;
            font-size: 9pt;
            color: rgba(212, 175, 106, 0.4);
            letter-spacing: 2px;
            margin-top: auto;
        }

        /* ── RIGHT CONTENT ── */
        .cert-body {
            position: absolute;
            top: 12mm;
            left: 65mm;
            right: 13mm;
            bottom: 12mm;
            padding: 7mm 7mm 6mm 10mm;
            display: flex;
            flex-direction: column;
        }

        /* ── Header ── */
        .header-area {
            margin-bottom: 3mm;
        }

        .inst-row {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 1.5mm;
        }

        .inst-line {
            flex: 1;
            height: 0.5px;
            background: linear-gradient(to right, var(--gold-light), transparent);
        }

        .inst-name {
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            letter-spacing: 3.5px;
            text-transform: uppercase;
            color: #999;
            white-space: nowrap;
        }

        .org-name {
            font-family: 'Cinzel', serif;
            font-size: 24pt;
            font-weight: 600;
            color: var(--crimson);
            letter-spacing: 6px;
            line-height: 1;
            margin-bottom: 1mm;
        }

        .org-tagline {
            font-family: 'Cormorant Garamond', serif;
            font-size: 8pt;
            color: var(--gold);
            letter-spacing: 2px;
            font-style: italic;
        }

        /* Gold ornament rule */
        .orn-rule {
            display: flex;
            align-items: center;
            gap: 6px;
            margin: 3mm 0;
        }
        .orn-rule .line {
            flex: 1;
            height: 0.5px;
            background: linear-gradient(to right, transparent, var(--gold-light), transparent);
        }
        .orn-rule .diamond {
            width: 5px;
            height: 5px;
            background: var(--gold);
            transform: rotate(45deg);
        }
        .orn-rule .dot {
            width: 3px;
            height: 3px;
            background: var(--gold-light);
            border-radius: 50%;
        }

        /* ── Main Content ── */
        .main-content {
            display: flex;
            gap: 7mm;
            flex: 1;
        }

        .left-content {
            flex: 1;
        }

        .cert-title-block {
            margin-bottom: 3mm;
        }

        .cert-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            letter-spacing: 4px;
            text-transform: uppercase;
            color: #aaa;
            margin-bottom: 0.5mm;
        }

        .cert-title-text {
            font-family: 'Cinzel', serif;
            font-size: 20pt;
            font-weight: 400;
            color: var(--crimson);
            letter-spacing: 4px;
            line-height: 1.1;
        }

        .presented-to {
            font-family: 'Cormorant Garamond', serif;
            font-size: 8pt;
            color: #999;
            letter-spacing: 1.5px;
            font-style: italic;
            margin-bottom: 0.5mm;
        }

        .recipient-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 22pt;
            font-weight: 500;
            font-style: italic;
            color: var(--ink);
            letter-spacing: 0.5px;
            line-height: 1;
            margin-bottom: 1mm;
            border-bottom: 0.5px solid var(--gold-pale);
            padding-bottom: 1.5mm;
        }

        /* ── Table ── */
        .nilai-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 2mm;
        }

        .nilai-table thead tr {
            border-bottom: 1px solid var(--crimson);
        }

        .nilai-table thead th {
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            letter-spacing: 1.5px;
            text-transform: uppercase;
            color: var(--crimson);
            padding: 0 6px 3px 6px;
            text-align: center;
            font-weight: 500;
        }

        .nilai-table thead th.th-materi { text-align: left; }

        .nilai-table tbody tr {
            border-bottom: 0.5px solid #ede8df;
        }

        .nilai-table tbody tr:nth-child(even) td {
            background: rgba(245, 236, 214, 0.3);
        }

        .nilai-table tbody td {
            font-family: 'Cormorant Garamond', serif;
            font-size: 8.5pt;
            color: #444;
            padding: 2.5px 6px;
            text-align: center;
        }

        .nilai-table tbody td.td-no {
            color: #aaa;
            font-size: 7pt;
            font-family: 'Montserrat', sans-serif;
        }

        .nilai-table tbody td.td-materi {
            text-align: left;
            color: var(--ink);
        }

        .predikat-badge {
            display: inline-block;
            padding: 1px 8px;
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            letter-spacing: 1px;
            text-transform: uppercase;
            border-radius: 20px;
        }
        .predikat-a {
            background: var(--gold-pale);
            color: var(--crimson);
            border: 0.5px solid var(--gold-light);
        }
        .predikat-b {
            background: #f0f0f0;
            color: #666;
            border: 0.5px solid #ddd;
        }

        /* ── RIGHT SIDEBAR (signature) ── */
        .right-sidebar {
            width: 42mm;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-end;
            padding-bottom: 1mm;
        }

        .cert-number-badge {
            width: 100%;
            background: var(--gold-pale);
            border: 0.5px solid var(--gold-light);
            padding: 3px 6px;
            text-align: center;
            margin-bottom: 4mm;
        }

        .cert-num-label {
            font-family: 'Montserrat', sans-serif;
            font-size: 5pt;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: #aaa;
        }

        .cert-num-value {
            font-family: 'Cormorant Garamond', serif;
            font-size: 8pt;
            color: var(--crimson);
            letter-spacing: 1px;
        }

        .ttd-area {
            width: 100%;
            text-align: center;
        }

        .ttd-city-date {
            font-family: 'Cormorant Garamond', serif;
            font-size: 7.5pt;
            color: #888;
            font-style: italic;
            margin-bottom: 2mm;
        }

        .foto-frame {
            width: 50px;
            height: 62px;
            border: 1px solid var(--gold-light);
            overflow: hidden;
            margin: 0 auto 2mm auto;
            position: relative;
        }

        .foto-frame::before {
            content: '';
            position: absolute;
            inset: 2px;
            border: 0.5px solid rgba(184, 150, 62, 0.3);
            pointer-events: none;
            z-index: 1;
        }

        .foto-frame img {
            width: 50px;
            height: 62px;
            object-fit: cover;
        }

        .foto-placeholder {
            width: 50px;
            height: 62px;
            background: var(--gold-pale);
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .sig-rule {
            width: 36mm;
            height: 0.5px;
            background: linear-gradient(to right, transparent, var(--ink), transparent);
            margin: 0 auto 2mm auto;
        }

        .ttd-name {
            font-family: 'Cormorant Garamond', serif;
            font-size: 9pt;
            font-weight: 600;
            color: var(--ink);
            letter-spacing: 0.3px;
        }

        .ttd-title {
            font-family: 'Montserrat', sans-serif;
            font-size: 5.5pt;
            color: #aaa;
            letter-spacing: 1px;
            text-transform: uppercase;
            margin-top: 1px;
        }

        /* ── QR / Seal area ── */
        .seal-area {
            margin-top: auto;
            margin-bottom: 3mm;
            text-align: center;
        }

        .seal-circle {
            width: 28px;
            height: 28px;
            border-radius: 50%;
            border: 1px solid var(--gold-light);
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto;
        }
    </style>
</head>
<body>
<div class="cert-wrap">

    <!-- Background texture -->
    <div class="bg-pattern"></div>
    <div class="watermark">A</div>

    <!-- Border layers -->
    <div class="border-1"></div>
    <div class="border-2"></div>
    <div class="border-3"></div>

    <!-- Corner ornaments -->
    <div class="corner corner-tl">
        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2 L20 2 M2 2 L2 20" stroke="#b8963e" stroke-width="1.5"/>
            <path d="M6 6 L18 6 M6 6 L6 18" stroke="#d4af6a" stroke-width="0.5"/>
            <circle cx="12" cy="12" r="2" fill="#b8963e" opacity="0.6"/>
            <path d="M12 6 L12 18 M6 12 L18 12" stroke="#b8963e" stroke-width="0.3" opacity="0.4"/>
        </svg>
    </div>
    <div class="corner corner-tr">
        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2 L20 2 M2 2 L2 20" stroke="#b8963e" stroke-width="1.5"/>
            <path d="M6 6 L18 6 M6 6 L6 18" stroke="#d4af6a" stroke-width="0.5"/>
            <circle cx="12" cy="12" r="2" fill="#b8963e" opacity="0.6"/>
        </svg>
    </div>
    <div class="corner corner-bl">
        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2 L20 2 M2 2 L2 20" stroke="#b8963e" stroke-width="1.5"/>
            <path d="M6 6 L18 6 M6 6 L6 18" stroke="#d4af6a" stroke-width="0.5"/>
            <circle cx="12" cy="12" r="2" fill="#b8963e" opacity="0.6"/>
        </svg>
    </div>
    <div class="corner corner-br">
        <svg viewBox="0 0 50 50" fill="none" xmlns="http://www.w3.org/2000/svg">
            <path d="M2 2 L20 2 M2 2 L2 20" stroke="#b8963e" stroke-width="1.5"/>
            <path d="M6 6 L18 6 M6 6 L6 18" stroke="#d4af6a" stroke-width="0.5"/>
            <circle cx="12" cy="12" r="2" fill="#b8963e" opacity="0.6"/>
        </svg>
    </div>

    <!-- LEFT BAND -->
    <div class="left-band">
        <div class="band-logo-circle">
            <svg viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                <polygon points="12,2 15,9 22,9 16.5,14 18.5,21 12,17 5.5,21 7.5,14 2,9 9,9" fill="none" stroke="#d4af6a" stroke-width="0.8"/>
                <circle cx="12" cy="12" r="3" fill="none" stroke="#d4af6a" stroke-width="0.5"/>
            </svg>
        </div>

        <div class="band-divider"></div>
        <div class="band-title-vert">Andikom</div>
        <div class="band-divider"></div>

        <div class="band-subtitle">Lembaga Pendidikan</div>
        <div class="band-year" style="margin-top:4mm;">2025</div>
    </div>

    <!-- MAIN CONTENT -->
    <div class="cert-body">

        <!-- Header -->
        <div class="header-area">
            <div class="inst-row">
                <div class="inst-name">Lembaga Pendidikan dan Pelatihan Siap Kerja</div>
                <div class="inst-line"></div>
            </div>
            <div class="org-name">ANDIKOM</div>
            <div class="org-tagline">Pusat Unggulan Teknologi & Kompetensi Digital</div>
        </div>

        <!-- Ornament rule -->
        <div class="orn-rule">
            <div class="line"></div>
            <div class="dot"></div>
            <div class="diamond"></div>
            <div class="dot"></div>
            <div class="line"></div>
        </div>

        <!-- Main content row -->
        <div class="main-content">
            <div class="left-content">

                <!-- Certificate title -->
                <div class="cert-title-block">
                    <div class="cert-label">Penghargaan Kompetensi</div>
                    <div class="cert-title-text">Sertifikat</div>
                </div>

                <!-- Recipient -->
                <div class="presented-to">Diberikan dengan bangga kepada</div>
                <div class="recipient-name">
                    {{ strtoupper($pendaftaran->peserta->nama_lengkap) }}
                </div>

                <!-- Table -->
                <table class="nilai-table">
                    <thead>
                        <tr>
                            <th width="5%" style="text-align:center">No</th>
                            <th width="55%" class="th-materi">Materi Pelatihan</th>
                            <th width="18%">Nilai</th>
                            <th width="22%">Predikat</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($pendaftaran->nilai->details as $i => $d)
                        <tr>
                            <td class="td-no">{{ $i + 1 }}</td>
                            <td class="td-materi">{{ $d->tool->name }}</td>
                            <td>{{ $d->skor }}</td>
                            <td>
                                @if($d->skor >= 90)
                                    <span class="predikat-badge predikat-a">Sangat Baik</span>
                                @else
                                    <span class="predikat-badge predikat-b">Baik</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

            </div><!-- /left-content -->

            <!-- RIGHT SIDEBAR -->
            <div class="right-sidebar">

                <div class="cert-number-badge">
                    <div class="cert-num-label">No. Sertifikat</div>
                    <div class="cert-num-value">
                        ANDIKOM/{{ date('Y') }}/{{ str_pad($pendaftaran->id, 4, '0', STR_PAD_LEFT) }}
                    </div>
                </div>

                <div class="ttd-area">
                    <div class="ttd-city-date">Bojonegoro, {{ date('d F Y') }}</div>
                    <div class="foto-frame">
                        <img src="{{ public_path('storage/' . $pendaftaran->peserta->foto) }}" alt="Foto">
                    </div>
                    <div class="sig-rule"></div>
                    <div class="ttd-name">Khoiruman, S.Ag, M.Pd</div>
                    <div class="ttd-title">Kepala Lembaga</div>
                </div>

            </div><!-- /right-sidebar -->

        </div><!-- /main-content -->

    </div><!-- /cert-body -->

</div><!-- /cert-wrap -->
</body>
</html>