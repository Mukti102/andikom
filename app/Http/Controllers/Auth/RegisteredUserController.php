<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Mail\AdminNotificationMail;
use App\Models\Peserta;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
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
        // 1. Validasi gabungan
        $validated = $request->validate([
            'name'          => ['required', 'string', 'max:255'],
            'email'         => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:users,email'],
            'password'      => ['required', 'confirmed', Rules\Password::defaults()],
            'nis'           => ['required', 'unique:peserta,nis'],
            'nama_lengkap'  => ['required', 'string', 'max:255'],
            'nama_panggilan' => ['nullable', 'string', 'max:50'],
            'tanggal_lahir' => ['required', 'date'],
            'tempat_lahir'  => ['required', 'string', 'max:100'],
            'jenis_kelamin' => ['required', 'in:L,P'],
            'agama'         => ['required', 'string', 'max:50'],
            'alamat_sekarang' => ['required', 'string'],
            'pekerjaan'     => ['nullable', 'string', 'max:100'],
            'no_hp'         => ['required', 'string'],
            'asal_sekolah'  => ['nullable', 'string', 'max:100'],
            'nama_ayah'     => ['required', 'string'],
            'nama_ibu'      => ['required', 'string'],
            'hp_orang_tua'  => ['required', 'string'],
            'status_tempat_tinggal' => ['required', 'string', 'max:100'],

            // Dokumen
            'kartu_keluarga' => ['required', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'ktp-akte'       => ['required', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'pas-photo'      => ['required', 'image', 'mimes:jpg,jpeg,png', 'max:1024'],
        ], $this->validationMessages());

        try {
            DB::transaction(function () use ($validated, $request) {
                // 2. Buat User
                $user = User::create([
                    'name'     => $validated['name'],
                    'email'    => $validated['email'],
                    'password' => Hash::make($validated['password']),
                    'role'     => 'user',
                ]);

                // 3. Buat Peserta (Ambil semua kecuali data user & file)
                $pesertaData = collect($validated)
                    ->except(['name', 'email', 'password', 'password_confirmation', 'kartu_keluarga', 'ktp-akte', 'pas-photo'])
                    ->merge(['user_id' => $user->id, 'status_aktif' => false])
                    ->toArray();

              

                $peserta = Peserta::create($pesertaData);

                // 4. Simpan Dokumen
                $peserta->documents()->create([
                    'kartu_keluarga' => $request->file('kartu_keluarga')->store('documents/kk', 'public'),
                    'ktp-akte'       => $request->file('ktp-akte')->store('documents/ktp', 'public'),
                    'pas-photo'      => $request->file('pas-photo')->store('documents/photo', 'public'),
                ]);
                $admins = User::where('role', 'admin')->get();
                foreach ($admins as $admin) {
                    Mail::to($admin)->queue(new AdminNotificationMail($peserta));
                }
            });


            return redirect()->back()->with('success', 'Berhasil Mendaftar. Silahkan tunggu konfirmasi dari admin.');
        } catch (\Exception $e) {
            // Jika ada error (misal: disk penuh atau db down), user tidak akan terbuat
            return redirect()->back()->withInput()->with('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }

    /**
     * Custom Validation Messages
     */
    protected function validationMessages(): array
    {
        return [
            // Akun & Identitas Utama
            'name.required'         => 'Nama pengguna wajib diisi.',
            'email.required'        => 'Alamat email wajib diisi.',
            'email.email'           => 'Format email tidak valid.',
            'email.unique'          => 'Email ini sudah terdaftar, silakan gunakan email lain.',
            'password.required'     => 'Password wajib diisi.',
            'password.confirmed'    => 'Konfirmasi password tidak cocok.',
            'password.min'          => 'Password minimal harus 8 karakter.',

            // Data Peserta
            'nis.required'          => 'Nomor Induk Siswa (NIS) wajib diisi.',
            'nis.unique'            => 'NIS ini sudah digunakan oleh peserta lain.',
            'nama_lengkap.required' => 'Nama lengkap wajib diisi sesuai identitas.',
            'tempat_lahir.required' => 'Tempat lahir wajib diisi.',
            'tanggal_lahir.required' => 'Tanggal lahir wajib diisi.',
            'tanggal_lahir.date'    => 'Format tanggal lahir tidak valid.',
            'jenis_kelamin.required' => 'Silakan pilih jenis kelamin.',
            'jenis_kelamin.in'      => 'Pilihan jenis kelamin tidak valid.',
            'agama.required'        => 'Agama wajib diisi.',
            'no_hp.required'        => 'Nomor HP aktif wajib diisi.',

            // Data Alamat & Orang Tua
            'alamat_sekarang.required' => 'Alamat domisili saat ini wajib diisi.',
            'status_tempat_tinggal.required' => 'Status tempat tinggal wajib diisi.',
            'nama_ayah.required'    => 'Nama ayah wajib diisi.',
            'nama_ibu.required'     => 'Nama ibu wajib diisi.',
            'hp_orang_tua.required' => 'Nomor HP orang tua wajib diisi untuk keperluan darurat.',

            // Dokumen (File Upload)
            'kartu_keluarga.required' => 'File Kartu Keluarga (KK) wajib diunggah.',
            'kartu_keluarga.mimes'    => 'Kartu Keluarga harus berupa format: JPG, PNG, atau PDF.',
            'kartu_keluarga.max'      => 'Ukuran file Kartu Keluarga maksimal 2MB.',

            'ktp-akte.required'       => 'File KTP atau Akte Kelahiran wajib diunggah.',
            'ktp-akte.mimes'          => 'Format KTP/Akte harus berupa: JPG, PNG, atau PDF.',
            'ktp-akte.max'            => 'Ukuran file KTP/Akte maksimal 2MB.',

            'pas-photo.required'      => 'Pas Photo wajib diunggah.',
            'pas-photo.image'         => 'File pas photo harus berupa gambar.',
            'pas-photo.mimes'         => 'Format foto harus berupa: JPG, JPEG, atau PNG.',
            'pas-photo.max'           => 'Ukuran foto terlalu besar, maksimal 1MB.',
        ];
    }
}
