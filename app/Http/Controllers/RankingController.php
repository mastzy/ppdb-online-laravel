namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RankingController extends Controller
{
    public function index(Request $request)
    {
        $jalur = $request->get('jalur', 'zonasi');

        // Pemeringkatan pendaftar berstatus approved & finalized
        $rankings = Registration::with('user')
            ->where('status', 'approved')
            ->where('is_locked', true)
            ->where('jalur', $jalur)
            ->orderBy('created_at', 'asc') // Urutan berdasarkan waktu submit/kriteria
            ->paginate(20);

        return view('admin.ranking', compact('rankings', 'jalur'));
    }
}