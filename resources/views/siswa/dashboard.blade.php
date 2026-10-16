<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Calon Siswa - PPDB Online</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 900px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; border: 1px solid #c3e6cb; }
        .alert-error { background-color: #f8d7da; color: #721c24; border: 1px solid #f5c6cb; }
        .badge { padding: 5px 10px; border-radius: 4px; font-weight: bold; font-size: 12px; display: inline-block; }
        .badge-draft { background: #e2e3e5; color: #383d41; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
        .badge-revision { background: #fff3cd; color: #856404; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; font-weight: bold; margin-bottom: 5px; }
        .form-group select, .form-group input { width: 100%; padding: 8px; box-sizing: border-box; border: 1px solid #ccc; border-radius: 4px; }
        .btn { padding: 10px 18px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 14px; display: inline-block; }
        .btn-primary { background-color: #007bff; color: white; }
        .btn-success { background-color: #28a745; color: white; }
        .btn-warning { background-color: #ffc107; color: #212529; }
        .btn-danger { background-color: #dc3545; color: white; }
        .btn:disabled { opacity: 0.6; cursor: not-allowed; }
        .section-title { margin-top: 30px; border-bottom: 1px solid #eee; padding-bottom: 8px; color: #333; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; }
        table th { background-color: #f8f9fa; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h2>Dashboard Calon Siswa</h2>
            <p>Selamat datang, <strong>{{ auth()->user()->name }}</strong> (NISN: {{ auth()->user()->nisn ?? '-' }})</p>
        </div>
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" class="btn btn-danger">Logout</button>
        </form>
    </div>

    <!-- Notifikasi Pesan -->
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div class="alert alert-error">{{ session('error') }}</div>
    @endif

    <!-- Status Pendaftaran -->
    @php
        $registration = auth()->user()->registration;
        $isLocked = $registration->is_locked ?? false;
        $status = $registration->status ?? 'draft';
    @endphp

    <div style="background: #e9ecef; padding: 15px; border-radius: 6px; margin-bottom: 20px;">
        <strong>Status Pendaftaran:</strong>
        <span class="badge badge-{{ $status }}">{{ strtoupper(str_replace('_', ' ', $status)) }}</span>
        @if($isLocked)
            <span class="badge" style="background: #17a2b8; color: white;">TERKUNCI (FINAL)</span>
        @endif

        @if($registration && $registration->catatan_koreksi)
            <div style="margin-top: 10px; color: #721c24; background: #f8d7da; padding: 10px; border-radius: 4px;">
                <strong>Catatan Koreksi dari Panitia:</strong> {{ $registration->catatan_koreksi }}
            </div>
        @endif
    </div>

    <!-- 1. Formulir Multistep Pendaftaran (REQ-REG-01 & REQ-REG-02) -->
    <h3 class="section-title">1. Formulir Pendaftaran & Pilihan Jalur</h3>
    <form action="{{ route('registration.draft') }}" method="POST">
        @csrf
        <fieldset @if($isLocked) disabled @endif style="border: none; padding: 0; margin: 0;">
            <div class="form-group">
                <label>Pilih Jalur Pendaftaran</label>
                <select name="jalur" required>
                    <option value="">-- Pilih Jalur --</option>
                    <option value="zonasi" {{ old('jalur', $registration->jalur ?? '') == 'zonasi' ? 'selected' : '' }}>Zonasi</option>
                    <option value="prestasi" {{ old('jalur', $registration->jalur ?? '') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="afirmasi" {{ old('jalur', $registration->jalur ?? '') == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                    <option value="perpindahan" {{ old('jalur', $registration->jalur ?? '') == 'perpindahan' ? 'selected' : '' }}>Perpindahan Tugas Orang Tua</option>
                </select>
            </div>

            @if(!$isLocked)
                <button type="submit" class="btn btn-primary">Simpan Draft Formulir</button>
            @endif
        </fieldset>
    </form>

    <!-- Tombol Finalisasi Data (REQ-REG-03) -->
    @if(!$isLocked)
        <form action="{{ route('registration.finalize') }}" method="POST" style="margin-top: 15px;">
            @csrf
            <button type="submit" class="btn btn-warning" onclick="return confirm('Apakah Anda yakin ingin mengunci data secara permanen? Data yang telah dikunci tidak dapat diubah kembali.')">
                🔒 Finalisasi & Kunci Data Pendaftaran
            </button>
        </form>
    @endif

    <!-- 2. Unggah Berkas Persyaratan (REQ-FILE-01 & REQ-FILE-02) -->
    <h3 class="section-title">2. Unggah Berkas Persyaratan (PDF/JPG/PNG max 2MB)</h3>
    @if(!$isLocked)
        <form action="{{ route('documents.upload') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label>Jenis Dokumen</label>
                <select name="type" required>
                    <option value="ijazah">Ijazah / Surat Keterangan Lulus</option>
                    <option value="kk">Kartu Keluarga (KK)</option>
                    <option value="akta">Akta Kelahiran</option>
                    <option value="sertifikat">Sertifikat Prestasi (Opsional)</option>
                </select>
            </div>
            <div class="form-group">
                <label>Pilih Berkas File</label>
                <input type="file" name="file" accept=".pdf,.jpg,.jpeg,.png" required>
            </div>
            <button type="submit" class="btn btn-primary">Unggah Berkas</button>
        </form>
    @else
        <p style="color: #6c757d; font-style: italic;">Unggah berkas ditutup karena data pendaftaran telah dikunci.</p>
    @endif

    <!-- Daftar Berkas Terunggah -->
    @if($registration && $registration->documents->count() > 0)
        <table>
            <thead>
                <tr>
                    <th>Jenis Dokumen</th>
                    <th>Nama File Asli</th>
                    <th>Ukuran File</th>
                    <th>Tanggal Unggah</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registration->documents as $doc)
                    <tr>
                        <td>{{ strtoupper($doc->type) }}</td>
                        <td>{{ $doc->original_name }}</td>
                        <td>{{ number_format($doc->file_size / 1024, 2) }} KB</td>
                        <td>{{ $doc->created_at->format('d/m/Y H:i') }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <!-- 3. Cetak Output Dokumentasi (REQ-OUT-02 & REQ-OUT-03) -->
    <h3 class="section-title">3. Cetak Kartu Pendaftaran & Hasil</h3>
    @if($isLocked)
        <p>Data Anda telah difinalisasi. Anda dapat mengunduh bukti tanda pendaftaran resmi yang dilengkapi Encrypted QR Code:</p>
        <a href="{{ route('registration.card.pdf') }}" class="btn btn-success" target="_blank">
            📄 Unduh Kartu Pendaftaran (PDF & QR Code)
        </a>
    @else
        <p style="color: #6c757d;">Tombol cetak kartu pendaftaran akan aktif setelah Anda melakukan <strong>Finalisasi Data</strong>.</p>
    @endif
</div>

</body>
</html>