@extends('layouts.app')
@section('title', 'Profile')

@section('content')
    <div class="container py-5">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-md-8">
                {{-- Update Profile Information --}}
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold">Profile Information</h5>
                    <p class="text-muted small">Update your account's profile information and email address.</p>

                    {{-- Bagian Avatar --}}
                    <div class="d-flex align-items-center mb-4">
                        <div class="me-3">
                            @if ($user->avatar)
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="Avatar"
                                    class="rounded-circle shadow-sm" style="width: 80px; height: 80px; object-fit: cover;">
                            @else
                                <div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center text-white"
                                    style="width: 80px; height: 80px;">
                                    {{ substr($user->name, 0, 1) }}
                                </div>
                            @endif
                        </div>
                        <div>
                            <h6 class="mb-0">{{ $user->name }}</h6>
                            <small class="text-muted">{{ $user->email }}</small>
                        </div>
                    </div>

                    <form action="{{ route('profile.update') }}" enctype="multipart/form-data" method="POST">
                        @csrf
                        @method('patch')

                        <div class="mb-3">
                            <label class="form-label">Name</label>
                            <input type="text" name="name" class="form-control" value="{{ old('name', $user->name) }}"
                                required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $user->email) }}" required>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Update Photo</label>
                            <input type="file" name="avatar" class="form-control">
                        </div>

                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>

                {{-- Update Password --}}
                <div class="card border-0 shadow-sm p-4 mb-4">
                    <h5 class="fw-bold">Update Password</h5>
                    <p class="text-muted small">Ensure your account is using a long, random password to stay secure.</p>
                    <form action="{{ route('password.update') }}" method="POST">
                        @csrf
                        @method('put')
                        <div class="mb-3">
                            <label class="form-label">Current Password</label>
                            <input type="password" name="current_password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">New Password</label>
                            <input type="password" name="password" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" name="password_confirmation" class="form-control" required>
                        </div>
                        <button type="submit" class="btn btn-primary">Save</button>
                    </form>
                </div>

                {{-- Delete Account --}}
                <div class="card border-0 shadow-sm p-4 border-danger">
                    <h5 class="fw-bold text-danger">Delete Account</h5>
                    <p class="text-muted small">Once your account is deleted, all of its resources and data will be
                        permanently deleted.</p>
                    <button type="button" class="btn btn-danger" data-bs-toggle="modal"
                        data-bs-target="#confirmDeleteModal">Delete Account</button>
                </div>

            </div>
        </div>
    </div>


    @if (auth()->user()->peserta)
        <form action="{{ route('peserta.update', auth()->user()->peserta->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="row">
                {{-- Data Identitas --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-person-badge me-2"></i>Data Identitas</h5>
                        </div>
                        <div class="card-body">
                            <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                            <x-form-input label="NIS" name="nis" value="{{ auth()->user()->peserta->nis }}"
                                readonly />
                            <x-form-input label="Nama Lengkap" name="nama_lengkap"
                                value="{{ auth()->user()->peserta->nama_lengkap }}" required />
                            <x-form-input label="Nama Panggilan" name="nama_panggilan"
                                value="{{ auth()->user()->peserta->nama_panggilan }}" />
                            <x-form-select label="Agama" name="agama" required :options="[
                                'Islam' => 'Islam',
                                'Kristen' => 'Kristen',
                                'Katolik' => 'Katolik',
                                'Hindu' => 'Hindu',
                                'Buddha' => 'Buddha',
                                'Khonghucu' => 'Khonghucu',
                            ]" :selected="auth()->user()->peserta->agama" />

                            <div class="row">
                                <div class="col-md-6"><x-form-input label="Tempat Lahir" name="tempat_lahir"
                                        value="{{ auth()->user()->peserta->tempat_lahir }}" required /></div>
                                <div class="col-md-6"><x-form-input label="Tanggal Lahir" name="tanggal_lahir"
                                        type="date" value="{{ auth()->user()->peserta->tanggal_lahir }}" required />
                                </div>
                            </div>
                            <x-form-select label="Jenis Kelamin" name="jenis_kelamin" required :options="['L' => 'Laki-laki', 'P' => 'Perempuan']"
                                :selected="auth()->user()->peserta->jenis_kelamin" />
                        </div>
                    </div>
                </div>

                {{-- Kontak & Domisili --}}
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-geo-alt me-2"></i>Kontak & Domisili</h5>
                        </div>
                        <div class="card-body">
                            <x-form-input label="Nomor HP / WhatsApp" name="no_hp"
                                value="{{ auth()->user()->peserta->no_hp }}" required />
                            <x-form-input label="Asal Sekolah" name="asal_sekolah"
                                value="{{ auth()->user()->peserta->asal_sekolah }}" />

                            <div class="form-group mb-3">
                                <label class="form-label">Alamat Lengkap</label>
                                <textarea name="alamat_sekarang" class="form-control" rows="3" required>{{ auth()->user()->peserta->alamat_sekarang }}</textarea>
                            </div>

                            <x-form-select label="Status Tempat Tinggal" name="status_tempat_tinggal" required
                                :options="[
                                    'Ikut Orang Tua' => 'Ikut Orang Tua',
                                    'Saudara' => 'Saudara',
                                    'Kost' => 'Kost',
                                ]" :selected="auth()->user()->peserta->status_tempat_tinggal" />
                        </div>
                    </div>
                </div>

                {{-- Data Orang Tua --}}
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <h5><i class="bi bi-people me-2"></i>Data Orang Tua / Wali</h5>
                        </div>
                        <div class="card-body row">
                            <div class="col-md-4"><x-form-input label="Nama Ayah" name="nama_ayah"
                                    value="{{ auth()->user()->peserta->nama_ayah }}" required /></div>
                            <div class="col-md-4"><x-form-input label="Nama Ibu" name="nama_ibu"
                                    value="{{ auth()->user()->peserta->nama_ibu }}" required /></div>
                            <div class="col-md-4"><x-form-input label="No. HP Orang Tua" name="hp_orang_tua"
                                    value="{{ auth()->user()->peserta->hp_orang_tua }}" required /></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mb-5 d-flex justify-content-end">
                <button type="submit" class="btn btn-primary px-4">Simpan Perubahan</button>
            </div>
        </form>
    @endif

    {{-- Modal Confirmation Delete --}}
    <div class="modal fade" id="confirmDeleteModal" tabindex="-1">
        <div class="modal-dialog">
            <form action="{{ route('profile.destroy') }}" method="POST" class="modal-content">
                @csrf
                @method('delete')
                <div class="modal-header">
                    <h5 class="modal-title">Are you sure?</h5>
                </div>
                <div class="modal-body">
                    <p>Please enter your password to confirm you would like to permanently delete your account.</p>
                    <input type="password" name="password" class="form-control" placeholder="Password" required>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete Account</button>
                </div>
            </form>
        </div>
    </div>
@endsection
