<?php

use App\Http\Controllers\AdminExportController;
use App\Http\Controllers\ApplicantAuthController;
use App\Http\Controllers\ApplicantRegistrationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CashierController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\PdfCardController;
use App\Http\Controllers\ReceiptController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\StopmapResumeController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\WelcomeHubController;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi PPDB Online Mandiri
|--------------------------------------------------------------------------
*/

// --- 1. Landing Page & Public Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::redirect('/daftar', '/pendaftar/formulir')->name('daftar');

// Rute untuk cek status publik via Form GET di Landing Page (Halaman Hasil Pencarian Cepat)
Route::get('/pendaftar/cek-status', function (Request $request) {
    $search = trim($request->input('search', ''));

    if (empty($search)) {
        return redirect()->route('home')->with('error', 'Masukkan NIK atau Kode Pendaftaran untuk mencari.');
    }

    $registration = Registration::with(['cluster', 'documents', 'latestPayment'])
        ->where('nik', $search)
        ->orWhere('reg_code', strtoupper($search))
        ->first();

    return view('pendaftar.cek_status_result', compact('registration', 'search'));
})->name('pendaftar.cek-status');


// --- 2. Alur Pendaftar (Calon Siswa / Orang Tua: Zero-Friction UX) ---
Route::prefix('pendaftar')->name('pendaftar.')->group(function () {
    // Autentikasi Tanpa Password (NIK 16 Digit + Tanggal Lahir DDMMYYYY atau Kode Registrasi)
    Route::get('/login', [ApplicantAuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [ApplicantAuthController::class, 'login'])->name('login.submit');
    Route::post('/logout', [ApplicantAuthController::class, 'logout'])->name('logout');

    // Formulir Multistep Pendaftaran (Alpine.js + Tailwind CSS)
    Route::get('/formulir', [ApplicantRegistrationController::class, 'index'])->name('formulir');
    Route::post('/step-1', [ApplicantRegistrationController::class, 'saveStep1'])->name('step1');

    // Tahapan lanjutan dilindungi oleh middleware applicant.auth
    Route::middleware('applicant.auth')->group(function () {
        Route::post('/step-2', [ApplicantRegistrationController::class, 'saveStep2'])->name('step2');
        Route::post('/step3', [ApplicantRegistrationController::class, 'saveStep3'])->name('save_step3');
        // Alias without dash for compatibility
        Route::post('/step3', [ApplicantRegistrationController::class, 'saveStep3'])->name('save_step3');
        Route::post('/check-sibling', [ApplicantRegistrationController::class, 'checkSibling'])->name('check_sibling');
        Route::post('/upload-document', [ApplicantRegistrationController::class, 'uploadDocument'])->name('upload_document');
        Route::post('/finalize', [ApplicantRegistrationController::class, 'finalize'])->name('finalize');

        // Modul Pembayaran Mandiri Calon Siswa (Transfer Bank & Upload Struk)
        Route::get('/pembayaran', [PaymentController::class, 'show'])->name('pembayaran');
        Route::post('/pembayaran', [PaymentController::class, 'store'])->name('pembayaran.store');

        // Halaman "Welcome Hub" Interaktif bagi Calon Siswa yang Lulus
        Route::get('/welcome-hub', [WelcomeHubController::class, 'show'])->name('welcome_hub');
    });
});


// --- 3. Autentikasi Panitia & Admin (Username + Password) ---
Route::middleware('guest')->group(function () {
    Route::get('/admin/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/admin/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');


// --- 4. Dashboard Calon Siswa (Legacy / Compatibility) ---
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [RegistrationController::class, 'index'])->name('siswa.dashboard');
    Route::post('/registration/draft', [RegistrationController::class, 'saveDraft'])->name('registration.draft');
    Route::post('/registration/finalize', [RegistrationController::class, 'finalize'])->name('registration.finalize');
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.upload');
    Route::get('/registration/card/pdf', [PdfCardController::class, 'downloadCard'])->name('registration.card.pdf');
    Route::get('/siswa/pembayaran', [PaymentController::class, 'show'])->name('siswa.pembayaran');
    Route::get('/siswa/welcome-hub', [WelcomeHubController::class, 'show'])->name('siswa.welcome_hub');
});


