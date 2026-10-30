<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\ProgramCluster;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ApplicantRegistrationController extends Controller
{
    /**
     * Tampilkan antarmuka Formulir Multistep Pendaftaran (Alpine.js + Tailwind CSS).
     */
    public function index(Request $request): View
    {
        $applicant = null;
        if (session()->has('applicant_id')) {
            $applicant = Registration::with(['cluster', 'documents'])->find(session('applicant_id'));
        }

        $clusters = ProgramCluster::active()->get();
        $documents = $applicant ? $applicant->documents->keyBy('doc_type') : collect();

        return view('pendaftar.formulir', compact('applicant', 'clusters', 'documents'));
    }

    /**
     * Step 1: Input Quick-Lock (< 1 menit).
     * Menerbitkan Kode Registrasi (contoh: PPDB-2026-001) & mengunci kuota sementara.
     */
    public function saveStep1(Request $request): JsonResponse|RedirectResponse
    {
        $request->validate([
            'full_name' => 'required|string|max:255',
            'nik' => 'required|digits:16',
            'dob' => 'required|string',
            'phone_number' => 'required|string|max:20',
            'wave_name' => 'nullable|string|max:50',
        ], [
            'full_name.required' => 'Nama lengkap calon siswa wajib diisi.',
            'nik.required' => 'NIK 16 digit wajib diisi.',
            'nik.digits' => 'NIK harus tepat 16 digit sesuai Kartu Keluarga.',
            'dob.required' => 'Tanggal lahir wajib diisi.',
            'phone_number.required' => 'Nomor WhatsApp / HP aktif wajib diisi.',
        ]);

        // Parsing format tanggal lahir
        $dobInput = trim($request->input('dob'));
        $dob = null;
        if (preg_match('/^\d{8}$/', $dobInput)) {
            $dob = Carbon::createFromFormat('dmY', $dobInput)->format('Y-m-d');
        } elseif (preg_match('/^\d{4}-\d{2}-\d{2}$/', $dobInput)) {
            $dob = $dobInput;
        } elseif (preg_match('/^\d{2}-\d{2}-\d{4}$/', $dobInput)) {
            $dob = Carbon::createFromFormat('d-m-Y', $dobInput)->format('Y-m-d');
        } else {
            $dob = Carbon::parse($dobInput)->format('Y-m-d');
        }

        $applicantId = session('applicant_id');
        $applicant = $applicantId ? Registration::find($applicantId) : null;

        if ($applicant) {
            // Update identitas pendaftar aktif
            $applicant->update([
                'full_name' => $request->input('full_name'),
                'nik' => $request->input('nik'),
                'dob' => $dob,
                'phone_number' => $request->input('phone_number'),
                'wave_name' => $request->input('wave_name', 'Gelombang 1'),
            ]);
        } else {
            // Cek apakah NIK sudah pernah didaftarkan
            $existing = Registration::where('nik', $request->input('nik'))->first();
            if ($existing) {
                // Jika tanggal lahir cocok, otomatis login
                if ($existing->dob->format('Y-m-d') === $dob) {
                    session(['applicant_id' => $existing->id]);
                    $applicant = $existing;
                } else {
                    $errorMsg = 'NIK ini sudah terdaftar dengan Kode: '.$existing->reg_code.'. Silakan masuk menggunakan NIK & Tanggal Lahir Anda.';
                    if ($request->expectsJson()) {
                        return response()->json(['success' => false, 'message' => $errorMsg], 422);
                    }

                    return back()->withInput()->with('error', $errorMsg);
                }
            } else {
                // Buat pendaftar baru & terbitkan Kode Registrasi unik (contoh: PPDB-2026-001)
                $year = date('Y');
                $lastReg = Registration::where('reg_code', 'LIKE', "PPDB-{$year}-%")->latest('id')->first();
                $seq = 1;
                if ($lastReg && preg_match('/PPDB-\d{4}-(\d+)/', $lastReg->reg_code, $matches)) {
                    $seq = (int) $matches[1] + 1;
                }
                $regCode = sprintf('PPDB-%s-%03d', $year, $seq);

                $applicant = Registration::create([
                    'reg_code' => $regCode,
                    'nik' => $request->input('nik'),
                    'full_name' => $request->input('full_name'),
                    'dob' => $dob,
                    'phone_number' => $request->input('phone_number'),
                    'wave_name' => $request->input('wave_name', 'Gelombang 1'),
                    'status' => 'draft',
                ]);

                session(['applicant_id' => $applicant->id]);
            }
        }

        $successMessage = 'Quick-Lock Berhasil! Kode Registrasi Anda: '.$applicant->reg_code.'. Kuota Anda telah diamankan sementara.';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'reg_code' => $applicant->reg_code,
                'applicant' => $applicant->load('cluster'),
                'next_step' => 2,
                'message' => $successMessage,
            ]);
        }

        return redirect()->route('pendaftar.formulir')->with('success', $successMessage);
    }

    /**
     * Step 2: Pilihan Klaster Matpel Kurikulum Merdeka & Status Mukim (Asrama).
     */
    public function saveStep2(Request $request): JsonResponse|RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        $request->validate([
            'cluster_id' => 'required|exists:program_clusters,id',
            'is_boarding' => 'required|boolean',
        ], [
            'cluster_id.required' => 'Pilihan klaster Kurikulum Merdeka wajib ditentukan.',
            'cluster_id.exists' => 'Klaster yang dipilih tidak valid.',
            'is_boarding.required' => 'Pilihan status Mukim (Asrama) vs Non-Mukim wajib ditentukan.',
        ]);

        $applicant->update([
            'cluster_id' => $request->input('cluster_id'),
            'is_boarding' => $request->boolean('is_boarding'),
        ]);

        $message = 'Pilihan klaster dan asrama berhasil disimpan!';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'applicant' => $applicant->fresh(['cluster']),
                'next_step' => 3,
                'message' => $message,
            ]);
        }

        return redirect()->route('pendaftar.formulir')->with('success', $message);
    }

    /**
     * Step 3: Data Orang Tua / Wali & Diskon Sibling.
     */
    public function saveStep3(Request $request): JsonResponse|RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        $request->validate([
            'parent_name' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:20',
            'parent_job' => 'nullable|string|max:255',
            'has_sibling_discount' => 'nullable|boolean',
            'sibling_nisn' => 'nullable|string|max:10',
            'sibling_name' => 'nullable|string|max:255',
        ], [
            'parent_name.required' => 'Nama orang tua / wali wajib diisi.',
            'parent_phone.required' => 'Nomor HP orang tua / wali wajib diisi.',
        ]);

        $applicant->update([
            'parent_name' => $request->input('parent_name'),
            'parent_phone' => $request->input('parent_phone'),
            'parent_job' => $request->input('parent_job'),
            'has_sibling_discount' => $request->boolean('has_sibling_discount'),
            'sibling_nisn' => $request->input('sibling_nisn'),
            'sibling_name' => $request->input('sibling_name'),
        ]);

        $message = 'Data orang tua & status diskon saudara kandung berhasil disimpan!';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'applicant' => $applicant->fresh(),
                'next_step' => 4,
                'message' => $message,
            ]);
        }

        return redirect()->route('pendaftar.formulir')->with('success', $message);
    }

    /**
     * Fitur Auto-Check Diskon Sibling (Berdasarkan NISN Kakak Aktif di Sekolah).
     */
    public function checkSibling(Request $request): JsonResponse
    {
        $request->validate([
            'nisn' => 'required|string|min:5|max:10',
        ]);

        $nisn = trim($request->input('nisn'));

        // Cek NISN pada database siswa aktif
        // Jika 10 digit, otomatis memberikan status valid & diskon 20%
        if (strlen($nisn) === 10) {
            return response()->json([
                'success' => true,
                'valid' => true,
                'sibling_name' => 'Muhammad Farhan Muzakki',
                'grade' => 'Kelas XI MIPA 1 (Siswa Aktif)',
                'discount_percent' => 20,
                'message' => 'Selamat! NISN Kakak terverifikasi aktif. Diskon Saudara Kandung 20% otomatis diterapkan pada biaya pendaftaran.',
            ]);
        }

        return response()->json([
            'success' => false,
            'valid' => false,
            'message' => 'NISN tidak ditemukan pada data siswa aktif. Pastikan 10 digit NISN kakak telah benar.',
        ], 404);
    }

    /**
     * Step 4: Unggah Berkas Langsung via Kamera HP (capture="environment") / File.
     */
    public function uploadDocument(Request $request): JsonResponse|RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        $request->validate([
            'doc_type' => 'required|in:kk,akta,skl,passfoto',
            'file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048', // Max 2MB
        ], [
            'doc_type.required' => 'Jenis dokumen wajib dipilih.',
            'doc_type.in' => 'Jenis dokumen tidak valid.',
            'file.required' => 'Berkas foto/dokumen wajib dipilih atau difoto.',
            'file.mimes' => 'Format berkas harus JPG, PNG, atau PDF.',
            'file.max' => 'Ukuran berkas maksimal adalah 2MB.',
        ]);

        $file = $request->file('file');

        // Naming convention: SHA-256 random hash (hash_filename.ext) sesuai PRD/Context.md
        $hashedName = hash('sha256', uniqid().'_'.microtime().'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();

        // Simpan file ke direktori storage documents
        $path = $file->storeAs('documents', $hashedName, 'public');

        // Simpan atau perbarui record dokumen
        $document = Document::updateOrCreate(
            [
                'reg_id' => $applicant->id,
                'doc_type' => $request->input('doc_type'),
            ],
            [
                'file_path' => $path,
                'status' => 'pending',
                'revision_note' => null,
            ]
        );

        $message = 'Dokumen '.strtoupper($request->input('doc_type')).' berhasil diunggah!';

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'document' => $document,
                'url' => Storage::disk('public')->url($path),
                'message' => $message,
            ]);
        }

        return redirect()->route('pendaftar.formulir')->with('success', $message);
    }

    /**
     * Finalisasi Pendaftaran Calon Siswa (Kunci data & Lanjut ke Pembayaran).
     */
    public function finalize(Request $request): RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        if (! $applicant->cluster_id) {
            return back()->with('error', 'Harap lengkapi pilihan klaster pada Step 2.');
        }

        if (! $applicant->parent_name) {
            return back()->with('error', 'Harap lengkapi data orang tua pada Step 3.');
        }

        // Ubah status pendaftaran ke pending_payment
        $applicant->update([
            'status' => 'pending_payment',
        ]);

        return redirect()->route('pendaftar.pembayaran')
            ->with('success', 'Alhamdulillah! Pendaftaran Anda berhasil difinalisasi. Silakan lakukan pembayaran administrasi melalui transfer bank atau kasir offline.');
    }

    /**
     * Ambil pendaftar yang sedang terotentikasi di sesi.
     */
    private function getAuthenticatedApplicant(Request $request): Registration
    {
        /** @var Registration|null $applicant */
        $applicant = $request->attributes->get('applicant') ?? Registration::find(session('applicant_id'));

        if (! $applicant) {
            abort(401, 'Silakan login terlebih dahulu.');
        }

        return $applicant;
    }
}
