@extends('layouts.app')
@section('title', 'Pendaftaran Kursus Baru')

@section('content')
 @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.pendaftaran.store') }}" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Data Peserta</h5>
                    </div>
                    <div class="card-body">
                        <x-form-select label="Pilih Peserta" name="peserta_id" :options="$pesertas" required />
                        <x-form-input label="Tanggal Daftar" name="tanggal_daftar" type="date"
                            value="{{ date('Y-m-d') }}" required />
                        <x-form-select label="Metode Bayar" name="metode_bayar" :options="['lunas' => 'Lunas', 'cicil' => 'Cicil']" />
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <h5 class="mb-3">Pilih Paket Kursus</h5>
                <div class="row" id="course-cards">
                    @php
                        // Kelompokkan data kursus berdasarkan kategori
                        $intensifCourses = $courses->where('category', 'intensif');
                        $privateCourses = $courses->where('category', 'private');
                    @endphp

                    <h5 class="text-primary mt-4 mb-3"><i class="bi bi-clock-history"></i> Paket Intensif</h5>
                    <div class="row">
                        @forelse($intensifCourses as $course)
                            <div class="col-md-6 mb-3">
                                <div class="card course-card h-100 border" data-id="{{ $course->id }}">
                                    <div class="card-body">
                                        <input type="radio" name="course_id" value="{{ $course->id }}" class="d-none"
                                            id="course_{{ $course->id }}">
                                        <h6 class="card-title">{{ $course->name_paket }}</h6>
                                        <p class="card-text small text-muted">
                                            Durasi: {{ $course->durasi_bulan ?? '-' }} Bulan <br>
                                            Pertemuan/Minggu: {{ $course->pertemuan_per_minggu ?? '-' }}x <br>
                                            Total Pertemuan: {{ $course->jumlah_pertemuan ?? '-' }}<br>
                                            Durasi Jam Pertemuan: {{ $course->durasi_jam ?? '-' }}<br>
                                            Slot Tersedia : {{ $course->getSisaSlotAttribute() }}
                                        </p>
                                        <span class="badge bg-primary">Rp
                                            {{ number_format($course->jumlah_total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted italic">Tidak ada paket intensif tersedia.</p>
                            </div>
                        @endforelse
                    </div>

                    <h5 class="text-info mt-4 mb-3"><i class="bi bi-person-badge"></i> Paket Private</h5>
                    <div class="row">
                        @forelse($privateCourses as $course)
                            <div class="col-md-6 mb-3">
                                <div class="card course-card h-100 border" data-id="{{ $course->id }}">
                                    <div class="card-body">
                                        <input type="radio" name="course_id" value="{{ $course->id }}" class="d-none"
                                            id="course_{{ $course->id }}">
                                        <h6 class="card-title">{{ $course->name_paket }}</h6>
                                        <p class="card-text small text-muted">
                                            Durasi per Pertemuan: {{ $course->durasi_jam }} Jam <br>
                                            Total Pertemuan: {{ $course->jumlah_pertemuan ?? '-' }} <br>
                                            Durasi Jam Pertemuan: {{ $course->durasi_jam ?? '-' }} Jam <br>
                                            Slot Tersedia : {{ $course->getSisaSlotAttribute() }}
                                        </p>
                                        <span class="badge bg-info">Rp
                                            {{ number_format($course->jumlah_total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            </div>
                        @empty
                            <div class="col-12">
                                <p class="text-muted italic">Tidak ada paket private tersedia.</p>
                            </div>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>

        <button type="submit" class="btn btn-primary mt-3">Proses Pendaftaran</button>
    </form>
@endsection
@push('scripts')
    <style>
        .course-card {
            cursor: pointer;
            transition: 0.3s;
        }

        .course-card.selected {
            border-color: #435ebe !important;
            background-color: #f0f4ff;
        }
    </style>

    <script>
        document.querySelectorAll('.course-card').forEach(card => {
            card.addEventListener('click', function() {
                // Hapus class selected dari semua card
                document.querySelectorAll('.course-card').forEach(c => c.classList.remove('selected'));

                // Tambahkan class selected ke card yang diklik
                this.classList.add('selected');

                // Checklist radio button di dalamnya
                this.querySelector('input[type="radio"]').checked = true;
            });
        });
    </script>
@endpush
