<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Pembayaran;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $auth = Auth::user();

        if ($auth->role == 'admin') {
            $stats = [
                'total_peserta'    => Peserta::count(),
                'pendaftaran_baru' => Pendaftaran::with('peserta')->whereDate('created_at', today())->count(),
                'total_materi'     => Tool::count(),
                'lulus_terbaru'    => Pendaftaran::whereHas('nilai')->count(),
            ];

            $peserta_terbaru = Peserta::latest()->take(5)->get();

            return view('pages.dashboard.admin', compact('stats', 'peserta_terbaru',));
        }

        if ($auth->role == 'tutor') {
            // Mengambil jadwal berdasarkan tutor_id (asumsi tutor_id di tabel jadwal merujuk ke id user/tutor)
            $jadwals = \App\Models\Jadwal::with('course')
                ->where('tutor_id', $auth->id)
                ->get();

            // Mengambil daftar course unik dari jadwal
            $my_courses = $jadwals->pluck('course')->unique('id');

            return view('pages.dashboard.tutor', compact('jadwals', 'my_courses'));
        }

        if ($auth->role == 'user') {
            // 1. Ambil pendaftaran beserta kursus dan nilainya
            $pendaftaranku = Pendaftaran::with(['course', 'nilai'])
                ->where('peserta_id', $auth->peserta->id)
                ->get();

            // 2. Ambil semua ID course yang diikuti peserta
            $courseIds = $pendaftaranku->pluck('course_id');

            // 3. Ambil jadwal untuk course-course tersebut
            $jadwals = \App\Models\Jadwal::with('course')
                ->whereIn('course_id', $courseIds)
                ->orderBy('hari')
                ->get();

            $availableCourses = Course::whereNotIn('id', $courseIds)->get();

            return view('pages.dashboard.peserta', compact('pendaftaranku', 'jadwals', 'availableCourses'));
        }

        if ($auth->role == 'owner') {
            $stats = [
                'total_revenue'   => \App\Models\Pembayaran::where('status_verifikasi', 'completed')->sum('nominal'),
                'active_courses'  => Course::count(),
                'total_students'  => Peserta::count(),
                'active_tutors'   => \App\Models\User::where('role', 'tutor')->count(),
            ];

            // Mengambil pendapatan bulanan dari tabel Pembayaran (lebih akurat daripada Pendaftaran)
            $revenue_per_month = \App\Models\Pembayaran::where('status_verifikasi', 'completed')
                ->selectRaw('MONTH(created_at) as month, SUM(nominal) as total')
                ->groupBy('month')
                ->orderBy('month')
                ->get();

            $best_course = \App\Models\Course::withCount('pendaftarans')
                ->orderBy('pendaftarans_count', 'desc')
                ->first();
            return view('pages.dashboard.owner', compact('stats', 'revenue_per_month','best_course'));
        }

        return redirect()->back(); // Handle jika bukan admin
    }
}
