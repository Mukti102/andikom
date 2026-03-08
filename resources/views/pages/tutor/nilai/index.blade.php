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
                            @foreach ($course->tools as $tool)
                                <th class="text-center">{{ $tool->name }}</th>
                            @endforeach
                            <th>Nomor Sertifikat</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->pendaftarans as $pendaftaran)
                            <tr>
                                <td>{{ $pendaftaran->peserta->nama_lengkap ?? 'N/A' }}</td>

                                @foreach ($course->tools as $tool)
                                    @php
                                        // Mencari nilai detail untuk tool ini dari pendaftaran terkait
                                        $nilaiDetail = $pendaftaran->nilai
                                            ? $pendaftaran->nilai->details->where('tool_id', $tool->id)->first()
                                            : null;
                                    @endphp
                                    <td class="text-center">
                                        @if ($nilaiDetail)
                                            @php
                                                $skor = $nilaiDetail->skor;
                                                $warna = match (true) {
                                                    $skor >= 90 => 'bg-success', // Hijau (Sangat Baik)
                                                    $skor >= 75 => 'bg-info text-dark', // Biru Muda (Baik)
                                                    $skor >= 60 => 'bg-warning text-dark', // Kuning (Cukup)
                                                    default => 'bg-danger', // Merah (Perlu Perbaikan)
                                                };
                                            @endphp
                                            <span class="badge {{ $warna }}">
                                                {{ $skor }}
                                            </span>
                                        @else
                                            <span class="badge bg-secondary">-</span>
                                        @endif
                                    </td>
                                @endforeach

                                <td>{{ $pendaftaran->nilai->nomor_sertifikat ?? '-' }}</td>

                                <td class="text-center">
                                    <button class="btn btn-sm btn-primary" data-bs-toggle="modal"
                                        data-bs-target="#nilaiModal{{ $pendaftaran->id }}">
                                        <i class="bi bi-pencil-square"></i> Set Nilai
                                    </button>
                                    {{-- <a class="btn btn-sm btn-primary"
                                        href="{{ route('pembelajaran.nilai.sertifikat', $pendaftaran->id) }}">
                                        <i class="bi bi-pencil-square"></i> Cetak Sertifikat
                                    </a> --}}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </section>

    <div class="modal fade" id="nilaiModal{{ $pendaftaran->id }}" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('pembelajaran.nilai.store') }}" method="POST" class="modal-content">
                @csrf
                <input type="hidden" name="pendaftaran_id" value="{{ $pendaftaran->id }}">
                <input type="hidden" name="instruktur_id" value="{{ auth()->id() }}">

                <div class="modal-header">
                    <h5 class="modal-title">Input Nilai: {{ $pendaftaran->peserta->nama_lengkap }}</h5>
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
                    <button type="submit" class="btn btn-primary">Simpan Nilai</button>
                </div>
            </form>
        </div>
    </div>
@endsection
