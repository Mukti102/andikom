@extends('layouts.app')
@section('title', $course->name_paket)

@section('content')
    <div class="container py-5">
        <div class="row g-4">
            {{-- Sidebar: Info Pembayaran & CTA --}}
            <div class="col-lg-4 order-lg-2">
                <div class="card border-0 shadow-sm sticky-top" style="top: 2rem;">
                    <img src="{{ $course->thumbnail ? asset('storage/' . $course->thumbnail) : asset('assets/images/default-course.png') }}"
                        class="card-img-top" alt="{{ $course->name_paket }}">

                    <div class="card-body p-4">
                        <div class="mb-4">
                            <span class="text-muted small d-block mb-1">Investasi Pelatihan</span>
                            <h2 class="fw-bold text-primary mb-0">{{ $course->formatted_price }}</h2>
                        </div>

                        @php
                            $sisaSlot = $course->getSisaSlotAttribute();
                        @endphp

                        @if (!$peserta)
                            <div class="alert alert-warning border-0 small">
                                <i class="fas fa-exclamation-triangle me-2"></i>
                                Lengkapi profil peserta untuk mendaftar.
                            </div>
                        @elseif($sisaSlot <= 0)
                            <button class="btn btn-secondary btn-lg w-100 fw-bold" disabled>Slot Sudah Penuh</button>
                        @else
                            <button type="button" class="btn btn-primary btn-lg w-100 fw-bold shadow-sm"
                                data-bs-toggle="modal" data-bs-target="#pendaftaranModal">
                                Daftar Sekarang
                            </button>
                            <p class="text-center text-danger small fw-bold mt-3 mb-0">
                                <i class="fas fa-fire me-1"></i> Tersisa {{ $sisaSlot }} slot lagi!
                            </p>
                        @endif
                    </div>
                </div>
            </div>

            {{-- Main Content: Deskripsi & Materi --}}
            <div class="col-lg-8 order-lg-1">
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <nav aria-label="breadcrumb" class="mb-3">
                        <ol class="breadcrumb small">
                            <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Dashboard</a></li>
                            <li class="breadcrumb-item active">{{ $course->category ?? 'Kursus' }}</li>
                        </ol>
                    </nav>

                    <h1 class="fw-bold  mb-3">{{ $course->name_paket }}</h1>
                    <p class="text-secondary leading-relaxed">{{ $course->description }}</p>

                    <hr class="my-4 opacity-25">

                    <h5 class="fw-bold mb-4"><i class="fas fa-list-ul text-primary me-2"></i>Materi Pembelajaran</h5>
                    <div class="row g-3 mb-5">
                        @forelse($course->tools as $tool)
                            <div class="col-md-6">
                                <div class="d-flex align-items-center p-2 border rounded-3 bg-light-hover">
                                    <div class="bg-success-subtle text-success rounded-circle p-2 me-3">
                                        <i class="fas fa-check fa-xs"></i>
                                    </div>
                                    <span class="small fw-medium">{{ $tool->name }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted small">Materi belum diperbarui.</p>
                            </div>
                        @endforelse
                    </div>

                    <h5 class="fw-bold mb-4"><i class="fas fa-info-circle text-primary me-2"></i>Detail Informasi</h5>
                    <div class="row g-4">
                        @php
                            $details = [
                                [
                                    'label' => 'Durasi Program',
                                    'value' => $course->durasi_bulan . ' Bulan',
                                    'icon' => 'calendar-alt',
                                ],
                                [
                                    'label' => 'Total Pertemuan',
                                    'value' => $course->jumlah_pertemuan . ' Sesi',
                                    'icon' => 'chalkboard-teacher',
                                ],
                                [
                                    'label' => 'Intensitas',
                                    'value' => $course->pertemuan_per_minggu . 'x / Minggu',
                                    'icon' => 'history',
                                ],
                                ['label' => 'Total Jam', 'value' => $course->durasi_jam . ' Jam', 'icon' => 'clock'],
                            ];
                        @endphp

                        @foreach ($details as $detail)
                            <div class="col-6 col-md-3 text-center">
                                <div class="p-3 border rounded-4">
                                    <i class="fas fa-{{ $detail['icon'] }} text-muted mb-2"></i>
                                    <small
                                        class="d-block text-muted x-small uppercase fw-bold">{{ $detail['label'] }}</small>
                                    <span class="fw-bold  small">{{ $detail['value'] }}</span>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modal tetap dipertahankan karena sudah bagus, cukup pastikan action route benar --}}
    {{-- Modal Pendaftaran --}}
    <div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow">
                <form id="pendaftaranForm" action="{{ route('pendaftaran.store') }}" method="POST">
                    @csrf
                    <div class="modal-header border-0 bg-light">
                        <h5 class="modal-title fw-bold">Konfirmasi Pendaftaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4">
                        {{-- Hidden Field: Course & Peserta --}}
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="peserta_id" value="{{ $peserta->id ?? '' }}">

                        <div class="text-center mb-4">
                            <p class="mb-1 text-muted">Anda akan mendaftar pada paket:</p>
                            <h5 class="fw-bold text-primary">{{ $course->name_paket }}</h5>
                        </div>

                        <div class="mb-3">
                            <label class="form-label fw-bold small">Nama Peserta</label>
                            <input type="text" class="form-control bg-light" value="{{ auth()->user()->name }}"
                                readonly>
                        </div>

                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label class="form-label fw-bold small">Pilih Metode Pembayaran</label>
                                <select name="metode_bayar" class="form-select" required>
                                    <option value="lunas">Lunas (Full Payment)</option>
                                    <option value="cicil">Cicil (Installment)</option>
                                </select>
                            </div>
                        </div>

                        {{-- Tanggal otomatis disembunyikan atau dibuat readonly agar tidak dimanipulasi user --}}
                        <input type="hidden" name="tanggal_daftar" value="{{ date('Y-m-d') }}">
                        <input type="hidden" name="status" value="aktif">

                        <p class="text-muted x-small mt-3 mb-0">
                            *Dengan mengklik tombol simpan, Anda setuju dengan syarat dan ketentuan pelatihan kami.
                        </p>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary px-4 fw-bold">Konfirmasi Daftar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
