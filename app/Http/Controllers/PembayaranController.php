<?php

namespace App\Http\Controllers;

use App\Http\Requests\PembayaranRequest;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(PembayaranRequest $request)
    {
        try {
            DB::beginTransaction();

            // 1. Handle Upload File
            $path = null;
            if ($request->hasFile('bukti_bayar')) {
                // Simpan di folder public/pembayaran
                $path = $request->file('bukti_bayar')->store('pembayaran', 'public');
            }

            // 2. Simpan Data Pembayaran
            Pembayaran::create([
                'tagihan_id'        => $request->tagihan_id,
                'angsuran_ke'       => $request->angsuran_ke,
                'nominal'           => $request->nominal,
                'tanggal_bayar'     => $request->tanggal_bayar,
                'bukti_bayar'       => $path,
                'status_verifikasi' => 'pending',
            ]);

            DB::commit();

            return redirect()->back()->with('success', 'Bukti pembayaran berhasil dikirim. Silahkan tunggu verifikasi admin.');
        } catch (\Exception $e) {
            DB::rollBack();
            if ($path) {
                Storage::disk('public')->delete($path);
            }

            return redirect()->back()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function verifikasi(Request $request, $id)
    {
        // 1. Validasi input dari modal
        $request->validate([
            'status_verifikasi' => 'required|in:completed,rejected',
            'reason'            => 'required_if:status_verifikasi,rejected|nullable|string',
        ]);

        $pembayaran = Pembayaran::findOrFail($id);

        try {
            DB::transaction(function () use ($request, $pembayaran) {

                // 2. Update status pembayaran
                $pembayaran->update([
                    'status_verifikasi' => $request->status_verifikasi,
                    'reason'            => $request->status_verifikasi == 'rejected' ? $request->reason : null,
                ]);

                // 3. Jika disetujui (Completed), update status di tabel tagihan menjadi paid
                if ($request->status_verifikasi == 'completed') {
                    $tagihan = Tagihan::findOrFail($pembayaran->tagihan_id);
                    $tagihan->update(['status' => 'paid']);
                }
            });

            return redirect()->back()->with('success', 'Status verifikasi berhasil diperbarui.');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memproses verifikasi: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
