@extends('layouts.app')
@section('title', 'Manajemen Pengumuman')

@section('content')
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="fw-bold ">📢 Pengumuman Global</h4>
            <button class="btn btn-primary rounded-pill px-4 shadow-sm" data-bs-toggle="modal" data-bs-target="#addModal">
                <i class="bi bi-plus-lg me-1"></i> Buat Baru
            </button>
        </div>

        <div class="card border-0 shadow-sm rounded-4">
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover align-middle mb-0">
                        <thead class="">
                            <tr>
                                <th class="ps-4 py-3">Tipe</th>
                                <th>Judul</th>
                                <th>Pesan</th>
                                <th>Tanggal</th>
                                <th class="text-center pe-4">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($announcements as $item)
                                <tr id="row-{{ $item->id }}">
                                    <td class="ps-4">
                                        <span
                                            class="badge bg-{{ $item->type }} bg-opacity-10 text-{{ $item->type }} rounded-pill px-3">
                                            {{ strtoupper($item->type) }}
                                        </span>
                                    </td>
                                    <td class="fw-bold ">{{ $item->title }}</td>
                                    <td><small class="text-secondary">{{ Str::limit($item->message, 50) }}</small></td>
                                    <td>{{ $item->created_at->format('d M Y') }}</td>
                                    <td class="text-center pe-4">
                                        <form id="delete-form-{{ $item->id }}"
                                            action="{{ route('admin.announcment.destroy', $item->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="button"
                                                class="btn btn-light btn-sm rounded-circle p-2 text-danger"
                                                onclick="confirmDelete({{ $item->id }})">
                                                <i class="bi bi-trash"></i>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center py-5 text-muted">Belum ada pengumuman aktif.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg rounded-4">
                <div class="modal-header border-0 pt-4 px-4">
                    <h5 class="fw-bold">Buat Pengumuman</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form action="{{ route('admin.announcment.store') }}" method="POST">
                    @csrf
                    <div class="modal-body p-4">
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Judul</label>
                            <input type="text" name="title" class="form-control rounded-3" required
                                placeholder="Judul singkat...">
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Kategori Warna</label>
                            <select name="type" class="form-select rounded-3">
                                <option value="info">Info (Biru)</option>
                                <option value="warning">Peringatan (Kuning)</option>
                                <option value="danger">Penting (Merah)</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label small fw-bold">Isi Pesan</label>
                            <textarea name="message" class="form-control rounded-3" rows="4" required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer border-0 p-4 pt-0">
                        <button type="submit" class="btn btn-primary w-100 rounded-pill py-2">Sebarkan Sekarang</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection

<script>
    function confirmDelete(id) {
        Swal.fire({
            title: 'Hapus Pengumuman?',
            text: "Data yang dihapus tidak dapat dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                // Submit form berdasarkan ID yang diklik
                document.getElementById(`delete-form-${id}`).submit();
            }
        });
    }
</script>