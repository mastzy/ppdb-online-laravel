<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mode Kasir Offline (Dashboard Bendahara) - PPDB Online</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --emerald: #059669;
            --emerald-dark: #047857;
            --amber: #d97706;
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
            background-color: #f1f5f9;
            color: var(--slate-800);
            min-height: 100vh;
            padding: 24px;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Top Header */
        .top-navbar {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            padding: 18px 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .brand-section {
            display: flex;
            align-items: center;
            gap: 14px;
        }

        .cashier-icon-badge {
            width: 44px;
            height: 44px;
            background: linear-gradient(135deg, #0284c7 0%, #0369a1 100%);
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            box-shadow: 0 4px 10px rgba(2, 132, 199, 0.3);
        }

        .brand-title {
            font-size: 18px;
            font-weight: 800;
            color: var(--slate-900);
            letter-spacing: -0.02em;
        }

        .brand-subtitle {
            font-size: 12px;
            color: var(--slate-600);
        }

        .user-nav {
            display: flex;
            align-items: center;
            gap: 16px;
        }

        .user-info {
            text-align: right;
            font-size: 13px;
        }

        .user-info strong {
            display: block;
            color: var(--slate-900);
        }

        .user-info span {
            color: #0284c7;
            font-weight: 600;
            font-size: 11px;
            text-transform: uppercase;
        }

        .btn-logout {
            background: #fee2e2;
            color: #dc2626;
            border: 1px solid #fecaca;
            padding: 8px 16px;
            border-radius: 8px;
            font-weight: 600;
            font-size: 13px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-logout:hover {
            background: #dc2626;
            color: white;
        }

        /* Alert notifications */
        .alert {
            padding: 14px 18px;
            border-radius: 12px;
            margin-bottom: 20px;
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

        /* Search Section */
        .search-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            padding: 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .search-card h2 {
            font-size: 16px;
            font-weight: 700;
            margin-bottom: 6px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .search-card p {
            font-size: 13px;
            color: var(--slate-600);
            margin-bottom: 16px;
        }

        .search-bar {
            display: flex;
            gap: 12px;
        }

        .search-input-wrapper {
            position: relative;
            flex: 1;
        }

        .search-input {
            width: 100%;
            padding: 14px 18px 14px 44px;
            border: 2px solid var(--slate-200);
            border-radius: 10px;
            font-size: 15px;
            font-family: inherit;
            transition: all 0.2s ease;
        }

        .search-input:focus {
            outline: none;
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(2, 132, 199, 0.15);
        }

        .search-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94a3b8;
        }

        .btn-search {
            background: var(--primary);
            color: white;
            border: none;
            padding: 0 24px;
            border-radius: 10px;
            font-weight: 700;
            font-size: 14px;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .btn-search:hover {
            background: var(--primary-dark);
        }

        /* Two columns layout */
        .content-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 24px;
        }

        @media (max-width: 900px) {
            .content-grid {
                grid-template-columns: 1fr;
            }
        }

        .panel-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 16px;
            padding: 24px;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .panel-title {
            font-size: 16px;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 16px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        /* Applicant Result Item */
        .applicant-item {
            border: 1.5px solid var(--slate-200);
            border-radius: 14px;
            padding: 18px;
            margin-bottom: 14px;
            transition: all 0.2s ease;
        }

        .applicant-item.active {
            border-color: var(--primary);
            background-color: #f0f9ff;
        }

        .applicant-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            margin-bottom: 10px;
        }

        .applicant-name {
            font-size: 16px;
            font-weight: 800;
            color: var(--slate-900);
        }

        .badge {
            display: inline-flex;
            align-items: center;
            gap: 4px;
            padding: 4px 10px;
            border-radius: 6px;
            font-size: 11px;
            font-weight: 700;
            text-transform: uppercase;
        }

        .badge-paid { background: #d1fae5; color: #065f46; }
        .badge-pending_payment { background: #fef3c7; color: #92400e; }
        .badge-draft { background: #e2e8f0; color: #334155; }

        .applicant-details {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 8px;
            font-size: 13px;
            color: var(--slate-600);
            margin-bottom: 14px;
        }

        .action-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            border-top: 1px solid rgba(0,0,0,0.06);
            padding-top: 14px;
            gap: 10px;
        }

        .amount-tag {
            font-size: 18px;
            font-weight: 800;
            color: var(--slate-900);
        }

        .btn-cash {
            background: linear-gradient(135deg, var(--emerald) 0%, var(--emerald-dark) 100%);
            color: white;
            border: none;
            padding: 10px 18px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            cursor: pointer;
            box-shadow: 0 4px 8px rgba(5, 150, 105, 0.25);
            transition: all 0.2s ease;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .btn-cash:hover {
            filter: brightness(1.08);
            transform: translateY(-1px);
        }

        .btn-print-kuitansi {
            background: #0284c7;
            color: white;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 8px;
            font-weight: 700;
            font-size: 13px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: all 0.2s ease;
        }

        .btn-print-kuitansi:hover {
            background: #0369a1;
        }

        /* Recent table */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 13px;
        }

        th {
            background: #f8fafc;
            color: var(--slate-600);
            font-weight: 700;
            text-align: left;
            padding: 10px 12px;
            border-bottom: 2px solid var(--slate-200);
        }

        td {
            padding: 12px;
            border-bottom: 1px solid var(--slate-200);
            vertical-align: middle;
        }

        tr:hover td {
            background: #f8fafc;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Top Navbar -->
    <div class="top-navbar">
        <div class="brand-section">
            <div class="cashier-icon-badge">
                <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
            </div>
            <div>
                <div class="brand-title">Mode Kasir Offline PPDB</div>
                <div class="brand-subtitle">Dashboard Transaksi Pembayaran Tunai di Tempat & Kuitansi Resmi</div>
            </div>
        </div>
        <div class="user-nav">
            <div class="user-info">
                <strong>{{ auth()->user()->name }}</strong>
                <span>Role: {{ auth()->user()->role }}</span>
            </div>
            <a href="{{ route('verifikator.dashboard') }}" class="btn-logout" style="background:#e0f2fe; color:#0284c7; border-color:#bae6fd; text-decoration:none;">
                Dashboard Panitia
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn-logout">Logout</button>
            </form>
        </div>
    </div>

    <!-- Alert Notifications -->
    @if(session('success'))
        <div class="alert alert-success">
            <svg width="20" height="20" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            <div>{{ session('success') }}</div>
        </div>
    @endif

    <!-- Form Pencarian Cepat Pendaftar (NIK / Kode Reg) -->
    <div class="search-card">
        <h2>
            <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
            Pencarian Cepat Calon Siswa (Kasir Offline)
        </h2>
        <p>Masukkan 16 digit NIK, Kode Registrasi (contoh: PPDB-2026-0001), atau Nama Lengkap calon siswa untuk melayani pembayaran tunai di tempat.</p>
        
        <form action="{{ route('bendahara.kasir') }}" method="GET" class="search-bar">
            <div class="search-input-wrapper">
                <svg class="search-icon" width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
                <input type="text" name="q" class="search-input" 
                       placeholder="Ketik NIK 16 Digit / No. Registrasi / Nama Pendaftar..." 
                       value="{{ $search }}" autofocus required>
            </div>
            <button type="submit" class="btn-search">Cari Pendaftar</button>
            @if(!empty($search))
                <a href="{{ route('bendahara.kasir') }}" class="btn-logout" style="display:flex; align-items:center; text-decoration:none;">Reset</a>
            @endif
        </form>
    </div>

    <!-- Content Grid -->
    <div class="content-grid">
        <!-- Kolom Kiri: Hasil Pencarian & Eksekusi Pembayaran Tunai -->
        <div class="panel-card">
            <div class="panel-title">
                <span>Hasil Pencarian Calon Siswa</span>
                <span style="font-size: 13px; font-weight: 500; color: #64748b;">{{ $registrations->count() }} Pendaftar ditemukan</span>
            </div>

            @if(!empty($search) && $registrations->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                    <svg width="44" height="44" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    <p style="font-weight: 600;">Data pendaftar dengan kata kunci "{{ $search }}" tidak ditemukan.</p>
                    <p style="font-size: 12px; margin-top: 4px;">Pastikan NIK atau No. Registrasi sudah benar dan telah terdaftar.</p>
                </div>
            @elseif($registrations->isEmpty())
                <div style="text-align: center; padding: 40px 20px; color: #64748b;">
                    <svg width="44" height="44" fill="none" stroke="#94a3b8" stroke-width="1.5" viewBox="0 0 24 24" style="margin: 0 auto 12px;"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4"/></svg>
                    <p style="font-weight: 600;">Silakan cari calon siswa melalui kolom pencarian di atas.</p>
                    <p style="font-size: 12px; margin-top: 4px;">Pencarian instan mempermudah antrean kasir offline di sekolah.</p>
                </div>
            @else
                @foreach($registrations as $reg)
                    @php
                        $nominal = $reg->has_sibling_discount ? 240000 : 300000;
                        $isPaid = in_array($reg->status, ['paid', 'verified', 'passed']);
                    @endphp
                    <div class="applicant-item {{ $isPaid ? '' : 'active' }}">
                        <div class="applicant-header">
                            <div>
                                <div class="applicant-name">{{ $reg->full_name }}</div>
                                <div style="font-size: 12px; font-weight: 600; color: #0284c7; margin-top: 2px;">
                                    Kode: {{ $reg->reg_code }} • NIK: {{ $reg->nik }}
                                </div>
                            </div>
                            <span class="badge badge-{{ $reg->status }}">
                                {{ strtoupper(str_replace('_', ' ', $reg->status)) }}
                            </span>
                        </div>

                        <div class="applicant-details">
                            <div>Klaster: <strong>{{ $reg->cluster->name ?? 'Belum Pilih' }}</strong></div>
                            <div>No. WA/HP: <strong>{{ $reg->phone_number ?? '-' }}</strong></div>
                            <div>Status Boarding: <strong>{{ $reg->is_boarding ? 'Mukim (Pesantren)' : 'Non-Mukim' }}</strong></div>
                            <div>Diskon Saudara: <strong>{{ $reg->has_sibling_discount ? 'Ya (20%)' : 'Tidak' }}</strong></div>
                        </div>

                        <div class="action-row">
                            <div>
                                <div style="font-size: 11px; color: #64748b; text-transform: uppercase;">Nominal Bulat:</div>
                                <div class="amount-tag">Rp {{ number_format($nominal, 0, ',', '.') }}</div>
                            </div>

                            <div>
                                @if(!$isPaid)
                                    <!-- Tombol Bayar Tunai di Tempat -->
                                    <form action="{{ route('bendahara.kasir.pay_cash', $reg->id) }}" method="POST" onsubmit="return confirm('Konfirmasi: Terima pembayaran tunai Rp {{ number_format($nominal, 0, ',', '.') }} untuk {{ $reg->full_name }}? Status pendaftar akan langsung diubah menjadi PAID.')">
                                        @csrf
                                        <button type="submit" class="btn-cash">
                                            <svg width="18" height="18" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                            Bayar Tunai di Tempat
                                        </button>
                                    </form>
                                @else
                                    <!-- Jika sudah paid, tampilkan tombol cetak kuitansi PDF & stopmap -->
                                    <div style="display: flex; gap: 6px; flex-wrap: wrap;">
                                        <a href="{{ route('kuitansi.pdf', $reg->id) }}" class="btn-print-kuitansi" target="_blank" title="Cetak Kuitansi Resmi PDF">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Kuitansi PDF
                                        </a>
                                        <a href="{{ route('stopmap.pdf', $reg->id) }}" class="btn-print-kuitansi" style="background:#475569;" target="_blank" title="Cetak Lembar Stopmap Wawancara (1 Hal A4)">
                                            <svg width="14" height="14" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            Stopmap
                                        </a>
                                        <span class="badge badge-paid" style="align-self: center;">LUNAS</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <!-- Kolom Kanan: Log Pembayaran Terakhir Kasir / Panitia -->
        <div class="panel-card">
            <div class="panel-title">
                <span>Log Transaksi Kasir & Pembayaran Terakhir</span>
                <span style="font-size: 13px; font-weight: 500; color: #64748b;">15 Transaksi</span>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>Waktu & No. Reg</th>
                            <th>Nama Pendaftar</th>
                            <th>Metode & Nominal</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($recentPayments as $payment)
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: #0284c7;">{{ $payment->registration->reg_code ?? '-' }}</div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        {{ $payment->paid_at ? $payment->paid_at->format('d/m/Y H:i') : $payment->created_at->format('d/m/Y H:i') }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 600;">{{ $payment->registration->full_name ?? '-' }}</div>
                                    <div style="font-size: 11px; color: #64748b;">
                                        NIK: {{ $payment->registration->nik ?? '-' }}
                                    </div>
                                </td>
                                <td>
                                    <div style="font-weight: 700; color: #0f172a;">
                                        Rp {{ number_format($payment->amount, 0, ',', '.') }}
                                    </div>
                                    <div>
                                        @if($payment->payment_method === 'cash')
                                            <span style="display:inline-block; font-size:10px; font-weight:700; color:#047857; background:#d1fae5; padding:2px 6px; border-radius:4px;">TUNAI KASIR</span>
                                        @else
                                            <span style="display:inline-block; font-size:10px; font-weight:700; color:#0369a1; background:#e0f2fe; padding:2px 6px; border-radius:4px;">TRANSFER</span>
                                        @endif
                                    </div>
                                </td>
                                <td>
                                    @if($payment->registration)
                                        <a href="{{ route('kuitansi.pdf', $payment->registration->id) }}" 
                                           class="btn-print-kuitansi" style="padding: 6px 10px; font-size: 11px;" target="_blank">
                                            Kuitansi
                                        </a>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" style="text-align: center; color: #94a3b8; padding: 24px;">
                                    Belum ada transaksi pembayaran yang tercatat.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

</body>
</html>
