<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Masuk — {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700&family=Playfair+Display:wght@700&display=swap"
        rel="stylesheet">
    <link rel="icon" href="{{ asset('storage/' . $site_settings['site_logo']) }}" type="image/png">
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --primary: #e11d48;
            --primary-hover: #be123c;
            --bg-soft: #f8fafc;
            --text-main: #0f172a;
            --text-muted: #64748b;
            --glass-bg: rgba(255, 255, 255, 0.95);
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-soft);
            margin: 0;
            color: var(--text-main);
            overflow-x: hidden;
        }

        .auth-container {
            display: flex;
            min-height: 100vh;
            width: 100%;
        }

        /* --- Sisi Kiri: Visual Branding --- */
        .auth-visual {
            flex: 1.2;
            position: relative;
            background: linear-gradient(135deg, #fffafa 0%, #fff2f2 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 3rem;
            color: white;
            overflow: hidden;
        }

        .auth-visual::before {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(202, 61, 94, 0.258) 0%, transparent 70%);
            top: -100px;
            left: -100px;
        }

        .visual-content {
            position: relative;
            z-index: 10;
            max-width: 500px;
            text-align: left;
        }

        .visual-content h2 {
            /* font-family: 'Playfair Display', serif; */
            font-size: 2.4rem;
            font-weight: 900;
            color: rgb(45, 45, 45);
            line-height: 1.1;
            margin-bottom: 0.7rem;
        }

        .visual-content p {
            font-size: 1rem;
            color: #333435;
            line-height: 1.6;
        }

        .secure-img {
            margin-top: 1.5rem;
            width: 100%;
            max-width: 440px;
            filter: drop-shadow(0 20px 50px rgba(0, 0, 0, 0.3));
            /* animation: float 6s ease-in-out infinite; */
        }

        /* --- Sisi Kanan: Form --- */
        .auth-form-section {
            flex: 1;
            background: white;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem;
            position: relative;
        }

        .form-card {
            width: 100%;
            max-width: 440px;
        }

        .brand-logo {
            width: 60px;
            height: 60px;
            border-radius: 16px;
            margin-bottom: 2rem;
            box-shadow: 0 10px 20px rgba(225, 29, 72, 0.1);
        }

        .form-header h1 {
            font-size: 2rem;
            font-weight: 700;
            letter-spacing: -0.02em;
            margin-bottom: 0.5rem;
        }

        .form-header p {
            color: var(--text-muted);
            margin-bottom: 2.5rem;
        }

        /* Modern Input Style */
        .input-group {
            position: relative;
            margin-bottom: 2rem;
        }

        .input-group label {
            display: block;
            font-size: 0.85rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            color: var(--text-muted);
            margin-bottom: 8px;
            transition: color 0.3s;
        }

        .input-group input {
            width: 100%;
            padding: 12px 0;
            border: none;
            border-bottom: 2px solid #e2e8f0;
            font-family: inherit;
            font-size: 1rem;
            font-weight: 500;
            background: transparent;

            /* Hapus Outline & Shadow Biru */
            outline: none !important;
            box-shadow: none !important;
            -webkit-appearance: none;
            /* Untuk iOS Safari */

            transition: border-color 0.3s ease;
        }

        .input-group input:focus {
            /* Hanya border bawah yang berubah warna */
            border-bottom: 2px solid var(--primary);

            /* Pastikan kembali tidak ada shadow */
            outline: none !important;
            box-shadow: none !important;
        }

        /* Memastikan label berubah warna saat input fokus */
        .input-group input:focus~label,
        .input-group input:focus-within~label {
            color: var(--primary);
        }

        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: var(--primary);
            color: white;
            border: none;
            border-radius: 12px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            box-shadow: 0 10px 25px rgba(225, 29, 72, 0.2);
            margin-top: 1rem;
        }

        .btn-primary:hover {
            background: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(225, 29, 72, 0.3);
        }

        .form-footer {
            margin-top: 2rem;
            text-align: center;
            font-size: 0.95rem;
            color: var(--text-muted);
        }

        .form-footer a {
            color: var(--primary);
            font-weight: 600;
            text-decoration: none;
        }

        /* Alerts */
        .alert {
            padding: 1rem;
            border-radius: 12px;
            margin-bottom: 1.5rem;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-error {
            background: #fff1f2;
            color: #e11d48;
            border: 1px solid #fecdd3;
        }

        .alert-success {
            background: #f0fdf4;
            color: #166534;
            border: 1px solid #bbf7d0;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0);
            }

            50% {
                transform: translateY(-20px);
            }
        }

        /* Responsive */
        @media (max-width: 1024px) {
            .auth-visual {
                display: none;
            }

            .auth-form-section {
                background: var(--bg-soft);
            }

            .form-card {
                background: white;
                padding: 2.5rem;
                border-radius: 24px;
                box-shadow: 0 20px 40px rgba(0, 0, 0, 0.05);
            }
        }
    </style>
</head>

<body>
    <div class="auth-container">
        <div class="auth-visual">
            <div class="visual-content">
                <h2>Investasi Terbaik <br>Adalah Dirimu Sendiri.</h2>
                <p>Asah keahlian baru setiap hari untuk membangun karir impian di industri kreatif dan teknologi.</p>

                <img class="secure-img" src="{{ asset('assets/ilustrator1.svg') }}" alt="Learning Journey">
            </div>
        </div>

        <div class="auth-form-section">
            <div class="form-card">

                <img class="brand-logo" src="{{ asset('storage/' . $site_settings['site_logo']) }}" alt="Logo">

                <div class="form-header">
                    <h1>Selamat Datang</h1>
                    <p>Silakan masuk ke akun Anda untuk melanjutkan.</p>
                </div>

                {{-- Alert Messages --}}
                @if (session('success'))
                    <div class="alert alert-success">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        {{ session('success') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="alert alert-error">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd"
                                d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Masukan tidak valid. Silakan cek kembali.
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    <div class="input-group">
                        <label for="email">Alamat Email</label>
                        <input type="email" name="email" id="email" placeholder="nama@email.com" required
                            value="{{ old('email') }}">
                    </div>

                    <div class="input-group">
                        <label for="password">Kata Sandi</label>
                        <input type="password" name="password" id="password" placeholder="••••••••" required>
                    </div>

                    <button type="submit" class="btn-primary">Masuk ke Dashboard</button>
                </form>

                <div class="form-footer">
                    Belum punya akun? <a href="{{ route('register') }}">Buat Akun Gratis</a>
                </div>
            </div>
        </div>
    </div>
</body>

</html>
