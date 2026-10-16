<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PdfCardController;
use App\Models\Registration;

/*
|--------------------------------------------------------------------------
| Web Routes - Sistem Informasi PPDB Online
|--------------------------------------------------------------------------
*/

// --- 1. Landing Page & Guest Routes ---
Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
    Route::get('/register', [AuthController::class, 'showRegisterForm'])->name('register.form');
    Route::post('/register', [AuthController::class, 'register'])->name('register'); // REQ-AUTH-01
});

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

// --- 2. Dashboard Calon Siswa (Role: siswa) ---
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::get('/siswa/dashboard', [RegistrationController::class, 'index'])->name('siswa.dashboard');
    
    // REQ-REG-01 & REQ-REG-02: Simpan Draft Form Pendaftaran
    Route::post('/registration/draft', [RegistrationController::class, 'saveDraft'])->name('registration.draft');
    
    // REQ-REG-03: Lock Data / Finalisasi Permanen
    Route::post('/registration/finalize', [RegistrationController::class, 'finalize'])->name('registration.finalize');
    
    // REQ-FILE-01 & REQ-FILE-02: Unggah Berkas Ber-hash SHA-256
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.upload');
    
    // REQ-OUT-02 & REQ-OUT-03: Unduh Kartu PDF ber-QR Code
    Route::get('/registration/card/pdf', [PdfCardController::class, 'downloadCard'])->name('registration.card.pdf');
});

// --- 3. Dashboard Panitia & Admin (Role: verifikator, admin) ---
Route::middleware(['auth', 'role:verifikator,admin'])->group(function () {
    // REQ-VERIF-01: Dashboard Verifikator & Filter Data
    Route::get('/verifikator/dashboard', [VerificationController::class, 'index'])->name('verifikator.dashboard');
    
    // REQ-VERIF-02 & REQ-VERIF-03: Update Status Verifikasi & Catatan Koreksi
    Route::post('/verifikator/verify/{registration}', [VerificationController::class, 'updateStatus'])->name('verifikator.verify');
});

// --- 4. Public Route: Validasi Encrypted QR Code ---
Route::get('/verify/document/{hash}', function ($hash) {
    try {
        $id = decrypt($hash);
        $registration = Registration::with(['user', 'documents'])->findOrFail($id);
        return view('public.verify_document', compact('registration'));
    } catch (\Exception $e) {
        abort(404, 'Dokumen tidak valid atau tautan verifikasi telah kadaluarsa.');
    }
})->name('verify.document');