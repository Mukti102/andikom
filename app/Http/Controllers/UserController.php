<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash; // Tambahkan ini
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $users = User::orderBy('created_at', 'desc')->where('role', '!=', 'user')->get();
        return view('pages.admin.users.index', compact('users'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $messages = [
            'name.required'     => 'Nama lengkap wajib diisi.',
            'name.string'       => 'Nama harus berupa teks.',
            'name.max'          => 'Nama maksimal 255 karakter.',
            'email.required'    => 'Alamat email wajib diisi.',
            'email.email'       => 'Format email tidak valid.',
            'email.unique'      => 'Email sudah terdaftar, gunakan email lain.',
            'phone.max'         => 'Nomor telepon maksimal 15 karakter.',
            'role.required'     => 'Role pengguna harus dipilih.',
            'role.in'           => 'Role yang dipilih tidak valid.',
            'password.required' => 'Password wajib diisi.',
            'password.min'      => 'Password minimal harus :min karakter.',
        ];

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users',
            'phone'    => 'nullable|string|max:15',
            'role'     => 'required|in:user,admin,tutor,owner',
            'password' => 'required|string|min:8',
        ], $messages);

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'phone'    => $request->phone,
            'role'     => $request->role,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success', 'User berhasil ditambahkan.');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $user = User::findOrFail($id);

        $messages = [
            'name.required'  => 'Nama lengkap tidak boleh kosong.',
            'email.required' => 'Email tidak boleh kosong.',
            'email.unique'   => 'Email sudah digunakan oleh user lain.',
            'role.required'  => 'Pilih salah satu role.',
            'password.min'   => 'Password baru minimal :min karakter.',
        ];

        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone'    => 'nullable|string|max:15',
            'role'     => 'required|in:user,admin,tutor,owner',
            'password' => 'nullable|string|min:8',
        ], $messages);

        $data = [
            'name'  => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'role'  => $request->role,
        ];

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        $user->update($data);

        return redirect()->back()->with('success', 'Data user berhasil diperbarui.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::findOrFail($id);

        // Opsional: Hapus avatar jika ada filenya di storage
        if ($user->avatar) {
            Storage::delete('public/' . $user->avatar);
        }

        $user->delete();

        return redirect()->back()->with('success', 'User berhasil dihapus.');
    }
}
