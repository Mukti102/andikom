@extends('layouts.app')
@section('title', 'List Daftar Peserta ' . $course->name_paket)

@section('content')
    <div class="container card">
        <div class="card-header">
            <div class="card-title">
                <h1>Daftar Peserta {{ $course->name_paket }} </h1>
            </div>
        </div>
        <div class="card-body">

            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Nama Peserta</th>
                        <th>NIS</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($course->pendaftarans as $index => $pendaftaran)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $pendaftaran->peserta->nama_lengkap }}</td>
                            <td>{{ $pendaftaran->peserta->nis }}</td>
                            <td>
                                <span
                                    class="badge bg-{{ $pendaftaran->status == 'aktif' ? 'success' : 'danger' }}">{{ $pendaftaran->status }}</span>
                            </td>
                            <td>
                                <button class="btn btn-info btn-sm" data-bs-toggle="modal"
                                    data-bs-target="#detailModal{{ $pendaftaran->id }}">Detail</button>
                                <a class="btn btn-warning btn-sm" href="{{ route('pembelajaran.peserta.toogle', $pendaftaran->id) }}">Ubah Status</a>
                            </td>
                        </tr>
                        @include('includes.modals.detail-peserta')
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
