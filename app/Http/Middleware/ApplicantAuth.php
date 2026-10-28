<?php

namespace App\Http\Middleware;

use App\Models\Registration;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApplicantAuth
{
    /**
     * Handle an incoming request for applicants.
     *
     * @param  Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $applicantId = session('applicant_id');

        if (! $applicantId) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Silakan masuk menggunakan NIK atau Kode Registrasi.'], 401);
            }

            return redirect()->route('pendaftar.login')
                ->with('error', 'Silakan masuk terlebih dahulu menggunakan NIK atau Kode Registrasi.');
        }

        $applicant = Registration::find($applicantId);

        if (! $applicant) {
            session()->forget('applicant_id');

            if ($request->expectsJson()) {
                return response()->json(['message' => 'Data pendaftar tidak ditemukan.'], 401);
            }

            return redirect()->route('pendaftar.login')
                ->with('error', 'Sesi pendaftaran Anda telah berakhir. Silakan masuk kembali.');
        }

        // Simpan instance pendaftar ke request attributes agar mudah diakses di controller
        $request->attributes->set('applicant', $applicant);

        return $next($request);
    }
}
