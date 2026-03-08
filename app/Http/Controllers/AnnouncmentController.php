<?php

namespace App\Http\Controllers;

use App\Mail\AnnouncmentEmail;
use App\Models\Announcment;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class AnnouncmentController extends Controller
{
    public function index()
    {
        $announcements = Announcment::orderBy('created_at', 'desc')->get();
        return view('pages.admin.announcment.index', compact('announcements'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:info,warning,danger',
            'message' => 'required',
        ]);

        $announcement  = Announcment::create($request->all());

        $users = User::all();

        foreach ($users as $user) {
            Mail::to($user->email)->queue(new AnnouncmentEmail($announcement));
        }

        return redirect()->back()->with('success', 'Pengumuman berhasil disebarkan!');
    }

    public function destroy($id)
    {
        $announcement = Announcment::findOrFail($id);
        $announcement->delete();

        return redirect()->back('success','Berhasil Di Hapus');
    }
}
