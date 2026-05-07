<?php

namespace App\Http\Requests;

use App\Models\Course;
use App\Models\Pendaftaran;
use Illuminate\Foundation\Http\FormRequest;

class PendaftaranRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
{
    return [
        'peserta_id'     => 'required|exists:peserta,id',
        'tanggal_daftar' => 'required|date',
        'metode_bayar'   => 'required|in:lunas,cicil',
        'status'         => 'required|in:aktif,nonaktif',
        'course_id'      => [
            'required',
            'exists:courses,id',
            function ($attribute, $value, $fail) {
                $kursus = \App\Models\Course::find($value);
                if (!$kursus) return;

                // Mendapatkan ID dari route (untuk handle update)
                // Jika route Anda: /pendaftaran/{id}, maka gunakan 'id' atau 'pendaftaran'
                $currentId = $this->route('pendaftaran') ?? $this->route('id');

                // 1. CEK DUPLIKASI
                $sudahDaftar = \App\Models\Pendaftaran::where('course_id', $value)
                    ->where('peserta_id', $this->peserta_id)
                    ->where('status', 'aktif')
                    ->when($currentId, function ($q) use ($currentId) {
                        return $q->where('id', '!=', $currentId);
                    })
                    ->exists();

                if ($sudahDaftar) {
                    $fail('Peserta ini sudah terdaftar aktif di kursus ini.');
                }

                // 2. CEK KUOTA
                $pendaftarAktif = \App\Models\Pendaftaran::where('course_id', $value)
                    ->where('status', 'aktif')
                    ->when($currentId, function ($q) use ($currentId) {
                        return $q->where('id', '!=', $currentId);
                    })
                    ->count();

                if ($pendaftarAktif >= $kursus->max_slot) {
                    $fail('Maaf, slot untuk kursus "' . $kursus->name_paket . '" sudah penuh.');
                }
            },
        ],
    ];
}
}