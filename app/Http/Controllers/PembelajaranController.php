<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;

class PembelajaranController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('pages.admin.pembelajaran.index', compact('courses'));
    }

    public function peserta($id)
    {
        // Mengambil course dengan relasi pendaftaran dan data user (peserta)
        $course = Course::with(['pendaftarans.peserta'])->findOrFail($id);
        return view('pages.admin.pembelajaran.peserta', compact('course'));
    }

    public function toogle($pendaftar_id)
    {   
        $pendaftaran = Pendaftaran::findOrFail($pendaftar_id);

        // Toggle status
        $pendaftaran->status = ($pendaftaran->status === 'aktif') ? 'nonaktif' : 'aktif';
        $pendaftaran->save();

        return redirect()->back()->with('success', 'Status berhasil diperbarui!');
    }
}
