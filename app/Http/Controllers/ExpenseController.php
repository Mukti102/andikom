<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\Pembayaran;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function index()
    {
        $pemasukan = Pembayaran::where('status_verifikasi', 'completed')->get();
        $pengeluaran = Expense::all();

        $arusKas = $pemasukan->sum('nominal') - $pengeluaran->sum('jumlah');

        return view('pages.admin.cashFlow.index', compact('pemasukan', 'pengeluaran'));
    }

    public function store(Request $request)
    {   
        $validated = $request->validate([
            'kategori' => 'required|string|max:255',
            'jumlah' => 'required|numeric|min:0',
            'tanggal' => 'required|date',
            'deskripsi' => 'nullable|string',
        ]);

        $validated['kategory'] = $validated['kategori'];
        Expense::create($validated);
        return redirect()->back()->with('success', 'Pengeluaran berhasil dicatat!');
    }

    public function destroy($id)
    {
        Expense::findOrFail($id)->delete();
        return redirect()->back()->with('success', 'Data pengeluaran dihapus.');
    }
}
