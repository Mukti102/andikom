<?php

namespace App\Http\Controllers;

use App\Models\CertificateTemplate;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateTemplateController extends Controller
{
    public function index()
    {
        $certificates = CertificateTemplate::with('course')->get();
        $courses = Course::all();
        return view('pages.admin.certificates.index', compact('certificates', 'courses'));
    }

    public function store(Request $request)
    {
        // Tambahkan validasi agar tidak error saat file kosong
        $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required',
            'background' => 'required|image|mimes:jpg,jpeg,png|max:5120', // Maks 5MB
        ]);

        $file = $request->file('background')->store('certificates', 'public');

        CertificateTemplate::create([
            'name' => $request->name,
            'course_id' => $request->course_id,
            'background' => $file
        ]);

        return redirect()->back()->with('success', 'Berhasil Menambahkan Template');
    }


    public function builder($id)
    {
        $template = CertificateTemplate::find($id);
        return view('pages.admin.certificates.builder', compact('template'));
    }

    public function save(Request $request, $id)
    {
        // Cari data berdasarkan ID, jika tidak ada akan otomatis mengembalikan error 404
        $template = CertificateTemplate::findOrFail($id);

        $template->fields = $request->fields;

        $template->save();

        return response()->json([
            'status' => 'ok',
            'message' => 'Template field berhasil diperbarui'
        ]);
    }

    /**
     * Menghapus template dan file fisiknya
     */
    public function delete($id)
    {
        $certificate = CertificateTemplate::findOrFail($id);

        // 1. Hapus file fisik dari storage jika ada
        if ($certificate->background && Storage::disk('public')->exists($certificate->background)) {
            Storage::disk('public')->delete($certificate->background);
        }

        // 2. Hapus data dari database
        $certificate->delete();

        return redirect()->back()->with('success', 'Template berhasil dihapus');
    }
}
