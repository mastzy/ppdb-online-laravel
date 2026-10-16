<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kartu Bukti Pendaftaran PPDB Online</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; margin: 20px; }
        .header { text-align: center; border-bottom: 2px solid #000; padding-bottom: 10px; margin-bottom: 20px; }
        .header h2 { margin: 0; text-transform: uppercase; }
        .header p { margin: 5px 0 0; font-size: 11px; }
        .table-data { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        .table-data td { padding: 6px; vertical-align: top; }
        .table-data td.label { font-weight: bold; width: 30%; }
        .footer { margin-top: 30px; width: 100%; }
        .qr-code { text-align: right; }
    </style>
</head>
<body>

    <div class="header">
        <h2>KARTU BUKTI PENDAFTARAN PPDB ONLINE</h2>
        <p>Tahun Ajaran 2026/2027 — Tanda Bukti Pendaftaran Resmi</p>
    </div>

    <table class="table-data">
        <tr>
            <td class="label">Nama Lengkap</td>
            <td>: {{ $registration->user->name }}</td>
        </tr>
        <tr>
            <td class="label">NIK / NISN</td>
            <td>: {{ $registration->user->nik }} / {{ $registration->user->nisn }}</td>
        </tr>
        <tr>
            <td class="label">Email Terdaftar</td>
            <td>: {{ $registration->user->email }}</td>
        </tr>
        <tr>
            <td class="label">Jalur Pendaftaran</td>
            <td>: {{ strtoupper($registration->jalur) }}</td>
        </tr>
        <tr>
            <td class="label">Status Verifikasi</td>
            <td>: {{ strtoupper(str_replace('_', ' ', $registration->status)) }}</td>
        </tr>
        <tr>
            <td class="label">Tanggal Finalisasi</td>
            <td>: {{ $registration->updated_at->format('d F Y H:i') }} WIB</td>
        </tr>
    </table>

    <table class="footer">
        <tr>
            <td style="width: 60%;">
                <p><strong>Catatan Penting:</strong></p>
                <ul>
                    <li>Kartu ini merupakan bukti sah pendaftaran PPDB Online.</li>
                    <li>Simpan dokumen ini untuk tahap verifikasi ulang/daftar ulang fisik.</li>
                    <li>Keabsahan dokumen dapat dipindai melalui QR Code terlampir.</li>
                </ul>
            </td>
            <td class="qr-code">
                <p style="margin-bottom: 5px; font-weight: bold;">Validasi Dokumen:</p>
                <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="110" height="110" alt="QR Code Validasi">
            </td>
        </tr>
    </table>

</body>
</html>