@extends('layouts.app')
@section('title', 'Daftar Pendaftaran Kursus')

@section('content')
<section class="section">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="card-title">Data Pendaftaran Peserta</h5>
            <a href="{{ route('admin.pendaftaran.create') }}" class="btn btn-primary">
                <i class="bi bi-plus-circle"></i> Tambah Pendaftaran
            </a>
        </div>
        <div class="card-body">
            <table class="table table-striped" id="table-pendaftaran">
                <thead>
                    <tr>
                        <th>No</th>
                        <th>Peserta</th>
                        <th>Kursus</th>
                        <th>Tgl Daftar</th>
                        <th>Metode</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($pendaftarans as $p)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>
                            <span class="fw-bold">{{ $p->peserta->nama_lengkap }}</span><br>
                            <small class="text-muted">NIS: {{ $p->peserta->nis }}</small>
                        </td>
                        <td>{{ $p->course->name_paket }}</td>
                        <td>{{ \Carbon\Carbon::parse($p->tanggal_daftar)->format('d-m-Y') }}</td>
                        <td>
                            <span class="badge {{ $p->metode_bayar == 'lunas' ? 'bg-success' : 'bg-warning' }}">
                                {{ ucfirst($p->metode_bayar) }}
                            </span>
                        </td>
                        <td>
                            <span class="badge {{ $p->status == 'aktif' ? 'bg-primary' : 'bg-secondary' }}">
                                {{ ucfirst($p->status) }}
                            </span>
                        </td>
                        <td>
                            <div class="btn-group">
                                <a href="{{ route('admin.pendaftaran.edit', $p->id) }}" class="btn btn-sm btn-outline-warning">
                                    <i class="bi bi-pencil"></i>
                                </a>
                                <button class="btn btn-sm btn-outline-danger btn-delete" data-id="{{ $p->id }}">
                                    <i class="bi bi-trash"></i>
                                </button>
                            </div>
                            <form id="delete-form-{{ $p->id }}" action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST" style="display: none;">
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



@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.querySelectorAll('.btn-delete').forEach(button => {
        button.addEventListener('click', function() {
            const id = this.getAttribute('data-id');
            Swal.fire({
                title: 'Hapus Data Pendaftaran?',
                text: "Data ini akan dihapus dari sistem!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!'
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('delete-form-' + id).submit();
                }
            });
        });
    });
</script>
@endpush
@endsection