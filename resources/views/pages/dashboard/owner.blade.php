@extends('layouts.app')
@section('content')
    <div class="container-fluid py-4">
        <h3 class="fw-bold mb-4">Executive Dashboard</h3>

        {{-- Stats Row --}}
        <div class="row g-4 mb-5">
            <div class="col-md-3">
                <div class="card p-3 shadow-sm border-0 bg-primary ">
                    <h6>Total Pendapatan</h6>
                    <h3>Rp {{ number_format($stats['total_revenue'], 0, ',', '.') }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm border-0">
                    <h6>Total Peserta Aktif</h6>
                    <h3>{{ $stats['total_students'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm border-0">
                    <h6>Kursus Tersedia</h6>
                    <h3>{{ $stats['active_courses'] }}</h3>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card p-3 shadow-sm border-0">
                    <h6>Tutor Aktif</h6>
                    <h3>{{ $stats['active_tutors'] }}</h3>
                </div>
            </div>
        </div>

        {{-- Analytical Section --}}
        <div class="row">
            <div class="col-md-8">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="fw-bold mb-4">Analisis Tren Pendapatan</h5>
                    {{-- Di sini Anda bisa memanggil library chart seperti Chart.js --}}
                    <canvas id="revenueChart"></canvas>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card shadow-sm border-0 p-4">
                    <h5 class="fw-bold mb-3">Laporan Cepat</h5>
                    <ul class="list-group list-group-flush">
                        <li class="list-group-item d-flex justify-content-between">Kursus Terlaris : 
                            <span>{{ $best_course->name_paket ?? '-' }}</span></li>
                        <li class="list-group-item d-flex justify-content-between">Tingkat Kelulusan <span>85%</span></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    {{-- Tempatkan di akhir file view Anda --}}
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('revenueChart').getContext('2d');

            new Chart(ctx, {
                type: 'line',
                data: {
                    // Label bulan atau data yang sesuai
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov',
                        'Des'
                    ],
                    datasets: [{
                        label: 'Pendapatan (IDR)',
                        // Pastikan data dikirim dari Controller sebagai JSON
                        data: {!! json_encode($revenue_per_month->pluck('total')) !!},
                        backgroundColor: 'rgba(67, 97, 238, 0.1)',
                        borderColor: '#4361ee',
                        borderWidth: 3,
                        fill: true,
                        tension: 0.4
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: {
                            position: 'top'
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
