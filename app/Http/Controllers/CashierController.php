<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Registration;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CashierController extends Controller
{
    /**
     * Tampilkan Mode Kasir Offline (Dashboard Bendahara):
     * - Form pencarian cepat pendaftar via NIK atau Kode Registrasi
     * - Ringkasan pendaftar & status pembayaran
     * - Tombol "Bayar Tunai di Tempat" untuk langsung mengubah status menjadi PAID
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('q', ''));
        $registrations = collect();
        $selectedApplicant = null;

        if (! empty($search)) {
            $registrations = Registration::with(['cluster', 'latestPayment'])
                ->where('nik', 'like', "%{$search}%")
                ->orWhere('reg_code', 'like', "%{$search}%")
                ->orWhere('full_name', 'like', "%{$search}%")
                ->limit(10)
                ->get();

            // Jika hasil pencarian spesifik hanya 1 pendaftar, pilih langsung
            if ($registrations->count() === 1) {
                $selectedApplicant = $registrations->first();
            }
        }

        // Tampilkan 15 transaksi pembayaran kasir / offline terakhir untuk log bendahara
        $recentPayments = Payment::with(['registration.cluster', 'verifier'])
            ->latest()
            ->limit(15)
            ->get();

        return view('bendahara.kasir', compact('registrations', 'selectedApplicant', 'search', 'recentPayments'));
    }

    /**
     * Endpoint API / JSON untuk pencarian pendaftar secara realtime (AJAX/Fetch)
     */
    public function search(Request $request): JsonResponse
    {
        $query = trim($request->input('query', ''));

        if (strlen($query) < 2) {
            return response()->json(['registrations' => []]);
        }

        $results = Registration::with(['cluster', 'latestPayment'])
            ->where('nik', 'like', "%{$query}%")
            ->orWhere('reg_code', 'like', "%{$query}%")
            ->orWhere('full_name', 'like', "%{$query}%")
            ->limit(8)
            ->get()
            ->map(function ($reg) {
                $nominal = $reg->has_sibling_discount ? 240000 : 300000;

                return [
                    'id' => $reg->id,
                    'reg_code' => $reg->reg_code,
                    'nik' => $reg->nik,
                    'full_name' => $reg->full_name,
                    'cluster_name' => $reg->cluster->name ?? 'Belum Pilih',
                    'status' => $reg->status,
                    'nominal' => $nominal,
                    'formatted_nominal' => 'Rp '.number_format($nominal, 0, ',', '.'),
                    'is_paid' => in_array($reg->status, ['paid', 'verified', 'passed']),
                ];
            });

        return response()->json(['registrations' => $results]);
    }

    /**
     * Tombol "Bayar Tunai di Tempat" (Kasir Offline Bendahara).
     * Langsung mengubah status pendaftaran menjadi PAID dan status pembayaran VERIFIED.
     */
    public function payCash(Request $request, Registration $registration): RedirectResponse
    {
        $amount = $registration->has_sibling_discount ? 240000 : 300000;

        // Buat record pembayaran tunai
        $payment = Payment::create([
            'reg_id' => $registration->id,
            'amount' => $amount,
            'sender_bank' => 'KASIR TUNAI',
            'sender_name' => $registration->full_name,
            'proof_file' => null,
            'payment_method' => 'cash',
            'status' => 'verified',
            'verified_by' => auth()->id(),
            'paid_at' => now(),
        ]);

        // REQ-KASIR-02: Ubah status pendaftaran langsung menjadi PAID
        $registration->update([
            'status' => 'paid',
        ]);

        return redirect()->route('bendahara.kasir', ['q' => $registration->reg_code])
            ->with('success', 'Pembayaran tunai sebesar Rp '.number_format($amount, 0, ',', '.')." untuk {$registration->full_name} ({$registration->reg_code}) berhasil diproses. Status kini PAID.");
    }
}
