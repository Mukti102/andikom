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
       <livewire:riwayat-pemasukan />
       <livewire:riwayat-pengeluaran />
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