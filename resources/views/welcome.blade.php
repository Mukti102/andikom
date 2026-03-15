<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $site_settings['site_name'] }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/' . $site_settings['site_logo']) }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --rose: #e11d48;
            --rose-dark: #9f1239;
            --rose-light: #fff1f2;
            --rose-mid: #fecdd3;
            --ink: #1a1a2e;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #ffffff;
            --bg: #fafafa;
            --warm: #fdf6f0;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            scroll-behavior: smooth;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background: var(--bg);
            color: var(--ink);
            overflow-x: hidden;
        }

        /* ─── NAV ─── */
        nav {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            z-index: 100;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1.25rem 5vw;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid var(--rose-mid);
        }

        .nav-logo {
            font-family: 'Playfair Display', serif;
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--ink);
            letter-spacing: -0.02em;
        }

        .nav-logo span {
            color: var(--rose);
        }

        .nav-links {
            display: flex;
            gap: 2rem;
            list-style: none;
        }

        .nav-links a {
            font-size: 0.88rem;
            font-weight: 500;
            color: var(--muted);
            text-decoration: none;
            transition: color .2s;
        }

        .nav-links a:hover {
            color: var(--rose);
        }

        .nav-cta {
            background: var(--rose);
            color: #fff;
            border: none;
            padding: .55rem 1.4rem;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: .85rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, transform .15s;
            text-decoration: none;
        }

        .nav-cta:hover {
            background: var(--rose-dark);
            transform: translateY(-1px);
        }

        /* ─── HERO ─── */
        #hero {
            min-height: 100vh;
            display: grid;
            grid-template-columns: 1fr 1fr;
            align-items: center;
            gap: 3rem;
            padding: 8rem 5vw 4rem;
            background: var(--warm);
            position: relative;
            overflow: hidden;
        }

        #hero::before {
            content: '';
            position: absolute;
            top: -120px;
            right: -120px;
            width: 500px;
            height: 500px;
            border-radius: 50%;
            background: radial-gradient(circle, #fecdd3 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-badge {
            display: inline-flex;
            align-items: center;
            gap: .4rem;
            background: var(--rose-mid);
            color: var(--rose-dark);
            font-size: .78rem;
            font-weight: 600;
            padding: .35rem .9rem;
            border-radius: 50px;
            margin-bottom: 1.25rem;
            letter-spacing: .04em;
            text-transform: uppercase;
        }

        .hero-badge::before {
            content: '';
            display: inline-block;
            width: 7px;
            height: 7px;
            border-radius: 50%;
            background: var(--rose);
            animation: pulse 2s infinite;
        }

        @keyframes pulse {

            0%,
            100% {
                transform: scale(1);
                opacity: 1;
            }

            50% {
                transform: scale(1.4);
                opacity: .6;
            }
        }

        .hero-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(2.5rem, 5vw, 4rem);
            font-weight: 700;
            line-height: 1.12;
            letter-spacing: -0.03em;
            color: var(--ink);
            margin-bottom: 1.25rem;
        }

        .hero-title em {
            font-style: italic;
            color: var(--rose);
        }

        .hero-desc {
            font-size: 1.05rem;
            font-weight: 400;
            color: var(--muted);
            line-height: 1.75;
            max-width: 480px;
            margin-bottom: 2rem;
        }

        .hero-actions {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .btn-primary {
            background: var(--rose);
            color: #fff;
            border: none;
            padding: .85rem 2rem;
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: .95rem;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: background .2s, transform .15s, box-shadow .2s;
            box-shadow: 0 4px 20px rgba(225, 29, 72, .25);
        }

        .btn-primary:hover {
            background: var(--rose-dark);
            transform: translateY(-2px);
            box-shadow: 0 8px 28px rgba(225, 29, 72, .35);
        }

        .btn-ghost {
            color: var(--ink);
            font-size: .93rem;
            font-weight: 500;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: .4rem;
            transition: color .2s;
        }

        .btn-ghost:hover {
            color: var(--rose);
        }

        .btn-ghost::after {
            content: '→';
            transition: transform .2s;
        }

        .btn-ghost:hover::after {
            transform: translateX(4px);
        }

        .hero-stats {
            display: flex;
            gap: 2rem;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid var(--rose-mid);
        }

        .hero-stat-num {
            font-family: 'Playfair Display', serif;
            font-size: 2rem;
            font-weight: 700;
            color: var(--ink);
        }

        .hero-stat-num span {
            color: var(--rose);
        }

        .hero-stat-label {
            font-size: .8rem;
            color: var(--muted);
            font-weight: 500;
            margin-top: .15rem;
        }

        /* hero visual side */
        .hero-visual {
            position: relative;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .hero-card-float {
            background: var(--surface);
            border: 1px solid var(--rose-mid);
            border-radius: 20px;
            padding: 2rem;
            width: 320px;
            box-shadow: 0 20px 60px rgba(225, 29, 72, .1);
            position: relative;
            z-index: 2;
        }

        .hero-card-tag {
            font-size: .72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: .07em;
            color: var(--rose);
            margin-bottom: .75rem;
        }

        .hero-card-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.3rem;
            font-weight: 600;
            margin-bottom: .4rem;
        }

        .hero-card-meta {
            font-size: .84rem;
            color: var(--muted);
            margin-bottom: 1.25rem;
            line-height: 1.6;
        }

        .hero-card-price {
            font-size: 1.6rem;
            font-weight: 700;
            font-family: 'Playfair Display', serif;
            color: var(--ink);
        }

        .hero-card-price small {
            font-family: 'DM Sans', sans-serif;
            font-size: .8rem;
            font-weight: 400;
            color: var(--muted);
        }

        .hero-card-btn {
            display: block;
            text-align: center;
            margin-top: 1.25rem;
            background: var(--rose-light);
            color: var(--rose);
            border: 1px solid var(--rose-mid);
            padding: .65rem 1rem;
            border-radius: 50px;
            font-size: .85rem;
            font-weight: 600;
            text-decoration: none;
            transition: background .2s, color .2s;
        }

        .hero-card-btn:hover {
            background: var(--rose);
            color: #fff;
        }

        .hero-badge-float {
            position: absolute;
            background: var(--surface);
            border: 1px solid var(--border);
            border-radius: 14px;
            padding: .7rem 1.1rem;
            display: flex;
            align-items: center;
            gap: .6rem;
            font-size: .82rem;
            font-weight: 500;
            box-shadow: 0 8px 24px rgba(0, 0, 0, .07);
        }

        .hero-badge-float.b1 {
            top: 0;
            right: -20px;
            animation: floatY 4s ease-in-out infinite;
        }

        .hero-badge-float.b2 {
            bottom: 20px;
            left: -30px;
            animation: floatY 5s ease-in-out infinite reverse;
        }

        @keyframes floatY {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-8px);
            }
        }

        .badge-icon {
            width: 32px;
            height: 32px;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .badge-icon.rose {
            background: var(--rose-light);
        }

        .badge-icon.green {
            background: #d1fae5;
        }

        /* ─── ABOUT ─── */
        #about {
            padding: 6rem 5vw;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 5rem;
            align-items: center;
            background: var(--surface);
        }

        .section-tag {
            font-size: .75rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .1em;
            color: var(--rose);
            margin-bottom: 1rem;
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            font-size: clamp(1.8rem, 3vw, 2.8rem);
            font-weight: 700;
            line-height: 1.2;
            letter-spacing: -0.02em;
            margin-bottom: 1.25rem;
        }

        .section-title em {
            font-style: italic;
            color: var(--rose);
        }

        .section-body {
            color: var(--muted);
            line-height: 1.8;
            font-size: 1rem;
            margin-bottom: 1.5rem;
        }

        .about-features {
            display: grid;
            gap: 1rem;
            margin-top: 1.5rem;
        }

        .about-feature {
            display: flex;
            align-items: flex-start;
            gap: .9rem;
            padding: 1rem;
            border: 1px solid var(--rose-mid);
            border-radius: 14px;
            background: var(--rose-light);
            transition: border-color .2s, transform .2s;
        }

        .about-feature:hover {
            border-color: var(--rose);
            transform: translateX(4px);
        }

        .about-feature-icon {
            width: 40px;
            height: 40px;
            background: var(--rose);
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            flex-shrink: 0;
        }

        .about-feature-title {
            font-weight: 600;
            font-size: .93rem;
            margin-bottom: .2rem;
        }

        .about-feature-desc {
            font-size: .83rem;
            color: var(--muted);
            line-height: 1.5;
        }

        /* visual grid about */
        .about-visual {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        .about-img-card {
            border-radius: 16px;
            overflow: hidden;
            background: var(--rose-mid);
            aspect-ratio: 4/5;
            position: relative;
        }

        .about-img-card.tall {
            grid-row: span 2;
        }

        .about-img-card .overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(26, 26, 46, .6) 0%, transparent 60%);
            display: flex;
            align-items: flex-end;
            padding: 1rem;
        }

        .about-img-card .overlay p {
            color: #fff;
            font-size: .82rem;
            font-weight: 600;
        }

        /* placeholder images via css */
        .img-bg-1 {
            background: linear-gradient(135deg, #fecdd3 0%, #e11d48 100%);
        }

        .img-bg-2 {
            background: linear-gradient(135deg, #1a1a2e 0%, #e11d48 100%);
        }

        .img-bg-3 {
            background: linear-gradient(135deg, #fdf6f0 0%, #fecdd3 100%);
        }

        /* ─── COURSES ─── */
        #courses {
            padding: 6rem 5vw;
            background: var(--warm);
        }

        .section-header {
            text-align: center;
            margin-bottom: 3.5rem;
        }

        .courses-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 1.5rem;
        }

        .course-card {
            background: var(--surface);
            border: 1px solid var(--rose-mid);
            border-radius: 20px;
            padding: 2rem;
            position: relative;
            overflow: hidden;
            transition: transform .25s, box-shadow .25s, border-color .25s;
            cursor: pointer;
        }

        .course-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 3px;
            background: var(--rose);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform .3s ease;
        }

        .course-card:hover::before {
            transform: scaleX(1);
        }

        .course-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 20px 50px rgba(225, 29, 72, .12);
            border-color: var(--rose);
        }

        .course-card.featured {
            border-color: var(--rose);
            box-shadow: 0 8px 32px rgba(225, 29, 72, .15);
        }

        .course-card.featured::before {
            transform: scaleX(1);
        }

        .popular-badge {
            position: absolute;
            top: 1.25rem;
            right: 1.25rem;
            background: var(--rose);
            color: #fff;
            font-size: .7rem;
            font-weight: 700;
            letter-spacing: .06em;
            text-transform: uppercase;
            padding: .3rem .8rem;
            border-radius: 50px;
        }

        .course-category {
            display: inline-flex;
            align-items: center;
            gap: .35rem;
            font-size: .72rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: .3rem .8rem;
            border-radius: 50px;
            margin-bottom: 1rem;
        }

        .course-category.private {
            background: #1a1a2e;
            color: #fff;
        }

        .course-category.intensif {
            background: var(--rose-light);
            color: var(--rose-dark);
        }

        .course-name {
            font-family: 'Playfair Display', serif;
            font-size: 1.35rem;
            font-weight: 700;
            line-height: 1.3;
            margin-bottom: .75rem;
        }

        .course-meta {
            display: flex;
            flex-direction: column;
            gap: .4rem;
            margin-bottom: 1.5rem;
        }

        .course-meta-item {
            display: flex;
            align-items: center;
            gap: .5rem;
            font-size: .84rem;
            color: var(--muted);
        }

        .course-meta-item .dot {
            width: 5px;
            height: 5px;
            border-radius: 50%;
            background: var(--rose-mid);
        }

        .course-divider {
            height: 1px;
            background: var(--border);
            margin-bottom: 1.25rem;
        }

        .course-bottom {
            display: flex;
            align-items: flex-end;
            justify-content: space-between;
        }

        .course-price {
            font-family: 'Playfair Display', serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--ink);
        }

        .course-price small {
            font-family: 'DM Sans', sans-serif;
            font-size: .78rem;
            font-weight: 400;
            color: var(--muted);
        }

        .course-slot {
            font-size: .78rem;
            color: var(--rose);
            font-weight: 600;
        }

        .course-btn {
            margin-top: 1.25rem;
            width: 100%;
            padding: .7rem;
            border: 1.5px solid var(--rose);
            background: transparent;
            color: var(--rose);
            border-radius: 50px;
            font-family: 'DM Sans', sans-serif;
            font-size: .88rem;
            font-weight: 600;
            cursor: pointer;
            transition: background .2s, color .2s;
            text-decoration: none;
            display: block;
            text-align: center;
        }

        .course-btn:hover,
        .course-card.featured .course-btn {
            background: var(--rose);
            color: #fff;
        }

        /* ─── TESTIMONIALS ─── */
        #testimonials {
            padding: 6rem 5vw;
            background: var(--ink);
            color: #fff;
        }

        #testimonials .section-tag {
            color: var(--rose-mid);
        }

        #testimonials .section-title {
            color: #fff;
        }

        .testi-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 1.25rem;
            margin-top: 3rem;
        }

        .testi-card {
            background: rgba(255, 255, 255, .06);
            border: 1px solid rgba(255, 255, 255, .1);
            border-radius: 20px;
            padding: 1.75rem;
            transition: background .25s, transform .25s;
        }

        .testi-card:hover {
            background: rgba(255, 255, 255, .1);
            transform: translateY(-4px);
        }

        .testi-stars {
            display: flex;
            gap: .2rem;
            margin-bottom: 1rem;
            color: #fbbf24;
            font-size: 14px;
        }

        .testi-text {
            font-size: .93rem;
            line-height: 1.75;
            color: rgba(255, 255, 255, .8);
            margin-bottom: 1.5rem;
            font-style: italic;
        }

        .testi-author {
            display: flex;
            align-items: center;
            gap: .8rem;
        }

        .testi-avatar {
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: var(--rose);
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: 700;
            font-size: .88rem;
            color: #fff;
            flex-shrink: 0;
        }

        .testi-name {
            font-weight: 600;
            font-size: .9rem;
        }

        .testi-role {
            font-size: .78rem;
            color: rgba(255, 255, 255, .5);
            margin-top: .1rem;
        }

        /* ─── CTA SECTION ─── */
        #cta {
            padding: 6rem 5vw;
            background: var(--rose);
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        #cta::before {
            content: '';
            position: absolute;
            top: -100px;
            left: -100px;
            width: 400px;
            height: 400px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .08);
            pointer-events: none;
        }

        #cta::after {
            content: '';
            position: absolute;
            bottom: -80px;
            right: -80px;
            width: 300px;
            height: 300px;
            border-radius: 50%;
            background: rgba(255, 255, 255, .06);
            pointer-events: none;
        }

        #cta .section-title {
            color: #fff;
        }

        #cta .section-body {
            color: rgba(255, 255, 255, .8);
        }

        .btn-white {
            display: inline-block;
            background: #fff;
            color: var(--rose);
            padding: .9rem 2.5rem;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 700;
            text-decoration: none;
            transition: transform .2s, box-shadow .2s;
            box-shadow: 0 8px 30px rgba(0, 0, 0, .15);
            position: relative;
            z-index: 1;
        }

        .btn-white:hover {
            transform: translateY(-3px);
            box-shadow: 0 14px 40px rgba(0, 0, 0, .2);
        }

        /* ─── FOOTER ─── */
        footer {
            background: var(--ink);
            color: rgba(255, 255, 255, .6);
            text-align: center;
            padding: 2rem 5vw;
            font-size: .84rem;
        }

        footer strong {
            color: #fff;
        }

        /* ─── RESPONSIVE ─── */
        @media (max-width: 768px) {
            #hero {
                grid-template-columns: 1fr;
                padding-top: 7rem;
            }

            #hero::before {
                display: none;
            }

            .hero-visual {
                display: none;
            }

            #about {
                grid-template-columns: 1fr;
            }

            .about-visual {
                display: none;
            }

            .nav-links {
                display: none;
            }
        }
    </style>
