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
            // Admin melihat semua course
            $courses = Course::all();
        } elseif ($auth->isTutor()) {
            // Tutor melihat course yang memiliki jadwal atas nama dirinya
            $courses = Course::whereHas('jadwals', function ($query) use ($auth) {
                $query->where('tutor_id', $auth->id);
            })->get();
        } else {
            // User/Peserta melihat course yang mereka daftar
            $courses = Course::whereHas('pendaftarans', function ($query) use ($auth) {
                $query->where('peserta_id', $auth->peserta->id);
            })->get();
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
