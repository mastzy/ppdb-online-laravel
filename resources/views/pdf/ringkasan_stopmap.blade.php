<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Lembar Ringkasan Stopmap - {{ $registration->reg_code }}</title>
    <style>
        @page {
            margin: 20px 28px;
            size: A4 portrait;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 10pt;
            color: #0f172a;
            line-height: 1.35;
        }

        /* Kop Formulir Stopmap */
        .kop-table {
            width: 100%;
            border-bottom: 2.5px solid #0f172a;
            padding-bottom: 8px;
            margin-bottom: 12px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo-box {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            background-color: #0284c7;
            color: #ffffff;
            font-size: 18pt;
            font-weight: bold;
            line-height: 50px;
            text-align: center;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 10pt;
            color: #0369a1;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .kop-text h2 {
            margin: 2px 0;
            font-size: 14pt;
            font-weight: 800;
            color: #0f172a;
        }

        .kop-text p {
            margin: 0;
            font-size: 8pt;
            color: #475569;
        }

        /* Stopmap Badge Box */
        .title-bar {
            background-color: #0f172a;
            color: #ffffff;
            padding: 6px 12px;
            border-radius: 4px;
            display: table;
            width: 100%;
            margin-bottom: 10px;
        }

        .title-left {
            display: table-cell;
            font-weight: bold;
            font-size: 11pt;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .title-right {
            display: table-cell;
            text-align: right;
            font-size: 11pt;
            font-weight: 800;
            color: #38bdf8;
            letter-spacing: 0.08em;
        }

        /* Section Header */
        .section-header {
            background-color: #e2e8f0;
            padding: 4px 8px;
            font-weight: bold;
            font-size: 9.5pt;
            color: #1e293b;
            text-transform: uppercase;
            letter-spacing: 0.05em;
            border-left: 4px solid #0284c7;
            margin-top: 10px;
            margin-bottom: 6px;
        }

        /* Info Table */
        .info-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 6px;
        }

        .info-table td {
            padding: 4px 6px;
            font-size: 9.5pt;
            vertical-align: top;
            border-bottom: 1px dotted #cbd5e1;
        }

        .col-label {
            width: 25%;
            font-weight: 600;
            color: #334155;
        }

        .col-sep {
            width: 3%;
            text-align: center;
        }

        .col-val {
            width: 72%;
            font-weight: 500;
            color: #0f172a;
        }

        /* Checklist Table */
        .checklist-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 6px;
            margin-bottom: 10px;
        }

        .checklist-table th {
            background-color: #f1f5f9;
            border: 1px solid #94a3b8;
            padding: 5px 6px;
            font-size: 8.5pt;
            font-weight: bold;
            text-align: center;
            color: #1e293b;
        }

        .checklist-table td {
            border: 1px solid #cbd5e1;
            padding: 4px 6px;
            font-size: 8.5pt;
            vertical-align: middle;
        }

        .box-check {
            width: 15px;
            height: 15px;
            border: 1.5px solid #0f172a;
            display: inline-block;
            margin: 0 auto;
        }

        .status-badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7.5pt;
            font-weight: bold;
        }

        .badge-ada {
            background-color: #d1fae5;
            color: #065f46;
        }

        .badge-belum {
            background-color: #fee2e2;
            color: #991b1b;
        }

        /* Footer Grid */
        .bottom-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 8px;
        }

        .bottom-table td {
            vertical-align: top;
        }

        .qr-cell {
            width: 32%;
            text-align: center;
            border: 1px solid #cbd5e1;
            padding: 8px;
            border-radius: 4px;
            background: #f8fafc;
        }

        .qr-caption {
            font-size: 7.5pt;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.2;
        }

        .sign-cell {
            width: 34%;
            text-align: center;
            border: 1px solid #cbd5e1;
            padding: 8px;
            border-radius: 4px;
        }

        .sign-title {
            font-size: 8.5pt;
            font-weight: bold;
            color: #334155;
            margin-bottom: 45px;
        }

        .sign-name {
            font-size: 8.5pt;
            font-weight: bold;
            border-bottom: 1px solid #0f172a;
            display: inline-block;
            min-width: 130px;
        }

        .notice-box {
            background-color: #f8fafc;
            border: 1px dashed #94a3b8;
            border-radius: 4px;
            padding: 6px 10px;
            font-size: 8pt;
            color: #475569;
            margin-top: 8px;
        }
    </style>