// --- 5. Dashboard Panitia & Verifikator ---
Route::middleware(['auth', 'role:verifikator,admin'])->group(function () {
    Route::get('/verifikator/dashboard', [VerificationController::class, 'index'])->name('verifikator.dashboard');
    Route::post('/verifikator/verify/{registration}', [VerificationController::class, 'updateStatus'])->name('verifikator.verify');
    Route::get('/verifikator/document/{document}/preview', [DocumentController::class, 'preview'])->name('verifikator.document.preview');

    // Modul Asesmen Diagnostik (Penguji / Verifikator)
    Route::get('/admin/assessment', [\App\Http\Controllers\AssessmentController::class, 'index'])->name('admin.assessment.index');
    Route::post('/admin/assessment/{registration}', [\App\Http\Controllers\AssessmentController::class, 'store'])->name('admin.assessment.store');

    // Executive Dashboard Analytics
    Route::get('/admin/dashboard', function () {
        $totalRegistrations = Registration::count();
        $passedRegistrations = Registration::whereIn('status', ['approved', 'passed', 'lunas'])->count();
        $totalRevenue = \App\Models\Payment::whereIn('status', ['verified', 'paid'])->sum('amount');
        if ($totalRevenue == 0) {
            $totalRevenue = Registration::whereIn('status', ['paid', 'approved', 'passed'])->count() * 300000;
        }
        $boardingCount = Registration::where('is_boarding', true)->count();

        $clusters = \App\Models\ProgramCluster::withCount('registrations')->get();
        $clusterLabels = $clusters->pluck('name')->toArray();
        $clusterCounts = $clusters->pluck('registrations_count')->toArray();

        $statusCounts = [
            Registration::where('status', 'draft')->count(),
            Registration::where('status', 'pending_payment')->count(),
            Registration::where('status', 'paid')->count(),
            Registration::where('status', 'revision_needed')->count(),
            Registration::whereIn('status', ['approved', 'passed'])->count(),
        ];

        return view('admin.dashboard', compact(
            'totalRegistrations', 'passedRegistrations', 'totalRevenue', 'boardingCount',
            'clusterLabels', 'clusterCounts', 'statusCounts'
        ));
    })->name('admin.dashboard');

    // Pengaturan Kuota & Gelombang (Admin Settings)
    Route::get('/admin/settings', function () {
        $clusters = \App\Models\ProgramCluster::all();
        return view('admin.settings.index', compact('clusters'));
    })->name('admin.settings.index');

    Route::post('/admin/settings/clusters', function (Request $request) {
        $quotas = $request->input('quota', []);
        foreach ($quotas as $id => $val) {
            \App\Models\ProgramCluster::where('id', $id)->update(['quota' => (int) $val]);
        }
        return back()->with('success', 'Alokasi kuota klaster berhasil diperbarui.');
    })->name('admin.settings.update_clusters');
});


// --- 6. Quick Status Check API (Public JSON API, No Login) ---
Route::get('/api/quick-status', function (Request $request) {
    $query = trim($request->input('q', ''));
    if (empty($query)) {
        return response()->json(['success' => false, 'message' => 'Masukkan NIK atau Kode Registrasi'], 422);
    }

    $registration = Registration::with(['cluster', 'documents', 'latestPayment'])
        ->where('nik', $query)
        ->orWhere('reg_code', strtoupper($query))
        ->first();

    if (! $registration) {
        return response()->json(['success' => false, 'message' => 'Data pendaftar dengan NIK / Kode: ' . $query . ' tidak ditemukan.'], 404);
    }

    return response()->json([
        'success' => true,
        'data' => [
            'id' => $registration->id,
            'reg_code' => $registration->reg_code,
            'full_name' => $registration->full_name,
            'nik' => substr($registration->nik, 0, 6) . '******' . substr($registration->nik, -4),
            'wave_name' => $registration->wave_name,
            'cluster_name' => $registration->cluster?->name ?? 'Belum Memilih',
            'status' => $registration->status,
            'is_boarding' => $registration->is_boarding,
            'has_sibling_discount' => $registration->has_sibling_discount,
            'documents_count' => $registration->documents->count(),
            'payment_status' => $registration->latestPayment?->status ?? ($registration->status === 'paid' ? 'verified' : 'unpaid'),
            'catatan_koreksi' => $registration->catatan_koreksi,
            'created_at' => $registration->created_at->format('d M Y H:i'),
        ],
    ]);
})->name('api.quick_status');


