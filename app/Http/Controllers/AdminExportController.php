<?php

namespace App\Http\Controllers;

use App\Models\Registration;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class AdminExportController extends Controller
{
    /**
     * Ekspor Data Siswa Lulus dalam Format EMIS 4.0 Kemenag (Excel / CSV dengan UTF-8 BOM).
     * Kolom standar EMIS: No, No Pendaftaran, NIK Siswa, NISN, Nama Lengkap, Tanggal Lahir (YYYY-MM-DD),
     * Jenis Kelamin, No KK, Nama Ayah/Wali, No HP/WA Orang Tua, Pekerjaan Orang Tua,
     * Pilihan Rumpun/Peminatan, Status Mukim/Pesantren, Status Kelulusan.
     */
    public function exportEmis(Request $request): StreamedResponse
    {
        $fileName = 'EMIS_Kemenag_PPDB_Lulus_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $registrations = Registration::with(['cluster', 'diagnosticScore'])
            ->where('status', 'passed')
            ->orderBy('full_name', 'asc')
            ->get();

        return response()->stream(function () use ($registrations) {
            $handle = fopen('php://output', 'w');

            // Tulis UTF-8 BOM agar Excel membaca karakter dan simbol dengan sempurna
            fwrite($handle, "\xEF\xBB\xBF");

            // Header Kolom Format EMIS Kemenag
            fputcsv($handle, [
                'NO',
                'KODE_REGISTRASI',
                'NIK_SISWA',
                'NISN',
                'NAMA_LENGKAP_SISWA',
                'TANGGAL_LAHIR',
                'NO_HP_WHATSAPP',
                'NAMA_ORANG_TUA_WALI',
                'NO_TELP_ORANG_TUA',
                'PEKERJAAN_ORANG_TUA',
                'RUMPUN_PEMINATAN_KURIKULUM',
                'STATUS_MUKIM_PESANTREN',
                'SKOR_BTQ_ALQURAN',
                'HAFALAN_TAHFIDZ_JUZ',
                'GELOMBANG_DAFTAR',
                'STATUS_PENERIMAAN',
            ]);

            $no = 1;
            foreach ($registrations as $reg) {
                fputcsv($handle, [
                    $no++,
                    $reg->reg_code,
                    "'".$reg->nik, // Format teks agar angka NIK tidak terpotong di Excel
                    $reg->nisn ? "'".$reg->nisn : '-',
                    strtoupper($reg->full_name),
                    $reg->dob ? $reg->dob->format('Y-m-d') : '-',
                    $reg->phone_number ?? '-',
                    $reg->parent_name ?? '-',
                    $reg->parent_phone ?? '-',
                    $reg->parent_job ?? '-',
                    $reg->cluster->name ?? 'Reguler',
                    $reg->is_boarding ? 'MUKIM (PESANTREN)' : 'NON-MUKIM',
                    $reg->diagnosticScore ? $reg->diagnosticScore->btq_score : '-',
                    $reg->diagnosticScore ? $reg->diagnosticScore->tahfidz_juz : '0',
                    $reg->wave_name ?? 'Gelombang 1',
                    'LULUS (DITERIMA)',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }

    /**
     * Ekspor Data Siswa Lulus dalam Format Dapodik Kemendikbudristek (Excel / CSV dengan UTF-8 BOM).
     * Kolom standar Dapodik: No, Registrasi, NIK, NISN, Nama Siswa, Tanggal Lahir, No Handphone,
     * Nama Ayah/Ibu/Wali, Kontak Ortu, Pekerjaan, Jurusan/Peminatan, Diskon Saudara Kandung, Status.
     */
    public function exportDapodik(Request $request): StreamedResponse
    {
        $fileName = 'Dapodik_Kemendikbud_PPDB_Lulus_'.date('Ymd_His').'.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$fileName}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $registrations = Registration::with(['cluster'])
            ->where('status', 'passed')
            ->orderBy('full_name', 'asc')
            ->get();

        return response()->stream(function () use ($registrations) {
            $handle = fopen('php://output', 'w');

            // UTF-8 BOM
            fwrite($handle, "\xEF\xBB\xBF");

            // Header Kolom Format Dapodik
            fputcsv($handle, [
                'No',
                'No_Pendaftaran',
                'NIK',
                'NISN',
                'Nama_Peserta_Didik',
                'Tanggal_Lahir',
                'Nomor_Telepon_Seluler',
                'Nama_Orang_Tua_Wali',
                'Nomor_Telepon_Orang_Tua',
                'Pekerjaan_Orang_Tua',
                'Rombel_Peminatan_Tujuan',
                'Status_Santri_Mukim',
                'Diskon_Sibling_Siswa_Aktif',
                'NISN_Saudara_Kandung',
                'Status_Kelulusan',
            ]);

            $no = 1;
            foreach ($registrations as $reg) {
                fputcsv($handle, [
                    $no++,
                    $reg->reg_code,
                    "'".$reg->nik,
                    $reg->nisn ? "'".$reg->nisn : '',
                    $reg->full_name,
                    $reg->dob ? $reg->dob->format('d/m/Y') : '',
                    $reg->phone_number ?? '',
                    $reg->parent_name ?? '',
                    $reg->parent_phone ?? '',
                    $reg->parent_job ?? '',
                    $reg->cluster->name ?? 'Umum',
                    $reg->is_boarding ? 'Ya' : 'Tidak',
                    $reg->has_sibling_discount ? 'Ya' : 'Tidak',
                    $reg->sibling_nisn ?? '-',
                    'Diterima',
                ]);
            }

            fclose($handle);
        }, 200, $headers);
    }
}
