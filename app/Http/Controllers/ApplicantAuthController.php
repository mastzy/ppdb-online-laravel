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
        $identifier = trim($request->input('identifier', $request->input('nik', $request->input('reg_code', ''))));
        $dobInput = trim($request->input('dob', ''));

        // Jika form mengirim identifier gabungan (NIK 16 digit atau Kode Pendaftaran)
        if (!empty($identifier)) {
            // Cek apakah identifier adalah Kode Registrasi (mengandung PPDB atau huruf)
            if (preg_match('/[a-zA-Z]/', $identifier)) {
                $applicant = Registration::where('reg_code', strtoupper($identifier))->first();

                // Jika pendaftar memasukkan tanggal lahir untuk verifikasi tambahan
                if ($applicant && !empty($dobInput)) {
                    $dob = $this->parseDob($dobInput);
                    if ($dob && $applicant->dob && $applicant->dob->format('Y-m-d') !== $dob) {
                        return back()->withInput()->with('error', 'Tanggal Lahir tidak cocok dengan Kode Pendaftaran ini.');
                    }
                }
            } else {
                // Berarti NIK 16 digit
                $request->validate([
                    'identifier' => 'sometimes|digits:16',
                    'nik' => 'sometimes|digits:16',
                    'dob' => 'required|string',
                ], [
                    'identifier.digits' => 'NIK harus berjumlah tepat 16 digit.',
                    'nik.digits' => 'NIK harus berjumlah tepat 16 digit.',
                    'dob.required' => 'Tanggal Lahir wajib diisi sebagai PIN masuk.',
                ]);

                $dob = $this->parseDob($dobInput);
                if (!$dob) {
                    return back()->withInput()->with('error', 'Format tanggal lahir tidak valid. Gunakan format DDMMYYYY (contoh: 15052010) atau pilih dari kalender.');
                }

                $applicant = Registration::byNikAndDob($identifier, $dob)->first();
            }
        } else {
            return back()->withInput()->with('error', 'Silakan masukkan NIK 16 digit atau Kode Pendaftaran Anda.');
        }

        if (! $applicant) {
            return back()->withInput()->with('error', 'Data pendaftaran tidak ditemukan. Pastikan NIK dan Tanggal Lahir atau Kode Pendaftaran yang dimasukkan sudah benar.');
        }

        // Simpan sesi autentikasi pendaftar
        session(['applicant_id' => $applicant->id]);

        return redirect()->route('pendaftar.formulir')
            ->with('success', 'Selamat datang kembali, '.$applicant->full_name.'! Kuota dan data pendaftaran Anda aktif.');
    }

    /**
     * Helper parsing berbagai variasi format tanggal lahir.
     */
    private function parseDob(string $input): ?string
    {
        if (preg_match('/^\d{8}$/', $input)) {
            try {
                return Carbon::createFromFormat('dmY', $input)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $input)) {
            return $input;
        } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $input)) {
            try {
                return Carbon::createFromFormat('d-m-Y', $input)->format('Y-m-d');
            } catch (\Exception $e) {
                return null;
            }
        }
        return null;
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
