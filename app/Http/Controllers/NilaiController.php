<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pendaftaran;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

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

    private function generateNomorSertifikat($pendaftaran_id)
    {
        $tahun = date('Y');
        // Format: ID-PEND-TAHUN (Contoh: 102-SK/2026)
        return str_pad($pendaftaran_id, 3, '0', STR_PAD_LEFT) . '/SK/' . $tahun;
    }

    public function cetak($id)
    {
        $pendaftaran = Pendaftaran::with(['peserta', 'nilai.details.tool', 'course'])->findOrFail($id);

        return view('pages.cetak.sertifikat', compact('pendaftaran'));
    }
}
