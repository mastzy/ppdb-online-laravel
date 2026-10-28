<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Validasi Keabsahan Kuitansi PPDB Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 100%);
            color: #1e293b;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            margin: 0;
        }

        .card-verify {
            background: #ffffff;
            border-radius: 20px;
            max-width: 540px;
            width: 100%;
            padding: 32px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.4);
            text-align: center;
        }

        .check-badge {
            width: 68px;
            height: 68px;
            background: #d1fae5;
            color: #059669;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 18px;
        }

        .verify-title {
            font-size: 20px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 6px;
        }

        .verify-desc {
            font-size: 13px;
            color: #64748b;
            margin-bottom: 24px;
        }

        .data-table {
            width: 100%;
            text-align: left;
            border-collapse: collapse;
            margin-bottom: 24px;
            background: #f8fafc;
            border-radius: 12px;
            overflow: hidden;
            border: 1px solid #e2e8f0;
        }

        .data-table td {
            padding: 10px 14px;
            border-bottom: 1px solid #e2e8f0;
            font-size: 13px;
        }

        .data-table tr:last-child td {
            border-bottom: none;
        }

        .data-label {
            color: #64748b;
            font-weight: 600;
            width: 40%;
        }

        .data-val {
            color: #0f172a;
            font-weight: 700;
        }

        .stamp-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 700;
            margin-bottom: 20px;
        }

        .btn-home {
            display: inline-block;
            background: #0284c7;
            color: white;
            padding: 10px 20px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
        }
    </style>
</head>
<body>

<div class="card-verify">
    <div class="check-badge">
        <svg width="36" height="36" fill="none" stroke="currentColor" stroke-width="2.5" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
    </div>

    <div class="stamp-status">
        ✓ DOKUMEN ASLI & TERVERIFIKASI SISTEM
    </div>

    <h1 class="verify-title">Kuitansi Pembayaran Sah</h1>
    <p class="verify-desc">
        Data pembayaran pendaftaran berikut tercatat secara resmi di basis data PPDB Online Mandiri:
    </p>

    <table class="data-table">
        <tr>
            <td class="data-label">Nama Calon Siswa</td>
            <td class="data-val">{{ $registration->full_name }}</td>
        </tr>
        <tr>
            <td class="data-label">Nomor Registrasi</td>
            <td class="data-val" style="color: #0284c7;">{{ $registration->reg_code }}</td>
        </tr>
        <tr>
            <td class="data-label">NIK (16 Digit)</td>
            <td class="data-val">{{ substr($registration->nik, 0, 8) . '********' }}</td>
        </tr>
        <tr>
            <td class="data-label">Pilihan Klaster</td>
            <td class="data-val">{{ $registration->cluster->name ?? '-' }}</td>
        </tr>
        <tr>
            <td class="data-label">Jumlah Nominal</td>
            <td class="data-val" style="color: #059669; font-size: 15px;">
                Rp {{ number_format($payment ? $payment->amount : 300000, 0, ',', '.') }}
            </td>
        </tr>
        <tr>
            <td class="data-label">Metode Pembayaran</td>
            <td class="data-val">
                {{ $payment && $payment->payment_method === 'cash' ? 'Tunai di Kasir Offline' : 'Transfer Bank Mandiri' }}
            </td>
        </tr>
        <tr>
            <td class="data-label">Status Verifikasi</td>
            <td class="data-val" style="color: #059669;">LUNAS (PAID)</td>
        </tr>
    </table>

    <a href="{{ route('home') }}" class="btn-home">Kembali ke Halaman Utama</a>
</div>

</body>
</html>
