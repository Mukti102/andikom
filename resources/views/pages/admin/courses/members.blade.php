@extends('layouts.app')
@section('title', 'Pendaftar Kursus ' . $course->name_paket)

@section('content')
    <section class="section">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title">Data Pendaftaran Peserta</h5>
                <button class="btn btn-primary btn-tambah">
                    <i class="bi bi-plus-circle"></i> Tambah Pendaftaran
                </button>
            </div>
            <div class="card-body">
                <table class="table table-striped" id="table1">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Peserta</th>
                            <th>Tgl Daftar</th>
                            <th>Metode</th>
                            <th>Status</th>
                            <th>Status Pembayaran</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($course->pendaftarans as $p)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>
                                    <span class="fw-bold">{{ $p->peserta->nama_lengkap }}</span><br>
                                    <small class="text-muted">NIS: {{ $p->peserta->nis }}</small>
                                </td>
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
                                    @php
                                        $totalBiaya = $p->course->jumlah_total;
                                        // Hitung total nominal tagihan yang sudah statusnya 'paid'
                                        $totalTerbayar = $p->tagihans->where('status', 'paid')->sum('nominal');
                                        $persentase = $totalBiaya > 0 ? ($totalTerbayar / $totalBiaya) * 100 : 0;
                                    @endphp

                                    <div class="progress mb-1" style="height: 10px;">
                                        <div class="progress-bar {{ $persentase == 100 ? 'bg-success' : 'bg-primary' }}"
                                            role="progressbar" style="width: {{ $persentase }}%;"
                                            aria-valuenow="{{ $persentase }}" aria-valuemin="0" aria-valuemax="100">
                                        </div>
                                    </div>

                                    <small>
                                        <strong>Rp {{ number_format($totalTerbayar, 0, ',', '.') }}</strong> /
                                        Rp {{ number_format($totalBiaya, 0, ',', '.') }}
                                        ({{ number_format($persentase, 0) }}%)
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group">
                                        <a href="{{ route('admin.tagihans', $p->id) }}"
                                            class="btn btn-sm btn-outline-info">
                                            <i class="bi bi-credit-card"></i>
                                        </a>
                                        <button class="btn btn-sm btn-outline-warning btn-edit"
                                            data-id="{{ $p->id }}" data-json="{{ json_encode($p) }}">
                                            <i class="bi bi-pencil"></i>
                                        </button>
                                        <button class="btn btn-sm btn-outline-danger btn-delete"
                                            data-id="{{ $p->id }}">
                                            <i class="bi bi-trash"></i>
                                        </button>
                                    </div>
                                    <form id="delete-form-{{ $p->id }}"
                                        action="{{ route('admin.pendaftaran.destroy', $p->id) }}" method="POST"
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

    <div class="modal fade" id="pendaftaranModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <form id="pendaftaranForm" action="" method="POST">
                    @csrf
                    <div id="methodField"></div>
                    <div class="modal-header">
                        <h5 class="modal-title" id="modalTitle">Tambah Pendaftaran</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body">
                        <input type="hidden" name="course_id" value="{{ $course->id }}">

                        <x-form-select label="Peserta" name="peserta_id" :options="$pesertas" required />
                        <x-form-input label="Tanggal Daftar" name="tanggal_daftar" type="date"
                            value="{{ date('Y-m-d') }}" required />
                        <x-form-select label="Metode Bayar" name="metode_bayar" :options="['lunas' => 'Lunas', 'cicil' => 'Cicil']" />
                        <x-form-select label="Status" name="status" :options="['aktif' => 'Aktif', 'nonaktif' => 'Nonaktif']" />
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Data</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        const modal = new bootstrap.Modal(document.getElementById('pendaftaranModal'));
        const form = document.getElementById('pendaftaranForm');

        // Fungsi buka modal Tambah
        document.querySelector('.btn-tambah').addEventListener('click', () => {
            form.action = "{{ route('admin.pendaftaran.store') }}";
            document.getElementById('methodField').innerHTML = ''; // Reset method
            document.getElementById('modalTitle').innerText = 'Tambah Pendaftaran';
            modal.show();
        });

        // Fungsi buka modal Edit
        document.querySelectorAll('.btn-edit').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const data = JSON.parse(this.getAttribute('data-json')); // Ambil data dari tombol

                form.action = "/admin/pendaftaran/" + id;
                document.getElementById('methodField').innerHTML = '@method('PUT')';
                document.getElementById('modalTitle').innerText = 'Edit Pendaftaran';

                // Isi input sesuai data
                form.querySelector('[name="peserta_id"]').value = data.peserta_id;
                form.querySelector('[name="tanggal_daftar"]').value = data.tanggal_daftar;
                form.querySelector('[name="metode_bayar"]').value = data.metode_bayar;
                form.querySelector('[name="status"]').value = data.status;

                modal.show();
            });
        });
    </script>
@endpush
