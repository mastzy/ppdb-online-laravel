<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome Hub - Selamat Anda Dinyatakan LULUS PPDB 2026</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary: #0284c7;
            --primary-dark: #0369a1;
            --emerald: #059669;
            --emerald-dark: #047857;
            --wa-green: #25d366;
            --wa-green-dark: #128c7e;
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
            background: linear-gradient(135deg, #064e3b 0%, #065f46 40%, #0f172a 100%);
            color: var(--slate-800);
            min-height: 100vh;
            padding: 30px 15px;
        }

        .container {
            max-width: 1040px;
            margin: 0 auto;
        }

        /* Top Nav */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            color: white;
        }

        .brand-badge {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: rgba(255, 255, 255, 0.12);
            border: 1px solid rgba(255, 255, 255, 0.2);
            padding: 8px 18px;
            border-radius: 9999px;
            font-size: 13px;
            font-weight: 700;
            color: #6ee7b7;
            backdrop-filter: blur(10px);
        }

        .btn-nav {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.15);
            color: white;
            text-decoration: none;
            padding: 8px 16px;
            border-radius: 8px;
            font-size: 13px;
            font-weight: 600;
            transition: all 0.2s ease;
        }

        .btn-nav:hover {
            background: rgba(255, 255, 255, 0.25);
        }

        /* Celebration Hero Banner */
        .hero-banner {
            background: #ffffff;
            border-radius: 24px;
            box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.45);
            overflow: hidden;
            margin-bottom: 25px;
            position: relative;
        }

        .hero-top {
            background: linear-gradient(135deg, #059669 0%, #047857 60%, #065f46 100%);
            color: white;
            padding: 36px 40px;
            position: relative;
        }

        .hero-top::after {
            content: "★ ★ ★ ★ ★";
            position: absolute;
            right: 40px;
            top: 36px;
            font-size: 18px;
            color: #fde047;
            letter-spacing: 4px;
        }

        .congrats-chip {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: rgba(255, 255, 255, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.3);
            padding: 6px 14px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: 800;
            letter-spacing: 0.08em;
            text-transform: uppercase;
            color: #fef08a;
            margin-bottom: 12px;
        }

        .hero-title {
            font-size: 30px;
            font-weight: 800;
            letter-spacing: -0.02em;
            margin-bottom: 8px;
        }

        .hero-subtitle {
            font-size: 15px;
            opacity: 0.95;
            max-width: 720px;
            line-height: 1.5;
        }

        .applicant-badge-bar {
            background: #f8fafc;
            border-bottom: 1px solid var(--slate-200);
            padding: 16px 40px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 12px;
            font-size: 13px;
        }

        .applicant-badge-bar strong {
            color: var(--slate-900);
            font-size: 15px;
        }

        .status-pill {
            background: #d1fae5;
            color: #065f46;
            font-weight: 800;
            padding: 6px 14px;
            border-radius: 8px;
            font-size: 12px;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            border: 1px solid #a7f3d0;
        }

        /* Grid Layout */
        .main-grid {
            display: grid;
            grid-template-columns: 1.15fr 0.85fr;
            gap: 25px;
            padding: 30px 40px;
        }

        @media (max-width: 860px) {
            .main-grid {
                grid-template-columns: 1fr;
                padding: 20px;
            }
            .hero-top {
                padding: 24px;
            }
            .applicant-badge-bar {
                padding: 16px 20px;
            }
        }

        /* WhatsApp Card */
        .wa-card {
            background: linear-gradient(135deg, #ecfdf5 0%, #d1fae5 100%);
            border: 2px solid #a7f3d0;
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
            position: relative;
            overflow: hidden;
        }

        .wa-card::before {
            content: "";
            position: absolute;
            right: -20px;
            bottom: -20px;
            width: 140px;
            height: 140px;
            background: rgba(37, 211, 102, 0.12);
            border-radius: 50%;
            pointer-events: none;
        }

        .wa-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 12px;
        }

        .wa-icon-box {
            width: 48px;
            height: 48px;
            background: var(--wa-green);
            color: white;
            border-radius: 14px;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 8px 16px rgba(37, 211, 102, 0.3);
        }

        .wa-title {
            font-size: 18px;
            font-weight: 800;
            color: #064e3b;
        }

        .wa-subtitle {
            font-size: 12px;
            color: #047857;
            font-weight: 600;
        }

        .wa-desc {
            font-size: 13.5px;
            color: #065f46;
            line-height: 1.5;
            margin-bottom: 18px;
        }

        .btn-wa {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            background: linear-gradient(135deg, #25d366 0%, #128c7e 100%);
            color: white;
            text-decoration: none;
            padding: 14px 24px;
            border-radius: 12px;
            font-weight: 800;
            font-size: 15px;
            box-shadow: 0 6px 20px rgba(37, 211, 102, 0.35);
            transition: all 0.2s ease;
        }

        .btn-wa:hover {
            filter: brightness(1.08);
            transform: translateY(-2px);
        }

        .wa-contact-note {
            margin-top: 10px;
            font-size: 11.5px;
            color: #047857;
            text-align: center;
        }

        /* Uniform Section */
        .section-card {
            background: white;
            border: 1px solid var(--slate-200);
            border-radius: 18px;
            padding: 24px;
            margin-bottom: 24px;
        }

        .section-title {
            font-size: 17px;
            font-weight: 800;
            color: var(--slate-900);
            margin-bottom: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .schedule-box {
            background: #f0fdf4;
            border: 1.5px dashed #86efac;
            border-radius: 12px;
            padding: 14px 18px;
            margin-bottom: 18px;
            font-size: 13px;
        }

        .schedule-row {
            display: flex;
            margin-bottom: 6px;
        }

        .schedule-row:last-child {
            margin-bottom: 0;
        }

        .schedule-label {
            width: 110px;
            font-weight: 700;
            color: #166534;
        }

        .schedule-val {
            color: #14532d;
            font-weight: 600;
        }

        .uniform-item {
            border: 1px solid var(--slate-200);
            border-radius: 12px;
            padding: 14px;
            margin-bottom: 10px;
            background: #f8fafc;
        }

        .uniform-name {
            font-size: 14px;
            font-weight: 700;
            color: var(--slate-900);
            margin-bottom: 3px;
            display: flex;
            justify-content: space-between;
        }

        .uniform-days {
            font-size: 11px;
            background: #e2e8f0;
            color: #334155;
            padding: 2px 8px;
            border-radius: 4px;
            font-weight: 700;
        }

        .uniform-detail {
            font-size: 12.5px;
            color: var(--slate-600);
            line-height: 1.4;
        }

        /* Action Buttons */
        .doc-btn-grid {
            display: grid;
            grid-template-columns: 1fr;
            gap: 10px;
        }

        .doc-btn {
            display: flex;
            align-items: center;
            gap: 12px;
            background: white;
            border: 1.5px solid var(--slate-200);
            border-radius: 12px;
            padding: 14px 18px;
            text-decoration: none;
            color: var(--slate-800);
            font-weight: 700;
            font-size: 13.5px;
            transition: all 0.2s ease;
        }

        .doc-btn:hover {
            border-color: var(--primary);
            background: #f0f9ff;
            color: var(--primary);
            transform: translateY(-1px);
        }

        .doc-btn-icon {
            width: 36px;
            height: 36px;
            background: #e0f2fe;
            color: var(--primary);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body>

<div class="container">
    <!-- Top Nav -->
    <div class="top-nav">
        <div class="brand-badge">
            <svg width="18" height="18" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2L2 7l10 5 10-5-10-5zM2 17l10 5 10-5M2 12l10 5 10-5"/></svg>
            PPDB Al-Hikmah Terpadu • Official Welcome Hub
        </div>
        <div>
            <a href="{{ route('pendaftar.pembayaran') }}" class="btn-nav">← Ke Pembayaran</a>
            <form action="{{ route('pendaftar.logout') }}" method="POST" style="display:inline; margin-left:8px;">
                @csrf
                <button type="submit" class="btn-nav" style="border:none; cursor:pointer;">Keluar</button>
            </form>
        </div>
    </div>

    <!-- Celebration Hero -->
    <div class="hero-banner">
        <div class="hero-top">
            <div class="congrats-chip">🎉 TAHAN BIAYA & SELEKSI PPDB 2026</div>
            <h1 class="hero-title">Ahlan Wa Sahlan, Selamat Bergabung!</h1>
            <p class="hero-subtitle">
                Alhamdulillah wa Syukurillah, Anda resmi dinyatakan <strong>LULUS (DITERIMA)</strong> sebagai Calon Santri Baru Madrasah Aliyah Al-Hikmah Terpadu Tahun Ajaran 2026/2027.
            </p>
        </div>

        <div class="applicant-badge-bar">
            <div>
                Calon Siswa: <strong>{{ strtoupper($applicant->full_name) }}</strong> 
                (No. Reg: <span style="color:#0284c7; font-weight:700;">{{ $applicant->reg_code }}</span> • NIK: {{ $applicant->nik }})
            </div>
            <div style="display: flex; gap: 10px; align-items: center;">
                <span class="status-pill">
                    ✓ STATUS: RESMI DITERIMA
                </span>
                <span style="font-size: 12px; font-weight: 700; color: #475569; background: #e2e8f0; padding: 6px 12px; border-radius: 6px;">
                    {{ $applicant->cluster->name ?? 'Reguler' }} ({{ $applicant->is_boarding ? 'Santri Mukim' : 'Non-Mukim' }})
                </span>
            </div>
        </div>

        <div class="main-grid">
            <!-- Kolom Kiri: WhatsApp Paguyuban & Panduan Orientasi -->
            <div>
                <!-- 1. Tombol Satu-Klik Grup WhatsApp Wali Murid -->
                <div class="wa-card">
                    <div class="wa-header">
                        <div class="wa-icon-box">
                            <svg width="28" height="28" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-1.127-.065-.27-.087-.615-.205-1.056-.396-1.874-.816-3.09-2.723-3.185-2.848-.093-.127-.764-.999-.764-1.922 0-.923.479-1.378.649-1.567.17-.189.37-.236.493-.236.124 0 .248.001.356.006.113.006.265-.043.414.316.155.373.53 1.292.577 1.386.046.095.077.206.015.33-.062.124-.093.201-.186.309-.092.107-.195.239-.278.322-.093.093-.19.195-.082.38.108.185.481.794 1.034 1.286.711.635 1.311.832 1.498.924.186.093.296.078.406-.046.111-.124.475-.555.602-.746.128-.19.255-.158.428-.095.174.064 1.101.519 1.29.613.19.094.316.142.363.222.047.08.047.46-.097.865zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.98-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        </div>
                        <div>
                            <div class="wa-title">Komunitas Wali Santri Baru 2026</div>
                            <div class="wa-subtitle">Official WhatsApp Community PPDB Al-Hikmah</div>
                        </div>
                    </div>

                    <p class="wa-desc">
                        Silakan bergabung ke grup WhatsApp resmi paguyuban wali santri angkatan 2026/2027 untuk mendapatkan pengumuman berkala terkait tanggal masuk asrama, orientasi santri (MATSAMA), serta koordinasi antar wali santri.
                    </p>

                    <a href="{{ $waCommunity['link'] }}" target="_blank" class="btn-wa">
                        <svg width="20" height="20" fill="currentColor" viewBox="0 0 24 24"><path d="M12.031 6.172c-3.181 0-5.767 2.586-5.768 5.766-.001 1.298.38 2.27 1.019 3.287l-.582 2.128 2.182-.573c.978.58 1.911.928 3.145.929 3.178 0 5.767-2.587 5.768-5.766.001-3.187-2.575-5.77-5.764-5.771zm3.392 8.244c-.144.405-.837.774-1.17.824-.312.045-.694.074-1.127-.065-.27-.087-.615-.205-1.056-.396-1.874-.816-3.09-2.723-3.185-2.848-.093-.127-.764-.999-.764-1.922 0-.923.479-1.378.649-1.567.17-.189.37-.236.493-.236.124 0 .248.001.356.006.113.006.265-.043.414.316.155.373.53 1.292.577 1.386.046.095.077.206.015.33-.062.124-.093.201-.186.309-.092.107-.195.239-.278.322-.093.093-.19.195-.082.38.108.185.481.794 1.034 1.286.711.635 1.311.832 1.498.924.186.093.296.078.406-.046.111-.124.475-.555.602-.746.128-.19.255-.158.428-.095.174.064 1.101.519 1.29.613.19.094.316.142.363.222.047.08.047.46-.097.865zM12 2C6.477 2 2 6.477 2 12c0 1.89.525 3.66 1.438 5.168L2 22l4.98-1.396A9.957 9.957 0 0012 22c5.523 0 10-4.477 10-10S17.523 2 12 2z"/></svg>
                        Gabung ke Grup WhatsApp Paguyuban
                    </a>

                    <div class="wa-contact-note">
                        Kendala bergabung grup? Hubungi koordinator: <strong>{{ $waCommunity['admin_name'] }}</strong> (WhatsApp: +{{ $waCommunity['admin_phone'] }})
                    </div>
                </div>

                <!-- 2. Petunjuk dan Pengukuran Seragam Madrasah -->
                <div class="section-card">
                    <div class="section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/></svg>
                        Petunjuk Seragam & Atribut Madrasah
                    </div>

                    <div class="schedule-box">
                        <div class="schedule-row">
                            <span class="schedule-label">Jadwal Ukur:</span>
                            <span class="schedule-val">{{ $uniformGuide['measurement_schedule']['date'] }}</span>
                        </div>
                        <div class="schedule-row">
                            <span class="schedule-label">Lokasi:</span>
                            <span class="schedule-val">{{ $uniformGuide['measurement_schedule']['location'] }}</span>
                        </div>
                        <div class="schedule-row">
                            <span class="schedule-label">Batas Akhir:</span>
                            <span class="schedule-val" style="color:#b91c1c;">{{ $uniformGuide['measurement_schedule']['deadline'] }}</span>
                        </div>
                    </div>

                    @foreach($uniformGuide['packages'] as $pkg)
                        <div class="uniform-item">
                            <div class="uniform-name">
                                <span>{{ $pkg['name'] }}</span>
                                <span class="uniform-days">{{ $pkg['days'] }}</span>
                            </div>
                            <div class="uniform-detail">{{ $pkg['detail'] }}</div>
                        </div>
                    @endforeach

                    <div style="font-size: 12px; color: var(--slate-600); margin-top: 14px; background:#f1f5f9; padding:12px; border-radius:8px;">
                        <strong>Catatan Khusus Seragam:</strong>
                        <ul style="margin-left: 18px; margin-top: 4px;">
                            @foreach($uniformGuide['notes'] as $note)
                                <li>{{ $note }}</li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Kolom Kanan: Unduh Dokumen Resmi & Checklist -->
            <div>
                <div class="section-card">
                    <div class="section-title">
                        <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Unduh Dokumen Berkas Resmi
                    </div>
                    <p style="font-size: 13px; color: var(--slate-600); margin-bottom: 16px;">
                        Silakan cetak dokumen resmi berikut sebagai bukti tanda penerimaan santri baru:
                    </p>

                    <div class="doc-btn-grid">
                        <!-- Lembar Ringkasan Stopmap (1 Halaman PDF) -->
                        <a href="{{ route('stopmap.pdf', $applicant->id) }}" class="doc-btn" target="_blank">
                            <div class="doc-btn-icon">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 13.5px; font-weight:700;">Lembar Stopmap Resume (PDF)</div>
                                <div style="font-size: 11.5px; color: #64748b;">1 Halaman A4 + Checklist Berkas Fisik</div>
                            </div>
                        </a>

                        <!-- Kuitansi Pelunasan Resmi -->
                        <a href="{{ route('kuitansi.pdf', $applicant->id) }}" class="doc-btn" target="_blank">
                            <div class="doc-btn-icon" style="background:#dcfce7; color:#16a34a;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 13.5px; font-weight:700;">Kuitansi Resmi Pembayaran (PDF)</div>
                                <div style="font-size: 11.5px; color: #64748b;">Dilengkapi QR Code & Stempel Digital</div>
                            </div>
                        </a>

                        <!-- Kartu Registrasi Peserta -->
                        <a href="{{ route('registration.card.pdf') }}" class="doc-btn" target="_blank">
                            <div class="doc-btn-icon" style="background:#fef3c7; color:#d97706;">
                                <svg width="20" height="20" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2"/></svg>
                            </div>
                            <div>
                                <div style="font-size: 13.5px; font-weight:700;">Kartu Tanda Pendaftaran PPDB</div>
                                <div style="font-size: 11.5px; color: #64748b;">Nomor Ujian & Bukti Verifikasi</div>
                            </div>
                        </a>
                    </div>
                </div>

                <div class="section-card" style="background:#f0fdf4; border-color:#bbf7d0;">
                    <div class="section-title" style="color:#166534; font-size:15px;">
                        📌 Agenda Penting Calon Santri Baru
                    </div>
                    <ul style="font-size: 12.5px; color: #14532d; padding-left: 18px; line-height: 1.6;">
                        <li><strong>15 - 20 Desember 2026:</strong> Pengambilan seragam & perlengkapan mukim di koperasi madrasah.</li>
                        <li><strong>05 Januari 2027:</strong> Kedatangan santri baru ke asrama (Check-in kamar pondok).</li>
                        <li><strong>06 - 09 Januari 2027:</strong> Pelaksanaan MATSAMA (Masa Ta'aruf Siswa Madrasah).</li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>

</body>
</html>
