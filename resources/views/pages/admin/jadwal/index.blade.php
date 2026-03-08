@extends('layouts.app')
@section('title', 'Pilih Course')

@section('content')
    <div class="container">
        <div class="row">
            @foreach ($courses as $course)
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-body">
                            <h5 class="card-title">{{ $course->name_paket }}</h5>
                            <a href="{{ route('admin.jadwal.show', $course->id) }}" class="btn btn-primary">Lihat Jadwal</a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
