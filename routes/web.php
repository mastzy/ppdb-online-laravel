<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\PdfCardController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\VerificationController;
use App\Models\Registration;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi PPDB Online
|--------------------------------------------------------------------------
*/

// --- Halaman Utama & Tamu (Guest Routes) ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register'); // REQ-AUTH-01: Validasi NIK/NISN
});

// Logout Route (Auth Users)
Route::post('/logout', function () {
    Auth::logout();
    request()->session()->invalidate();
    request()->session()->regenerateToken();
    return redirect()->route('login');
})->middleware('auth')->name('logout');

// --- Rute Calon Siswa (Role: Siswa) ---
Route::middleware(['auth', 'role:siswa'])->group(function () {
    // Dashboard & Form Pendaftaran Multistep
    Route::get('/siswa/dashboard', [RegistrationController::class, 'index'])->name('siswa.dashboard');
    
    // REQ-REG-01 & REQ-REG-02: Save Draft Form Pendaftaran
    Route::post('/registration/draft', [RegistrationController::class, 'saveDraft'])->name('registration.draft');
    
    // REQ-REG-03: Finalisasi / Lock Data Permanen
    Route::post('/registration/finalize', [RegistrationController::class, 'finalize'])->name('registration.finalize');
    
    // REQ-FILE-01 & REQ-FILE-02: Unggah Berkas & Hashing SHA-256
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.upload');
    
    // REQ-OUT-02: Unduh Kartu Pendaftaran PDF ber-QR Code
    Route::get('/registration/card/pdf', [PdfCardController::class, 'downloadCard'])->name('registration.card.pdf');
});

// --- Rute Panitia & Admin (Role: Verifikator, Admin) ---
Route::middleware(['auth', 'role:verifikator,admin'])->group(function () {
    // REQ-VERIF-01: Dashboard Verifikator & Filtering Pendaftar
    Route::get('/verifikator/dashboard', [VerificationController::class, 'index'])->name('verifikator.dashboard');
    
    // REQ-VERIF-02 & REQ-VERIF-03: Update Status Verifikasi & Catatan Perbaikan
    Route::post('/verifikator/verify/{registration}', [VerificationController::class, 'updateStatus'])->name('verifikator.verify');
    
    // REQ-FILE-03: In-App Document Preview untuk Panitia
    Route::get('/verifikator/document/{document}/preview', [DocumentController::class, 'preview'])->name('verifikator.document.preview');
});

// --- Rute Publik (REQ-OUT-03: Validasi Keabsahan QR Code) ---
Route::get('/verify/document/{hash}', function ($hash) {
    try {
        $id = decrypt($hash);
        $registration = Registration::with(['user', 'documents'])->findOrFail($id);
        return view('public.verify_document', compact('registration'));
    } catch (\Exception $e) {
        abort(404, 'Dokumen tidak valid atau tautan verifikasi telah kadaluarsa.');
    }
})->name('verify.document');