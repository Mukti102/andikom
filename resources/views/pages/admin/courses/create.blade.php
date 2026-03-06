@extends('layouts.app')
@section('title', 'Tambah Kursus Baru')

@section('content')
    <div class="card">
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form action="{{ route('admin.courses.store') }}" method="POST">
                @csrf
                <x-form-input label="Nama Paket" name="name_paket" required />

                <x-form-select label="Kategori" name="category" id="categorySelect" required :options="['intensif' => 'Intensif', 'private' => 'Private']" />

                <div id="intensifFields" class="d-none">
                    <x-form-input label="Durasi (Bulan)" name="durasi_bulan" type="number" />
                    <x-form-input label="Pertemuan per Minggu" name="pertemuan_per_minggu" type="number" />
                </div>

                <div id="privateFields" class="d-none">
                    <x-form-input label="Jumlah Pertemuan" name="jumlah_pertemuan" type="number" />
                </div>
                <x-form-input label="Durasi per Pertemuan (Jam)" name="durasi_jam" type="number" />

                <x-form-input label="Total Harga (IDR)" name="jumlah_total" type="number" step="0.01" required />
                <x-form-input label="Max Slot" name="max_slot" type="number" step="1" required />

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Tools</label>
                    <div class="border p-3 rounded">
                        @foreach ($tools as $tool)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tools[]" value="{{ $tool->id }}"
                                    id="tool_{{ $tool->id }}">
                                <label class="form-check-label" for="tool_{{ $tool->id }}">
                                    {{ $tool->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <small class="text-muted">Centang pada kotak untuk memilih tools yang dibutuhkan.</small>
                </div>

                <button type="submit" class="btn btn-primary">Simpan Kursus</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        // Gunakan fungsi defer agar script berjalan setelah semua file di-load
        document.addEventListener("DOMContentLoaded", function() {

            // Coba cari elemen select berdasarkan name, bukan ID
            const categorySelect = document.querySelector('select[name="category"]');
            const intensifFields = document.getElementById('intensifFields');
            const privateFields = document.getElementById('privateFields');

            if (categorySelect) {
                categorySelect.addEventListener('change', function() {

                    const maxSlotInput = document.querySelector('input[name="max_slot"]');
                    if (this.value === 'private') {
                        maxSlotInput.value = 1;
                        maxSlotInput.readOnly = true; // Kunci agar tidak bisa diubah
                    } else {
                        maxSlotInput.readOnly = false; // Buka kunci untuk intensif
                    }

                    if (this.value === 'intensif') {
                        intensifFields.classList.remove('d-none');
                        privateFields.classList.add('d-none');
                    } else if (this.value === 'private') {
                        privateFields.classList.remove('d-none');
                        intensifFields.classList.add('d-none');
                    } else {
                        intensifFields.classList.add('d-none');
                        privateFields.classList.add('d-none');
                    }
                });
            } else {
                console.error('Element categorySelect tidak ditemukan!');
            }
        });
    </script>
@endpush
