<?php

namespace App\Http\Controllers;

use App\Models\Document;
use App\Models\Registration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    // REQ-FILE-01 & REQ-FILE-02: Validasi & Upload Berkas SHA-256
    public function store(Request $request)
    {
        $registration = Registration::where('user_id', auth()->id())->firstOrFail();

        if ($registration->is_locked) {
            return back()->with('error', 'Data pendaftaran telah dikunci.');
        }

        $request->validate([
            'type' => 'required|string',
            'file' => 'required|file|mimes:pdf,jpg,jpeg,png|max:2048', // Max 2MB
        ]);

        $file = $request->file('file');

        // Generasi nama terenkripsi SHA-256
        $hashedName = hash('sha256', time().'_'.$file->getClientOriginalName()).'.'.$file->getClientOriginalExtension();

        // Simpan berkas di direktori terisolasi
        $path = $file->storeAs('documents', $hashedName, 'private');

        Document::create([
            'registration_id' => $registration->id,
            'type' => $request->type,
            'original_name' => $file->getClientOriginalName(),
            'hashed_path' => $path,
            'file_size' => $file->getSize(),
        ]);

        return back()->with('success', 'Dokumen berhasil diunggah.');
    }

    // REQ-FILE-03: In-App Document Preview
    public function preview(Document $document)
    {
        $path = $document->file_path ?? $document->hashed_path ?? null;

        if (! $path) {
            abort(404, 'Berkas dokumen tidak ditemukan.');
        }

        if (Storage::disk('public')->exists($path)) {
            $file = Storage::disk('public')->get($path);
            $mime = Storage::disk('public')->mimeType($path);
            return response($file, 200)->header('Content-Type', $mime);
        }

        if (Storage::disk('private')->exists($path)) {
            $file = Storage::disk('private')->get($path);
            $mime = Storage::disk('private')->mimeType($path);
            return response($file, 200)->header('Content-Type', $mime);
        }

        abort(404, 'Berkas fisik tidak ditemukan di penyimpanan server.');
    }
}
