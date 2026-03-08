<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Jadwal;
use App\Models\User;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    public function index()
    {
        $courses = Course::all();
        return view('pages.admin.jadwal.index', compact('courses'));
    }

    public function show($course_id)
    {
        $course = Course::findOrFail($course_id);
        $jadwals = Jadwal::where('course_id', $course_id)->get();
        $tutors = User::all(); // Mengambil semua user untuk pilihan tutor
        return view('pages.admin.jadwal.show', compact('course', 'jadwals', 'tutors'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'course_id' => 'required',
            'tutor_id'  => 'required',
            'hari'      => 'required',
            'start_time' => 'required|before:end_time',
            'end_time'  => 'required|after:start_time',
            'room'      => 'required',
        ]);

        $isConflict = Jadwal::where('hari', $request->hari)
            ->where('room', $request->room)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['error' => 'Jadwal bentrok dengan kegiatan lain di ruangan ini pada jam tersebut.']);
        }

        Jadwal::create($request->all());
        return back()->with('success', 'Jadwal berhasil ditambahkan.');
    }

    public function update(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'hari' => 'required',
            'start_time' => 'required|before:end_time',
            'end_time' => 'required|after:start_time',
            'room' => 'required',
        ]);

        $isConflict = Jadwal::where('hari', $request->hari)
            ->where('room', $request->room)
            ->where('id', '!=', $jadwal->id)
            ->where(function ($query) use ($request) {
                $query->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q) use ($request) {
                        $q->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })->exists();

        if ($isConflict) {
            return back()->withErrors(['error' => 'Jadwal bentrok! Ruangan sudah dipakai di jam tersebut.']);
        }

        $jadwal->update($request->all());
        return back()->with('success', 'Jadwal berhasil diperbarui.');
    }

    public function destroy(Jadwal $jadwal)
    {
        $jadwal->delete();
        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}
