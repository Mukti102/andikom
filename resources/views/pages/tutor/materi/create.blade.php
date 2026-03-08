@extends('layouts.app')
@section('title', 'Tambah Materi - ' . $course->name)

@section('content')
<div class="container py-4">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white py-3">
                    <h5 class="mb-0 fw-bold">Tambah Materi Baru</h5>
                </div>
                <div class="card-body p-4">
                    <form action="{{ route('pembelajaran.materi.store', $course->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="course_id" value="{{ $course->id }}">
                        <input type="hidden" name="tutor_id" value="{{ auth()->id() }}">

                        <div class="row">
                            <div class="col-md-8 mb-3">
                                <label class="form-label fw-bold">Judul Materi</label>
                                <input type="text" name="title" class="form-control" required>
                            </div>
                            <div class="col-md-4 mb-3">
                                <label class="form-label fw-bold">Urutan Pertemuan</label>
                                <input type="number" name="urutan" class="form-control" value="{{ $course->materis->count() + 1 }}" required>
                            </div>
                        </div>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">Software / Tool Terkait</label>
                                <select name="tool_id" class="form-select" required>
                                    <option value="">-- Pilih Tool --</option>
                                    @foreach($course->tools as $tool)
                                        <option value="{{ $tool->id }}">{{ $tool->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="form-label fw-bold">File Materi</label>
                                <input type="file" name="file_path" class="form-control" required>
                            </div>
                        </div>

                        <div class="mb-4">
                            <label class="form-label fw-bold">Deskripsi Materi</label>
                            <textarea name="deskripsi" class="form-control" rows="5" required></textarea>
                        </div>

                        <div class="d-flex justify-content-end">
                            <a href="{{ route('pembelajaran.materi.index', $course->id) }}" class="btn btn-secondary me-2">Batal</a>
                            <button type="submit" class="btn btn-primary px-4">Simpan Materi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection