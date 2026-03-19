@extends('layouts.app')
@section('title', 'Daftar Nilai Peserta ' . $course->name_paket)

@section('content')
    <section class="section">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center  py-3">
                <h5 class="card-title mb-0">Daftar Nilai Peserta {{ $course->name_paket }}</h5>
            </div>
            <div class="card-body">
                <table class="table table-hover" id="table1">
                    <thead>
                        <tr>
                            <th>Peserta</th>

                            <th>Nomor Sertifikat</th>
                            @if (auth()->user()->isAdmin())
                                <th class="text-center">Action</th>
                            @endif

                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->peserta->nama_lengkap ?? 'N/A' }}</td>



                                <td>{{ $pendaftaran->nilai->nomor_sertifikat ?? '-' }}</td>

                                <td class="text-center">
                                    <div class="d-flex justify-content-center gap-1">
                                        {{-- 1. Lihat Nilai (Selalu Ada) --}}
                                        <button class="btn btn-sm btn-info text-white" data-bs-toggle="modal"
                                            data-bs-target="#detailNilaiModal{{ $pendaftaran->id }}"
                                            title="Lihat Rincian Nilai">
                                            <i class="bi bi-eye"></i>
                                        </button>

                                        @if (auth()->user()->isTutor())
                                            {{-- 2. Set Nilai --}}
                                            <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                                data-bs-target="#nilaiModal{{ $pendaftaran->id }}" title="Input/Edit Nilai">
                                                <i class="bi bi-pencil-square"></i>
                                            </button>

                                            {{-- 3. Upload Sertifikat (Hanya jika nilai sudah ada) --}}
                                            @if ($pendaftaran->nilai && $pendaftaran->nilai->details->isNotEmpty())
                                                <button
                                                    class="btn btn-sm {{ $pendaftaran->nilai->certificate_path ? 'btn-success' : 'btn-warning' }}"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#uploadSertifikatModal{{ $pendaftaran->id }}"
                                                    title="{{ $pendaftaran->nilai->certificate_path ? 'Ganti Sertifikat' : 'Upload Sertifikat' }}">
                                                    <i class="bi bi-file-earmark-arrow-up"></i>
                                                </button>
                                            @endif
                                        @endif

                                        {{-- 4. Download/Lihat PDF (Hanya jika file sudah ada) --}}
                                        @if ($pendaftaran->nilai && $pendaftaran->nilai->certificate_path)
                                            <a href="{{ asset('storage/' . $pendaftaran->nilai->certificate_path) }}"
                                                target="_blank" class="btn btn-sm btn-outline-danger"
                                                title="Buka PDF Sertifikat">
                                                <i class="bi bi-file-pdf"></i>
                                            </a>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>
    @foreach ($course->pendaftarans as $pendaftaran)
        <div class="modal fade" id="nilaiModal{{ $pendaftaran->id }}" tabindex="-1">
            <div class="modal-dialog">
                <form action="{{ route('pembelajaran.nilai.store') }}" method="POST" class="modal-content">
                    @csrf

                    <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id }}">
                    <input type="hidden" name="instruktur_id" value="{{ auth()->id() }}">

                    <div class="modal-header">
                        <h5 class="modal-title">
                            Input Nilai: {{ $pendaftaran->peserta->nama_lengkap }}
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">
                        @foreach ($course->tools as $tool)
                            @php
                                $existingScore = $pendaftaran->nilai
                                    ? $pendaftaran->nilai->details->where('tool_id', $tool->id)->first()
                                    : null;
                            @endphp

                            <div class="mb-3">
                                <label class="form-label fw-bold">{{ $tool->name }}</label>
                                <input type="number" name="skor[{{ $tool->id }}]" class="form-control"
                                    value="{{ $existingScore->skor ?? '' }}" placeholder="0 - 100" required>
                            </div>
                        @endforeach
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                            Simpan Nilai
                        </button>
                    </div>

                </form>
            </div>
        </div>
    @endforeach
    @foreach ($course->pendaftarans as $pendaftaran)
        <div class="modal fade" id="detailNilaiModal{{ $pendaftaran->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                    <div class="modal-header bg-light">
                        <h5 class="modal-title">Rincian Nilai: {{ $pendaftaran->peserta->nama_lengkap }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="text-center mb-4">
                            <small class="text-muted d-block">Nomor Sertifikat</small>
                            <h6 class="fw-bold">{{ $pendaftaran->nilai->nomor_sertifikat ?? 'Belum Terbit' }}</h6>
                        </div>

                        <ul class="list-group list-group-flush">
                            @foreach ($course->tools as $tool)
                                @php
                                    $detail = $pendaftaran->nilai
                                        ? $pendaftaran->nilai->details->where('tool_id', $tool->id)->first()
                                        : null;
                                    $skor = $detail->skor ?? 0;
                                @endphp
                                <li class="list-group-item d-flex justify-content-between align-items-center border-0 px-0">
                                    <span>{{ $tool->name }}</span>
                                    <span class="fw-bold {{ $skor >= 75 ? 'text-success' : 'text-danger' }}">
                                        {{ $detail ? $skor : '-' }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>

                        <hr>

                        <div class="d-flex justify-content-between">
                            <span class="fw-bold">Rata-rata:</span>
                            @php
                                $totalSkor = $pendaftaran->nilai ? $pendaftaran->nilai->details->avg('skor') : 0;
                            @endphp
                            <span class="badge bg-primary fs-6">{{ number_format($totalSkor, 1) }}</span>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
    @foreach ($course->pendaftarans as $pendaftaran)
        <div class="modal fade" id="uploadSertifikatModal{{ $pendaftaran->id }}" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog">
                <form action="{{ route('pembelajaran.nilai.store.certificate', $pendaftaran->nilai->id) }}" method="POST"
                    enctype="multipart/form-data" class="modal-content">
                    @csrf
                    @method('PATCH') {{-- Gunakan PATCH atau POST sesuai route Anda --}}

                    <div class="modal-header bg-warning">
                        <h5 class="modal-title text-dark">Upload Sertifikat: {{ $pendaftaran->peserta->nama_lengkap }}</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>

                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label fw-bold">Nomor Sertifikat</label>
                            <input type="text" name="nomor_sertifikat" class="form-control"
                                value="{{ $pendaftaran->nilai->nomor_sertifikat ?? '' }}"
                                placeholder="Contoh: CERT/2023/001" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold">File Sertifikat (PDF/JPG/PNG)</label>
                            <input type="file" name="file_sertifikat" class="form-control"
                                accept=".pdf,.jpg,.jpeg,.png" required>
                            <div class="form-text text-muted">Maksimal ukuran file: 2MB</div>
                        </div>

                        @if ($pendaftaran->nilai && $pendaftaran->nilai->certificate_path)
                            <div class="alert alert-info py-2">
                                <small>
                                    <i class="bi bi-info-circle"></i> File saat ini:
                                    <a href="{{ asset('storage/' . $pendaftaran->nilai->certificate_path) }}"
                                        target="_blank" class="fw-bold">Lihat Sertifikat</a>
                                </small>
                            </div>
                        @endif
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Sertifikat</button>
                    </div>
                </form>
            </div>
        </div>
    @endforeach

@endsection
