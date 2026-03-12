@extends('layouts.app')
@section('title', 'Kursus Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Paket Kursus</h5>
                <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">
                    <i class="bi bi-plus-circle"></i> Tambah Kursus Baru
                </a>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Paket</th>
                            <th>Kategori</th>
                            <th>Total (IDR)</th>
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
                                <td>{{ number_format($course->jumlah_total, 0, ',', '.') }}</td>
                                <td>
                                    <div class="btn-group">
                                        <button type="button" class="btn btn-sm btn-outline-secondary"
                                            data-bs-toggle="modal" data-bs-target="#detailModal{{ $course->id }}">
                                            <i class="bi bi-info-circle"></i>
                                        </button>

                                        <a href="{{ route('admin.course.pendaftar', $course->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-people"></i>
                                        </a>
                                        <a href="{{ route('admin.courses.edit', $course->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"
                                            data-id="{{ $course->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>

                                    <form id="delete-form-{{ $course->id }}"
                                        action="{{ route('admin.courses.destroy', $course->id) }}" method="POST"
                                        style="display: none;">
                                        @csrf
                                        @method('DELETE')
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="detailModal{{ $course->id }}" tabindex="-1" aria-hidden="true">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header bg-light">
                                            <h5 class="modal-title fw-bold">Detail Paket: {{ $course->name_paket }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <h6 class="text-primary border-bottom pb-2">Informasi Paket</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Kategori:</strong> {{ ucfirst($course->category) }}
                                                        </li>
                                                        <li><strong>Durasi:</strong> {{ $course->durasi_bulan ?? '-' }}
                                                            Bulan</li>
                                                        <li><strong>Durasi per Sesi:</strong> {{ $course->durasi_jam }} Jam
                                                        </li>
                                                        <li><strong>Max Slot:</strong> {{ $course->max_slot }} Peserta</li>
                                                    </ul>
                                                </div>
                                                <div class="col-md-6">
                                                    <h6 class="text-primary border-bottom pb-2">Detail Jadwal</h6>
                                                    <ul class="list-unstyled">
                                                        <li><strong>Pertemuan/Minggu:</strong>
                                                            {{ $course->pertemuan_per_minggu ?? '-' }}x</li>
                                                        <li><strong>Total Pertemuan:</strong>
                                                            {{ $course->jumlah_pertemuan ?? '-' }}x</li>
                                                        <li><strong>Total Biaya:</strong> Rp
                                                            {{ number_format($course->jumlah_total, 0, ',', '.') }}</li>
                                                    </ul>
                                                </div>
                                            </div>

                                            <div class="mt-3">
                                                <h6 class="text-primary border-bottom pb-2">Kelengkapan Materi/Tools</h6>
                                                @if ($course->tools && $course->tools->count() > 0)
                                                    <div class="d-flex flex-wrap gap-2">
                                                        @foreach ($course->tools as $tool)
                                                            <span class="badge bg-info px-3 py-2">
                                                                <i class="bi bi-tools me-1"></i> {{ $tool->name }}
                                                            </span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                    <p class="text-muted small">Tidak ada tools yang terdaftar untuk paket
                                                        ini.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

@endsection
