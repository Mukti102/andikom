@extends('layouts.export')

@section('content')
    <h3 style="text-align: center;">Daftar Peserta Kursus</h3>

    <table>
        <thead>
            <tr>
                <th style="width: 10%;">NIS</th>
                <th>Nama Lengkap</th>
                <th style="width: 15%;">Gender</th>
                <th style="width: 20%;">No HP</th>
                <th>Asal Sekolah</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($peserta as $p)
                <tr>
                    <td>{{ $p->nis }}</td>
                    <td>{{ $p->nama_lengkap }}</td>
                    <td>{{ $p->jenis_kelamin == 'L' ? 'Laki-laki' : 'Perempuan' }}</td>
                    <td>{{ $p->no_hp }}</td>
                    <td>{{ $p->asal_sekolah }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" style="text-align: center;">Data tidak ditemukan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div style="margin-top: 30px; text-align: right;">
        <p>Jember, {{ date('d F Y') }}</p>
        <br><br><br>
        <p>({{ auth()->user()->name }})</p>
    </div>
@endsection
