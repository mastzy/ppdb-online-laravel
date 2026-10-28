<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Verifikator Panitia - PPDB Online</title>
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f6f9; margin: 0; padding: 20px; }
        .container { max-width: 1200px; margin: 0 auto; background: white; padding: 30px; border-radius: 8px; box-shadow: 0 2px 10px rgba(0,0,0,0.1); }
        .header { display: flex; justify-content: space-between; align-items: center; border-bottom: 2px solid #eee; padding-bottom: 15px; margin-bottom: 20px; }
        .alert { padding: 12px; border-radius: 4px; margin-bottom: 20px; }
        .alert-success { background-color: #d4edda; color: #155724; }
        .filter-card { background: #f8f9fa; padding: 15px; border-radius: 6px; margin-bottom: 20px; border: 1px solid #e9ecef; }
        .filter-form { display: flex; gap: 15px; align-items: center; }
        .filter-form select, .filter-form input { padding: 8px; border: 1px solid #ccc; border-radius: 4px; }
        table { width: 100%; border-collapse: collapse; margin-top: 10px; }
        table th, table td { border: 1px solid #ddd; padding: 10px; text-align: left; vertical-align: top; }
        table th { background-color: #007bff; color: white; }
        .badge { padding: 4px 8px; border-radius: 4px; font-weight: bold; font-size: 11px; }
        .badge-draft { background: #e2e3e5; color: #383d41; }
        .badge-approved { background: #d4edda; color: #155724; }
        .badge-rejected { background: #f8d7da; color: #721c24; }
        .badge-revision_needed { background: #fff3cd; color: #856404; }
        .btn { padding: 6px 12px; border: none; border-radius: 4px; cursor: pointer; text-decoration: none; font-size: 12px; }
        .btn-primary { background: #007bff; color: white; }
        .btn-danger { background: #dc3545; color: white; }
    </style>
</head>
<body>

<div class="container">
    <div class="header">
        <div>
            <h2>Dashboard Verifikasi Panitia PPDB</h2>
            <p>Pengelola: <strong>{{ auth()->user()->name }}</strong> (Role: Verifikator/Admin)</p>
        </div>
        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
            <a href="{{ route('admin.export.emis') }}" class="btn" style="background:#059669; color:white;" title="Ekspor Data Siswa Lulus Format EMIS 4.0 Kemenag">
                📥 Ekspor EMIS (Kemenag)
            </a>
            <a href="{{ route('admin.export.dapodik') }}" class="btn" style="background:#2563eb; color:white;" title="Ekspor Data Siswa Lulus Format Dapodik Kemendikbud">
                📥 Ekspor Dapodik (Kemendikbud)
            </a>
            @if(in_array(auth()->user()->role, ['admin', 'bendahara']))
                <a href="{{ route('bendahara.kasir') }}" class="btn" style="background:#0284c7; color:white;">
                    💵 Mode Kasir Offline
                </a>
            @endif
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-danger">Logout</button>
            </form>
        </div>
    </div>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <!-- Filtering Data Pendaftar (REQ-VERIF-01) -->
    <div class="filter-card">
        <h4>Filter Data Pendaftar</h4>
        <form action="{{ route('verifikator.dashboard') }}" method="GET" class="filter-form">
            <div>
                <label>Jalur:</label>
                <select name="jalur">
                    <option value="">Semua Jalur</option>
                    <option value="zonasi" {{ request('jalur') == 'zonasi' ? 'selected' : '' }}>Zonasi</option>
                    <option value="prestasi" {{ request('jalur') == 'prestasi' ? 'selected' : '' }}>Prestasi</option>
                    <option value="afirmasi" {{ request('jalur') == 'afirmasi' ? 'selected' : '' }}>Afirmasi</option>
                    <option value="perpindahan" {{ request('jalur') == 'perpindahan' ? 'selected' : '' }}>Perpindahan</option>
                </select>
            </div>
            <div>
                <label>Status Verifikasi:</label>
                <select name="status">
                    <option value="">Semua Status</option>
                    <option value="draft" {{ request('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="approved" {{ request('status') == 'approved' ? 'selected' : '' }}>Approved</option>
                    <option value="revision_needed" {{ request('status') == 'revision_needed' ? 'selected' : '' }}>Revision Needed</option>
                    <option value="rejected" {{ request('status') == 'rejected' ? 'selected' : '' }}>Rejected</option>
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Terapkan Filter</button>
            <a href="{{ route('verifikator.dashboard') }}" class="btn" style="background:#6c757d; color:white;">Reset</a>
        </form>
    </div>

    <!-- Tabel Verifikasi Pendaftar (REQ-VERIF-02 & REQ-VERIF-03) -->
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Calon Siswa</th>
                <th>NIK & NISN</th>
                <th>Jalur</th>
                <th>Berkas Terunggah</th>
                <th>Status Saat Ini</th>
                <th>Aksi Verifikasi Panitia</th>
            </tr>
        </thead>
        <tbody>
            @forelse($registrations as $index => $reg)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>
                        <strong>{{ $reg->user->name }}</strong><br>
                        <small>{{ $reg->user->email }}</small>
                    </td>
                    <td>
                        NIK: {{ $reg->user->nik ?? '-' }}<br>
                        NISN: {{ $reg->user->nisn ?? '-' }}
                    </td>
                    <td>{{ strtoupper($reg->jalur ?? 'Draft') }}</td>
                    <td>
                        <!-- In-App Document Preview (REQ-FILE-03) -->
                        @if($reg->documents->count() > 0)
                            <ul style="padding-left: 15px; margin: 0;">
                                @foreach($reg->documents as $doc)
                                    <li>
                                        <a href="{{ route('verifikator.document.preview', $doc->id) }}" target="_blank">
                                            {{ strtoupper($doc->type) }} (Preview)
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        @else
                            <em style="color: #999;">Belum ada berkas</em>
                        @endif
                    </td>
                    <td>
                        <span class="badge badge-{{ $reg->status }}">{{ strtoupper(str_replace('_', ' ', $reg->status)) }}</span><br>
                        @if($reg->is_locked)
                            <small style="color: green;">✔ Finalized</small>
                        @else
                            <small style="color: orange;">⏳ Belum Final</small>
                        @endif
                    </td>
                    <td>
                        <form action="{{ route('verifikator.verify', $reg->id) }}" method="POST">
                            @csrf
                            <div style="margin-bottom: 5px;">
                                <select name="status" required style="width: 100%;">
                                    <option value="approved" {{ $reg->status == 'approved' ? 'selected' : '' }}>Approve (Terima)</option>
                                    <option value="revision_needed" {{ $reg->status == 'revision_needed' ? 'selected' : '' }}>Revision Needed (Perbaikan)</option>
                                    <option value="rejected" {{ $reg->status == 'rejected' ? 'selected' : '' }}>Reject (Tolak)</option>
                                </select>
                            </div>
                            <div style="margin-bottom: 5px;">
                                <input type="text" name="catatan_koreksi" value="{{ $reg->catatan_koreksi }}" placeholder="Alasan jika ditolak/perbaikan (Wajib)" style="width: 100%; box-sizing: border-box;">
                            </div>
                            <button type="submit" class="btn btn-primary" style="width: 100%;">Simpan Verifikasi</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" style="text-align: center; color: #888;">Tidak ada data pendaftar yang ditemukan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

</body>
</html>