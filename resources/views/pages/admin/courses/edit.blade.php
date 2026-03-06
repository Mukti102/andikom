@extends('layouts.app')
@section('title', 'Edit Kursus: ' . $course->name_paket)

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
            <form action="{{ route('admin.courses.update', $course->id) }}" method="POST">
                @csrf
                @method('PUT')

                <x-form-input label="Nama Paket" name="name_paket" :value="$course->name_paket" required />

                <x-form-select label="Kategori" name="category" id="categorySelect" required :options="['intensif' => 'Intensif', 'private' => 'Private']"
                    :selected="$course->category" />

                <div id="intensifFields" class="d-none">
                    <x-form-input label="Durasi (Bulan)" name="durasi_bulan" type="number" :value="$course->durasi_bulan" />
                    <x-form-input label="Pertemuan per Minggu" name="pertemuan_per_minggu" type="number"
                        :value="$course->pertemuan_per_minggu" />
                    <x-form-input label="Durasi per Pertemuan (Jam)" name="durasi_jam" type="number" :value="$course->durasi_jam" />
                </div>

                <div id="privateFields" class="d-none">
                    <x-form-input label="Jumlah Pertemuan" name="jumlah_pertemuan" type="number" :value="$course->jumlah_pertemuan" />
                </div>

                <x-form-input label="Total Harga (IDR)" name="jumlah_total" type="number" step="0.01" :value="$course->jumlah_total"
                    required />

                <div class="mb-3">
                    <label class="form-label fw-bold">Pilih Tools</label>
                    <div class="border p-3 rounded" >
                        @foreach ($tools as $tool)
                            <div class="form-check">
                                <input class="form-check-input" type="checkbox" name="tools[]" value="{{ $tool->id }}"
                                    id="tool_{{ $tool->id }}"
                                    {{ $course->tools->contains($tool->id) ? 'checked' : '' }}>
                                <label class="form-check-label" for="tool_{{ $tool->id }}">
                                    {{ $tool->name }}
                                </label>
                            </div>
                        @endforeach
                    </div>
                </div>

                <x-form-input label="Max Slot" name="max_slot" type="number" step="1" :value="$course->max_slot" required />



                <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Batal</a>
                <button type="submit" class="btn btn-warning text-white">Update Kursus</button>
            </form>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const categorySelect = document.querySelector('select[name="category"]');
            const intensifFields = document.getElementById('intensifFields');
            const privateFields = document.getElementById('privateFields');
            // Deklarasikan variabel di sini agar bisa diakses di seluruh scope DOMContentLoaded
            const maxSlotInput = document.querySelector('input[name="max_slot"]');

            function toggleFields(value) {
                // Cek apakah elemen ditemukan sebelum memanipulasi
                if (!maxSlotInput) return;

                if (value === 'intensif') {
                    maxSlotInput.readOnly = false;
                    intensifFields.classList.remove('d-none');
                    privateFields.classList.add('d-none');
                } else if (value === 'private') {
                    maxSlotInput.value = 1;
                    maxSlotInput.readOnly = true;
                    privateFields.classList.remove('d-none');
                    intensifFields.classList.add('d-none');
                } else {
                    intensifFields.classList.add('d-none');
                    privateFields.classList.add('d-none');
                }
            }

            if (categorySelect) {
                // Jalankan saat load
                toggleFields(categorySelect.value);

                // Jalankan saat berubah
                categorySelect.addEventListener('change', function() {
                    toggleFields(this.value);
                });
            }
        });
    </script>
@endpush
