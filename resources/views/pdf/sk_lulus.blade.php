<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Surat Keputusan Kelulusan - {{ $registration->reg_code }}</title>
    <style>
        @page {
            size: A4 portrait;
            margin: 20mm 20mm 20mm 20mm;
        }
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            line-height: 1.5;
            color: #1e293b;
        }
        .header-table {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 20px;
        }
        .school-title {
            font-size: 15pt;
            font-weight: bold;
            color: #065f46;
            text-transform: uppercase;
            margin: 0;
        }
        .school-sub {
            font-size: 9pt;
            color: #475569;
            margin: 2px 0 0 0;
        }
        .doc-title {
            text-align: center;
            margin: 20px 0 15px 0;
        }
        .doc-title h2 {
            font-size: 13pt;
            text-transform: uppercase;
            text-decoration: underline;
            margin: 0;
            color: #0f172a;
        }
        .doc-title p {
            font-size: 9.5pt;
            margin: 4px 0 0 0;
            color: #475569;
        }
        .content {
            margin: 15px 0;
            text-align: justify;
        }
        .info-table {
            width: 90%;
            margin: 15px auto;
            border-collapse: collapse;
        }
        .info-table td {
            padding: 5px 8px;
            vertical-align: top;
            font-size: 10.5pt;
        }
        .badge-passed {
            display: inline-block;
            background-color: #d1fae5;
            color: #065f46;
            border: 2px solid #059669;
            padding: 6px 18px;
            font-size: 12pt;
            font-weight: bold;
            border-radius: 6px;
            letter-spacing: 1px;
        }
        .footer-table {
            width: 100%;
            margin-top: 35px;
        }
        .signature-box {
            text-align: center;
            width: 200px;
        }
    </style>
</head>
<body>

    <!-- Kop Surat -->
    <table class="header-table">
        <tr>
            <td style="width: 80px; text-align: center; vertical-align: middle;">
                <div style="width: 60px; height: 60px; background: #065f46; border-radius: 50%; color: white; font-size: 24pt; line-height: 60px; font-weight: bold; margin: 0 auto;">
                    M
                </div>
            </td>
            <td style="text-align: center;">
                <h1 class="school-title">PANITIA PENERIMAAN PESERTA DIDIK BARU</h1>
                <h2 style="font-size: 12pt; margin: 3px 0; color: #1e293b;">MA AL-HIKMAH TERPADU 2026/2027</h2>
                <p class="school-sub">Jl. Pendidikan No. 45, Kecamatan Sukamaju, Jawa Tengah • Telp: (0281) 892345 • info@alhikmah.sch.id</p>
            </td>
        </tr>
    </table>

    <!-- Judul Dokumen -->
    <div class="doc-title">
        <h2>SURAT KETERANGAN KELULUSAN SELEKSI</h2>
        <p>Nomor: SK-PPDB/{{ date('Y') }}/{{ str_pad($registration->id, 4, '0', STR_PAD_LEFT) }}</p>
    </div>

    <div class="content">
        <p>Berdasarkan hasil verifikasi administrasi, asesmen diagnostik, serta rapat pleno Panitia Penerimaan Peserta Didik Baru (PPDB) Madrasah Aliyah Al-Hikmah Terpadu Tahun Ajaran 2026/2027, dengan ini menerangkan bahwa:</p>

        <table class="info-table">
            <tr>
                <td style="width: 35%; font-weight: bold;">Nomor Registrasi</td>
                <td style="width: 3%;">:</td>
                <td style="font-weight: bold; color: #065f46;">{{ $registration->reg_code }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nama Lengkap Siswa</td>
                <td>:</td>
                <td style="font-weight: bold; text-transform: uppercase;">{{ $registration->full_name }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Nomor Induk Kependudukan (NIK)</td>
                <td>:</td>
                <td>{{ $registration->nik }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Tanggal Lahir</td>
                <td>:</td>
                <td>{{ $registration->dob ? $registration->dob->format('d F Y') : '-' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Pilihan Peminatan Klaster</td>
                <td>:</td>
                <td style="font-weight: bold;">{{ $registration->cluster?->name ?? 'Klaster Terpilih' }}</td>
            </tr>
            <tr>
                <td style="font-weight: bold;">Program Tempat Tinggal</td>
                <td>:</td>
                <td>{{ $registration->is_boarding ? 'Santri Mukim (Asrama Pesantren)' : 'Non-Mukim (Reguler PP)' }}</td>
            </tr>
        </table>

        <div style="text-align: center; margin: 20px 0;">
            <p style="margin-bottom: 8px; font-size: 10pt; color: #475569;">Dinyatakan secara resmi:</p>
            <span class="badge-passed">LULUS / DITERIMA</span>
        </div>

        <p style="margin-top: 15px;">Demikian surat keterangan kelulusan ini diterbitkan secara sah melalui sistem elektronik PPDB Online untuk dapat dipergunakan dalam proses daftar ulang dan registrasi fisik santri baru.</p>
    </div>

    <!-- Tanda Tangan & QR Code Validasi -->
    <table class="footer-table">
        <tr>
            <td style="width: 50%; vertical-align: top; text-align: left;">
                @if(isset($qrCode))
                    <div style="display: inline-block; padding: 6px; border: 1px solid #cbd5e1; border-radius: 8px;">
                        <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="90" height="90">
                    </div>
                    <div style="font-size: 7.5pt; color: #64748b; margin-top: 4px;">
                        Pindai QR Code untuk memvalidasi keaslian surat keputusan ini.
                    </div>
                @endif
            </td>
            <td style="width: 50%; vertical-align: top; text-align: right;">
                <div style="display: inline-block; text-align: center;" class="signature-box">
                    <p style="margin: 0; font-size: 9.5pt;">Ditetapkan di: Jawa Tengah</p>
                    <p style="margin: 2px 0 0 0; font-size: 9.5pt;">Pada tanggal: {{ date('d F Y') }}</p>
                    <p style="margin: 15px 0 0 0; font-size: 9.5pt; font-weight: bold;">Ketua Panitia PPDB 2026,</p>
                    
                    @if(isset($stampBase64) && $stampBase64)
                        <div style="margin: 5px 0;">
                            <img src="data:image/png;base64,{{ $stampBase64 }}" width="90" style="opacity: 0.85;">
                        </div>
                    @else
                        <div style="height: 60px;"></div>
                    @endif

                    <p style="margin: 0; font-size: 10pt; font-weight: bold; text-decoration: underline;">H. Ahmad Zaki Mubarak, M.Pd.</p>
                    <p style="margin: 2px 0 0 0; font-size: 8.5pt; color: #475569;">NIP. 19820514 200801 1 012</p>
                </div>
            </td>
        </tr>
    </table>

</body>
</html>

