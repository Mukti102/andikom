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
                        <th>Durasi (Bulan)</th>
                        <th>Pertemuan/Minggu</th>
                        <th>Jumlah Pertemuan</th>
                        <th>Total (IDR)</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($courses as $course)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><span class="fw-bold">{{ $course->name_paket }}</span></td>
                        <td>
                            <span class="badge {{ $course->category == 'private' ? 'bg-info' : 'bg-primary' }}">
                                {{ ucfirst($course->category) }}
                            </span>
                        </td>
                        <td>{{ $course->durasi_bulan ?? '-' }} Bulan</td>
                        <td>{{ $course->pertemuan_per_minggu ? $course->pertemuan_per_minggu . 'x' : '-' }}</td>
                        <td>{{ $course->jumlah_pertemuan ? $course->jumlah_pertemuan . 'x'  : '-' }}</td>
                        <td>{{ number_format($course->jumlah_total, 0, ',', '.') }}</td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.course.pendaftar', $course->id) }}" class="btn btn-sm btn-outline-info">
                                    <i class="bi bi-eye"></i>
                                </a>
                                <a href="{{ route('admin.courses.edit', $course->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $course->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $course->id }}" action="{{ route('admin.courses.destroy', $course->id) }}" method="POST" style="display: none;">
                                @csrf
                                @method('DELETE')
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</section>

@endsection