namespace App\Http\Controllers;

use App\Models\Registration;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class PdfCardController extends Controller
{
    public function downloadCard()
    {
        $registration = auth()->user()->registration;

        if (!$registration || !$registration->is_locked) {
            return back()->with('error', 'Anda harus me-finalisasi pendaftaran sebelum mengunduh kartu.');
        }

        // REQ-OUT-03: URL enkripsi keabsahan dokumen via QR Code
        $validationUrl = route('verify.document', encrypt($registration->id));
        $qrCode = base64_encode(QrCode::format('svg')->size(120)->generate($validationUrl));

        // REQ-OUT-02: Render PDF
        $pdf = Pdf::loadView('pdf.kartu_pendaftaran', compact('registration', 'qrCode'));
        return $pdf->download("Kartu_PPDB_{$registration->user->nisn}.pdf");
    }
}