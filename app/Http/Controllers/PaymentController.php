<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PaymentController extends Controller
{
    /**
     * Tampilkan Halaman Pembayaran Pendaftar:
     * - Nominal resmi bulat (tanpa kode unik / admin fee, e.g. Rp 300.000)
     * - Petunjuk transfer bank resmi sekolah
     * - Form upload bukti transfer (wajib isi Nama Bank & Nama Pemilik Rekening Pengirim)
     */
    public function show(Request $request): View|RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        $bankAccounts = [
            [
                'bank' => 'Bank Syariah Indonesia (BSI)',
                'account_number' => '7123456789',
                'account_name' => 'PPDB MA AL-HIKMAH TERPADU',
            ],
            [
                'bank' => 'Bank Mandiri',
                'account_number' => '1370009876543',
                'account_name' => 'YAYASAN PENDIDIKAN AL-HIKMAH',
            ],
            [
                'bank' => 'Bank BRI',
                'account_number' => '012301004567508',
                'account_name' => 'PPDB ONLINE AL-HIKMAH',
            ],
        ];

        // Nominal resmi bulat tanpa admin fee / kode unik
        $baseAmount = 300000;
        // Jika ada diskon saudara kandung (sibling discount 20%)
        if ($applicant->has_sibling_discount) {
            $baseAmount = 240000;
        }

        $latestPayment = $applicant->latestPayment;

        return view('pendaftar.pembayaran', compact('applicant', 'bankAccounts', 'baseAmount', 'latestPayment'));
    }

    /**
     * Simpan unggahan bukti transfer pembayaran pendaftar.
     */
    public function store(Request $request): RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        $request->validate([
            'sender_bank' => 'required|string|max:100',
            'sender_name' => 'required|string|max:150',
            'proof_file' => 'required|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ], [
            'sender_bank.required' => 'Nama Bank Pengirim wajib diisi.',
            'sender_name.required' => 'Nama Pemilik Rekening Pengirim wajib diisi.',
            'proof_file.required' => 'Struk / Bukti transfer wajib diunggah.',
            'proof_file.mimes' => 'Format file bukti harus berupa JPG, PNG, atau PDF.',
            'proof_file.max' => 'Ukuran file bukti transfer maksimal 2MB.',
        ]);

        $baseAmount = $applicant->has_sibling_discount ? 240000 : 300000;

        // Simpan file bukti transfer dengan penamaan acak yang aman
        $file = $request->file('proof_file');
        $filename = 'proof_'.hash('sha256', time().'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();
        $filePath = $file->storeAs('payments', $filename, 'public');

        // Buat record pembayaran
        Payment::create([
            'reg_id' => $applicant->id,
            'amount' => $baseAmount,
            'sender_bank' => trim($request->input('sender_bank')),
            'sender_name' => trim($request->input('sender_name')),
            'proof_file' => $filePath,
            'payment_method' => 'transfer',
            'status' => 'pending',
            'paid_at' => now(),
        ]);

        // Update status pendaftaran menjadi pending_payment bila belum
        if ($applicant->status === 'draft') {
            $applicant->update(['status' => 'pending_payment']);
        }

        return redirect()->route('pendaftar.pembayaran')
            ->with('success', 'Bukti transfer berhasil diunggah! Panitia/Bendahara akan memverifikasi pembayaran Anda.');
    }

    /**
     * Helper mengambil model Registration pendaftar aktif.
     */
    private function getAuthenticatedApplicant(Request $request): Registration
    {
        /** @var Registration|null $applicant */
        $applicant = $request->attributes->get('applicant') ?? Registration::find(session('applicant_id'));

        if (! $applicant && auth()->check() && auth()->user()->role === 'siswa') {
            $applicant = Registration::where('user_id', auth()->id())->first();
        }

        if (! $applicant) {
            abort(401, 'Silakan login terlebih dahulu untuk mengakses halaman pembayaran.');
        }

        return $applicant;
    }
}
