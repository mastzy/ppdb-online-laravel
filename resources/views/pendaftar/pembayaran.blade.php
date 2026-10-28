<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pembayaran Pendaftaran - PPDB Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --emerald: #059669;
            --emerald-dark: #047857;
            --slate-50: #f8fafc;
            --slate-100: #f1f5f9;
            --slate-200: #e2e8f0;
            --slate-600: #475569;
            --slate-700: #334155;
            --slate-800: #1e293b;
            --slate-900: #0f172a;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: linear-gradient(135deg, #0f172a 0%, #1e293b 50%, #0f172a 100%);
            color: var(--slate-800);
            min-height: 100vh;
            padding: 30px 15px;
        }

        .container {
            max-width: 980px;
            margin: 0 auto;
        }

        .header-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 25px;
            color: #fff;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.08);
            border: 1px solid rgba(255, 255, 255, 0.15);
            padding: 8px 16px;
            border-radius: 9999px;
            backdrop-filter: blur(10px);
            font-size: 13px;
            font-weight: 600;
            color: #38bdf8;
        }

        .nav-actions {
            display: flex;
            gap: 10px;
        }

        .btn-link {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.1);
            color: #fff;
            padding: 8px 16px;
            border-radius: 8px;
            text-decoration: none;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-link:hover {
            background: rgba(255, 255, 255, 0.2);
        }

        .card-main {
            background: #ffffff;
            border-radius: 20px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.35);
            overflow: hidden;
            margin-bottom: 25px;
        }

        .card-topbar {
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            padding: 24px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .topbar-info h1 {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 4px;
        }

        .topbar-info p {
            font-size: 13px;
            opacity: 0.9;
        }

        .reg-tag {
            background: rgba(255, 255, 255, 0.18);
            padding: 8px 14px;
            border-radius: 10px;
            font-size: 13px;
            font-weight: 700;
            letter-spacing: 0.05em;
            border: 1px solid rgba(255, 255, 255, 0.25);
        }

        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin: 20px 30px 0 30px;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .alert-success {
            background-color: #ecfdf5;
            color: #065f46;
            border: 1px solid #a7f3d0;
        }

        .alert-error {
            background-color: #fef2f2;
            color: #991b1b;
            border: 1px solid #fecaca;
        }

        .grid-layout {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 30px;
            padding: 30px;
        }

        @media (max-width: 820px) {
            .grid-layout {
                grid-template-columns: 1fr;
            }
        }

        /* Invoice Section */
        .price-banner {
            background: linear-gradient(135deg, #f8fafc 0%, #f1f5f9 100%);
            border: 2px dashed #cbd5e1;
            border-radius: 16px;
            padding: 22px;
            text-align: center;
            margin-bottom: 25px;
        }

        .price-label {
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.08em;
            color: var(--slate-600);
            margin-bottom: 6px;
        }

        .price-amount {
            font-size: 38px;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.03em;
            line-height: 1.1;
        }

        .price-meta {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            margin-top: 8px;
            font-size: 12px;
            font-weight: 600;
            color: #047857;
            background: #d1fae5;
            padding: 4px 10px;
            border-radius: 9999px;
        }

        .section-header {
            font-size: 16px;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .bank-card {
            background: #ffffff;
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 12px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            transition: all 0.2s ease;
        }

        .bank-card:hover {
            border-color: var(--primary);
            box-shadow: 0 4px 12px rgba(2, 132, 199, 0.08);
            transform: translateY(-1px);
        }

        .bank-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 2px;
        }

        .bank-number {
            font-family: monospace;
            font-size: 16px;
            font-weight: 700;
            color: var(--primary-dark);
            letter-spacing: 0.05em;
        }

        .bank-owner {
            font-size: 11px;
            color: var(--slate-600);
        }

        .btn-copy {
            background: var(--slate-100);
            border: 1px solid var(--slate-200);
            padding: 6px 12px;
            border-radius: 6px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.15s ease;
        }

        .btn-copy:hover {
            background: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .instructions-list {
            background: #f8fafc;
            border-radius: 12px;
            padding: 16px 20px;
            margin-top: 18px;
            font-size: 13px;
            color: var(--slate-700);
        }

        .instructions-list ol {
            padding-left: 20px;
        }

        .instructions-list li {
            margin-bottom: 6px;
            line-height: 1.5;
        }

        /* Form Upload */
        .form-box {
            background: #f8fafc;
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            padding: 22px;
        }

        .form-group {
            margin-bottom: 18px;
        }

        .form-label {
            display: block;
            font-size: 13px;
            font-weight: 700;
            color: var(--slate-800);
            margin-bottom: 6px;
        }

        .form-label span.req {
            color: #ef4444;
        }

        .form-input {
            width: 100%;
            padding: 10px 14px;
            border: 1.5px solid var(--slate-200);
            border-radius: 8px;
            font-size: 14px;
            font-family: inherit;
            transition: all 0.2s ease;
            background: white;
        }

        .form-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(2, 132, 199, 0.15);
        }

        .file-upload-zone {
            border: 2px dashed #94a3b8;
            border-radius: 10px;
            padding: 18px;
            text-align: center;
            background: white;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .file-upload-zone:hover {
            border-color: var(--primary);
            background: #f0f9ff;
        }

        .btn-submit {
            width: 100%;
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dark) 100%);
            color: white;
            border: none;
            padding: 13px 20px;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 700;
            cursor: pointer;
            box-shadow: 0 4px 12px rgba(5, 150, 105, 0.25);
            transition: all 0.2s ease;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 8px;
        }

        .btn-submit:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .payment-status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            padding: 6px 12px;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 700;
        }

        .status-paid {
            background: #d1fae5;
            color: #065f46;
        }

        .status-pending {
            background: #fef3c7;
            color: #92400e;
        }

        .status-draft {
            background: #e2e8f0;
            color: #334155;
        }

        .btn-receipt {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            background: #0284c7;
            color: white;
            text-decoration: none;
            padding: 12px 18px;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 700;
            width: 100%;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.2);
            transition: all 0.2s ease;
        }

        .btn-receipt:hover {
            background: #0369a1;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Header Navigation -->
    <div class="header-nav">
        <div class="brand-badge">
            <svg width="16" height="16" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            Sistem Informasi PPDB Online Mandiri
        </div>
        <div class="nav-actions">
            <a href="{{ route('pendaftar.formulir') }}" class="btn-link">
                ← Kembali ke Formulir
            </a>
            <form action="{{ route('pendaftar.logout') }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn-link" style="border:none; cursor:pointer;">Keluar</button>
            </form>
        </div>
    </div>

    <!-- Main Card -->
    <div class="card-main">
        <div class="card-topbar">
            <div class="topbar-info">
                <h1>Modul Pembayaran Mandiri</h1>
                <p>Calon Siswa: <strong>{{ $applicant->full_name }}</strong> (NIK: {{ $applicant->nik }})</p>
            </div>
            <div class="reg-tag">
                NO. REG: {{ $applicant->reg_code }}
            </div>
        </div>

        @if(session('success'))
            <div class="alert alert-success">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                <div>{{ session('success') }}</div>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-error">
                <svg width="18" height="18" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/></svg>
                <div>
                    <strong>Perhatian:</strong>
                    <ul style="margin-left: 15px; margin-top: 4px;">
                        @foreach($errors->all() as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            </div>
        @endif

        <div class="grid-layout">
            <!-- Kolom Kiri: Tagihan & Rekening Sekolah -->
            <div>
                <!-- Nominal Resmi Bulat Tanpa Kode Unik / Admin Fee -->
                <div class="price-banner">
                    <div class="price-label">Nominal Resmi Administrasi Pendaftaran</div>
                    <div class="price-amount">Rp {{ number_format($baseAmount, 0, ',', '.') }}</div>
                    <div class="price-meta">
                        <svg width="14" height="14" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        Nominal Bulat • Bebas Biaya Layanan & Tanpa Kode Unik
                    </div>
                    @if($applicant->has_sibling_discount)
                        <div style="margin-top: 8px; font-size: 12px; color: #0284c7; font-weight: 600;">
                            ✨ Diskon Saudara Kandung Aktif (Potongan Rp 60.000)
                        </div>
                    @endif
                </div>

                <!-- Petunjuk Transfer Bank Sekolah -->
                <div class="section-header">
                    <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"/></svg>
                    Rekening Resmi Bank Sekolah
                </div>

                @foreach($bankAccounts as $bank)
                    <div class="bank-card">
                        <div>
                            <div class="bank-name">{{ $bank['bank'] }}</div>
                            <div class="bank-number" id="acc-{{ $loop->index }}">{{ $bank['account_number'] }}</div>
                            <div class="bank-owner">a.n. {{ $bank['account_name'] }}</div>
                        </div>
                        <button type="button" class="btn-copy" onclick="copyAccount('{{ $bank['account_number'] }}', this)">
                            Salin No. Rek
                        </button>
                    </div>
                @endforeach

                <div class="instructions-list">
                    <strong>Petunjuk Pembayaran:</strong>
                    <ol>
                        <li>Transfer sesuai nominal pas <strong>Rp {{ number_format($baseAmount, 0, ',', '.') }}</strong> ke salah satu rekening sekolah di atas.</li>
                        <li>Pastikan simpan tangkapan layar (screenshot) atau foto struk bukti transfer ATM/m-Banking.</li>
                        <li>Isi form di samping dengan mencantumkan <strong>Nama Bank</strong> dan <strong>Nama Pemilik Rekening Pengirim</strong> yang sesuai pada struk.</li>
                        <li>Pendaftar juga dapat melakukan pembayaran tunai langsung di sekretariat PPDB sekolah via <strong>Kasir Offline</strong>.</li>
                    </ol>
                </div>
            </div>

            <!-- Kolom Kanan: Status & Form Upload Bukti -->
            <div>
                <!-- Status Pendaftaran Saat Ini -->
                <div style="background: white; border: 1px solid var(--slate-200); border-radius: 16px; padding: 18px; margin-bottom: 20px;">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 12px;">
                        <span style="font-size: 13px; font-weight: 600; color: var(--slate-600);">Status Pembayaran:</span>
                        @if(in_array($applicant->status, ['paid', 'verified', 'passed']))
                            <span class="payment-status-badge status-paid">✓ LUNAS (PAID)</span>
                        @elseif($latestPayment && $latestPayment->status === 'pending')
                            <span class="payment-status-badge status-pending">⏳ MENUNGGU VERIFIKASI</span>
                        @else
                            <span class="payment-status-badge status-draft">BELUM DIBAYAR</span>
                        @endif
                    </div>

                    @if(in_array($applicant->status, ['paid', 'verified', 'passed']))
                        <div style="background: #ecfdf5; border: 1px solid #a7f3d0; border-radius: 10px; padding: 14px; text-align: center; margin-bottom: 14px;">
                            <p style="font-size: 13px; font-weight: 700; color: #065f46; margin-bottom: 6px;">
                                Pembayaran Resmi Telah Dikonfirmasi!
                            </p>
                            <p style="font-size: 12px; color: #047857;">
                                Anda dapat mengunduh Kuitansi Pembayaran Resmi berformat PDF yang dilengkapi QR Code keabsahan & stempel digital.
                            </p>
                        </div>

                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <a href="{{ route('kuitansi.pdf', $applicant->id) }}" class="btn-receipt">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh Kuitansi Resmi PDF
                            </a>
                            <a href="{{ route('stopmap.pdf', $applicant->id) }}" class="btn-receipt" style="background:#475569;" target="_blank">
                                <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                Unduh Ringkasan Stopmap (PDF 1 Lembar)
                            </a>
                            @if($applicant->status === 'passed')
                                <a href="{{ route('pendaftar.welcome_hub') }}" class="btn-receipt" style="background: linear-gradient(135deg, #059669 0%, #047857 100%);">
                                    🎉 Buka Welcome Hub (LULUS)
                                </a>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- Form Upload Struk Transfer (Wajib Nama Bank & Nama Rekening Pengirim) -->
                <div class="form-box">
                    <div class="section-header" style="margin-bottom: 16px;">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-8l-4-4m0 0L8 8m4-4v12"/></svg>
                        Konfirmasi Pembayaran Transfer
                    </div>

                    <form action="{{ route('pendaftar.pembayaran.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="form-group">
                            <label class="form-label">
                                Nama Bank Pengirim <span class="req">*</span>
                            </label>
                            <input type="text" name="sender_bank" class="form-input" 
                                   placeholder="Contoh: Bank BCA / Mandiri / BSI / BRI" 
                                   value="{{ old('sender_bank', $latestPayment->sender_bank ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Nama Pemilik Rekening Pengirim <span class="req">*</span>
                            </label>
                            <input type="text" name="sender_name" class="form-input" 
                                   placeholder="Contoh: Budi Santoso (Sesuai buku rekening/struk)" 
                                   value="{{ old('sender_name', $latestPayment->sender_name ?? '') }}" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">
                                Unggah File Struk / Bukti Transfer <span class="req">*</span>
                            </label>
                            <div class="file-upload-zone" onclick="document.getElementById('proof_file_input').click()">
                                <svg width="32" height="32" fill="none" stroke="#64748b" stroke-width="1.8" viewBox="0 0 24 24" style="margin: 0 auto 6px;"><path stroke-linecap="round" stroke-linejoin="round" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"/></svg>
                                <div style="font-size: 13px; font-weight: 600; color: var(--slate-700);" id="upload_label">
                                    Klik untuk memilih berkas foto / struk
                                </div>
                                <div style="font-size: 11px; color: #94a3b8; margin-top: 2px;">
                                    Format JPG, PNG, atau PDF (Maks. 2 MB)
                                </div>
                                <input type="file" id="proof_file_input" name="proof_file" accept=".jpg,.jpeg,.png,.pdf" style="display:none;" required onchange="handleFileSelected(this)">
                            </div>
                        </div>

                        <button type="submit" class="btn-submit">
                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            Kirim Bukti Pembayaran
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyAccount(accountNumber, button) {
    navigator.clipboard.writeText(accountNumber).then(() => {
        const originalText = button.innerText;
        button.innerText = 'Tersalin!';
        button.style.background = '#059669';
        button.style.color = '#ffffff';
        setTimeout(() => {
            button.innerText = originalText;
            button.style.background = '';
            button.style.color = '';
        }, 2000);
    });
}

function handleFileSelected(input) {
    if (input.files && input.files[0]) {
        const fileName = input.files[0].name;
        document.getElementById('upload_label').innerText = 'Berkas dipilih: ' + fileName;
        document.getElementById('upload_label').style.color = '#0284c7';
    }
}
</script>

</body>
</html>
