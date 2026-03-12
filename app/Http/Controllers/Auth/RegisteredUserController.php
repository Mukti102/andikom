<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;
use Illuminate\View\View;

class RegisteredUserController extends Controller
{
    /**
     * Display the registration view.
     */
    public function create(): View
    {
        return view('pages.auth.register');
    }

    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): RedirectResponse
    {
        // 1. Validasi gabungan (User & Peserta)
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:' . User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'nis' => ['required', 'unique:peserta,nis'],
            'nama_lengkap' => ['required', 'string', 'max:255'],
            'nama_panggilan'        => 'nullable|string|max:50',
            'tanggal_lahir' => ['required', 'date'],
            'tempat_lahir'          => 'required|string|max:100',
            'jenis_kelamin'         => 'required|in:L,P',
            'agama'                 => 'required|string|max:50',
            'alamat_sekarang'       => 'required|string',
            'pekerjaan'             => 'nullable|string|max:100',
            'asal_sekolah'          => 'nullable|string|max:100',
            'status_tempat_tinggal' => 'required|string|max:100',
            'no_hp' => ['required', 'string'],
            'nama_ayah' => ['required', 'string'],
            'nama_ibu' => ['required', 'string'],
            'hp_orang_tua' => ['required', 'string'],
        ], [
            'name.required' => 'Nama pengguna wajib diisi.',
            'email.unique' => 'Email ini sudah terdaftar.',
            'password.confirmed' => 'Konfirmasi password tidak cocok.',
            'nis.required' => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.unique' => 'NIS ini sudah digunakan oleh peserta lain.',
            'nama_lengkap.required' => 'Nama lengkap peserta wajib diisi.',
            'no_hp.required' => 'Nomor HP peserta wajib diisi.',
            'nama_ayah.required' => 'Nama ayah wajib diisi.',
            'nama_ibu.required' => 'Nama ibu wajib diisi.',
            'hp_orang_tua.required' => 'Nomor HP orang tua wajib diisi untuk keperluan darurat.',
        ]);

        // 2. Transaksi Database
        DB::transaction(function () use ($request) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'user', // Pastikan kolom role ada
            ]);

            Peserta::create([
                'user_id' => $user->id,
                'nis' => $request->nis,
                'nama_lengkap' => $request->nama_lengkap,
                'nama_panggilan' => $request->nama_panggilan,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'jenis_kelamin' => $request->jenis_kelamin,
                'agama' => $request->agama,
                'alamat_sekarang' => $request->alamat_sekarang,
                'pekerjaan' => $request->pekerjaan,
                'no_hp' => $request->no_hp,
                'asal_sekolah' => $request->asal_sekolah,
                'nama_ayah' => $request->nama_ayah,
                'nama_ibu' => $request->nama_ibu,
                'hp_orang_tua' => $request->hp_orang_tua,
                'status_tempat_tinggal' => $request->status_tempat_tinggal,
            ]);

            event(new Registered($user));
            Auth::login($user);
        });

        return redirect(route('dashboard', absolute: false));
    }
}
