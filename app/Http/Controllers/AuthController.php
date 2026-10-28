<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function showRegisterForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        // REQ-AUTH-01: Validasi NIK (16 digit) & NISN (10 digit) unik
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users',
            'nik' => 'required|digits:16|unique:users,nik',
            'nisn' => 'required|digits:10|unique:users,nisn',
            'password' => 'required|string|min:8|confirmed',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'nik' => $request->nik,
            'nisn' => $request->nisn,
            'password' => Hash::make($request->password),
            'role' => 'siswa',
        ]);

        // Inisialisasi draft pendaftaran
        Registration::create([
            'user_id' => $user->id,
            'status' => 'draft',
        ]);

        Auth::login($user);

        return redirect()->route('siswa.dashboard')->with('success', 'Registrasi berhasil! Silakan lengkapi pendaftaran Anda.');
    }

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            if (Auth::user()->role === 'siswa') {
                return redirect()->route('siswa.dashboard');
            }
            if (Auth::user()->role === 'bendahara') {
                return redirect()->route('bendahara.kasir');
            }

            return redirect()->route('verifikator.dashboard');
        }

        return back()->withErrors(['email' => 'Kredensial yang dimasukkan tidak sesuai.']);
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}
