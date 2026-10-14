namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class VerificationController extends Controller
{
    public function index(Request $request)
    {
        $query = Registration::with('user', 'documents');

        if ($request->filled('jalur')) {
            $query->where('jalur', $request->jalur);
        }
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $registrations = $query->paginate(15);
        return view('verifikator.dashboard', compact('registrations'));
    }

    public function updateStatus(Request $request, Registration $registration)
    {
        // REQ-VERIF-03: Catatan koreksi wajib jika status rejected / revision_needed
        $request->validate([
            'status'          => 'required|in:approved,rejected,revision_needed',
            'catatan_koreksi' => 'required_if:status,rejected,revision_needed|nullable|string',
        ]);

        $registration->update([
            'status'          => $request->status,
            'catatan_koreksi' => $request->catatan_koreksi,
        ]);

        return back()->with('success', 'Status verifikasi pendaftar berhasil diperbarui.');
    }
}