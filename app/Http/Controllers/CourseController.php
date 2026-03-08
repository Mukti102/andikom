<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::all();
        return view('pages.admin.courses.index', compact('courses'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tools = Tool::all();
        return view('pages.admin.courses.create', compact('tools'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CourseRequest $request)
    {
        $data = $request->validated();

        // 2. Buat record Course
        $course = Course::create($data);

        if ($request->has('tools')) {
            $course->tools()->sync($request->tools);
        }

        return redirect()->route('admin.courses.index')
            ->with('success', 'Kursus berhasil ditambahkan!');
    }

    public function user()
    {
        $user = Auth::user();
        $courses = Course::whereHas('pendaftarans', function ($query) use ($user) {
            $query->where('peserta_id', $user->peserta->id);
        })->with('pendaftarans')->get();
        return view('pages.user.courses.index', compact('courses', 'user'));
    }

    public function pendaftar($id)
    {
        $pesertas =  Peserta::pluck('nama_lengkap', 'id');
        $course = Course::with('pendaftarans.tagihans')->findOrFail($id);
        return view('pages.admin.courses.members', compact('course', 'pesertas'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Course $course)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $tools = Tool::all();
        return view('pages.admin.courses.edit', compact('course', 'tools'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CourseRequest $request, Course $course)
    {
        // 1. Validasi sudah dilakukan oleh CourseRequest
        $data = $request->validated();

        // 2. Update data course (kecuali tools)
        $course->update($data);

        // 3. Update relasi tools menggunakan sync
        // Jika tidak ada tools yang dicentang, kita kirim array kosong [] agar semua relasi lama dihapus
        $course->tools()->sync($request->tools ?? []);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Data kursus dan tools berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        $course->delete();
        return redirect()->route('admin.courses.index')
            ->with('success', 'Kursus berhasil dihapus!');
    }
}
