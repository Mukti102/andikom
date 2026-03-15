@extends('layouts.export')
@section('content')
    <div class='' style="text-align: center">
        <h3>LAPORAN PENGELUARAN BULANAN</h3>
        <p>Periode: {{ date('F Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th class="text-end">Jumlah</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pengeluaran as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d M Y') }}</td>
                    <td>{{ $item->kategory }}</td>
                    <td class="text-end text-danger">Rp {{ number_format($item->jumlah, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total Pengeluaran</td>
                <td class="text-end" style="font-weight: bold;">
                    Rp {{ number_format($pengeluaran->sum('jumlah'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
@endsection
