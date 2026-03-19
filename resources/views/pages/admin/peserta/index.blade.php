@extends('layouts.app')
@section('title', 'Peserta Management')

@section('content')
    <section class="section">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Daftar Peserta Kursus</h5>
                <div>
                    <a href="{{ route('admin.peserta.create') }}" class="btn btn-primary">
                        <i class="bi bi-person-plus"></i> Tambah Peserta Baru
                    </a>
                    <a href="{{ route('admin.peserta.export') }}" class="btn btn-warning">
                        <i class="bi bi-page"></i> Export
                    </a>
                </div>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>NIS</th>
                            <th>Nama Lengkap</th>
                            <th>No. HP</th>
                            <th>Asal Sekolah</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pesertas as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td><span class="badge bg-light-secondary">{{ $p->nis }}</span></td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <span class="fw-bold">{{ $p->nama_lengkap }}</span>
                                        <small class="text-muted">{{ $p->user->email ?? '' }}</small>
                                    </div>
                                </td>
                                <td>{{ $p->no_hp }}</td>
                                <td>{{ $p->asal_sekolah ?? '-' }}</td>
                                <td>
                                    @if ($p->status_aktif)
                                        <span class="badge bg-success">Aktif</span>
                                    @else
                                        <span class="badge bg-danger">Non-Aktif</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.peserta.show', $p->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.peserta.edit', $p->id) }}"
                                            class="btn btn-sm btn-outline-warning">
                                            <i class="bi bi-pencil"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"
                                            data-id="{{ $p->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    {{-- Form hidden untuk delete --}}
                                    <form id="delete-form-{{ $p->id }}"
                                        action="{{ route('admin.peserta.destroy', $p->id) }}" method="POST"
                                        style="display: none;">
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
