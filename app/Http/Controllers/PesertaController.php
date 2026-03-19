<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaRequest;
use App\Mail\PesertaTerverifikasiMail;
use App\Models\Peserta;
use App\Models\User;
use Barryvdh\DomPDF\Facade\Pdf;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;

class PesertaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pesertas = Peserta::all();
        return view('pages.admin.peserta.index', compact('pesertas'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereDoesntHave('peserta')->where('role', 'user')->pluck('name', 'id');

        return view('pages.admin.peserta.create', compact('users'));
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(PesertaRequest $request)
    {
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {

            $peserta = Peserta::create(collect($validatedData)->except(['kartu_keluarga', 'ktp-akte', 'pas-photo'])->toArray());

            $peserta->documents()->create([
                'kartu_keluarga' => $request->file('kartu_keluarga')->store('documents/kk', 'public'),
                'ktp-akte'       => $request->file('ktp-akte')->store('documents/ktp', 'public'),
                'pas-photo'      => $request->file('pas-photo')->store('documents/photo', 'public'),
            ]);

            DB::commit();
            return redirect()->route('admin.peserta.index')->with('success', 'Berhasil!');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Gagal: ' . $e->getMessage());
        }
    }

    public function verifikasi($id)
    {
        try {
            $peserta = Peserta::findOrFail($id);
            $peserta->update(['status_aktif' => true]);

            Mail::to($peserta->user->email)->queue(new PesertaTerverifikasiMail($peserta));

            return redirect()->back()->with('success', 'Peserta berhasil dikonfirmasi dan status kini Aktif.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal konfirmasi: ' . $e->getMessage());
        }
    }

    public function update(PesertaRequest $request, $id)
    {
        $peserta = Peserta::findOrFail($id);
        $validatedData = $request->validated();

        DB::beginTransaction();
        try {
            // 1. Update data utama peserta (kecuali file)
            $peserta->update(collect($validatedData)->except(['kartu_keluarga', 'ktp-akte', 'pas-photo'])->toArray());

            // 2. Update status aktif secara manual jika tidak masuk di validatedData
            $peserta->status_aktif = $request->has('status_aktif') ? (bool)$request->status_aktif : false;
            $peserta->save();

            // 3. Update Dokumen (Hanya jika ada file baru yang diupload)
            $documentData = [];
            $files = ['kartu_keluarga' => 'documents/kk', 'ktp-akte' => 'documents/ktp', 'pas-photo' => 'documents/photo'];

            foreach ($files as $field => $path) {
                if ($request->hasFile($field)) {
                    // Hapus file lama jika ada
                    if ($peserta->documents && $peserta->documents->$field) {
                        Storage::disk('public')->delete($peserta->documents->$field);
                    }
                    // Simpan file baru
                    $documentData[$field] = $request->file($field)->store($path, 'public');
                }
            }

            if (!empty($documentData)) {
                // Menggunakan updateOrCreate agar jika record dokumen belum ada, dia akan buat baru
                $peserta->documents()->updateOrCreate(
                    ['peserta_id' => $peserta->id],
                    $documentData
                );
            }

            DB::commit();
            return redirect()->route('admin.peserta.index')->with('success', 'Data peserta berhasil diperbarui.');
        } catch (\Exception $e) {
            DB::rollBack();
            // Gunakan back dengan error message daripada dd() di production
            return back()->with('error', 'Gagal memperbarui data: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $peserta = Peserta::with('user', 'documents')->find($id);
        return view('pages.admin.peserta.show', compact('peserta'));
    }

    public function exportPDF()
    {
        // Mengambil semua data peserta
        $peserta = Peserta::all();

        // Memuat view 'pdf.daftar-peserta' dan mengirim data
        $pdf = Pdf::loadView('export.peserta', ['peserta' => $peserta]);

        // Mengunduh file
        return $pdf->download('daftar-peserta-kursus.pdf');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {

        $peserta = Peserta::find($id);
        // Ambil user yang belum punya profil PESERTA + user yang sedang diedit saat ini
        $users = User::where(function ($query) use ($peserta) {
            $query->whereDoesntHave('peserta')
                ->orWhere('id', $peserta->user_id);
        })
            ->where('role', 'user') // sesuaikan dengan enum role Anda (peserta/user)
            ->pluck('name', 'id');


        return view('pages.admin.peserta.edit', compact('peserta', 'users'));
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peserta = Peserta::find($id);
        $peserta->delete();
        return redirect()->route('admin.peserta.index')->with('success', 'Berhasil Menghapus Peserta');
    }
}
