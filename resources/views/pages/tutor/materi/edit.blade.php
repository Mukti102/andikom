@extends('layouts.app')
@section('title', 'Edit Materi - ' . $materi->title)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-warning py-3">
                    <h5 class="mb-0 fw-bold text-dark">Edit Materi: {{ $materi->title }}</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pembelajaran.materi.update', $materi->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Judul Materi</label>
                                <input type="text" name="title" class="form-control" value="{{ $materi->title }}" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Urutan</label>
                                <input type="number" name="urutan" class="form-control" value="{{ $materi->urutan }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Software / Tool Terkait</label>
                                <select name="tool_id" class="form-select" required>
                                    @foreach($course->tools as $tool)
                                        <option value="{{ $tool->id }}" {{ $materi->tool_id == $tool->id ? 'selected' : '' }}>
                                            {{ $tool->name }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">File Baru (Kosongkan jika tidak ganti)</label>
                                <input type="file" name="file_path" class="form-control">
                                <small class="text-muted">File saat ini: {{ basename($materi->file_path) }}</small>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Materi</label>
                            <textarea name="deskripsi" class="form-control" rows="5" required>{{ $materi->deskripsi }}</textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('pembelajaran.materi.index', $course->id) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-warning px-4">Update Materi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection