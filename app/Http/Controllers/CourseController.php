<?php

namespace App\Http\Controllers;

use App\Http\Requests\CourseRequest;
use App\Models\Course;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Tool;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

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

        if ($request->hasFile('thumbnail')) {
            $path = $request->file('thumbnail')->store('thumbnails', 'public');
            $data['thumbnail'] = $path;
        }

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
    public function show($id)
    {

        $course = Course::find($id);
        $course->load('tools');
        // Ambil data peserta milik user yang login
        $peserta = auth()->user()->peserta;


        return view('pages.user.courses.detail', compact('course', 'peserta'));
    }

    /**c
     * Show the form for editing the specified resource.
     */
    public function edit(Course $course)
    {
        $tools = Tool::all();
        return view('pages.admin.courses.edit', compact('course', 'tools'));
    }


    public function update(CourseRequest $request, Course $course)
    {
       

        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $course->update($data);

        $course->tools()->sync($request->tools ?? []);

        return redirect()->route('admin.courses.index')
            ->with('success', 'Data kursus dan thumbnail berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Course $course)
    {
        try {
            DB::beginTransaction();

            if ($course->thumbnail && Storage::disk('public')->exists($course->thumbnail)) {
                Storage::disk('public')->delete($course->thumbnail);
            }

            $course->delete();

            DB::commit();

            return redirect()->route('admin.courses.index')
                ->with('success', 'Kursus berhasil dihapus!');
        } catch (\Exception $e) {
            DB::rollBack();

            Log::error("Gagal menghapus kursus: " . $e->getMessage());

            return redirect()->route('admin.courses.index')
                ->with('error', 'Terjadi kesalahan saat menghapus kursus.');
        }
    }
}
