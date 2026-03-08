@extends('layouts.app')
@section('title', 'Pemantauan Arus Kas')

@section('content')
<div class="container">
    <div class="row mb-4">
        @php
            $totalIn = $pemasukan->sum('nominal');
            $totalOut = $pengeluaran->sum('jumlah');
            $saldo = $totalIn - $totalOut;
        @endphp
        <div class="col-md-4"><div class="card p-3 border-success text-success text-center"><h6>Total Pemasukan</h6><h3>Rp {{ number_format($totalIn, 0) }}</h3></div></div>
        <div class="col-md-4"><div class="card p-3 border-danger text-danger text-center"><h6>Total Pengeluaran</h6><h3>Rp {{ number_format($totalOut, 0) }}</h3></div></div>
        <div class="col-md-4"><div class="card p-3 border-primary text-primary text-center"><h6>Saldo Kas</h6><h3>Rp {{ number_format($saldo, 0) }}</h3></div></div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header  border-0 pt-4 px-4 fw-bold">💰 Riwayat Pemasukan</div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead class=""><tr><th>Tanggal</th><th>Item</th><th class="text-end">Jumlah</th></tr></thead>
                        <tbody>
                            @foreach($pemasukan as $in)
                            <tr><td>{{ $in->created_at->format('d M Y') }}</td><td>{{ $in->tagihan->pendaftaran->course->name_paket ?? 'Pembayaran' }}</td><td class="text-end text-success">+Rp {{ number_format($in->nominal, 0) }}</td></tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm border-0 rounded-4">
                <div class="card-header  border-0 pt-4 px-4 d-flex justify-content-between align-items-center">
                    <span class="fw-bold">📉 Riwayat Pengeluaran</span>
                    <button class="btn btn-sm btn-primary rounded-pill" data-bs-toggle="modal" data-bs-target="#addExpenseModal">+ Tambah</button>
                </div>
                <div class="card-body p-0">
                    <table class="table table-hover">
                        <thead><tr><th>Kategori</th><th>Tanggal</th><th class="text-end">Jumlah</th><th></th></tr></thead>
                        <tbody>
                            @foreach($pengeluaran as $out)
                            <tr>
                                <td>{{ $out->kategory }}</td>
                                <td>{{ \Carbon\Carbon::parse($out->tanggal)->format('d M Y') }}</td>
                                <td class="text-end text-danger">-Rp {{ number_format($out->jumlah, 0) }}</td>
                                <td>
                                    <form action="{{ route('cash.flow.destroy', $out->id) }}" method="POST" onsubmit="return confirm('Hapus data?')">
                                        @csrf @method('DELETE')
                                        <button class="btn btn-sm text-danger"><i class="bi bi-trash"></i></button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="addExpenseModal" tabindex="-1">
    <div class="modal-dialog"><form action="{{ route('cash.flow.store') }}" method="POST" class="modal-content border-0 rounded-4 p-3">
        @csrf
        <div class="modal-header border-0"><h5 class="fw-bold">Tambah Pengeluaran</h5></div>
        <div class="modal-body">
            <input name="kategori" class="form-control mb-3" placeholder="Kategori (e.g. Listrik)" required>
            <input type="number" name="jumlah" class="form-control mb-3" placeholder="Jumlah (Rp)" required>
            <input type="date" name="tanggal" class="form-control mb-3" required>
            <textarea name="deskripsi" class="form-control" placeholder="Deskripsi..."></textarea>
        </div>
        <div class="modal-footer border-0"><button class="btn btn-primary w-100 rounded-pill">Simpan</button></div>
    </form></div>
</div>
@endsection