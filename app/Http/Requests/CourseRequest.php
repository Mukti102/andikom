<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CourseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Pastikan ubah ke true
    }

    public function rules(): array
    {
        return [
            'name_paket'           => 'required|string|max:255',
            'category'             => 'required|in:private,intensif',
            'jumlah_total'         => 'required|numeric',
            'max_slot'             => 'required|integer',
            'thumbnail' => [
                'required',
                'image',
                'mimes:jpeg,png,jpg,webp',
                'mimetypes:image/jpeg,image/png,image/jpg,image/webp', // Menambahkan MIME eksplisit
                'max:2048'
            ],

            // durasi_jam wajib diisi untuk KEDUANYA
            'durasi_jam'           => 'required|integer',

            // Field khusus Intensif
            'durasi_bulan'         => 'required_if:category,intensif|nullable|integer',
            'pertemuan_per_minggu' => 'required_if:category,intensif|nullable|integer',

            // tools
            'tools'                => 'nullable|array',
            'tools.*'              => 'exists:tools,id',
            // Field khusus Private
            'jumlah_pertemuan'     => 'required_if:category,private|nullable|integer',
        ];
    }
}
