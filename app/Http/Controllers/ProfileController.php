<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Tampilkan halaman profil panitia yang sedang login.
     */
    public function edit(): View
    {
        $user = Auth::user();

        return view('panitia.profil', compact('user'));
    }

    /**
     * Validasi dan perbarui nama serta email panitia.
     */
    public function updateProfile(Request $request): RedirectResponse
    {
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$user->id],
        ], [
            'name.required' => 'Nama panitia wajib diisi.',
            'email.required' => 'Email panitia wajib diisi.',
            'email.email' => 'Format email tidak valid.',
            'email.unique' => 'Email ini sudah digunakan oleh akun lain.',
        ]);

        $user->name = trim($request->input('name'));
        $user->email = trim($request->input('email'));
        $user->save();

        return redirect()->route('panitia.profil')->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Validasi dan perbarui password akun panitia.
     */
    public function updatePassword(Request $request): RedirectResponse
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ], [
            'current_password.required' => 'Password saat ini wajib diisi.',
            'current_password.current_password' => 'Password saat ini tidak sesuai.',
            'password.required' => 'Password baru wajib diisi.',
            'password.min' => 'Password baru minimal 8 karakter.',
            'password.confirmed' => 'Konfirmasi password baru tidak cocok.',
        ]);

        $user = Auth::user();
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('panitia.profil')->with('success', 'Password berhasil diperbarui!');
    }
}
