@extends('layouts.app')
@section('title', 'Pilih Course Pembelajaran')

@section('content')
    <section class="section">
        <div class="container">
            <h4 class="mb-4">Daftar Kursus Anda</h4>
            <div class="row">
                @foreach ($courses as $course)
                    <div class="col-md-4">
                        <div class="card h-100 border-0 shadow-sm transition-card">
                            <div class="card-body d-flex flex-column">
                                <div class="mb-3">
                                    <span class="badge bg-primary bg-opacity-10 text-primary">ID: {{ $course->id }}</span>
                                    <h5 class="card-title mt-2 fw-bold">{{ $course->name_paket }}</h5>
                                </div>

                                <div class="mb-2">
                                    <small class="text-muted d-block mb-1">Materi Utama:</small>
                                    <div class="d-flex flex-wrap gap-1">
                                        @foreach ($course->tools as $tool)
                                            <span class="badge bg-light text-dark border" style="font-size: 0.7rem;">
                                                {{ $tool->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="mt-auto d-grid gap-2">
                                    <a href="{{ route('pembelajaran.peserta', $course->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-people"></i> Peserta
                                    </a>
                                    <a href="{{ route('pembelajaran.materi.index', $course->id) }}"
                                        class="btn btn-outline-primary">
                                        <i class="bi bi-book"></i> Materi
                                    </a>
                                    <a href="{{ route('pembelajaran.nilai.index', $course->id) }}" class="btn btn-primary">
                                        <i class="bi bi-star"></i> Nilai
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <style>
        .transition-card {
            transition: transform 0.2s;
        }

        .transition-card:hover {
            transform: translateY(-5px);
        }
    </style>
@endsection
