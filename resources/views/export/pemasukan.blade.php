@extends('layouts.export')
@section('content')
    <div class='' style="text-align: center">
        <h3>LAPORAN PEMASUKAN BULANAN</h3>
        <p>Periode: {{ date('F Y') }}</p>
    </div>
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Tanggal</th>
                <th>Item Pemasukan</th>
                <th class="text-end">Nominal</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pemasukan as $index => $item)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $item->created_at->format('d M Y') }}</td>
                    <td>{{ $item->tagihan->pendaftaran->course->name_paket ?? 'Pembayaran' }}</td>
                    <td class="text-end text-success">Rp {{ number_format($item->nominal, 0, ',', '.') }}</td>
                </tr>
            @endforeach
        </tbody>
        <tfoot>
            <tr>
                <td colspan="3" style="text-align: right; font-weight: bold;">Total</td>
                <td class="text-end" style="font-weight: bold;">
                    Rp {{ number_format($pemasukan->sum('nominal'), 0, ',', '.') }}
                </td>
            </tr>
        </tfoot>
    </table>
@endsection
