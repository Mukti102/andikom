@extends('layouts.app')
@section('title', 'Kursus Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Paket Kursus</h5>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Kategori</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($courses as $course)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="fw-bold">{{ $course->name_paket }}</span></td>
                                <td>
                                    <span class="badge {{ $course->category == 'private' ? 'bg-info' : 'bg-primary' }}">
                                        {{ ucfirst($course->category) }}
                                    </span>
                                </td>

                                <td>
                                    @php
                                        $totalBiaya = $course->jumlah_total;
                                        $pendaftaran = $course->pendaftarans
                                            ->where('peserta_id', $user->peserta->id)
                                            ->first();
                                        // Hitung total nominal tagihan yang sudah statusnya 'paid'
                                        $totalTerbayar = $pendaftaran->tagihans
                                            ->where('status', 'paid')
                                            ->sum('nominal');
                                        $persentase = $totalBiaya > 0 ? ($totalTerbayar / $totalBiaya) * 100 : 0;
                                    @endphp

                                    <div class="progress mb-1" style="height: 10px;">
                                        <div class="progress-bar {{ $persentase == 100 ? 'bg-success' : 'bg-primary' }}"
                                            role="progressbar" style="width: {{ $persentase }}%;"
                                            aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                    <small>
                                        <strong>Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</strong> /
                                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                        ({{ number_format($persentase, 0) }}%)
                                    </small>
                                </td>

                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('user.tagihan', $user->peserta->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-credit-card"></i>
                                        </a>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
