@extends('layouts.app')
@section('title', 'Jadwal ' . $course->name)

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
    <div class="container">
        <h3>Jadwal: {{ $course->name }}</h3>
        <button class="btn btn-success" data-bs-toggle="modal" data-bs-target="#addModal">+ Tambah Jadwal</button>

        <table class="table mt-3">
            <thead>
                <tr>
                    <th>Hari</th>
                    <th>Instruktur</th>
                    <th>Waktu</th>
                    <th>Ruangan</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($jadwals as $j)
                    <tr>
                        <td>{{ $j->hari }}</td>
                        <td>{{ $j->tutor->name ?? 'N/A' }}</td>
                        <td>{{ $j->start_time }} - {{ $j->end_time }}</td>
                        <td>{{ $j->room }}</td>
                        <td>
                            <button class="btn btn-sm btn-warning" data-bs-toggle="modal"
                                data-bs-target="#editModal{{ $j->id }}">Edit</button>
                            <form action="{{ route('admin.jadwal.destroy', $j->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button class="btn btn-sm btn-danger"
                                    onclick="return confirm('Yakin hapus?')">Hapus</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

   

    @include('includes.modals.edit-jadwal')
    @include('includes.modals.add-jadwal')
@endsection
