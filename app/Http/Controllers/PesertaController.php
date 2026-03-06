<?php

namespace App\Http\Controllers;

use App\Http\Requests\PesertaRequest;
use App\Models\Peserta;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;

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
        // Jika sampai di sini, artinya data sudah lolos validasi
        Peserta::create($request->validated());

        return redirect()->route('admin.peserta.index')
            ->with('success', 'Data peserta berhasil ditambahkan.');
    }

    public function update(PesertaRequest $request, $id)
    {
        try {
            $peserta = Peserta::findOrFail($id);
            $data = $request->validated();

            // Konversi status_aktif ke boolean (0 atau 1)
            $data['status_aktif'] = $request->has('status_aktif') ? (bool)$request->status_aktif : false;
            $peserta->update($data);
            return redirect()->route('admin.peserta.index')
                ->with('success', 'Data peserta berhasil diperbarui.');
        } catch (Exception $th) {
            dd($th->getMessage());
            return redirect()->back();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Peserta $peserta)
    {
        //
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
            return redirect()->route('admin.peserta.index')->with('success','Berhasil Menghapus Peserta');
    }
}
