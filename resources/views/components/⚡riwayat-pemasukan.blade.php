<?php

use Livewire\Component;
use Carbon\Carbon;
use App\Models\Pembayaran;

use Barryvdh\DomPDF\Facade\Pdf;

new class extends Component {
    public $bulan;
    public $tahun;

    public function mount()
    {
        $this->bulan = date('m');
        $this->tahun = date('Y');
    }

    // UBAH 'amount' MENJADI 'with'
    public function with(): array
    {   
        return [
            'pemasukan' => Pembayaran::where('status_verifikasi', 'completed')->whereMonth('created_at', $this->bulan)
                ->whereYear('created_at', $this->tahun)
                ->latest()
                ->get(),
        ];
    }

    public function exportPdf()
    {
        $data = Pembayaran::whereMonth('created_at', $this->bulan)->whereYear('created_at', $this->tahun)->get();

        $pdf = Pdf::loadView('export.pemasukan', ['pemasukan' => $data]);
        return response()->streamDownload(fn() => print $pdf->output(), "Riwayat-Pemasukan-{$this->bulan}-{$this->tahun}.pdf");
    }
}; ?>

<div class="col-md-6">
    <div class="card shadow-sm border-0 rounded-4">
        <div class="card-header border-0 pt-4 px-4 bg-white d-flex justify-content-between align-items-center">
            <span class="fw-bold">💰 Riwayat Pemasukan</span>
            <div class="d-flex gap-2">
                <select wire:model.live="bulan" class="form-select form-select-sm">
                    @foreach (range(1, 12) as $m)
                        <option value="{{ sprintf('%02d', $m) }}">{{ Carbon::create()->month($m)->format('F') }}</option>
                    @endforeach
                </select>
                <button wire:click="exportPdf" class="btn btn-sm btn-outline-danger">PDF</button>
            </div>
        </div>
        <div class="card-body p-0">
            <table class="table table-hover mb-0">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Item</th>
                        <th class="text-end">Jumlah</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($pemasukan as $in)
                        <tr>
                            <td>{{ $in->created_at->format('d M Y') }}</td>
                            <td>{{ $in->tagihan->pendaftaran->course->name_paket ?? 'Pembayaran' }}</td>
                            <td class="text-end text-success fw-bold">+Rp {{ number_format($in->nominal, 0, ',', '.') }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3" class="text-center p-3">Data tidak ditemukan</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
