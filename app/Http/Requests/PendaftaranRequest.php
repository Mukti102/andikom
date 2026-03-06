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
            'tanggal_daftar' => 'required',
            'metode_bayar'   => 'required|in:lunas,cicil',
            'status'         => 'required|in:aktif,nonaktif',
            'course_id'      => [
                'required',
                'exists:courses,id',
                function ($attribute, $value, $fail) {
                    $kursus = Course::find($value);
                    
                    // Mendapatkan ID pendaftaran yang sedang diedit (jika ada)
                    // Pastikan route parameter Anda bernama 'pendaftaran'
                    $currentId = $this->route('pendaftaran');

                    // 1. CEK DUPLIKASI: Apakah peserta sudah terdaftar di kursus yang sama & aktif?
                    $queryCekDuplikat = Pendaftaran::where('course_id', $value)
                        ->where('peserta_id', $this->peserta_id)
                        ->where('status', 'aktif');

                    // Abaikan data milik sendiri saat proses update
                    if ($currentId) {
                        $queryCekDuplikat->where('id', '!=', $currentId);
                    }

                    if ($queryCekDuplikat->exists()) {
                        $fail('Peserta ini sudah terdaftar di kursus "' . ($kursus->name_paket ?? 'tersebut') . '" dengan status aktif.');
                    }

                    // 2. CEK KUOTA: Apakah slot kursus masih tersedia?
                    $queryCekKuota = Pendaftaran::where('course_id', $value)
                        ->where('status', 'aktif');

                    // Abaikan data milik sendiri saat update, agar kuota tidak double count
                    if ($currentId) {
                        $queryCekKuota->where('id', '!=', $currentId);
                    }

                    $pendaftarAktif = $queryCekKuota->count();

                    if ($kursus && $pendaftarAktif >= $kursus->max_slot) {
                        $fail('Maaf, slot untuk kursus "' . $kursus->name_paket . '" sudah penuh (' . $pendaftarAktif . '/' . $kursus->max_slot . ').');
                    }
                },
            ],
        ];
    }
}