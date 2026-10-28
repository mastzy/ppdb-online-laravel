<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfCardController extends Controller
{
    // REQ-OUT-02 & REQ-OUT-03: Cetak Kartu PDF & QR Code Validation
    public function downloadCard()
    {
        $registration = Registration::with(['user', 'documents'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (! $registration->is_locked) {
            return back()->with('error', 'Anda harus melakukan finalisasi data terlebih dahulu.');
        }

        // Buat enkripsi payload QR Code
        $encryptedHash = Crypt::encryptString($registration->id);
        $verifyUrl = route('verify.document', ['hash' => $encryptedHash]);

        // Generate QR Code format SVG
        $qrCode = base64_encode(QrCode::format('svg')->size(120)->generate($verifyUrl));

        $pdf = Pdf::loadView('pdf.kartu_pendaftaran', compact('registration', 'qrCode'));

        return $pdf->download('Kartu_PPDB_'.$registration->user->nisn.'.pdf');
    }
}
