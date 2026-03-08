<?php

namespace App\Http\Controllers;

use App\Http\Requests\PendaftaranRequest;
use App\Models\Course;
use App\Models\Pendaftaran;
use App\Models\Peserta;
use App\Models\Tagihan;
use Exception;
use Illuminate\Http\Request;

class PendaftaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $pendaftarans = Pendaftaran::with(['peserta', 'course'])->latest()->get();
        return view('pages.admin.pendafataran.index', compact('pendaftarans'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $pesertas = Peserta::pluck('nama_lengkap', 'id');
        $courses = Course::all();
        return view('pages.admin.pendafataran.create', compact('courses', 'pesertas'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PendaftaranRequest $request)
    {
        $pendaftaran = Pendaftaran::create($request->validated());
        $course = $pendaftaran->course;
        $totalBiaya = $course->jumlah_total;

        if ($pendaftaran->metode_bayar == 'cicil') {
            $jumlahMinggu = $course->jumlah_pertemuan ?: ($course->durasi_bulan * 4);
            $nominalPerMinggu = floor($totalBiaya / $jumlahMinggu);
            $sisa = $totalBiaya - ($nominalPerMinggu * $jumlahMinggu);

            for ($i = 1; $i <= $jumlahMinggu; $i++) {
                $nominal = ($i == $jumlahMinggu) ? ($nominalPerMinggu + $sisa) : $nominalPerMinggu;

                \App\Models\Tagihan::create([
                    'pendaftaran_id' => $pendaftaran->id,
                    'angsuran_ke'    => $i,
                    'nominal'        => $nominal,
                    'jatuh_tempo'    => \Carbon\Carbon::parse($pendaftaran->tanggal_daftar)->addWeeks($i),
                    'status'         => 'unpaid'
                ]);
            }
        } else {
            \App\Models\Tagihan::create([
                'pendaftaran_id' => $pendaftaran->id,
                'angsuran_ke'    => 1,
                'nominal'        => $totalBiaya,
                'jatuh_tempo'    => $pendaftaran->tanggal_daftar,
                'status'         => 'unpaid'
            ]);
        }



        return redirect()->route('admin.pendaftaran.index')
            ->with('success', 'Pendaftaran & tagihan berhasil dibuat!');
    }


    public function tagihan($id)
    {
        $pendaftaran = Pendaftaran::with('tagihans')->find($id);
        return view('pages.admin.tagihan.index', compact('pendaftaran'));
    }

    public function userTagihan($id)
    {
        $pendaftaran = Pendaftaran::with('tagihans')->where('peserta_id', $id)->first();
        return view('pages.admin.tagihan.index', compact('pendaftaran'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pendaftaran $pendaftaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pendaftaran $pendaftaran)
    {
        $pendaftaran->update($request->all());
        return redirect()->back()
            ->with('success', 'Pendaftaran berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pendaftaran $pendaftaran)
    {
        try {
            $pendaftaran->delete();
            return redirect()->back()->with('success', 'Berhasil Menghapus');
        } catch (Exception $th) {
            return redirect()->back()->with('error', 'Gagal Menghapus');
        }
    }
}
