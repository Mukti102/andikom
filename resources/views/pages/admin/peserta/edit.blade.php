@extends('layouts.app')
@section('title', 'Edit Peserta: ' . $peserta->nama_lengkap)

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
    <form action="{{ route('peserta.update', $peserta->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-person-badge me-2"></i>Data Identitas</h5>
                    </div>
                    <div class="card-body">
                        {{-- Dropdown User dengan User yang sudah terpilih --}}
                        <x-form-select label="Hubungkan Akun User" name="user_id" required :options="$users"
                            :selected="$peserta->user_id" />

                        <x-form-input label="NIS" name="nis" :value="$peserta->nis" required />
                        <x-form-input label="Nama Lengkap" name="nama_lengkap" :value="$peserta->nama_lengkap" required />
                        <x-form-input label="Nama Panggilan" name="nama_panggilan" :value="$peserta->nama_panggilan" required />
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
                                <x-form-input label="Tempat Lahir" name="tempat_lahir" :value="$peserta->tempat_lahir" required />
                            </div>
                            <div class="col-md-6">
                                <x-form-input label="Tanggal Lahir" name="tanggal_lahir" type="date" :value="$peserta->tanggal_lahir"
                                    required />
                            </div>
                        </div>

                        <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required :options="['L' => 'Laki-laki', 'P' => 'Perempuan']"
                            :selected="$peserta->jenis_kelamin" />
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h5><i class="bi bi-geo-alt me-2"></i>Kontak & Domisili</h5>
                    </div>
                    <div class="card-body">
                        <x-form-input label="Nomor HP" name="no_hp" :value="$peserta->no_hp" required />
                        <x-form-input label="Asal Sekolah" name="asal_sekolah" :value="$peserta->asal_sekolah" />

                        <div class="form-group mb-3">
                            <label class="form-label">Alamat Sekarang</label>
                            <textarea name="alamat_sekarang" class="form-control @error('alamat_sekarang') is-invalid @enderror" rows="3">{{ old('alamat_sekarang', $peserta->alamat_sekarang) }}</textarea>
                            @error('alamat_sekarang')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                         <x-form-select label="Status Tempat Tinggal" name="status_tempat_tinggal" required
                            :options="['Ikut Orang Tua' => 'Ikut Orang Tua', 'Saudara' => 'Saudara', 'Kost' => 'Kost']" />

                        <x-form-select label="Status Aktif" name="status_aktif" required :options="['1' => 'Aktif', '0' => 'Non-Aktif']"
                            :selected="$peserta->status_aktif" />
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
                            <x-form-input label="Nama Ayah" name="nama_ayah" :value="$peserta->nama_ayah" required />
                        </div>
                        <div class="col-md-4">
                            <x-form-input label="Nama Ibu" name="nama_ibu" :value="$peserta->nama_ibu" required />
                        </div>
                        <div class="col-md-4">
                            <x-form-input label="HP Orang Tua" name="hp_orang_tua" :value="$peserta->hp_orang_tua" required />
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="mb-5 d-flex justify-content-end">
            <a href="{{ route('admin.peserta.index') }}" class="btn btn-light-secondary me-2">Batal</a>
            <button type="submit" class="btn btn-warning text-white">Update Data Peserta</button>
        </div>
    </form>
@endsection
