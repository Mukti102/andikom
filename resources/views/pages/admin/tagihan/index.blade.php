@extends('layouts.app')
@section('title', 'List Tagihan - ' . $pendaftaran->peserta->nama_lengkap)

@section('content')

    <section class="section">
        <div class="row">
            <div class="col-md-4">
                <div class="card">
                    <div class="card-body">
                        <h6>Informasi Peserta</h6>
                        <hr>
                        <p class="mb-1"><strong>Nama:</strong> {{ $pendaftaran->peserta->nama_lengkap }}</p>
                        <p class="mb-1"><strong>Kursus:</strong> {{ $pendaftaran->course->name_paket }}</p>
                        <p class="mb-1"><strong>Metode:</strong>
                            <span class="badge {{ $pendaftaran->metode_bayar == 'lunas' ? 'bg-success' : 'bg-info' }}">
                                {{ ucfirst($pendaftaran->metode_bayar) }}
                            </span>
                        </p>
                        <p class="mb-0"><strong>Total Biaya:</strong> Rp
                            {{ number_format($pendaftaran->course->jumlah_total, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>

            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title">Jadwal Pembayaran / Cicilan</h5>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-lg">
                                <thead>
                                    <tr>
                                        <th>Angsuran</th>
                                        <th>Jatuh Tempo</th>
                                        <th>Nominal</th>
                                        <th>Status</th>
                                        <th>Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pendaftaran->tagihans as $t)
                                        <tr>
                                            <td>Ke-{{ $t->angsuran_ke }}</td>
                                            <td>{{ \Carbon\Carbon::parse($t->jatuh_tempo)->translatedFormat('d F Y') }}</td>
                                            <td>Rp {{ number_format($t->nominal, 0, ',', '.') }}</td>
                                            <td>
                                                @if ($t->status == 'paid')
                                                    <span class="badge bg-success">Sudah Bayar</span>
                                                @else
                                                    <span class="badge bg-warning">Belum Bayar</span>
                                                @endif
                                            </td>
                                            <td>
                                                @php
                                                    $pembayaranPending = $t
                                                        ->pembayaran()
                                                        ->where('status_verifikasi', 'pending')
                                                        ->exists();
                                                    $pembayaran = $t->pembayaran;
                                                @endphp

                                                @if ($t->status == 'paid')
                                                    <span class="text-success font-bold"><i class="bi bi-check-circle"></i>
                                                        Lunas</span>
                                                @elseif($pembayaranPending)
                                                    @if (auth()->user()->isAdmin())
                                                        <button type="button" class="btn btn-sm btn-info btn-verifikasi"
                                                            data-id="{{ $pembayaran->id ?? '' }}"
                                                            data-nominal="{{ $pembayaran->nominal ?? 0 }}"
                                                            data-bukti="{{ $pembayaran ? asset('storage/' . $pembayaran->bukti_bayar) : '' }}">
                                                            Verifikasi
                                                        </button>
                                                    @elseif(auth()->user()->isUser())
                                                        <span class="badge bg-secondary">Menunggu Verifikasi</span>
                                                    @endif
                                                @else
                                                    <button class="btn btn-sm btn-primary btn-bayar"
                                                        data-id="{{ $t->id }}"
                                                        data-angsuran="{{ $t->angsuran_ke }}"
                                                        data-nominal="{{ $t->nominal }}">
                                                        Bayar Sekarang
                                                    </button>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center text-muted">Belum ada jadwal tagihan.</td>
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

    <div class="modal fade" id="modalVerifikasi" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Verifikasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form id="formVerifikasi" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 text-center border-end">
                                <label class="fw-bold d-block mb-2">Bukti
                                    Pembayaran</label>
                                <a href="#" id="linkBukti" target="_blank">
                                    <img src="" id="imgBukti" class="img-fluid rounded shadow-sm"
                                        style="max-height: 400px;" alt="Bukti Bayar">
                                </a>
                                <small class="text-muted d-block mt-2">Klik
                                    gambar untuk memperbesar</small>
                            </div>

                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label class="form-label fw-bold">Nominal
                                        yang Dilaporkan</label>
                                    <input type="text" id="verif_nominal" class="form-control bg-light" readonly>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label fw-bold">Keputusan</label>
                                    <select name="status_verifikasi" id="statusSelect" class="form-select" required>
                                        <option value="">-- Pilih
                                            Keputusan --</option>
                                        <option value="completed" class="text-success">✅ Setujui
                                            (Completed)
                                        </option>
                                        <option value="rejected" class="text-danger">❌ Tolak
                                            (Rejected)</option>
                                    </select>
                                </div>

                                <div id="reasonSection" class="mb-3 d-none">
                                    <label class="form-label fw-bold text-danger">Alasan
                                        Penolakan</label>
                                    <textarea name="reason" class="form-control" rows="3"
                                        placeholder="Contoh: Bukti transfer tidak terbaca atau nominal kurang."></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                        <button type="submit" class="btn btn-primary">Simpan
                            Keputusan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>


    <div class="modal fade" id="modalBayar" tabindex="-1" aria-labelledby="modalBayarLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Konfirmasi Pembayaran</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <form action="{{ route('admin.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="modal-body">
                        <input type="hidden" name="tagihan_id" id="modal_tagihan_id">

                        <div class="mb-3">
                            <label class="form-label">Angsuran Ke</label>
                            <input type="text" name="angsuran_ke" id="modal_angsuran_ke" class="form-control"
                                readonly>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Nominal Harus Dibayar</label>
                            <div class="input-group">
                                <span class="input-group-text">Rp</span>
                                <input type="number" name="nominal" id="modal_nominal" class="form-control" readonly>
                            </div>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Tanggal Bayar</label>
                            <input type="date" name="tanggal_bayar" class="form-control" value="{{ date('Y-m-d') }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Upload Bukti Bayar</label>
                            <input type="file" name="bukti_bayar" class="form-control" accept="image/*" required>
                            <small class="text-muted">Format: JPG, PNG, Max 2MB</small>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-success">Kirim Pembayaran</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const modalBayar = new bootstrap.Modal(document.getElementById('modalBayar'));

            document.querySelectorAll('.btn-bayar').forEach(button => {
                button.addEventListener('click', function() {
                    // Ambil data dari atribut tombol
                    const id = this.getAttribute('data-id');
                    const angsuran = this.getAttribute('data-angsuran');
                    const nominal = this.getAttribute('data-nominal');

                    // Isi ke dalam input modal
                    document.getElementById('modal_tagihan_id').value = id;
                    document.getElementById('modal_angsuran_ke').value = angsuran;
                    document.getElementById('modal_nominal').value = nominal;

                    // Tampilkan modal
                    modalBayar.show();
                });
            });
        });


        const modalElement = document.getElementById('modalVerifikasi');
        const modalVerifikasi = new bootstrap.Modal(modalElement);
        const formVerifikasi = document.getElementById('formVerifikasi');
        const statusSelect = document.getElementById('statusSelect');
        const reasonSection = document.getElementById('reasonSection');

        // Event saat tombol verifikasi diklik
        document.querySelectorAll('.btn-verifikasi').forEach(btn => {
            btn.addEventListener('click', function() {
                const id = this.getAttribute('data-id');
                const nominal = this.getAttribute('data-nominal');
                const bukti = this.getAttribute('data-bukti');

                // Isi form action
                formVerifikasi.action = "/admin/pembayaran/verifikasi/" + id;

                // Isi input modal
                document.getElementById('imgBukti').src = bukti;
                document.getElementById('linkBukti').href = bukti;
                document.getElementById('verif_nominal').value = "Rp " + new Intl.NumberFormat('id-ID')
                    .format(nominal);

                modalVerifikasi.show();
            });
        });

        // Toggle Alasan
        statusSelect.addEventListener('change', function() {
            if (this.value === 'rejected') {
                reasonSection.classList.remove('d-none');
            } else {
                reasonSection.classList.add('d-none');
            }
        });
    </script>
@endpush
