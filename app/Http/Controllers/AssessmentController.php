<?php

namespace App\Http\Controllers;

use App\Models\DiagnosticScore;
use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AssessmentController extends Controller
{
    /**
     * Tampilkan antarmuka penginputan asesmen diagnostik bagi penguji / panitia.
     */
    public function index(Request $request): View
    {
        $search = trim($request->input('q', ''));

        $query = Registration::with(['cluster', 'diagnosticScore'])
            ->orderBy('reg_code', 'asc');

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('reg_code', 'LIKE', "%{$search}%")
                  ->orWhere('nik', 'LIKE', "%{$search}%");
            });
        }

        $registrations = $query->paginate(15)->withQueryString();

        return view('admin.assessment.index', compact('registrations', 'search'));
    }

    /**
     * Simpan atau perbarui skor asesmen diagnostik calon siswa.
     */
    public function store(Request $request, Registration $registration): RedirectResponse
    {
        $request->validate([
            'btq_score' => 'required|numeric|min:0|max:100',
            'tahfidz_juz' => 'nullable|integer|min:0|max:30',
            'literacy_score' => 'required|numeric|min:0|max:100',
            'notes' => 'nullable|string|max:1000',
        ], [
            'btq_score.required' => 'Skor Tes BTQ wajib diisi (0 - 100).',
            'literacy_score.required' => 'Skor Tes Literasi / Numerasi wajib diisi (0 - 100).',
        ]);

        DiagnosticScore::updateOrCreate(
            ['reg_id' => $registration->id],
            [
                'btq_score' => $request->input('btq_score'),
                'tahfidz_juz' => $request->input('tahfidz_juz', 0) ?: 0,
                'literacy_score' => $request->input('literacy_score'),
                'notes' => $request->input('notes'),
                'tested_by' => auth()->user()->name ?? 'Penguji PPDB',
            ]
        );

        // Jika nilai rata-rata >= 70, otomatis dapat disarankan lulus
        $avg = ($request->input('btq_score') + $request->input('literacy_score')) / 2;
        if ($avg >= 70 && in_array($registration->status, ['draft', 'paid'])) {
            $registration->update(['status' => 'approved']);
        }

        return back()->with('success', "Skor asesmen diagnostik untuk {$registration->full_name} berhasil disimpan.");
    }
}

