<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;

class RegistrationController extends Controller
{
    public function index()
    {
        $registration = Registration::with(['cluster', 'documents', 'latestPayment'])
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if (view()->exists('student.dashboard')) {
            return view('student.dashboard', compact('registration'));
        }

        return view('siswa.dashboard', compact('registration'));
    }

    // REQ-REG-01 & REQ-REG-02: Simpan Draft Pendaftaran
    public function saveDraft(Request $request)
    {
        $registration = Registration::where('user_id', auth()->id())->firstOrFail();

        if ($registration->is_locked) {
            return back()->with('error', 'Data pendaftaran telah dikunci dan tidak dapat diubah.');
        }

        $request->validate([
            'jalur' => 'required|in:zonasi,prestasi,afirmasi,perpindahan',
        ]);

        $registration->update([
            'jalur' => $request->jalur,
            'status' => 'draft',
        ]);

        return back()->with('success', 'Draft pendaftaran berhasil disimpan.');
    }

    // REQ-REG-03: Lock Data / Finalisasi Permanen
    public function finalize()
    {
        $registration = Registration::where('user_id', auth()->id())->firstOrFail();

        if (! $registration->jalur) {
            return back()->with('error', 'Harap lengkapi pilihan jalur pendaftaran sebelum melalukan finalisasi.');
        }

        $registration->update([
            'is_locked' => true,
        ]);

        return back()->with('success', 'Pendaftaran berhasil difinalisasi dan data telah dikunci.');
    }
}
