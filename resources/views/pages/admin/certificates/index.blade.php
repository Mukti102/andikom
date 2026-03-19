@extends('layouts.app')
@section('title', 'Template Sertifikat')

@section('content')
    <section class="section">
        <div class="row">
            <div class="col-12">
                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Data Template Sertifikat</h5>
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                            <i class="bi bi-plus"></i> Tambah Template
                        </button>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Template</th>
                                        <th>Course</th>
                                        <th>Preview Background</th>
                                        <th style="width: 150px;">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($certificates as $cert)
                                        <tr>
                                            <td><strong>{{ $cert->name }}</strong></td>
                                            <td><span class="badge bg-info">{{ $cert->course->name_paket ?? 'N/A' }}</span>
                                            </td>
                                            <td>
                                                <a href="{{ asset('storage/' . $cert->background) }}" target="_blank">
                                                    <img src="{{ asset('storage/' . $cert->background) }}" alt="bg"
                                                        style="height: 50px; border-radius: 4px; border: 1px solid #ddd">
                                                </a>
                                            </td>
                                            <td>

                                                <a href="{{ route('admin.certificate-template.builder', $cert->id) }}"
                                                    class="btn btn-info btn-sm">setup</a>
                                                <form action="{{ route('admin.certificate-template.delete', $cert->id) }}"
                                                    method="POST" class="d-inline">
                                                    @csrf @method('DELETE')
                                                    <button class="btn btn-sm btn-danger"
                                                        onclick="return confirm('Yakin ingin menghapus template ini?')">
                                                        Hapus
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4" class="text-center">Data template belum tersedia</td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <div class="modal fade" id="modalAdd" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('admin.certificate-template.store') }}" method="POST" enctype="multipart/form-data"
                class="modal-content">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Template Baru</h5>
                </div>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">Nama Template</label>
                        <input name="name" class="form-control" placeholder="Contoh: Sertifikat Kelulusan A" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Pilih Course</label>
                        <select name="course_id" class="form-select" required>
                            <option value="">-- Pilih Course --</option>
                            @foreach ($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name_paket }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Background Template (Gambar)</label>
                        <input type="file" name="background" class="form-control" accept="image/*" required>
                        <small class="text-muted">Format: JPG, PNG. Maks: 5MB</small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan Template</button>
                </div>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Logika Edit jika dibutuhkan kedepannya
            const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));

            document.querySelectorAll('.edit-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    // Sesuaikan action URL dan value input untuk Edit
                    // document.getElementById('editForm').action = `{{ url('admin/certificates') }}/${this.dataset.id}`;
                    // modalEdit.show();
                });
            });
        });
    </script>
@endpush