</head>
<body>

    <!-- KOP FORMULIR -->
    <table class="kop-table">
        <tr>
            <td style="width: 58px;">
                <div class="kop-logo-box">MA</div>
            </td>
            <td class="kop-text">
                <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB) 2026/2027</h3>
                <h2>MADRASAH ALIYAH AL-HIKMAH TERPADU</h2>
                <p>Islamic Boarding School & Sains Terpadu • Akreditasi A • NPSN: 69912345</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL STOPMAP -->
    <div class="title-bar">
        <div class="title-left">LEMBAR KENDALI & RINGKASAN STOPMAP WAWANCARA</div>
        <div class="title-right">{{ $registration->reg_code }}</div>
    </div>

    <!-- 1. IDENTITAS CALON SISWA -->
    <div class="section-header">1. Identitas Calon Siswa & Pilihan Program</div>
    <table class="info-table">
        <tr>
            <td class="col-label">Nama Lengkap</td>
            <td class="col-sep">:</td>
            <td class="col-val"><strong>{{ strtoupper($registration->full_name) }}</strong></td>
        </tr>
        <tr>
            <td class="col-label">NIK / NISN</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $registration->nik }} &nbsp;/&nbsp; {{ $registration->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Tanggal Lahir / Usia</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $registration->dob ? $registration->dob->translatedFormat('d F Y') : '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">No. WhatsApp / HP Siswa</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $registration->phone_number ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Rumpun Peminatan</td>
            <td class="col-sep">:</td>
            <td class="col-val"><strong>{{ $registration->cluster->name ?? 'Reguler' }}</strong></td>
        </tr>
        <tr>
            <td class="col-label">Pilihan Asrama (Boarding)</td>
            <td class="col-sep">:</td>
            <td class="col-val">
                {{ $registration->is_boarding ? 'MUKIM (SANTRI ASRAMA / PESANTREN)' : 'NON-MUKIM (PULANG-PERGI)' }}
            </td>
        </tr>
    </table>

    <!-- 2. IDENTITAS ORANG TUA / WALI -->
    <div class="section-header">2. Data Orang Tua / Wali Murid</div>
    <table class="info-table">
        <tr>
            <td class="col-label">Nama Orang Tua / Wali</td>
            <td class="col-sep">:</td>
            <td class="col-val"><strong>{{ $registration->parent_name ?? '-' }}</strong></td>
        </tr>
        <tr>
            <td class="col-label">No. Telepon / WA Wali</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $registration->parent_phone ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Pekerjaan Orang Tua</td>
            <td class="col-sep">:</td>
            <td class="col-val">{{ $registration->parent_job ?? '-' }}</td>
        </tr>
        <tr>
            <td class="col-label">Diskon Sibling (Saudara)</td>
            <td class="col-sep">:</td>
            <td class="col-val">
                @if($registration->has_sibling_discount)
                    <strong>YA (20% DISKON)</strong> — NISN Saudara: {{ $registration->sibling_nisn ?? '-' }} ({{ $registration->sibling_name ?? '-' }})
                @else
                    TIDAK ADA
                @endif
            </td>
        </tr>
    </table>

    <!-- 3. CHECKLIST BERKAS FISIK WAWANCARA -->
    <div class="section-header">3. Checklist Pemeriksaan Berkas Fisik (Oleh Panitia)</div>
    <table class="checklist-table">
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th style="width: 32%;">Item Berkas Persyaratan Fisik</th>
                <th style="width: 18%;">Status Upload Web</th>
                <th style="width: 15%;">Asli Diperiksa</th>
                <th style="width: 15%;">Fotokopi Rangkap</th>
                <th style="width: 15%;">Paraf Petugas</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td style="text-align: center;">1</td>
                <td>Kartu Keluarga (KK Asli & Legalisir)</td>
                <td style="text-align: center;">
                    <span class="status-badge {{ isset($uploadedDocs['kk']) ? 'badge-ada' : 'badge-belum' }}">
                        {{ isset($uploadedDocs['kk']) ? '✓ TERUNGGAH' : 'BELUM' }}
                    </span>
                </td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">2</td>
                <td>Akta Kelahiran Calon Siswa</td>
                <td style="text-align: center;">
                    <span class="status-badge {{ isset($uploadedDocs['akta']) ? 'badge-ada' : 'badge-belum' }}">
                        {{ isset($uploadedDocs['akta']) ? '✓ TERUNGGAH' : 'BELUM' }}
                    </span>
                </td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">3</td>
                <td>SKL / Ijazah / Rapor Terakhir</td>
                <td style="text-align: center;">
                    <span class="status-badge {{ isset($uploadedDocs['skl']) ? 'badge-ada' : 'badge-belum' }}">
                        {{ isset($uploadedDocs['skl']) ? '✓ TERUNGGAH' : 'BELUM' }}
                    </span>
                </td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">4</td>
                <td>Pasfoto Resmi (3x4 Background Merah/Biru)</td>
                <td style="text-align: center;">
                    <span class="status-badge {{ isset($uploadedDocs['passfoto']) ? 'badge-ada' : 'badge-belum' }}">
                        {{ isset($uploadedDocs['passfoto']) ? '✓ TERUNGGAH' : 'BELUM' }}
                    </span>
                </td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td></td>
            </tr>
            <tr>
                <td style="text-align: center;">5</td>
                <td>Bukti Pembayaran / Kuitansi PPDB</td>
                <td style="text-align: center;">
                    <span class="status-badge {{ in_array($registration->status, ['paid', 'verified', 'passed']) ? 'badge-ada' : 'badge-belum' }}">
                        {{ in_array($registration->status, ['paid', 'verified', 'passed']) ? '✓ LUNAS' : 'PENDING' }}
                    </span>
                </td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td style="text-align: center;"><div class="box-check"></div></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <!-- 4. HASIL OBSERVASI AWAL & TANDA TANGAN VERIFIKATOR -->
    <table class="bottom-table">
        <tr>
            <!-- Validasi QR Code -->
            <td class="qr-cell">
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="85" height="85" alt="QR Code Pendaftar">
                <div class="qr-caption">
                    Scan untuk sinkronisasi data langsung dengan portal web panitia PPDB.
                </div>
            </td>

            <!-- Paraf Pewawancara / Penguji Diagnostik -->
            <td class="sign-cell" style="margin-left: 6px;">
                <div class="sign-title">Pewawancara / Penguji BTQ:</div>
                <div class="sign-name"></div>
                <div style="font-size: 7.5pt; color: #64748b; margin-top: 2px;">Tanda Tangan & Nama Terang</div>
            </td>

            <!-- Paraf Petugas Verifikasi Berkas Fisik -->
            <td class="sign-cell" style="margin-left: 6px;">
                <div class="sign-title">Petugas Verifikasi Berkas:</div>
                <div class="sign-name"></div>
                <div style="font-size: 7.5pt; color: #64748b; margin-top: 2px;">Tanda Tangan & Nama Terang</div>
            </td>
        </tr>
    </table>

    <!-- Petunjuk Tempel Stopmap -->
    <div class="notice-box">
        <strong>Petunjuk Penggunaan Stopmap:</strong> Cetak lembar ini tepat 1 halaman ukuran A4, kemudian tempelkan pada bagian depan stopmap map folio (Merah: Keagamaan, Biru: MIPA/STEM, Hijau: Soshum, Kuning: Vokasi). Serahkan stopmap berisi seluruh berkas fisik asli & fotokopi saat memasuki ruang wawancara dan observasi.
    </div>

</body>
</html>
