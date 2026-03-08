<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Materi;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MateriController extends Controller
{
    /**
     * Display a listing of the resource.
     */

    public function index(Request $request, $id)
    {
        // Ambil course dengan tools
        $course = Course::with('tools')->findOrFail($id);

        // Query materi, filter jika ada parameter 'tool'
        $materis = Materi::where('course_id', $id)
            ->when($request->tool, function ($query) use ($request) {
                $query->where('tool_id', $request->tool);
            })
            ->orderBy('urutan', 'asc')
            ->get();

        return view('pages.tutor.materi.index', compact('course', 'materis'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create($id)
    {
        $course = Course::with('tools')->find($id);
        $tools = $course->tools->pluck('name', 'id');
        return view('pages.tutor.materi.create', compact('course'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request, $id)
    {
        $validated = $request->validate([
            'title' => 'required',
            'file_path' => 'required|file|mimes:pdf,zip,doc,docx|max:5120', // Maksimal 5MB
            'tool_id' => 'required',
            'deskripsi' => 'required',
            'urutan' => 'required'
        ]);

        if ($request->hasFile('file_path')) {
            $path = $request->file('file_path')->store('materi_files', 'public');
            $validated['file_path'] = $path;
        }

        $validated['course_id'] = $id;
        $validated['tutor_id'] = auth()->id();

        Materi::create($validated);

        return redirect()->route('pembelajaran.materi.index', $id)->with('success', 'Materi berhasil ditambahkan');
    }

    /**
     * Display the specified resource.
     */
    public function show(Materi $materi)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $materi = Materi::findOrFail($id);
        $course = Course::with('tools')->findOrFail($materi->course_id);

        return view('pages.tutor.materi.edit', compact('materi', 'course'));
    }

    public function update(Request $request, $id)
    {
        $materi = Materi::findOrFail($id);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file_path' => 'nullable|file|mimes:pdf,zip,doc,docx,ppt,pptx|max:10240',
            'tool_id' => 'required',
            'deskripsi' => 'required',
            'urutan' => 'required|integer',
        ]);

        // Handle File Update
        if ($request->hasFile('file_path')) {
            // Hapus file lama jika ada
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }
            $validated['file_path'] = $request->file('file_path')->store('materi', 'public');
        }

        $materi->update($validated);

        return redirect()->route('pembelajaran.materi.index', $materi->course_id)
            ->with('success', 'Materi berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        try {
            $materi = Materi::findOrFail($id); // Gunakan findOrFail untuk keamanan

            // 1. Cek dan hapus file fisik di storage
            if ($materi->file_path && Storage::disk('public')->exists($materi->file_path)) {
                Storage::disk('public')->delete($materi->file_path);
            }

            // 2. Hapus data dari database
            $materi->delete();

            return redirect()->back()->with('success', 'Materi berhasil dihapus beserta file terkait.');
        } catch (Exception $th) {
            return redirect()->back()->with('error', 'Gagal menghapus materi: ' . $th->getMessage());
        }
    }
}
