<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pendaftaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PembelajaranController extends Controller
{
    public function index()
    {
        $auth = Auth::user();
        if ($auth->isAdmin()) {
            $courses = Course::all();
        } else {
            $pendaftaranku = Pendaftaran::with(['course', 'nilai'])
                ->where('peserta_id', $auth->peserta->id)
                ->get();

            // 2. Ambil semua ID course yang diikuti peserta
            $courseIds = $pendaftaranku->pluck('course_id');

            // 3. Ambil jadwal untuk course-course tersebut
            $courses = Course::whereIn('id', $courseIds)
                ->get();
        }

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
