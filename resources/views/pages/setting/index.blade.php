@extends('layouts.app')
@section('title', 'Setting')
@section('content')
    <div class="container-fluid py-4">
        <div class="row">
            <div class="col-12">
                <h4 class="fw-bold mb-4">Pengaturan Sistem</h4>

                <form action="{{ route('setting.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="card shadow-sm border-0">
                        <div class="card-header  p-0 border-bottom-0">
                            {{-- Nav Tabs --}}
                            <ul class="nav nav-tabs px-3 pt-2" id="settingTab" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link active fw-semibold" id="umum-tab" data-bs-toggle="tab"
                                        data-bs-target="#umum" type="button" role="tab">
                                        <i class="fas fa-info-circle me-1"></i> Umum
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" id="kontak-tab" data-bs-toggle="tab"
                                        data-bs-target="#kontak" type="button" role="tab">
                                        <i class="fas fa-address-book me-1"></i> Kontak
                                    </button>
                                </li>
                                <li class="nav-item" role="presentation">
                                    <button class="nav-link fw-semibold" id="sosmed-tab" data-bs-toggle="tab"
                                        data-bs-target="#sosmed" type="button" role="tab">
                                        <i class="fas fa-share-alt me-1"></i> Sosial Media
                                    </button>
                                </li>
                            </ul>
                        </div>

                        <div class="card-body p-4">
                            {{-- Tab Content --}}
                            <div class="tab-content" id="settingTabContent">

                                {{-- Tab Umum --}}
                                <div class="tab-pane fade show active" id="umum" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-8">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nama Lembaga</label>
                                                <input type="text" name="site_name" class="form-control"
                                                    value="{{ $settings['site_name'] ?? '' }}"
                                                    placeholder="Masukkan nama lembaga">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Deskripsi Singkat</label>
                                                <textarea name="site_description" class="form-control" rows="3">{{ $settings['site_description'] ?? '' }}</textarea>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label">Logo Website</label>
                                                @if (!empty($settings['site_logo']))
                                                    <div class="mb-2">
                                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}"
                                                            width="150" class="img-thumbnail">
                                                    </div>
                                                @endif
                                                <input type="file" name="site_logo" class="form-control">
                                                <small class="text-muted">Format: PNG, JPG, WebP (Max: 2MB)</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab Kontak --}}
                                <div class="tab-pane fade" id="kontak" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Email Kontak</label>
                                                <input type="email" name="contact_email" class="form-control"
                                                    value="{{ $settings['contact_email'] ?? '' }}">
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Nomor WhatsApp</label>
                                                <input type="text" name="whatsapp_number" class="form-control"
                                                    value="{{ $settings['whatsapp_number'] ?? '' }}"
                                                    placeholder="Contoh: 628123456789">
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Alamat Instansi</label>
                                                <textarea name="address" class="form-control" rows="4">{{ $settings['address'] ?? '' }}</textarea>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                {{-- Tab Sosmed --}}
                                <div class="tab-pane fade" id="sosmed" role="tabpanel">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Instagram URL</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="fab fa-instagram"></i></span>
                                                    <input type="text" name="instagram_url" class="form-control"
                                                        value="{{ $settings['instagram_url'] ?? '' }}">
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label class="form-label fw-bold">Facebook URL</label>
                                                <div class="input-group">
                                                    <span class="input-group-text bg-light"><i
                                                            class="fab fa-facebook"></i></span>
                                                    <input type="text" name="facebook_url" class="form-control"
                                                        value="{{ $settings['facebook_url'] ?? '' }}">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div> {{-- End Tab Content --}}

                            <hr class="mt-4">
                            <div class="d-flex justify-content-end">
                                <button type="submit" class="btn btn-primary px-5 shadow-sm">
                                    <i class="fas fa-save me-1"></i> Simpan Semua Perubahan
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <style>
        .nav-tabs .nav-link {
            border: none;
            padding: 1rem 1.5rem;
        }

        .nav-tabs .nav-link.active {
            color: #4361ee;
            border-bottom: 3px solid #4361ee;
            background: none;
        }

        .card {
            border-radius: 12px;
        }
    </style>
@endsection
