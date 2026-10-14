use App\Http\Controllers\AuthController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\DocumentController;
use App\Http\Controllers\VerificationController;
use App\Http\Controllers\PdfCardController;
use Illuminate\Support\Facades\Route;

// Guest Routes
Route::post('/register', [AuthController::class, 'register'])->name('register');

// Auth Routes (Calon Siswa)
Route::middleware(['auth', 'role:siswa'])->group(function () {
    Route::post('/registration/draft', [RegistrationController::class, 'saveDraft'])->name('registration.draft');
    Route::post('/registration/finalize', [RegistrationController::class, 'finalize'])->name('registration.finalize');
    Route::post('/documents/upload', [DocumentController::class, 'store'])->name('documents.upload');
    Route::get('/registration/card/pdf', [PdfCardController::class, 'downloadCard'])->name('registration.card.pdf');
});

// Auth Routes (Panitia & Admin)
Route::middleware(['auth', 'role:verifikator,admin'])->group(function () {
    Route::get('/verifikator/dashboard', [VerificationController::class, 'index'])->name('verifikator.dashboard');
    Route::post('/verifikator/verify/{registration}', [VerificationController::class, 'updateStatus'])->name('verifikator.verify');
});

// Public Route (Validasi QR Code)
Route::get('/verify/document/{hash}', function ($hash) {
    $id = decrypt($hash);
    $registration = Registration::findOrFail($id);
    return view('public.verify_document', compact('registration'));
})->name('verify.document');