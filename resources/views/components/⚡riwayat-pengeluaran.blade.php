<?php

use Livewire\Component;
use App\Models\Expense;

use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

new class extends Component {
    public $bulan;
    public $tahun;
    
    // Properti untuk form tambah
    public $kategori, $jumlah, $tanggal, $deskripsi;

    public function mount() {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    public function with(): array {
        return [
            'pengeluaran' => Expense::whereMonth('tanggal', $this->bulan)
                ->whereYear('tanggal', $this->tahun)
                ->latest()
                ->get(),
        ];
    }

    public function save() {
        $this->validate([
            'kategori' => 'required',
            'jumlah' => 'required|numeric',
            'tanggal' => 'required|date',
        ]);

        Expense::create([
            'kategory' => $this->kategori,
            'jumlah' => $this->jumlah,
            'tanggal' => $this->tanggal,
            'deskripsi' => $this->deskripsi,
        ]);

        $this->reset(['kategori', 'jumlah', 'tanggal', 'deskripsi']);
        $this->dispatch('close-modal'); // Untuk menutup modal lewat JS
    }

    public function delete($id) {
        Expense::find($id)->delete();
    }

    public function exportPdf() {
        $data = Expense::whereMonth('tanggal', $this->bulan)
            ->whereYear('tanggal', $this->tahun)->get();
        $pdf = Pdf::loadView('export.pengeluaran', ['pengeluaran' => $data]);
        return response()->streamDownload(fn () => print($pdf->output()), "Pengeluaran-{$this->bulan}.pdf");
    }
}; ?>

<div class="col-md-6">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header border-0 pt-4 px-4 bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">📉 Riwayat Pengeluaran</span>
            <div class="d-flex gap-2">
                <select wire:model.live="bulan" class="form-select form-select-sm">
                    @foreach(range(1, 12) as $m)
                        <option value="{{ sprintf("%02d", $m) }}">{{ Carbon::create()->month($m)->format('F') }}</option>
                    @endforeach
                </select>
                <button wire:click="exportPdf" class="btn btn-sm btn-outline-danger">PDF</button>
                <button class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addExpenseModal">+</button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead><tr><th>Kategori</th><th>Tanggal</th><th class="text-end">Jumlah</th><th></th></tr></thead>
                <tbody>
                    @forelse($pengeluaran as $out)
                    <tr>
                        <td>{{ $out->kategory }}</td>
                        <td>{{ Carbon::parse($out->tanggal)->format('d M Y') }}</td>
                        <td class="text-end text-danger">-Rp {{ number_format($out->jumlah, 0, ',', '.') }}</td>
                        <td>
                            <button wire:click="delete({{ $out->id }})" wire:confirm="Yakin ingin menghapus?" class="btn btn-sm text-danger">
                                <i class="bi bi-trash"></i>
                            </button>
                        </td>
                    </tr>
                    @empty
                    <tr><td colspan="4" class="text-center p-3">Data kosong</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal fade" id="addExpenseModal" tabindex="-1">
        <div class="modal-dialog">
            <form wire:submit="save" class="modal-content border-0 rounded-4 p-3">
                <div class="modal-header border-0"><h5 class="fw-bold">Tambah Pengeluaran</h5></div>
                <div class="modal-body">
                    <input wire:model="kategori" class="form-control mb-3" placeholder="Kategori" required>
                    <input type="number" wire:model="jumlah" class="form-control mb-3" placeholder="Jumlah" required>
                    <input type="date" wire:model="tanggal" class="form-control mb-3" required>
                </div>
                <div class="modal-footer border-0"><button class="btn btn-primary w-100 rounded-pill">Simpan</button></div>
            </form>
        </div>
    </div>
</div>