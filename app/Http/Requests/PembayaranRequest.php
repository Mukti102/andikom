<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PembayaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Ubah ke true agar request diizinkan
        return true; 
    }

    public function rules(): array
    {
        return [
            'tagihan_id'    => 'required|exists:tagihans,id',
            'angsuran_ke'   => 'required|integer',
            'nominal'       => 'required|numeric',
            'tanggal_bayar' => 'required|date',
            'bukti_bayar'   => 'required|image|mimes:jpeg,png,jpg|max:2048', // Maks 2MB
        ];
    }

    public function messages(): array
    {
        return [
            'bukti_bayar.required' => 'Bukti pembayaran wajib diunggah.',
            'bukti_bayar.image'    => 'File harus berupa gambar.',
            'bukti_bayar.max'      => 'Ukuran gambar maksimal 2MB.',
        ];
    }
}