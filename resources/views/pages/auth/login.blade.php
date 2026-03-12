@extends('layouts.auth')

@section('content')
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-900">Selamat Datang</h2>
        <p class="text-gray-500 text-sm">Masukkan kredensial Anda untuk mengakses sistem</p>
    </div>

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf
        
        <x-guest.input 
            label="Email" 
            name="email" 
            type="email" 
            required 
        />

        <x-guest.input 
            label="Password" 
            name="password" 
            type="password" 
            required 
        />

        <button type="submit" 
            class="w-full bg-rose-600 hover:bg-rose-700 text-white font-bold py-3 rounded-xl shadow-lg shadow-rose-200 transition-all duration-200 active:scale-[0.98]">
            Masuk Sekarang
        </button>
    </form>
@endsection