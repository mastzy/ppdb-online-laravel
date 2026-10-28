<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplicantAuthController extends Controller
{
    /**
     * Tampilkan formulir login khusus calon siswa / orang tua.
     */
    public function showLoginForm(): View|RedirectResponse
    {
        if (session()->has('applicant_id') && Registration::find(session('applicant_id'))) {
            return redirect()->route('pendaftar.formulir');
        }

        return view('pendaftar.login');
    }

    /**
     * Proses autentikasi pendaftar tanpa email & tanpa password.
     * Menggunakan NIK (16 digit) + Tanggal Lahir (DDMMYYYY) ATAU Kode Registrasi.
     */
    public function login(Request $request): RedirectResponse
    {
        $loginType = $request->input('login_type', 'nik_dob');

        if ($loginType === 'reg_code') {
            $request->validate([
                'reg_code' => 'required|string|max:50',
            ], [
                'reg_code.required' => 'Kode Registrasi wajib diisi.',
            ]);

            $regCode = strtoupper(trim($request->input('reg_code')));
            $applicant = Registration::where('reg_code', $regCode)->first();
        } else {
            $request->validate([
                'nik' => 'required|digits:16',
                'dob' => 'required|string',
            ], [
                'nik.required' => 'NIK 16 digit wajib diisi.',
                'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
                'dob.required' => 'Tanggal Lahir wajib diisi.',
            ]);

            $nik = trim($request->input('nik'));
            $dobInput = trim($request->input('dob'));

            // Mendukung format DDMMYYYY (misal: 15052010) atau YYYY-MM-DD dari HTML datepicker
            $dob = null;
            if (preg_match('/^\d{8}$/', $dobInput)) {
                try {
                    $dob = Carbon::createFromFormat('dmY', $dobInput)->format('Y-m-d');
                } catch (\Exception $e) {
                    $dob = null;
                }
            } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dobInput)) {
                $dob = $dobInput;
            } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $dobInput)) {
                try {
                    $dob = Carbon::createFromFormat('d-m-Y', $dobInput)->format('Y-m-d');
                } catch (\Exception $e) {
                    $dob = null;
                }
            }

            if (! $dob) {
                return back()->withInput()->with('error', 'Format tanggal lahir tidak valid. Gunakan format DDMMYYYY (contoh: 15052010).');
            }

            $applicant = Registration::byNikAndDob($nik, $dob)->first();
        }

        if (! $applicant) {
            return back()->withInput()->with('error', 'Data pendaftaran tidak ditemukan. Mohon periksa kembali NIK dan Tanggal Lahir atau Kode Registrasi Anda.');
        }

        // Simpan sesi autentikasi pendaftar
        session(['applicant_id' => $applicant->id]);

        return redirect()->route('pendaftar.formulir')
            ->with('success', 'Selamat datang kembali, '.$applicant->full_name.'! Silakan lanjutkan pendaftaran Anda.');
    }

    /**
     * Keluar dari sesi pendaftaran.
     */
    public function logout(): RedirectResponse
    {
        session()->forget('applicant_id');

        return redirect()->route('pendaftar.login')
            ->with('success', 'Anda telah berhasil keluar dari sesi pendaftaran.');
    }
}
