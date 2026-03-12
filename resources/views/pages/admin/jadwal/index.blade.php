@extends('layouts.app')
@section('title', 'Pilih Course')

@section('content')
<div class="container py-4">
    <div class="row mb-4">
        <div class="col">
            <h3 class="fw-bold">Pilih Kursus</h3>
            <p class="text-muted">Pilih paket kursus untuk melihat jadwal yang tersedia.</p>
        </div>
    </div>

    <div class="row g-4">
        @foreach ($courses as $course)
            <div class="col-md-6 col-lg-4">
                <div class="card h-100 border-0 shadow-sm rounded-4 overflow-hidden">
                    {{-- Thumbnail --}}
                    <div class="position-relative">
                        <img src="{{ asset('storage/' . $course->thumbnail) }}" 
                             class="card-img-top" 
                             alt="{{ $course->name_paket }}"
                             style="height: 200px; object-fit: cover;">
                        
                        {{-- Badge Kategori --}}
                        <span class="position-absolute top-0 start-0 m-3 badge {{ $course->category == 'private' ? 'bg-info' : 'bg-primary' }} px-3 py-2 shadow">
                            {{ ucfirst($course->category) }}
                        </span>
                    </div>

                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title fw-bold mb-1">{{ $course->name_paket }}</h5>
                        <p class="text-primary fw-bold mb-3">Rp {{ number_format($course->jumlah_total, 0, ',', '.') }}</p>

                        {{-- Info Singkat --}}
                        <div class="row g-2 mb-4 small text-muted">
                            <div class="col-6">
                                <i class="bi bi-clock me-1"></i> {{ $course->durasi_jam }} Jam/Sesi
                            </div>
                            <div class="col-6">
                                <i class="bi bi-people me-1"></i> Max {{ $course->max_slot }} Slot
                            </div>
                            @if($course->category == 'intensif')
                                <div class="col-6">
                                    <i class="bi bi-calendar-event me-1"></i> {{ $course->durasi_bulan }} Bulan
                                </div>
                                <div class="col-6">
                                    <i class="bi bi-arrow-repeat me-1"></i> {{ $course->pertemuan_per_minggu }}x/Minggu
                                </div>
                            @else
                                <div class="col-12">
                                    <i class="bi bi-check-circle me-1"></i> Total {{ $course->jumlah_pertemuan }} Pertemuan
                                </div>
                            @endif
                        </div>

                        {{-- Action Button --}}
                        <div class="mt-auto">
                            <a href="{{ route('admin.jadwal.show', $course->id) }}" class="btn btn-primary w-100 rounded-pill py-2 fw-semibold">
                                <i class="bi bi-calendar3 me-2"></i>Lihat Jadwal
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>

<style>
    .card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
        transform: translateY(-10px);
        box-shadow: 0 10px 20px rgba(0,0,0,0.1) !important;
    }
</style>
@endsection