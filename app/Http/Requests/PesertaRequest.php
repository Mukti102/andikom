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

            'status_aktif'          => 'nullable|boolean'
        ];
    }

    /**
     * Custom error messages (Opsional).
     */
    public function messages(): array
    {
        return [
            'nis.unique' => 'Nomor Induk Siswa (NIS) sudah terdaftar.',
            'user_id.required' => 'Wajib memilih akun user untuk profil ini.',
            'jenis_kelamin.in' => 'Pilihan jenis kelamin tidak valid.',
        ];
    }
}
