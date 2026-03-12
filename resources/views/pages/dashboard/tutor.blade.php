@extends('layouts.app')
@section('content')
<div class="container-fluid py-4">
    <h3 class="fw-bold mb-4">Dashboard Tutor</h3>

    {{-- Cards Course yang diajar --}}
    <div class="row mb-5">
        @foreach($my_courses as $course)
        <div class="col-md-4">
            <div class="card shadow-sm border-0 bg-primary text-white">
                <div class="card-body">
                    <h5 class="card-title">{{ $course->name_paket }}</h5>
                    <p class="card-text opacity-75">{{ ucfirst($course->category) }} Class</p>
                    @if ($course->jumlah_pertemuan)
                    <span class="badge bg-white text-primary rounded-pill">Total Pertemuan: {{ $course->jumlah_pertemuan }}x</span>
                    @else
                    <span class="badge bg-white text-primary rounded-pill">Total Pertemuan: {{ $course->pertemuan_per_minggu }} Perminggu</span>
                    @endif
                </div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- Tabel Jadwal --}}
    <div class="card shadow-sm border-0">
        <div class="card-header bg-white py-3">
            <h5 class="mb-0 fw-bold text-dark">Jadwal Mengajar Anda</h5>
        </div>
        <div class="table-responsive">
            <table class="table table-hover align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Hari</th>
                        <th>Course</th>
                        <th>Waktu</th>
                        <th>Ruangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($jadwals as $jadwal)
                    <tr>
                        <td class="fw-bold">{{ $jadwal->hari }}</td>
                        <td>{{ $jadwal->course->name_paket }}</td>
                        <td>{{ $jadwal->start_time }} - {{ $jadwal->end_time }}</td>
                        <td><span class="badge bg-info text-dark">{{ $jadwal->room }}</span></td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="text-center py-4 text-muted">Belum ada jadwal yang ditetapkan.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection