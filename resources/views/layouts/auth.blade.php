<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Daftar Akun — {{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600&family=DM+Sans:wght@300;400;500;600&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --rose: #e11d48;
            --rose-light: #fff1f2;
            --rose-mid: #fecdd3;
            --ink: #1a1a2e;
            --muted: #6b7280;
            --border: #e5e7eb;
            --surface: #ffffff;
            --bg: #fafafa;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--bg);
            background-image:
                radial-gradient(circle at 15% 20%, rgba(225, 29, 72, 0.06) 0%, transparent 50%),
                radial-gradient(circle at 85% 80%, rgba(225, 29, 72, 0.04) 0%, transparent 50%);
            min-height: 100vh;
        }

        .page-wrapper {
            min-height: 100vh;
            display: flex;
            align-items: flex-start;
            justify-content: center;
            padding: 3rem 1rem 4rem;
        }

        .card {
            width: 100%;
            max-width: 660px;
            background: var(--surface);
            border-radius: 20px;
            box-shadow:
                0 1px 2px rgba(0, 0, 0, 0.04),
                0 8px 32px rgba(0, 0, 0, 0.07);
            overflow: hidden;
        }

        /* ── Header ── */
        .card-header {
            padding: 2.5rem 2.5rem 2rem;
            border-bottom: 1px solid var(--border);
            display: flex;
            align-items: center;
            gap: 1.25rem;
        }

        .card-header img {
            width: 52px;
            height: 52px;
            object-fit: contain;
            border-radius: 12px;
            border: 1px solid var(--border);
            padding: 4px;
            background: var(--rose-light);
        }

        .card-header-text h1 {
            font-family: 'Playfair Display', serif;
            font-size: 1.5rem;
            color: var(--ink);
            line-height: 1.2;
            margin: 0 0 2px;
        }

        .card-header-text p {
            font-size: 0.8125rem;
            color: var(--muted);
            font-weight: 300;
            margin: 0;
        }

        /* ── Error banner ── */
        .error-banner {
            margin: 1.5rem 2.5rem 0;
            padding: 0.875rem 1rem;
            background: var(--rose-light);
            border: 1px solid var(--rose-mid);
            border-radius: 10px;
            color: var(--rose);
            font-size: 0.8125rem;
        }

        .error-banner ul {
            margin: 0;
            padding-left: 1.1rem;
        }

        .error-banner li+li {
            margin-top: 3px;
        }

        /* ── Form body ── */
        .card-body {
            padding: 2rem 2.5rem 2.5rem;
        }

        form {
            display: flex;
            flex-direction: column;
            gap: 2.25rem;
        }

        /* ── Section ── */
        .form-section {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }

        .section-label {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            font-size: 0.6875rem;
            font-weight: 600;
            letter-spacing: 0.1em;
            text-transform: uppercase;
            color: var(--rose);
            margin-bottom: 0.25rem;
        }

        .section-label::after {
            content: '';
            flex: 1;
            height: 1px;
            background: var(--rose-mid);
        }

        /* ── Two-column grid ── */
        .grid-2 {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 1rem;
        }

        /* ── Submit ── */
        .btn-submit {
            width: 100%;
            background: var(--rose);
            color: #fff;
            font-family: 'DM Sans', sans-serif;
            font-weight: 600;
            font-size: 0.9375rem;
            letter-spacing: 0.02em;
            padding: 0.875rem;
            border: none;
            border-radius: 12px;
            cursor: pointer;
            transition: background 0.15s, transform 0.1s, box-shadow 0.15s;
            box-shadow: 0 4px 16px rgba(225, 29, 72, 0.25);
        }

        .btn-submit:hover {
            background: #be123c;
            box-shadow: 0 6px 20px rgba(225, 29, 72, 0.3);
        }

        .btn-submit:active {
            transform: scale(0.985);
        }

        /* ── Footer link ── */
        .card-footer {
            padding: 1.25rem 2.5rem;
            border-top: 1px solid var(--border);
            text-align: center;
            font-size: 0.8125rem;
            color: var(--muted);
        }

        .card-footer a {
            color: var(--rose);
            font-weight: 600;
            text-decoration: none;
        }

        .card-footer a:hover {
            text-decoration: underline;
        }

        /* ── Native select resets to match input style ── */
        select {
            appearance: none;
            -webkit-appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' viewBox='0 0 24 24' fill='none' stroke='%236b7280' stroke-width='2' stroke-linecap='round' stroke-linejoin='round'%3E%3Cpath d='M6 9l6 6 6-6'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 0.875rem center;
            padding-right: 2.5rem !important;
            cursor: pointer;
        }

        /* ── Shared field style (complement Blade component) ── */
        input[type="text"],
        input[type="email"],
        input[type="password"],
        input[type="date"],
        input[type="tel"],
        select {
            width: 100%;
            padding: 0.75rem 1rem;
            border: 1px solid var(--border);
            border-radius: 10px;
            font-family: 'DM Sans', sans-serif;
            font-size: 0.9rem;
            color: var(--ink);
            background: var(--surface);
            transition: border-color 0.15s, box-shadow 0.15s;
            outline: none;
            box-sizing: border-box;
        }

        input:focus,
        select:focus {
            border-color: var(--rose);
            box-shadow: 0 0 0 3px rgba(225, 29, 72, 0.1);
        }

        input.border-rose-500,
        select.border-rose-500 {
            border-color: var(--rose);
        }

        label {
            display: block;
            font-size: 0.8125rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 0.375rem;
        }

        label .req {
            color: var(--rose);
            margin-left: 2px;
        }

        @media (max-width: 500px) {

            .card-header,
            .card-body,
            .card-footer {
                padding-left: 1.25rem;
                padding-right: 1.25rem;
            }

            .error-banner {
                margin-left: 1.25rem;
                margin-right: 1.25rem;
            }

            .grid-2 {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="page-wrapper">
        <div class="card">

            {{-- Header --}}
            <div class="card-header">
                <img src="{{ asset('storage/' . ($site_settings['site_logo'] ?? 'default-logo.png')) }}" alt="Logo">
                <div class="card-header-text">
                    <h1>Login Akun</h1>
                    <p>Masukkan Email Dan Password Dengan Benar</p>
                </div>
            </div>

            {{-- Validation errors --}}
            @if ($errors->any())
                <div class="error-banner">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="card-body">
                <form method="POST" action="{{ route('login') }}">
                    @csrf

                    {{-- Section 1: Informasi Akun --}}
                    <div class="form-section">

                        <x-guest.input label="Email" name="email" type="email" required />
                        <x-guest.input label="Password" name="password" type="password" required />
                    </div>


                    <button type="submit" class="btn-submit">Masuk Sekarang</button>
                </form>
            </div>

            <div class="card-footer">
                Belum Punya Akun? <a href="{{ route('register') }}">Daftar di sini</a>
            </div>

        </div>
    </div>
</body>

</html>
