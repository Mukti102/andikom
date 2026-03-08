<div class="modal fade" id="detailModal{{ $pendaftaran->id }}" tabindex="-1">
    <div class="modal-dialog modal-lg"> <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detail Peserta: {{ $pendaftaran->peserta->nama_lengkap }}</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-md-6">
                        <h6>Data Pribadi</h6>
                        <hr>
                        <p><strong>NIS:</strong> {{ $pendaftaran->peserta->nis }}</p>
                        <p><strong>Nama Panggilan:</strong> {{ $pendaftaran->peserta->nama_panggilan ?? '-' }}</p>
                        <p><strong>TTL:</strong> {{ $pendaftaran->peserta->tempat_lahir }}, {{ $pendaftaran->peserta->tanggal_lahir }}</p>
                        <p><strong>Gender:</strong> {{ $pendaftaran->peserta->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                        <p><strong>Agama:</strong> {{ $pendaftaran->peserta->agama }}</p>
                        <p><strong>Alamat:</strong> {{ $pendaftaran->peserta->alamat_sekarang }}</p>
                    </div>
                    <div class="col-md-6">
                        <h6>Data Keluarga & Lainnya</h6>
                        <hr>
                        <p><strong>Nama Ayah:</strong> {{ $pendaftaran->peserta->nama_ayah }}</p>
                        <p><strong>Nama Ibu:</strong> {{ $pendaftaran->peserta->nama_ibu }}</p>
                        <p><strong>HP Orang Tua:</strong> {{ $pendaftaran->peserta->hp_orang_tua }}</p>
                        <p><strong>Status Tinggal:</strong> {{ $pendaftaran->peserta->status_tempat_tinggal }}</p>
                        <p><strong>No HP Siswa:</strong> {{ $pendaftaran->peserta->no_hp }}</p>
                        <p><strong>Asal Sekolah:</strong> {{ $pendaftaran->peserta->asal_sekolah ?? '-' }}</p>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
            </div>
        </div>
    </div>
</div>