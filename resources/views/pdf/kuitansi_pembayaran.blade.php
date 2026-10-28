<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Kuitansi Pembayaran PPDB - {{ $registration->reg_code }}</title>
    <style>
        @page {
            margin: 25px 35px;
        }

        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            font-size: 11pt;
            color: #1e293b;
            line-height: 1.4;
        }

        /* Kop Surat */
        .kop-table {
            width: 100%;
            border-bottom: 3px double #0f172a;
            padding-bottom: 12px;
            margin-bottom: 18px;
        }

        .kop-table td {
            vertical-align: middle;
        }

        .kop-logo {
            width: 75px;
            text-align: center;
        }

        .kop-logo-box {
            width: 65px;
            height: 65px;
            border-radius: 50%;
            background-color: #0284c7;
            color: #ffffff;
            font-size: 24pt;
            font-weight: bold;
            line-height: 65px;
            text-align: center;
            display: inline-block;
        }

        .kop-text {
            text-align: center;
            padding-left: 10px;
        }

        .kop-text h3 {
            margin: 0;
            font-size: 13pt;
            color: #0369a1;
            letter-spacing: 0.05em;
            text-transform: uppercase;
        }

        .kop-text h1 {
            margin: 2px 0;
            font-size: 18pt;
            font-weight: 800;
            color: #0f172a;
            letter-spacing: -0.01em;
        }

        .kop-text p {
            margin: 0;
            font-size: 8.5pt;
            color: #64748b;
        }

        /* Document Title */
        .title-box {
            text-align: center;
            margin-bottom: 20px;
        }

        .title-box h2 {
            margin: 0;
            font-size: 15pt;
            text-decoration: underline;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: #0f172a;
        }

        .title-box .receipt-no {
            margin-top: 4px;
            font-size: 9.5pt;
            font-weight: bold;
            color: #0284c7;
            letter-spacing: 0.05em;
        }

        /* Data Table */
        .content-table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 18px;
        }

        .content-table td {
            padding: 7px 4px;
            vertical-align: top;
            font-size: 10.5pt;
        }

        .label-col {
            width: 28%;
            font-weight: 600;
            color: #334155;
        }

        .sep-col {
            width: 3%;
            text-align: center;
        }

        .val-col {
            width: 69%;
            font-weight: 500;
            color: #0f172a;
        }

        /* Terbilang Box */
        .terbilang-box {
            background-color: #f8fafc;
            border-left: 4px solid #0284c7;
            padding: 8px 12px;
            font-style: italic;
            font-size: 10pt;
            color: #334155;
            margin-bottom: 20px;
        }

        /* Nominal Box */
        .amount-highlight-box {
            background-color: #f1f5f9;
            border: 1.5px solid #cbd5e1;
            padding: 12px 18px;
            border-radius: 6px;
            display: inline-block;
            margin-bottom: 15px;
        }

        .amount-highlight-label {
            font-size: 8.5pt;
            text-transform: uppercase;
            font-weight: bold;
            color: #64748b;
            letter-spacing: 0.05em;
        }

        .amount-highlight-value {
            font-size: 18pt;
            font-weight: 800;
            color: #047857;
            letter-spacing: 0.02em;
        }

        /* Footer Signature & Validation */
        .footer-table {
            width: 100%;
            margin-top: 25px;
            border-collapse: collapse;
        }

        .footer-table td {
            vertical-align: top;
        }

        .qr-section {
            width: 45%;
            text-align: left;
        }

        .qr-box {
            display: inline-block;
            padding: 8px;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
        }

        .qr-caption {
            font-size: 8pt;
            color: #64748b;
            margin-top: 4px;
            line-height: 1.3;
        }

        .signature-section {
            width: 55%;
            text-align: center;
            position: relative;
        }

        .signature-date {
            font-size: 10pt;
            margin-bottom: 4px;
        }

        .signature-role {
            font-size: 10pt;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .stamp-container {
            position: relative;
            height: 90px;
            margin: 0 auto;
        }

        .stamp-image {
            position: absolute;
            left: 20px;
            top: -15px;
            width: 110px;
            height: 110px;
            opacity: 0.88;
        }

        .signature-name {
            font-size: 10.5pt;
            font-weight: bold;
            text-decoration: underline;
            color: #0f172a;
        }

        .signature-nip {
            font-size: 8.5pt;
            color: #64748b;
        }

        .watermark-paid {
            font-size: 10pt;
            font-weight: bold;
            color: #059669;
            background: #d1fae5;
            padding: 2px 8px;
            border-radius: 4px;
            display: inline-block;
            margin-top: 4px;
        }
    </style>
</head>
<body>

    <!-- KOP SURAT RESMI -->
    <table class="kop-table">
        <tr>
            <td class="kop-logo">
                <div class="kop-logo-box">MA</div>
            </td>
            <td class="kop-text">
                <h3>PANITIA PENERIMAAN PESERTA DIDIK BARU (PPDB)</h3>
                <h1>MADRASAH ALIYAH AL-HIKMAH TERPADU</h1>
                <p>Jl. Raya Pendidikan No. 45, Kompleks Islamic Centre • NPSN: 69912345 • Akreditasi A (Unggul)</p>
                <p>Website: ppdb.sekolah.sch.id | Email: ppdb@sekolah.sch.id | Telp: (021) 8899-7766</p>
            </td>
        </tr>
    </table>

    <!-- JUDUL KUITANSI -->
    <div class="title-box">
        <h2>KUITANSI PEMBAYARAN RESMI</h2>
        <div class="receipt-no">NOMOR: {{ $receiptNumber }}</div>
        <div class="watermark-paid">STATUS: LUNAS (PAID)</div>
    </div>

    <!-- RINCIAN TRANSAKSI -->
    <table class="content-table">
        <tr>
            <td class="label-col">Telah Diterima Dari</td>
            <td class="sep-col">:</td>
            <td class="val-col"><strong>{{ $registration->full_name }}</strong></td>
        </tr>
        <tr>
            <td class="label-col">Nomor Registrasi / NIK</td>
            <td class="sep-col">:</td>
            <td class="val-col">{{ $registration->reg_code }} &nbsp;/&nbsp; {{ $registration->nik }}</td>
        </tr>
        <tr>
            <td class="label-col">NISN Calon Siswa</td>
            <td class="sep-col">:</td>
            <td class="val-col">{{ $registration->nisn ?? '-' }}</td>
        </tr>
        <tr>
            <td class="label-col">Pilihan Klaster / Jurusan</td>
            <td class="sep-col">:</td>
            <td class="val-col">{{ $registration->cluster->name ?? 'Reguler PPDB 2026/2027' }} ({{ $registration->is_boarding ? 'Mukim / Pesantren' : 'Non-Mukim' }})</td>
        </tr>
        <tr>
            <td class="label-col">Untuk Pembayaran</td>
            <td class="sep-col">:</td>
            <td class="val-col">Biaya Pendaftaran & Administrasi PPDB Gelombang 1 T.A. 2026/2027 (Tanpa Biaya Layanan Tambahan)</td>
        </tr>
        <tr>
            <td class="label-col">Metode Pembayaran</td>
            <td class="sep-col">:</td>
            <td class="val-col">
                @if($payment && $payment->payment_method === 'cash')
                    <strong>TUNAI DI TEMPAT (Kasir Offline Bendahara PPDB)</strong>
                @else
                    <strong>TRANSFER BANK</strong> (Pengirim: {{ $payment->sender_bank ?? 'Bank' }} a.n {{ $payment->sender_name ?? $registration->full_name }})
                @endif
            </td>
        </tr>
        <tr>
            <td class="label-col">Tanggal Pelunasan</td>
            <td class="sep-col">:</td>
            <td class="val-col">
                {{ $payment && $payment->paid_at ? $payment->paid_at->translatedFormat('d F Y H:i') : now()->translatedFormat('d F Y H:i') }} WIB
            </td>
        </tr>
    </table>

    <!-- TERBILANG -->
    @php
        $amountValue = $payment ? (float) $payment->amount : 300000;
        if (!function_exists('penyebut')) {
            function penyebut($nilai) {
                $nilai = abs($nilai);
                $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
                $temp = "";
                if ($nilai < 12) {
                    $temp = " ". $huruf[$nilai];
                } else if ($nilai < 20) {
                    $temp = penyebut($nilai - 10). " Belas";
                } else if ($nilai < 100) {
                    $temp = penyebut($nilai/10)." Puluh". penyebut($nilai % 10);
                } else if ($nilai < 200) {
                    $temp = " Seratus" . penyebut($nilai - 100);
                } else if ($nilai < 1000) {
                    $temp = penyebut($nilai/100) . " Ratus" . penyebut($nilai % 100);
                } else if ($nilai < 2000) {
                    $temp = " Seribu" . penyebut($nilai - 1000);
                } else if ($nilai < 1000000) {
                    $temp = penyebut($nilai/1000) . " Ribu" . penyebut($nilai % 1000);
                } else if ($nilai < 1000000000) {
                    $temp = penyebut($nilai/1000000) . " Juta" . penyebut($nilai % 1000000);
                }
                return $temp;
            }
        }
        $terbilangText = trim(penyebut((int)$amountValue)) . " Rupiah";
    @endphp

    <div class="terbilang-box">
        <strong>Terbilang:</strong> # {{ $terbilangText }} #
    </div>

    <!-- KOTAK JUMLAH NOMINAL RESMI BULAT -->
    <div class="amount-highlight-box">
        <div class="amount-highlight-label">Jumlah Pembayaran Diterima:</div>
        <div class="amount-highlight-value">Rp {{ number_format($amountValue, 0, ',', '.') }},-</div>
    </div>

    <!-- FOOTER: QR CODE VALIDASI KEABSAHAN & STEMPEL DIGITAL -->
    <table class="footer-table">
        <tr>
            <!-- QR CODE VALIDASI RESMI -->
            <td class="qr-section">
                <div class="qr-box">
                    <img src="data:image/svg+xml;base64,{{ $qrCode }}" width="115" height="115" alt="QR Code Keabsahan">
                </div>
                <div class="qr-caption">
                    <strong>Pindai / Scan QR Code</strong> untuk memvalidasi keaslian tanda terima ini secara real-time pada sistem pusat PPDB Online.
                </div>
            </td>

            <!-- TANDA TANGAN & STEMPEL DIGITAL -->
            <td class="signature-section">
                <div class="signature-date">
                    Ditetapkan di: Jakarta<br>
                    Pada tanggal: {{ $payment && $payment->paid_at ? $payment->paid_at->translatedFormat('d F Y') : now()->translatedFormat('d F Y') }}
                </div>
                <div class="signature-role">
                    Bendahara Penerimaan PPDB,
                </div>

                <div class="stamp-container">
                    @if(!empty($stampBase64))
                        <img src="data:image/png;base64,{{ $stampBase64 }}" class="stamp-image" alt="Stempel Digital Panitia">
                    @endif
                </div>

                <div class="signature-name">
                    {{ $payment && $payment->verifier ? $payment->verifier->name : 'Hj. Siti Rahmawati, S.E.' }}
                </div>
                <div class="signature-nip">
                    NIP / NBM. 19820514 200801 2 009
                </div>
            </td>
        </tr>
    </table>

</body>
</html>
