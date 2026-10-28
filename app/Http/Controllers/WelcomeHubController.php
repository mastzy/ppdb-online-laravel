<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class WelcomeHubController extends Controller
{
    /**
     * Tampilkan Halaman "Welcome Hub" Interaktif bagi siswa yang dinyatakan LULUS (status: passed).
     * Fitur:
     * - Status ucapan selamat interaktif & kartu kelulusan resmi
     * - Tombol satu-klik gabung ke Grup WhatsApp Paguyuban Wali Murid Angkatan 2026
     * - Petunjuk seragam madrasah (Jadwal pengukuran, jenis seragam, ketentuan atribut & jilbab/peci)
     * - Download Surat Keterangan Lulus (SKL) / Kuitansi & Stopmap
     * - Informasi jadwal orientasi santri baru (MATSAMA / Masa Ta'aruf Siswa Madrasah)
     */
    public function show(Request $request): View|RedirectResponse
    {
        $applicant = $this->getAuthenticatedApplicant($request);

        // Jika siswa belum berstatus 'passed', beri informasi dan redirect ke dashboard
        if ($applicant->status !== 'passed') {
            return redirect()->route('pendaftar.pembayaran')
                ->with('info', 'Status pendaftaran Anda saat ini adalah '.strtoupper(str_replace('_', ' ', $applicant->status)).'. Halaman Welcome Hub khusus pendaftar yang dinyatakan LULUS seleksi.');
        }

        $applicant->load(['cluster', 'latestPayment']);

        // Data grup WA wali murid & koordinator
        $waCommunity = [
            'name' => 'Paguyuban Wali Santri Baru MA Al-Hikmah 2026',
            'link' => 'https://chat.whatsapp.com/invitation-ppdb-alhikmah-2026',
            'admin_phone' => '6281234567890',
            'admin_name' => 'Ustadzah Fatimah (Humas & Kesiswaan)',
        ];

        // Rincian & Petunjuk Seragam Sekolah / Asrama
        $uniformGuide = [
            'measurement_schedule' => [
                'date' => 'Senin - Sabtu (08:00 - 14:00 WIB)',
                'location' => 'Koperasi Syariah MA Al-Hikmah Terpadu (Lantai 1 Kampus Utama)',
                'deadline' => '30 November 2026',
            ],
            'packages' => [
                [
                    'name' => 'Seragam Putih - Abu-Abu Resmi',
                    'detail' => 'Kemeja berbadge OSIS MA, celana/rok panjang rempel, dasi, & kaos kaki.',
                    'days' => 'Senin & Selasa',
                ],
                [
                    'name' => 'Seragam Batik Identitas & Gamis Al-Hikmah',
                    'detail' => 'Batik motif khas madrasah dengan peci hitam/jilbab warna selaras.',
                    'days' => 'Rabu & Kamis',
                ],
                [
                    'name' => 'Seragam Pramuka Lengkap & Koko Santri',
                    'detail' => 'Baju pramuka penegak dan setelan busana muslim santri untuk hari Jumat.',
                    'days' => 'Jumat & Sabtu',
                ],
                [
                    'name' => 'Kaos Olahraga & Training Pack',
                    'detail' => 'Kaos dryfit sport dan training panjang berlogo almamater.',
                    'days' => 'Hari Olahraga & Ekstrakurikuler',
                ],
            ],
            'notes' => [
                'Bagi santri mukim (boarding), wajib menyiapkan minimal 3 stel busana muslim harian dan mukena/sarung tambahan.',
                'Pengambilan bahan atau paket seragam yang sudah jadi dapat diambil mulai 15 Desember 2026.',
                'Konsultasi ukuran khusus atau penjahitan mandiri dapat menghubungi koordinator seragam.',
            ],
        ];

        return view('pendaftar.welcome_hub', compact('applicant', 'waCommunity', 'uniformGuide'));
    }

    /**
     * Helper mengambil model Registration pendaftar aktif.
     */
    private function getAuthenticatedApplicant(Request $request): Registration
    {
        /** @var Registration|null $applicant */
        $applicant = $request->attributes->get('applicant') ?? Registration::find(session('applicant_id'));

        if (! $applicant && auth()->check() && auth()->user()->role === 'siswa') {
            $applicant = Registration::where('user_id', auth()->id())->first();
        }

        if (! $applicant) {
            abort(401, 'Silakan login terlebih dahulu untuk mengakses Welcome Hub.');
        }

        return $applicant;
    }
}
