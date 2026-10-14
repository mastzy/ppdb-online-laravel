namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    // REQ-REG-02: Save Draft Otomatis
    public function saveDraft(Request $request)
    {
        $registration = Registration::firstOrCreate(['user_id' => auth()->id()]);

        if ($registration->is_locked) {
            return back()->with('error', 'Data pendaftaran sudah dikunci dan tidak dapat diubah.');
        }

        $registration->update([
            'data_diri'      => $request->input('data_diri'),
            'data_orang_tua' => $request->input('data_orang_tua'),
            'data_akademik'  => $request->input('data_akademik'),
            'jalur'          => $request->input('jalur'),
            'status'         => 'draft',
        ]);

        return back()->with('success', 'Draft pendaftaran berhasil disimpan.');
    }

    // REQ-REG-03: Finalisasi / Lock Data
    public function finalize()
    {
        $registration = auth()->user()->registration;

        if (!$registration || $registration->is_locked) {
            return back()->with('error', 'Pendaftaran tidak dapat difinalisasi.');
        }

        $registration->update([
            'is_locked' => true, // Penguncian permanen
        ]);

        return back()->with('success', 'Pendaftaran berhasil difinalisasi dan data telah dikunci.');
    }
}