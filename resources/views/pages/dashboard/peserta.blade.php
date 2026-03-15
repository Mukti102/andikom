@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="mb-4">
            <h2 class="fw-bold">Selamat Datang, {{ Auth::user()->name }}</h2>
            <p class="text-muted">Pantau progres belajar dan sertifikat Anda di sini.</p>
        </div>

        {{-- <div class="row g-4">
            @foreach ($pendaftaranku as $item)
                <div class="col-12 col-md-6 col-lg-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4">
                        <div class="card-body">
                            <h5 class="fw-bold mb-3">{{ $item->course->name_paket }}</h5>

                            <div class="mb-3">
                                <small class="text-muted d-block">Status:</small>
                                <span class="badge {{ $item->nilai ? 'bg-success' : 'bg-warning' }}">
                                    {{ $item->nilai ? 'Lulus / Selesai' : 'Sedang Berlangsung' }}
                                </span>
                            </div>

                            <div class="d-grid gap-2 mt-4">
                                @if ($item->nilai)
                                    <a href="#" class="btn btn-primary rounded-pill">
                                        <i class="bi bi-download"></i> Unduh Sertifikat
                                    </a>
                                @else
                                    <button class="btn btn-outline-secondary rounded-pill" disabled>
                                        Sertifikat Belum Tersedia
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div> --}}

        <div class="row mt-5">
            <div class="col-12">
                <h4 class="fw-bold mb-3">Jadwal Kelas Anda</h4>
                <div class="card shadow-sm border-0">
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th>Hari</th>
                                    <th>Mata Pelajaran</th>
                                    <th>Waktu</th>
                                    <th>Ruang</th>
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
                                        <td colspan="4" class="text-center py-3 text-muted">Belum ada jadwal yang
                                            tersedia.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-5">
            <div class="col-12">
                <h4 class="fw-bold mb-3">Kursus yang Tersedia</h4>
                <p class="text-muted">Pilih paket pelatihan lainnya untuk meningkatkan skill Anda.</p>
            </div>

            @forelse ($availableCourses as $course)
                <div class="col-12 col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden card-hover">
                        <div class="position-relative">
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" class="card-img-top"
                                alt="{{ $course->name_paket }}" style="height: 200px; object-fit: cover;">
                            <span class="position-absolute top-0 end-0 m-3 badge bg-primary">
                                Rp {{ number_format($course->jumlah_total, 0, ',', '.') }}
                            </span>
                        </div>

                        <div class="card-body d-flex flex-column">
                            <h5 class="fw-bold mb-2">{{ $course->name_paket }}</h5>
                            <p class="text-muted small mb-3 flex-grow-1">
                                {{ Str::limit($course->description, 100) }}
                            </p>

                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <small class="text-muted">
                                    <i class="bi bi-people me-1"></i> Sisa Slot:
                                    <span class="fw-bold ">{{ $course->sisa_slot }}</span>
                                </small>
                                <small class="text-muted">
                                    <i class="bi bi-clock me-1"></i> {{ $course->duration }} Jam
                                </small>
                            </div>

                            <div class="d-grid">
                                @if ($course->sisa_slot > 0)
                                    <a href="{{ route('user.courses.show', $course->id) }}"
                                        class="btn btn-primary rounded-pill fw-bold">
                                        Lihat Detail & Daftar
                                    </a>
                                @else
                                    <button class="btn btn-secondary rounded-pill fw-bold" disabled>
                                        Slot Penuh
                                    </button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <p class="text-muted italic">Saat ini belum ada kursus baru yang tersedia.</p>
                </div>
            @endforelse
        </div>

        <style>
            .card-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }

            .card-hover:hover {
                transform: translateY(-10px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1) !important;
            }
        </style>
    </div>
@endsection
