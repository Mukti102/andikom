@extends('layouts.app')
@section('title', 'Detail Peserta')

@section('content')
    <section class="section">
        <div class="section-header">
            <h1>Detail Peserta: {{ $peserta->nama_lengkap }}</h1>
        </div>

        <div class="section-body">
            <div class="row">
                <div class="col-12 col-md-12 col-lg-4">
                    <div class="card p-0 overflow-hidden">
                        <div class="card-header bg-primary" style="height: 80px;"></div>

                        <div class="card-body text-center" style="margin-top: -50px;">
                            <div class="mb-3">
                                <img alt="image"
                                    src="{{ $peserta->documents?->{'pas-photo'} ? asset('storage/' . $peserta->documents->{'pas-photo'}) : asset('assets/img/avatar/avatar-1.png') }}"
                                    class="rounded-circle img-thumbnail shadow-sm"
                                    style="width: 120px; height: 120px; object-fit: cover; border: 4px solid #fff;">
                            </div>

                            <h5 class="font-weight-bold mb-0">{{ $peserta->nama_lengkap }}</h5>
                            <p class="text-muted">{{ $peserta->nama_panggilan ?? '-' }}</p>

                            <div class="row border-top border-bottom py-3 my-3">
                                <div class="col-6 border-right">
                                    <small class="text-muted d-block">NIS</small>
                                    <span class="font-weight-bold">{{ $peserta->nis }}</span>
                                </div>
                                <div class="col-6">
                                    <small class="text-muted d-block">Status</small>
                                    <span class="badge {{ $peserta->status_aktif ? 'bg-success' : 'bg-danger' }}">
                                        {{ $peserta->status_aktif ? 'Aktif' : 'Non-Aktif' }}
                                    </span>
                                </div>
                            </div>

                            <p class="mb-4">
                                <i class="fas fa-user-circle mr-1 text-primary"></i>
                                Akun: <strong>{{ $peserta->user->name ?? 'N/A' }}</strong>
                            </p>
                        </div>

                        <div class="card-footer bg-light text-center border-top-0">
                            <div class="btn-group-vertical w-100">
                               @if (!$peserta->status_aktif)
    <button type="button" class="btn btn-success mb-2 shadow-sm btn-block" 
            data-bs-toggle="modal" data-bs-target="#confirmModal">
        <i class="fas fa-check-circle"></i> Konfirmasi Peserta
    </button>
@endif
                                <div class="btn-group w-100">
                                    <a href="{{ route('admin.peserta.index') }}" class="btn btn-secondary shadow-sm">
                                        <i class="fas fa-arrow-left"></i> Kembali
                                    </a>
                                    <a href="{{ route('admin.peserta.edit', $peserta->id) }}"
                                        class="btn btn-primary shadow-sm">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="card mt-4">
                        <div class="card-header">
                            <h4>Dokumen Pendukung</h4>
                        </div>
                        <div class="card-body">
                            <ul class="list-group">
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    Kartu Keluarga
                                    <a href="{{ asset('storage/' . $peserta->documents->kartu_keluarga) }}" target="_blank"
                                        class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Lihat</a>
                                </li>
                                <li class="list-group-item d-flex justify-content-between align-items-center">
                                    KTP / Akte
                                    <a href="{{ asset('storage/' . $peserta->documents?->{'ktp-akte'}) }}" target="_blank"
                                        class="btn btn-sm btn-info"><i class="fas fa-eye"></i> Lihat</a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="col-12 col-md-12 col-lg-8">
                    <div class="card">
                        <div class="card-header">
                            <h4>Informasi Pribadi</h4>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Email</label>
                                    <p class="form-control-static">{{ $peserta->user->email }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Tempat, Tanggal Lahir</label>
                                    <p class="form-control-static">{{ $peserta->tempat_lahir }},
                                        {{ \Carbon\Carbon::parse($peserta->tanggal_lahir)->format('d F Y') }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Jenis Kelamin</label>
                                    <p class="form-control-static">
                                        {{ $peserta->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Agama</label>
                                    <p class="form-control-static">{{ $peserta->agama }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>No. HP</label>
                                    <p class="form-control-static">{{ $peserta->no_hp }}</p>
                                </div>
                                <div class="form-group col-12">
                                    <label>Alamat Sekarang</label>
                                    <p class="form-control-static">{{ $peserta->alamat_sekarang }}</p>
                                </div>
                            </div>

                            <hr>
                            <h4 class="mt-4">Data Keluarga & Pendidikan</h4>
                            <div class="row">
                                <div class="form-group col-md-6">
                                    <label>Nama Ayah</label>
                                    <p class="form-control-static">{{ $peserta->nama_ayah }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Nama Ibu</label>
                                    <p class="form-control-static">{{ $peserta->nama_ibu }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>HP Orang Tua</label>
                                    <p class="form-control-static">{{ $peserta->hp_orang_tua }}</p>
                                </div>
                                <div class="form-group col-md-6">
                                    <label>Asal Sekolah</label>
                                    <p class="form-control-static">{{ $peserta->asal_sekolah ?? '-' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>


    </section>
    <div class="modal fade" id="confirmModal" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="confirmModalLabel">Konfirmasi Pendaftaran</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form action="{{ route('admin.peserta.verifikasi', $peserta->id) }}" method="POST">
                @csrf
                @method('PATCH')
                <div class="modal-body text-center py-4">
                    <i class="fas fa-exclamation-circle text-warning mb-3" style="font-size: 3rem;"></i>
                    <p class="mb-0">Apakah Anda yakin ingin mengonfirmasi pendaftaran:</p>
                    <h5 class="font-weight-bold">{{ $peserta->nama_lengkap }}</h5>
                    <p class="text-muted small mt-2">Status akan diubah menjadi Aktif dan sistem akan mengirim email notifikasi.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-light-secondary" data-bs-dismiss="modal">
                        <i class="bx bx-x d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Batal</span>
                    </button>
                    <button type="submit" class="btn btn-success ms-1">
                        <i class="bx bx-check d-block d-sm-none"></i>
                        <span class="d-none d-sm-block">Ya, Konfirmasi</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

