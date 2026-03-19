@extends('layouts.app')
@section('title', 'Tambah Peserta Baru')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('admin.peserta.store') }}" enctype="multipart/form-data" method="POST">
        @csrf
        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-person-badge me-2"></i>Data Identitas</h5>
                    </div>
                    <div class="card-body">
                        {{-- pilih user id --}}
                        <x-form-select label="Pilih Akun User" name="user_id" required :options="$users" />
                        <x-form-input label="NIS (Nomor Induk Siswa)" name="nis" required
                            placeholder="Contoh: 2024001" />
                        <x-form-input label="Nama Lengkap" name="nama_lengkap" required />
                        <x-form-input label="Nama Panggilan" name="nama_panggilan" />
                        <x-form-select label="Agama" name="agama" required :options="[
                            'Islam' => 'Islam',
                            'Kristen' => 'Kristen',
                            'Katolik' => 'Katolik',
                            'Hindu' => 'Hindu',
                            'Buddha' => 'Buddha',
                            'Khonghucu' => 'Khonghucu',
                        ]" />
                        <div class="row">
                            <div class="col-md-6">
                                <x-form-input label="Tempat Lahir" name="tempat_lahir" required />
                            </div>
                            <div class="col-md-6">
                                <x-form-input label="Tanggal Lahir" name="tanggal_lahir" type="date" required />
                            </div>
                        </div>
                        <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required :options="['L' => 'Laki-laki', 'P' => 'Perempuan']" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-geo-alt me-2"></i>Kontak & Domisili</h5>
                    </div>
                    <div class="card-body">
                        <x-form-input label="Nomor HP / WhatsApp" name="no_hp" required placeholder="0812xxx" />
                        <x-form-input label="Asal Sekolah / Instansi" name="asal_sekolah" />
                        <div class="form-group mb-3">
                            <label class="form-label">Alamat Lengkap</label>
                            <textarea name="alamat_sekarang" class="form-control @error('alamat_sekarang') is-invalid @enderror" rows="3">{{ old('alamat_sekarang') }}</textarea>
                            @error('alamat_sekarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        <x-form-select label="Status Tempat Tinggal" name="status_tempat_tinggal" required
                            :options="['Ikut Orang Tua' => 'Ikut Orang Tua', 'Saudara' => 'Saudara', 'Kost' => 'Kost']" />
                    </div>
                </div>
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-geo-alt me-2"></i>Dokumen Berkas</h5>
                    </div>
                    <div class="card-body">
                        <x-form-input label="Foto Copy KK (1 Lembar)" type="file" name="kartu_keluarga" required />
                        <x-form-input label="Foto Copy KTP/Akte (1 Lembar)" type="file" name="ktp-akte" required />
                        <x-form-input label="Pas Foto Warna 3x4 (1 Lembar)" type="file" name="pas-photo" required />
                    </div>
                </div>
            </div>

            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-people me-2"></i>Data Orang Tua / Wali</h5>
                    </div>
                    <div class="card-body row">
                        <div class="col-md-4">
                            <x-form-input label="Nama Ayah" name="nama_ayah" required />
                        </div>
                        <div class="col-md-4">
                            <x-form-input label="Nama Ibu" name="nama_ibu" required />
                        </div>
                        <div class="col-md-4">
                            <x-form-input label="No. HP Orang Tua" name="hp_orang_tua" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5 d-flex justify-content-end">
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-light-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-primary">Simpan Data Peserta</button>
        </div>
    </form>
@endsection
