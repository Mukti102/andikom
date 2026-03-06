@extends('layouts.app')
@section('title', 'Daftar Software')

@section('content')
<section class="section">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Data Software</h5>
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modalAdd">
                        <i class="bi bi-plus"></i> Tambah Software
                    </button>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover table-striped">
                            <thead>
                                <tr>
                                    <th>Nama</th>
                                    <th>Deskripsi</th>
                                    <th style="width: 150px;">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($tools as $tool)
                                    <tr>
                                        <td><strong>{{ $tool->name }}</strong></td>
                                        <td>{{ $tool->description ?? '-' }}</td>
                                        <td>
                                            <button class="btn btn-sm btn-warning edit-btn" 
                                                data-id="{{ $tool->id }}"
                                                data-name="{{ $tool->name }}"
                                                data-desc="{{ $tool->description }}">
                                                Edit
                                            </button>
                                            <form action="{{ route('admin.tools.destroy', $tool->id) }}" method="POST" class="d-inline">
                                                @csrf @method('DELETE')
                                                <button class="btn btn-sm btn-danger" onclick="return confirm('Yakin hapus?')">Hapus</button>
                                            </form>
                                        </td>
                                    </tr>
                                @empty
                                    <tr><td colspan="3" class="text-center">Data tidak ditemukan</td></tr>
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
        <form action="{{ route('admin.tools.store') }}" method="POST" class="modal-content">
            @csrf
            <div class="modal-header"><h5 class="modal-title">Tambah Software</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input name="name" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
        </form>
    </div>
</div>

<div class="modal fade" id="modalEdit" tabindex="-1">
    <div class="modal-dialog">
        <form id="editForm" method="POST" class="modal-content">
            @csrf @method('PUT')
            <div class="modal-header"><h5 class="modal-title">Edit Software</h5></div>
            <div class="modal-body">
                <div class="mb-3">
                    <label class="form-label">Nama</label>
                    <input name="name" id="editName" class="form-control" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Deskripsi</label>
                    <textarea name="description" id="editDesc" class="form-control" rows="3"></textarea>
                </div>
            </div>
            <div class="modal-footer"><button type="submit" class="btn btn-success">Update</button></div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const modalEdit = new bootstrap.Modal(document.getElementById('modalEdit'));
        
        document.querySelectorAll('.edit-btn').forEach(btn => {
            btn.addEventListener('click', function() {
                document.getElementById('editForm').action = `{{ url('admin/tools') }}/${this.dataset.id}`;
                document.getElementById('editName').value = this.dataset.name;
                document.getElementById('editDesc').value = this.dataset.desc;
                modalEdit.show();
            });
        });
    });
</script>
@endpush