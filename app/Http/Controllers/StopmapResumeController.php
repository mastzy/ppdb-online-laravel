<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class StopmapResumeController extends Controller
{
    /**
     * Generator Lembar Ringkasan Stopmap (One-Page Resume PDF):
     * - Tepat 1 lembar A4 portrait
     * - Berisi ringkasan data identitas calon siswa & orang tua
     * - Checklist berkas fisik persyaratan (KK, Akta, SKL/Ijazah, Pasfoto, Bukti Transfer)
     * - Kotak paraf verifikator/pewawancara & QR Code validasi keabsahan
     * - Ditempel pada stopmap berkas saat sesi wawancara/daftar ulang fisik.
     */
    public function download(Request $request, Registration $registration): Response
    {
        $this->authorizeAccess($request, $registration);

        $registration->load(['cluster', 'documents', 'diagnosticScore', 'latestPayment']);

        // Kelompokkan berkas terunggah berdasarkan doc_type
        $uploadedDocs = $registration->documents->keyBy('doc_type');

        // Buat QR Code validasi pendaftar
        $encryptedHash = Crypt::encryptString((string) $registration->id);
        $verifyUrl = route('verify.document', ['hash' => $encryptedHash]);
        $qrCodeSvg = base64_encode(QrCode::format('svg')->size(110)->margin(0)->generate($verifyUrl));

        $pdf = Pdf::loadView('pdf.ringkasan_stopmap', [
            'registration' => $registration,
            'uploadedDocs' => $uploadedDocs,
            'qrCode' => $qrCodeSvg,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Stopmap_Resume_'.$registration->reg_code.'.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Stream preview langsung PDF Stopmap di browser.
     */
    public function stream(Request $request, Registration $registration): Response
    {
        $this->authorizeAccess($request, $registration);

        $registration->load(['cluster', 'documents', 'diagnosticScore', 'latestPayment']);
        $uploadedDocs = $registration->documents->keyBy('doc_type');

        $encryptedHash = Crypt::encryptString((string) $registration->id);
        $verifyUrl = route('verify.document', ['hash' => $encryptedHash]);
        $qrCodeSvg = base64_encode(QrCode::format('svg')->size(110)->margin(0)->generate($verifyUrl));

        $pdf = Pdf::loadView('pdf.ringkasan_stopmap', [
            'registration' => $registration,
            'uploadedDocs' => $uploadedDocs,
            'qrCode' => $qrCodeSvg,
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Stopmap_Resume_'.$registration->reg_code.'.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Otorisasi akses: Siswa bersangkutan atau Panitia (Admin / Verifikator / Penguji / Bendahara).
     */
    private function authorizeAccess(Request $request, Registration $registration): void
    {
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'verifikator', 'bendahara', 'penguji'])) {
            return;
        }

        if (session('applicant_id') && session('applicant_id') == $registration->id) {
            return;
        }

        if (auth()->check() && auth()->user()->id === $registration->user_id) {
            return;
        }

        abort(403, 'Akses ditolak: Anda tidak memiliki wewenang mencetak berkas stopmap ini.');
    }
}
