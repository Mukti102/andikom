@extends('layouts.app')

@section('title', 'Dashboard Admin')

@section('content')
    <div class="container-fluid py-4  min-vh-100">

        {{-- Header --}}
        <div class="row mb-4">
            <div class="col-12">
                <p class="text-muted small">Selamat datang kembali, {{ Auth::user()->name }}</p>
            </div>
        </div>

        {{-- ── Stats Cards ── --}}
        <div class="row g-4 mb-5">
            @php
                $cards = [
                    [
                        'label' => 'Total Peserta',
                        'value' => $stats['total_peserta'],
                        'icon' => 'users',
                        'color' => 'primary',
                        'bg' => 'primary',
                    ],
                    [
                        'label' => 'Pendaftaran Baru',
                        'value' => $stats['pendaftaran_baru'],
                        'icon' => 'clipboard-list',
                        'color' => 'success',
                        'bg' => 'success',
                    ],
                    [
                        'label' => 'Total Materi',
                        'value' => $stats['total_materi'],
                        'icon' => 'book',
                        'color' => 'info',
                        'bg' => 'info',
                    ],
                    [
                        'label' => 'Siap Cetak',
                        'value' => $stats['lulus_terbaru'],
                        'icon' => 'award',
                        'color' => 'warning',
                        'bg' => 'warning',
                    ],
                ];
            @endphp

            @foreach ($cards as $card)
                <div class="col-12 col-sm-6 col-xl-3">
                    <div class="card border-0 shadow-sm rounded-4 h-100">
                        <div class="card-body p-4">
                            <div class="d-flex align-items-center justify-content-between">
                                <div>
                                    <p class="text-uppercase fw-semibold text-muted small mb-1 tracking-wider">
                                        {{ $card['label'] }}</p>
                                    <h2 class="mb-0 fw-bold">{{ $card['value'] }}</h2>
                                </div>
                                <div class="rounded-3 bg-{{ $card['bg'] }} bg-opacity-10 p-3">
                                    <i class="fas fa-{{ $card['icon'] }} fa-2x text-{{ $card['color'] }}"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="row g-4">
            <div class="col-12 col-lg-12">
                <div class="card border-0 shadow-sm rounded-1 overflow-hidden">
                    <div
                        class="card-header bg-primary py-3 d-flex justify-content-between align-items-center border-bottom-0">
                        <h5 class="mb-0 fw-bold ">Peserta Terbaru</h5>
                        <a href="{{ route('admin.peserta.index') }}" class="btn btn-sm btn-light text-primary fw-bold">Lihat
                            Semua</a>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-hover align-middle mb-0">
                            <thead class="">
                                <tr class="text-muted small">
                                    <th class="px-4 py-3 border-0">NAMA LENGKAP</th>
                                    <th class="px-4 py-3 border-0">NIS</th>
                                    <th class="px-4 py-3 border-0">NO HP</th>
                                    <th class="px-4 py-3 border-0">STATUS</th>
                                    <th class="px-4 py-3 border-0">TGL DAFTAR</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($peserta_terbaru as $p)
                                    <tr>
                                        {{-- Mengakses data melalui relasi 'peserta' --}}
                                        <td class="px-4 py-3 fw-medium">
                                            {{ $p->nama_lengkap ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-muted">
                                            {{ $p->nis ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3 text-muted">
                                            {{ $p->no_hp ?? '-' }}
                                        </td>
                                        <td class="px-4 py-3">
                                            {{-- Contoh status: sesuaikan dengan field status di tabel Anda --}}
                                            <span class="badge bg-primary-subtle text-primary">
                                                {{ $p->status ?? 'Aktif' }}
                                            </span>
                                        </td>
                                        <td class="px-4 py-3 text-muted">
                                            {{ $p->created_at->format('d M Y') }}
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

    </div>

    <style>
        .tracking-wider {
            letter-spacing: 0.05em;
        }

        .rounded-4 {
            border-radius: 1rem !important;
        }

        . {
            background-color: #f8f9fa !important;
        }

        .table thead th {
            font-weight: 600;
            letter-spacing: 0.5px;
        }

        .btn-primary {
            background-color: #4361ee;
            border-color: #4361ee;
        }

        .btn-primary:hover {
            background-color: #3f37c9;
            border-color: #3f37c9;
        }
    </style>
@endsection
