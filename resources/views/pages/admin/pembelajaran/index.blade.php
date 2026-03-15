@extends('layouts.app')
@section('title', 'Pilih Course Pembelajaran')

@section('content')
<section class="section">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h4 class="fw-bold mb-1">Daftar Kursus Anda</h4>
                <p class="text-muted small">Kelola peserta, materi, dan nilai dalam satu panel.</p>
            </div>
            <span class="badge bg-soft-primary text-primary px-3 py-2 rounded-pill">
                Total: {{ $courses->count() }} Kursus
            </span>
        </div>

        <div class="row g-4">
            @foreach ($courses as $course)
                <div class="col-md-6 col-lg-4">
                    <div class="card h-100 border-0 shadow-sm transition-card rounded-4">
                        {{-- Bagian Atas Card --}}
                        <div class="card-body d-flex flex-column">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div class="badge-category">
                                    <span class="badge {{ $course->category == 'private' ? 'bg-info' : 'bg-primary' }} mb-2">
                                        {{ ucfirst($course->category) }}
                                    </span>
                                </div>
                                <small class="text-muted fw-bold">#{{ $course->id }}</small>
                            </div>

                            <h5 class="card-title fw-bold mb-3">{{ $course->name_paket }}</h5>

                            {{-- Tools/Materi Section --}}
                            <div class="mb-4">
                                <div class="d-flex flex-wrap gap-1">
                                    @forelse ($course->tools as $tool)
                                        <span class="badge bg-light text-secondary border-0 px-2 py-1" style="font-size: 0.75rem;">
                                            <i class="bi bi-cpu me-1"></i>{{ $tool->name }}
                                        </span>
                                    @empty
                                        <span class="text-muted small italic">Belum ada tools terdaftar</span>
                                    @endforelse
                                </div>
                            </div>

                            {{-- Action Buttons --}}
                            <div class="mt-auto pt-3 border-top">
                                <div class="row g-2">
                                    @if (auth()->user()->isAdmin() || auth()->user()->isTutor())
                                        <div class="col-12">
                                            <a href="{{ route('pembelajaran.peserta', $course->id) }}"
                                               class="btn btn-outline-primary w-100 d-flex align-items-center justify-content-center">
                                                <i class="bi bi-people me-2"></i> Kelola Peserta
                                            </a>
                                        </div>
                                    @endif
                                    
                                    <div class="col-6">
                                        <a href="{{ route('pembelajaran.materi.index', $course->id) }}"
                                           class="btn btn-light w-100 text-primary fw-semibold">
                                            <i class="bi bi-folder2-open me-1"></i> Materi
                                        </a>
                                    </div>
                                    <div class="col-6">
                                        <a href="{{ route('pembelajaran.nilai.index', $course->id) }}" 
                                           class="btn btn-primary w-100 shadow-sm">
                                            <i class="bi bi-star-fill me-1"></i> Nilai
                                        </a>
                                    </div>
                                </div>
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
        transition: all 0.3s cubic-bezier(.25,.8,.25,1);
    }

    .transition-card:hover {
        transform: translateY(-8px);
        box-shadow: 0 1rem 3rem rgba(0,0,0,.1) !important;
    }

    .bg-soft-primary {
        background-color: rgba(67, 97, 238, 0.1);
    }

    .badge {
        font-weight: 500;
        padding: 0.5em 0.8em;
    }

    .btn-light {
        background-color: #f8f9fa;
        border-color: #f1f3f5;
    }
</style>
@endsection