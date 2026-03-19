<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class PesertaRequest extends FormRequest
{
    /**
     * Izinkan akses untuk request ini.
     */
    public function authorize(): bool
    {
        return true; // Ubah ke true agar request diproses
    }

    /**
     * Aturan validasi data peserta.
     */
    public function rules(): array
    {
        $pesertaId = $this->route('pesertum');

        return [
            'user_id'               => 'required|exists:users,id',
            'nis'               => [
                'required',
                'string',
                'max:50',
                Rule::unique('peserta', 'nis')->ignore($pesertaId),
            ],
            'nama_lengkap'          => 'required|string|max:255',
            'nama_panggilan'        => 'nullable|string|max:50',
            'tempat_lahir'          => 'required|string|max:100',
            'tanggal_lahir'         => 'required|date',
            'jenis_kelamin'         => 'required|in:L,P',
            'agama'                 => 'required|string|max:50',
            'alamat_sekarang'       => 'required|string',
            'pekerjaan'             => 'nullable|string|max:100',
            'no_hp'                 => 'required|string|max:20',
            'asal_sekolah'          => 'nullable|string|max:100',

            // Data Keluarga
            'nama_ayah'             => 'required|string|max:255',
            'nama_ibu'              => 'required|string|max:255',
            'hp_orang_tua'          => 'required|string|max:20',
            'status_tempat_tinggal' => 'required|string|max:100',

            'kartu_keluarga' => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'ktp-akte'       => 'required|mimes:jpg,jpeg,png,pdf|max:2048',
            'pas-photo'      => 'required|image|mimes:jpg,jpeg,png|max:1024',

            'status_aktif'          => 'nullable|boolean'
        ];
    }

    /**
     * Custom error messages (Opsional).
     */
    /**
     * Custom error messages.
     */
    public function messages(): array
    {
        return [
            // Identitas Dasar
            'user_id.required'       => 'Pilih akun pengguna terlebih dahulu.',
            'user_id.exists'         => 'Akun pengguna yang dipilih tidak terdaftar.',
            'nis.required'           => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.unique'             => 'Nomor Induk Siswa (NIS) sudah terdaftar.',
            'nama_lengkap.required'  => 'Nama lengkap wajib diisi sesuai identitas.',
            'tempat_lahir.required'  => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin.',
            'jenis_kelamin.in'       => 'Pilihan jenis kelamin tidak valid.',
            'agama.required'         => 'Agama wajib diisi.',
            'no_hp.required'         => 'Nomor HP aktif wajib diisi.',
            'alamat_sekarang.required' => 'Alamat domisili saat ini wajib diisi.',

            // Data Keluarga
            'nama_ayah.required'     => 'Nama ayah wajib diisi.',
            'nama_ibu.required'      => 'Nama ibu wajib diisi.',
            'hp_orang_tua.required'  => 'Nomor HP orang tua wajib diisi.',
            'status_tempat_tinggal.required' => 'Status tempat tinggal wajib diisi.',

            // Validasi Dokumen (File)
            'kartu_keluarga.required' => 'File Kartu Keluarga wajib diunggah.',
            'kartu_keluarga.mimes'    => 'Kartu Keluarga harus berupa format: jpg, jpeg, png, atau pdf.',
            'kartu_keluarga.max'      => 'Ukuran Kartu Keluarga maksimal adalah 2MB.',

            'ktp-akte.required'       => 'File KTP atau Akte Kelahiran wajib diunggah.',
            'ktp-akte.mimes'          => 'Format KTP/Akte harus: jpg, jpeg, png, atau pdf.',
            'ktp-akte.max'            => 'Ukuran file KTP/Akte maksimal 2MB.',

            'pas-photo.required'      => 'Pas Photo wajib diunggah.',
            'pas-photo.image'         => 'File harus berupa gambar.',
            'pas-photo.mimes'         => 'Format foto harus: jpg, jpeg, atau png.',
            'pas-photo.max'           => 'Ukuran foto terlalu besar, maksimal 1MB.',
        ];
    }
}