// --- 7. Fitur Ekspor Data Admin (Format EMIS Kemenag & Dapodik Kemendikbud) ---
Route::middleware(['auth', 'role:admin,verifikator,bendahara'])->group(function () {
    Route::get('/admin/export/emis', [AdminExportController::class, 'exportEmis'])->name('admin.export.emis');
    Route::get('/admin/export/dapodik', [AdminExportController::class, 'exportDapodik'])->name('admin.export.dapodik');
});


// --- 8. Mode Kasir Offline (Dashboard Bendahara & Kasir PPDB) ---
Route::middleware(['auth', 'role:bendahara,admin'])->group(function () {
    Route::get('/bendahara/kasir', [CashierController::class, 'index'])->name('bendahara.kasir');
    Route::get('/bendahara/kasir/search', [CashierController::class, 'search'])->name('bendahara.kasir.search');
    Route::post('/bendahara/kasir/pay-cash/{registration}', [CashierController::class, 'payCash'])->name('bendahara.kasir.pay_cash');
});


// --- 9. Generator Lembar Ringkasan Stopmap (One-Page Resume PDF) ---
Route::get('/stopmap/{registration}/pdf', [StopmapResumeController::class, 'download'])->name('stopmap.pdf');
Route::get('/stopmap/{registration}/stream', [StopmapResumeController::class, 'stream'])->name('stopmap.stream');


// --- 10. Generator Kuitansi PDF & QR Code Validation ---
Route::get('/kuitansi/{registration}/pdf', [ReceiptController::class, 'download'])->name('kuitansi.pdf');
Route::get('/kuitansi/{registration}/stream', [ReceiptController::class, 'stream'])->name('kuitansi.stream');
Route::get('/verify/receipt/{hash}', [ReceiptController::class, 'verifyPublic'])->name('verify.receipt');

// Generator Surat Keterangan Lulus (SK Lulus PDF)
Route::get('/sk-lulus/{registration}/pdf', function (Registration $registration) {
    $encryptedHash = \Illuminate\Support\Facades\Crypt::encryptString((string) $registration->id);
    $verifyUrl = route('verify.document', ['hash' => $encryptedHash]);
    $qrCode = base64_encode(\SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(100)->margin(0)->generate($verifyUrl));

    $stampPath = public_path('images/stempel_lunas.png');
    $stampBase64 = file_exists($stampPath) ? base64_encode(file_get_contents($stampPath)) : '';

    $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('pdf.sk_lulus', [
        'registration' => $registration->load('cluster'),
        'qrCode' => $qrCode,
        'stampBase64' => $stampBase64,
    ]);
    $pdf->setPaper('a4', 'portrait');

    return $pdf->download('SK_Lulus_'.$registration->reg_code.'.pdf');
})->name('sk_lulus.pdf');


// --- 11. Public Route: Validasi Kartu Pendaftaran & Dokumen ---
Route::get('/verify/document/{hash}', function ($hash) {
    try {
        $id = decrypt($hash);
        $registration = Registration::with(['cluster', 'documents'])->findOrFail($id);

        return view('public.verify_document', compact('registration'));
    } catch (\Exception $e) {
        abort(404, 'Dokumen tidak valid atau tautan verifikasi telah kadaluarsa.');
    }
})->name('verify.document');