</head>

<body>

    {{-- ── NAV ── --}}
    <nav>
        <div class="nav-logo">
            <img class="md:w-12 w-10" src="{{ asset('storage/' . $site_settings['site_logo']) }}" alt="">
        </div>
        <ul class="nav-links">
            <li><a href="#about">Tentang Kami</a></li>
            <li><a href="#courses">Paket Kursus</a></li>
            <li><a href="#testimonials">Testimoni</a></li>
        </ul>
        <a href="{{ route('login') }}" class="nav-cta">Masuk</a>
    </nav>

    {{-- ── HERO ── --}}
    <section id="hero">
        <div class="hero-content">
            <div class="hero-badge">Terpercaya sejak 2018</div>
            <h1 class="hero-title">
                Belajar Lebih<br>
                <em>Efektif &amp; Terarah</em><br>
                Bersama Kami
            </h1>
            <p class="hero-desc">
                Kami menyediakan program bimbingan belajar private dan intensif yang disesuaikan
                dengan kebutuhan dan ritme belajar setiap siswa.
            </p>
            <div class="hero-actions">
                <a href="#courses" class="btn-primary">Lihat Paket Kursus</a>
                <a href="#about" class="btn-ghost">Kenali Kami</a>
            </div>
            <div class="hero-stats">
                <div>
                    <div class="hero-stat-num">500<span>+</span></div>
                    <div class="hero-stat-label">Siswa Aktif</div>
                </div>
                <div>
                    <div class="hero-stat-num">98<span>%</span></div>
                    <div class="hero-stat-label">Tingkat Kepuasan</div>
                </div>
                <div>
                    <div class="hero-stat-num">6<span>+</span></div>
                    <div class="hero-stat-label">Tahun Pengalaman</div>
                </div>
            </div>
        </div>

        <div class="hero-visual">
            <div class="hero-card-float">
                <div class="hero-card-tag">✦ Paket Unggulan</div>
                <div class="hero-card-name">Intensif Reguler</div>
                <div class="hero-card-meta">
                    3× seminggu · 90 menit/sesi<br>
                    Total 36 pertemuan intensif
                </div>
                <div class="hero-card-price">
                    Rp 1.500.000 <small>/ bulan</small>
                </div>
                <a href="#courses" class="hero-card-btn">Pilih Paket Ini</a>
            </div>

            <div class="hero-badge-float b1">
                <div class="badge-icon rose">🎯</div>
                <div>
                    <div style="font-size:.8rem;font-weight:600;">Kurikulum Terstruktur</div>
                    <div style="font-size:.72rem;color:var(--muted);">Materi terkini & relevan</div>
                </div>
            </div>

            <div class="hero-badge-float b2">
                <div class="badge-icon green">✓</div>
                <div>
                    <div style="font-size:.8rem;font-weight:600;">Pengajar Berpengalaman</div>
                    <div style="font-size:.72rem;color:var(--muted);">Lulusan universitas ternama</div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── ABOUT ── --}}
    <section id="about">
        <div>
            <div class="section-tag">Tentang Kami</div>
            <h2 class="section-title">Mengapa Memilih<br><em>Program Kami?</em></h2>
            <p class="section-body">
                Kami percaya bahwa setiap anak memiliki potensi yang luar biasa. Program kami dirancang untuk
                menemukan dan memaksimalkan potensi tersebut melalui pendekatan belajar yang personal, terstruktur,
                dan menyenangkan.
            </p>

            <div class="about-features">
                <div class="about-feature">
                    <div>
                        <div class="about-feature-title">Kelas Kecil & Fokus</div>
                        <div class="about-feature-desc">Slot terbatas memastikan setiap siswa mendapat perhatian penuh
                            dari pengajar.</div>
                    </div>
                </div>
                <div class="about-feature">
                    <div>
                        <div class="about-feature-title">Laporan Progres Berkala</div>
                        <div class="about-feature-desc">Orang tua mendapat update perkembangan anak setiap bulan secara
                            transparan.</div>
                    </div>
                </div>
                <div class="about-feature">
                    <div>
                        <div class="about-feature-title">Metode Terbukti Efektif</div>
                        <div class="about-feature-desc">Ribuan siswa telah mencapai nilai terbaik bersama program kami.
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="about-visual">
            <div class="about-img-card img-bg-1 tall">
                <img src="https://i.pinimg.com/736x/13/06/24/1306243ab4f7b31de2249b941da51f49.jpg"
                    class="w-full h-full object-cover" alt="">
                <div class="overlay">
                    <p>Hard Skill</p>
                </div>
            </div>
            <div class="about-img-card img-bg-2">
                <img src="https://i.pinimg.com/736x/d3/d5/a3/d3d5a3e259ee8ca212d85f07e92c16cd.jpg"
                    class="w-full h-full object-cover" alt="">
                <div class="overlay">
                    <p>Design Grafis</p>
                </div>
            </div>
            <div class="about-img-card img-bg-3">
                <img src="https://i.pinimg.com/1200x/c9/a0/6c/c9a06c6a16d7cccf03a57e9e2002eba0.jpg"
                    class="w-full h-full object-cover" alt="">
                <div class="overlay">
                    <p>MS Office</p>
                </div>
            </div>
        </div>
    </section>

    {{-- ── COURSES ── --}}
    <section id="courses">
        <div class="section-header">
            <div class="section-tag">Paket Kursus</div>
            <h2 class="section-title">Pilih Program<br><em>Yang Tepat Untukmu</em></h2>
            <p style="color:var(--muted);max-width:500px;margin:1rem auto 0;line-height:1.7;">
                Tersedia dalam dua kategori: <strong>Private</strong> (satu siswa satu pengajar) dan
                <strong>Intensif</strong> (kelompok kecil, lebih terjangkau).
            </p>
        </div>

        <div class="courses-grid">
            @forelse($courses as $course)
                <div class="course-card {{ $loop->iteration === 2 ? 'featured' : '' }}">
                    @if ($loop->iteration === 2)
                        <div class="popular-badge">Terpopuler</div>
                    @endif

                    <div class="course-category {{ $course->category }}">
                        {{ $course->category === 'private' ? '👤 Private' : '👥 Intensif' }}
                    </div>

                    <div class="course-name">{{ $course->name_paket }}</div>

                    <div class="course-meta">
                        @if ($course->durasi_bulan)
                            <div class="course-meta-item">
                                <span class="dot"></span>
                                {{ $course->durasi_bulan }} bulan program
                            </div>
                        @endif
                        @if ($course->pertemuan_per_minggu)
                            <div class="course-meta-item">
                                <span class="dot"></span>
                                {{ $course->pertemuan_per_minggu }}× pertemuan / minggu
                            </div>
                        @endif
                        <div class="course-meta-item">
                            <span class="dot"></span>
                            {{ $course->durasi_jam }} jam / sesi
                        </div>
                        @if ($course->jumlah_pertemuan)
                            <div class="course-meta-item">
                                <span class="dot"></span>
                                Total {{ $course->jumlah_pertemuan }} pertemuan
                            </div>
                        @endif
                    </div>

                    <div class="course-divider"></div>

                    <div class="course-bottom">
                        <div>
                            <div class="course-price">
                                Rp {{ number_format($course->jumlah_total, 0, ',', '.') }}
                                <small>/ paket</small>
                            </div>
                            @if ($course->max_slot > 1)
                                <div class="course-slot">{{ $course->max_slot }} slot tersedia</div>
                            @else
                                <div class="course-slot">1:1 Personal</div>
                            @endif
                        </div>
                    </div>

                    <a href="{{ route('register') }}" class="course-btn">Daftar Sekarang</a>
                </div>
            @empty
                {{-- Fallback static cards when no data --}}
                <div class="course-card">
                    <div class="course-category intensif">👥 Intensif</div>
                    <div class="course-name">Intensif Reguler</div>
                    <div class="course-meta">
                        <div class="course-meta-item"><span class="dot"></span>3 bulan program</div>
                        <div class="course-meta-item"><span class="dot"></span>3× pertemuan / minggu</div>
                        <div class="course-meta-item"><span class="dot"></span>1.5 jam / sesi</div>
                        <div class="course-meta-item"><span class="dot"></span>Total 36 pertemuan</div>
                    </div>
                    <div class="course-divider"></div>
                    <div class="course-bottom">
                        <div>
                            <div class="course-price">Rp 1.500.000 <small>/ paket</small></div>
                            <div class="course-slot">6 slot tersedia</div>
                        </div>
                    </div>
                    <a href="#" class="course-btn">Daftar Sekarang</a>
                </div>

                <div class="course-card featured">
                    <div class="popular-badge">Terpopuler</div>
                    <div class="course-category intensif">👥 Intensif</div>
                    <div class="course-name">Intensif Plus</div>
                    <div class="course-meta">
                        <div class="course-meta-item"><span class="dot"></span>6 bulan program</div>
                        <div class="course-meta-item"><span class="dot"></span>4× pertemuan / minggu</div>
                        <div class="course-meta-item"><span class="dot"></span>2 jam / sesi</div>
                        <div class="course-meta-item"><span class="dot"></span>Total 96 pertemuan</div>
                    </div>
                    <div class="course-divider"></div>
                    <div class="course-bottom">
                        <div>
                            <div class="course-price">Rp 2.800.000 <small>/ paket</small></div>
                            <div class="course-slot">4 slot tersedia</div>
                        </div>
                    </div>
                    <a href="#" class="course-btn">Daftar Sekarang</a>
                </div>

                <div class="course-card">
                    <div class="course-category private">👤 Private</div>
                    <div class="course-name">Private Eksklusif</div>
                    <div class="course-meta">
                        <div class="course-meta-item"><span class="dot"></span>Durasi fleksibel</div>
                        <div class="course-meta-item"><span class="dot"></span>Jadwal menyesuaikan siswa</div>
                        <div class="course-meta-item"><span class="dot"></span>2 jam / sesi</div>
                        <div class="course-meta-item"><span class="dot"></span>Kurikulum personal</div>
                    </div>
                    <div class="course-divider"></div>
                    <div class="course-bottom">
                        <div>
                            <div class="course-price">Rp 4.500.000 <small>/ paket</small></div>
                            <div class="course-slot">1:1 Personal</div>
                        </div>
                    </div>
                    <a href="#" class="course-btn">Daftar Sekarang</a>
                </div>
            @endforelse
        </div>
    </section>

    {{-- ── TESTIMONIALS ── --}}
    <section id="testimonials">
        <div class="section-header" style="text-align:center;">
            <div class="section-tag">Testimoni</div>
            <h2 class="section-title">Apa Kata <em style="color:var(--rose-mid);">Mereka?</em></h2>
        </div>

        <div class="testi-grid">
            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">
                    "Anak saya yang dulunya kesulitan Matematika, sekarang jadi juara kelas. Metode pengajaran di sini
                    benar-benar berbeda dan menyenangkan."
                </p>
                <div class="testi-author">
                    <div class="testi-avatar">SR</div>
                    <div>
                        <div class="testi-name">Siti Rahayu</div>
                        <div class="testi-role">Orang tua siswa · Kelas Intensif</div>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">
                    "Ikut bimbel private di sini dan nilai UN saya naik drastis. Pengajarnya sabar dan selalu siap
                    membantu kapanpun saya butuh penjelasan lebih."
                </p>
                <div class="testi-author">
                    <div class="testi-avatar">AK</div>
                    <div>
                        <div class="testi-name">Ahmad Kurniawan</div>
                        <div class="testi-role">Siswa SMA · Kelas Private</div>
                    </div>
                </div>
            </div>

            <div class="testi-card">
                <div class="testi-stars">★★★★★</div>
                <p class="testi-text">
                    "Laporan progres bulanan sangat membantu saya memantau perkembangan anak. Saya tahu persis area mana
                    yang perlu diperkuat."
                </p>
                <div class="testi-author">
                    <div class="testi-avatar">DW</div>
                    <div>
                        <div class="testi-name">Dwi Wulandari</div>
                        <div class="testi-role">Orang tua siswa · Intensif Plus</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- ── CTA ── --}}
    <section id="cta">
        <div class="section-tag" style="color:rgba(255,255,255,.7);">Mulai Sekarang</div>
        <h2 class="section-title" style="margin-bottom:1rem;">
            Siap Raih Prestasi<br><em style="font-style:italic;opacity:.85;">Terbaik Anda?</em>
        </h2>
        <p class="section-body" style="max-width:460px;margin:0 auto 2.5rem;">
            Bergabunglah dengan ratusan siswa yang telah membuktikan perubahan nyata bersama program kami.
        </p>
        <a href="#courses" class="btn-white">Pilih Paket Kursus →</a>
    </section>

    {{-- ── FOOTER ── --}}
    <footer>
        <p>© {{ date('Y') }} <strong>{{ $site_settings['site_name'] ?? 'EduPrima' }}</strong>. Semua hak
            dilindungi.</p>
    </footer>

</body>

</html>
