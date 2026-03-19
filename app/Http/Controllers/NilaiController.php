<?php

namespace App\Http\Controllers;

use App\Mail\CertificateUploadedMail;
use App\Models\CertificateTemplate;
use App\Models\Course;
use App\Models\Nilai;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class NilaiController extends Controller
{
    public function index($id)
    {
        // Mengambil course, tools, dan pendaftar yang sudah memiliki data nilai
        $course = Course::with(['tools', 'pendaftarans.peserta', 'pendaftarans.nilai.details'])->findOrFail($id);

        return view('pages.tutor.nilai.index', compact('course'));
    }

    public function store(Request $request)
    {
        // Validasi
        $request->validate([
            'pendaftaran_id' => 'required',
            'skor' => 'required|array'
        ]);

        $nomor = $request->nomor_sertifikat ?? $this->generateNomorSertifikat($request->pendaftaran_id);

        $nilai = \App\Models\Nilai::updateOrCreate(
            ['pendaftaran_id' => $request->pendaftaran_id],
            [
                'tutor_id' => auth()->id(),
                'nomor_sertifikat' => $nomor
            ]
        );

        foreach ($request->skor as $tool_id => $skor) {
            \App\Models\NilaiDetail::updateOrCreate(
                ['nilai_id' => $nilai->id, 'tool_id' => $tool_id],
                ['skor' => $skor]
            );
        }

        return redirect()->back()->with('success', 'Nilai berhasil disimpan.');
    }

    public function store_certificate(Request $request, $id)
    {
        // 1. Cari data nilai berdasarkan ID
        $nilai = Nilai::with('pendaftaran.peserta.user')->findOrFail($id);

        // 2. Validasi input
        $request->validate([
            'nomor_sertifikat' => 'required|string|max:255',
            'file_sertifikat'  => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Batas 2MB
        ]);

        // 3. Hapus file lama jika instruktur mengunggah ulang (opsional tapi disarankan)
        if ($nilai->certificate_path && Storage::disk('public')->exists($nilai->certificate_path)) {
            Storage::disk('public')->delete($nilai->certificate_path);
        }

        // 4. Simpan file baru ke folder 'sertifikat' di disk 'public'
        if ($request->hasFile('file_sertifikat')) {
            $path = $request->file('file_sertifikat')->store('sertifikat', 'public');
            $nilai->certificate_path = $path;
        }

        // 5. Update nomor sertifikat dan simpan
        $nilai->nomor_sertifikat = $request->nomor_sertifikat;
        $nilai->save();

        // 6. Kirim Email ke Peserta (Pastikan relasi user ada)
        $user = $nilai->pendaftaran->peserta->user;
        if ($user && $user->email) {
            Mail::to($user->email)->queue(new CertificateUploadedMail($nilai));
        }

        return redirect()->back()->with('success', 'Berhasil mengupload sertifikat untuk ' . $nilai->pendaftaran->peserta->nama_lengkap);
    }

    private function generateNomorSertifikat($pendaftaran_id)
    {
        $tahun = date('Y');
        // Format: ID-PEND-TAHUN (Contoh: 102-SK/2026)
        return str_pad($pendaftaran_id, 3, '0', STR_PAD_LEFT) . '/SK/' . $tahun;
    }
}
