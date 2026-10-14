namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        // REQ-AUTH-01: Validasi NIK 16 digit & NISN 10 digit unik
        $request->validate([
            'name'     => 'required|string|max:255',
            'email'    => 'required|email|unique:users,email',
            'nik'      => 'required|digits:16|unique:users,nik',
            'nisn'     => 'required|digits:10|unique:users,nisn',
            'password' => 'required|min:8|confirmed',
        ]);

        $user = User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'nik'      => $request->nik,
            'nisn'     => $request->nisn,
            'password' => Hash::make($request->password),
            'role'     => 'siswa', // REQ-AUTH-02: Default role siswa
        ]);

        auth()->login($user);

        return redirect()->route('dashboard.siswa')->with('success', 'Registrasi akun berhasil!');
    }
}