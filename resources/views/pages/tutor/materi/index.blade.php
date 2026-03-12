@extends('layouts.app')
@section('title', 'Materi ' . $course->name)

@section('content')
    <div class="container py-4">
        <div class="row align-items-center mb-5">
            <div class="col-md-8">
                <h2 class="fw-bold text-dark dark-text-light">E-Learning Materi</h2>
                <p class="text-muted mb-0">Kelola modul pembelajaran untuk kursus <strong>{{ $course->name }}</strong>.</p>
            </div>
            <div class="col-md-4 text-md-end mt-3 mt-md-0">
                @if (auth()->user()->isAdmin())
                    <a href="{{ route('pembelajaran.materi.create', $course->id) }}"
                        class="btn btn-primary rounded-pill px-4 shadow-sm">
                        <i class="bi bi-plus-lg me-1"></i> Tambah Materi
                    </a>
                @endif
            </div>
        </div>

        <div class="d-flex align-items-center mb-4 gap-2 flex-wrap">
            <span class="text-muted small me-2"><i class="bi bi-funnel-fill"></i> Filter:</span>
            <a href="{{ route('pembelajaran.materi.index', $course->id) }}"
                class="btn btn-sm {{ !request()->tool ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
                Semua
            </a>
            @foreach ($course->tools as $tool)
                <a href="{{ route('pembelajaran.materi.index', ['course_id' => $course->id, 'tool' => $tool->id]) }}"
                    class="btn btn-sm {{ request()->tool == $tool->id ? 'btn-primary' : 'btn-outline-secondary' }} rounded-pill px-3">
                    {{ $tool->name }}
                </a>
            @endforeach
        </div>

        <div class="row">
            @forelse($materis as $materi)
                <div class="col-md-6 col-lg-4 mb-4">
                    <div class="card h-100 border-0 shadow-sm transition-hover bg-body-tertiary">
                        <div class="card-header bg-transparent border-0 pt-4 px-4 pb-0">
                            <span class="badge bg-primary bg-opacity-25 text-primary rounded-pill px-3 py-1">Modul
                                {{ $materi->urutan }}</span>
                        </div>
                        <div class="card-body px-4">
                            <h5 class="card-title fw-bold mb-3 mt-2">{{ $materi->title }}</h5>
                            <p class="card-text text-secondary small">{{ Str::limit($materi->deskripsi, 85) }}</p>
                        </div>
                        <div class="card-footer bg-transparent border-0 px-4 pb-4">
                            <div class="d-flex gap-2">
                                <a href="{{ asset('storage/' . $materi->file_path) }}" target="_blank"
                                    class="btn btn-primary flex-grow-1 rounded-3 shadow-sm">
                                    <i class="bi bi-download"></i> Unduh
                                </a>

                                <div class="btn-group">
                                    <button class="btn btn-outline-secondary rounded-3" data-bs-toggle="modal"
                                        data-bs-target="#materiModal{{ $materi->id }}">
                                        <i class="bi bi-info-circle"></i>
                                    </button>

                                    @if (auth()->user()->isAdmin())
                                        <button type="button"
                                            class="btn btn-outline-secondary rounded-3 dropdown-toggle dropdown-toggle-split"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <span class="visually-hidden">Toggle Dropdown</span>
                                        </button>

                                        <ul class="dropdown-menu dropdown-menu-end shadow border-0">
                                            <li>
                                                <a class="dropdown-item"
                                                    href="{{ route('pembelajaran.materi.edit', $materi->id) }}">
                                                    <i class="bi bi-pencil me-2 text-warning"></i>Edit
                                                </a>
                                            </li>
                                            <li>
                                                <hr class="dropdown-divider">
                                            </li>
                                            <li>
                                                <form action="{{ route('pembelajaran.materi.destroy', $materi->id) }}"
                                                    method="POST"
                                                    onsubmit="return confirm('Apakah Anda yakin ingin menghapus materi ini?');">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="dropdown-item text-danger">
                                                        <i class="bi bi-trash me-2"></i>Hapus
                                                    </button>
                                                </form>
                                            </li>
                                        </ul>
                                    @endif

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal fade" id="materiModal{{ $materi->id }}" tabindex="-1" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered">
                        <div class="modal-content shadow">
                            <div class="modal-header border-0 pb-0"><button type="button" class="btn-close"
                                    data-bs-dismiss="modal"></button></div>
                            <div class="modal-body p-4">
                                <h4 class="fw-bold text-primary mb-3">{{ $materi->title }}</h4>
                                <p class="lh-lg" style="white-space: pre-line;">{{ $materi->deskripsi }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5">
                    <h5 class="text-muted">Tidak ada materi ditemukan.</h5>
                </div>
            @endforelse
        </div>
    </div>

    <style>
        /* Transisi Hover */
        .transition-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .transition-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.15) !important;
        }

        /* Penyesuaian Dark Mode manual jika tema global tidak mencakup */
        [data-bs-theme="dark"] .text-dark {
            color: #f8f9fa !important;
        }

        [data-bs-theme="dark"] .bg-body-tertiary {
            background-color: #212529 !important;
        }
    </style>
@endsection
