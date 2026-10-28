<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Crypt;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class ReceiptController extends Controller
{
    /**
     * Generator Kuitansi PDF Resmi:
     * - Format PDF menggunakan barryvdh/laravel-dompdf
     * - Dilengkapi QR Code validasi keabsahan menggunakan simplesoftwareio/simple-qrcode
     * - Dilengkapi gambar stempel digital resmi panitia LUNAS
     */
    public function download(Request $request, Registration $registration): Response
    {
        // Validasi akses: Siswa yang bersangkutan atau Panitia (Admin / Bendahara / Verifikator)
        $this->authorizeAccess($request, $registration);

        // Ambil pembayaran yang sah (verified) atau pembayaran terakhir
        $payment = $registration->payments()
            ->where('status', 'verified')
            ->latest()
            ->first();

        if (! $payment) {
            $payment = $registration->latestPayment;
        }

        // Generate encrypted verification link untuk QR Code
        $encryptedHash = Crypt::encryptString((string) $registration->id);
        $verifyUrl = route('verify.receipt', ['hash' => $encryptedHash]);

        // Generate QR Code format SVG base64
        $qrCodeSvg = base64_encode(QrCode::format('svg')->size(130)->margin(0)->generate($verifyUrl));

        // Stempel digital path / base64
        $stampPath = public_path('images/stempel_lunas.png');
        $stampBase64 = '';
        if (file_exists($stampPath)) {
            $stampBase64 = base64_encode(file_get_contents($stampPath));
        }

        $pdf = Pdf::loadView('pdf.kuitansi_pembayaran', [
            'registration' => $registration,
            'payment' => $payment,
            'qrCode' => $qrCodeSvg,
            'stampBase64' => $stampBase64,
            'receiptNumber' => 'KWT-'.date('Ymd', strtotime($payment ? $payment->created_at : $registration->updated_at)).'-'.str_pad((string) $registration->id, 4, '0', STR_PAD_LEFT),
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Kuitansi_PPDB_'.$registration->reg_code.'.pdf';

        return $pdf->download($fileName);
    }

    /**
     * Stream kuitansi PDF langsung di browser (preview).
     */
    public function stream(Request $request, Registration $registration): Response
    {
        $this->authorizeAccess($request, $registration);

        $payment = $registration->payments()
            ->where('status', 'verified')
            ->latest()
            ->first();

        if (! $payment) {
            $payment = $registration->latestPayment;
        }

        $encryptedHash = Crypt::encryptString((string) $registration->id);
        $verifyUrl = route('verify.receipt', ['hash' => $encryptedHash]);

        $qrCodeSvg = base64_encode(QrCode::format('svg')->size(130)->margin(0)->generate($verifyUrl));

        $stampPath = public_path('images/stempel_lunas.png');
        $stampBase64 = '';
        if (file_exists($stampPath)) {
            $stampBase64 = base64_encode(file_get_contents($stampPath));
        }

        $pdf = Pdf::loadView('pdf.kuitansi_pembayaran', [
            'registration' => $registration,
            'payment' => $payment,
            'qrCode' => $qrCodeSvg,
            'stampBase64' => $stampBase64,
            'receiptNumber' => 'KWT-'.date('Ymd', strtotime($payment ? $payment->created_at : $registration->updated_at)).'-'.str_pad((string) $registration->id, 4, '0', STR_PAD_LEFT),
        ]);

        $pdf->setPaper('a4', 'portrait');

        $fileName = 'Kuitansi_PPDB_'.$registration->reg_code.'.pdf';

        return $pdf->stream($fileName);
    }

    /**
     * Halaman Publik untuk Scan QR Code Validasi Keabsahan Kuitansi.
     */
    public function verifyPublic(string $hash)
    {
        try {
            $id = Crypt::decryptString($hash);
            $registration = Registration::with(['cluster', 'latestPayment.verifier'])->findOrFail($id);

            $payment = $registration->payments()
                ->where('status', 'verified')
                ->latest()
                ->first() ?? $registration->latestPayment;

            return view('public.verify_receipt', compact('registration', 'payment'));
        } catch (\Exception $e) {
            abort(404, 'Kuitansi tidak valid atau barcode keabsahan telah rusak.');
        }
    }

    /**
     * Helper otorisasi akses kuitansi.
     */
    private function authorizeAccess(Request $request, Registration $registration): void
    {
        // Jika login sebagai panitia
        if (auth()->check() && in_array(auth()->user()->role, ['admin', 'bendahara', 'verifikator'])) {
            return;
        }

        // Jika login pendaftar via session applicant_id
        if (session('applicant_id') && session('applicant_id') == $registration->id) {
            return;
        }

        // Jika login via auth user siswa
        if (auth()->check() && auth()->user()->id === $registration->user_id) {
            return;
        }

        abort(403, 'Anda tidak berhak mengakses dokumen kuitansi ini.');
    }
}
