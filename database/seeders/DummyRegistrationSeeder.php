<?php

namespace Database\Seeders;

use App\Models\DiagnosticScore;
use App\Models\Document;
use App\Models\Payment;
use App\Models\ProgramCluster;
use App\Models\Registration;
use Carbon\Carbon;
use Illuminate\Database\Seeder;

class DummyRegistrationSeeder extends Seeder
{
    /**
     * Jalankan seeder untuk membuat data pendaftar melimpah (35-45 pendaftar)
     * dengan berbagai variasi status dan klaster.
     */
    public function run(): void
    {
        $clusters = ProgramCluster::all();
        if ($clusters->isEmpty()) {
            return;
        }

        $names = [
            'Ahmad Fauzan Muzakki', 'Siti Nur Aisyah', 'Muhammad Rizky Pratama', 'Fatimah Az-Zahra',
            'Budi Setiawan', 'Dewi Lestari', 'Hafizh Syahputra', 'Nabila Putri Rahma',
            'Zaidan Al-Farisi', 'Anisa Rahmawati', 'Rafi Athallah Putra', 'Salma Khairunnisa',
            'Irfan Maulana', 'Khadijah Maryam', 'Faris Ihsanuddin', 'Zahra Amelia',
            'Alif Bahtiar', 'Tsabita Qolbi', 'Wildan Nur Hidayat', 'Alya Safitri',
            'Ilham Ramadhan', 'Syifa Fauziah', 'Hamdan Yuwafi', 'Husna Maulida',
            'Rizwan Hakim', 'Fadilah Putri', 'Danial Arkan', 'Najwa Shihabuddin',
            'Zaki Mubarak', 'Aisyah Humaira', 'Rasyid Ridha', 'Bilqis Maharani',
            'Rayhan Fadillah', 'Muthia Rahmah', 'Taufiq Hidayat', 'Dina Kartika',
            'Iqbal Tawakal', 'Yasmin Salsabila', 'Lukman Hakim', 'Nidaul Hasanah'
        ];

        $year = date('Y');
        $counter = 10;

        foreach ($names as $idx => $name) {
            $counter++;
            $seq = str_pad((string) $counter, 3, '0', STR_PAD_LEFT);
            $regCode = "PPDB-{$year}-{$seq}";
            $nik = '3302' . str_pad((string) (100000000000 + $idx), 12, '0', STR_PAD_LEFT);
            $dob = Carbon::create(2010, rand(1, 12), rand(1, 28))->format('Y-m-d');
            $cluster = $clusters[$idx % $clusters->count()];
            $isBoarding = ($idx % 2 === 0);
            $hasSibling = ($idx % 4 === 0);

            // Valid enum status pada registrasi: 'draft', 'pending_payment', 'paid', 'verified', 'passed', 'rejected'
            if ($idx < 10) {
                $status = ($idx % 2 === 0) ? 'draft' : 'pending_payment';
            } elseif ($idx < 20) {
                $status = 'paid';
            } elseif ($idx < 25) {
                $status = 'draft'; // pendaftar perlu perbaikan berkas
            } else {
                $status = 'passed';
            }

            $registration = Registration::create([
                'reg_code' => $regCode,
                'nik' => $nik,
                'full_name' => $name,
                'dob' => $dob,
                'phone_number' => '08' . rand(1111111111, 9999999999),
                'wave_name' => ($idx % 3 === 0) ? 'Gelombang 2' : 'Gelombang 1',
                'cluster_id' => $cluster->id,
                'is_boarding' => $isBoarding,
                'parent_name' => 'Wali dari ' . explode(' ', $name)[0],
                'parent_phone' => '08' . rand(1111111111, 9999999999),
                'parent_job' => ($idx % 2 === 0) ? 'Wiraswasta' : 'Pegawai Swasta',
                'has_sibling_discount' => $hasSibling,
                'status' => $status,
            ]);

            // Buat dokumen pendukung simulasi
            if ($status !== 'draft' || ($idx >= 20 && $idx < 25)) {
                $isRevision = ($idx >= 20 && $idx < 25);
                Document::create([
                    'reg_id' => $registration->id,
                    'doc_type' => 'kk',
                    'file_path' => 'documents/sample_kk.jpg',
                    'status' => $isRevision ? 'revision_needed' : 'approved',
                    'revision_note' => $isRevision ? 'Foto Kartu Keluarga buram, mohon unggah foto yang jelas dan terbaca.' : null,
                ]);

                Document::create([
                    'reg_id' => $registration->id,
                    'doc_type' => 'akta',
                    'file_path' => 'documents/sample_akta.jpg',
                    'status' => 'approved',
                ]);

                Document::create([
                    'reg_id' => $registration->id,
                    'doc_type' => 'skl',
                    'file_path' => 'documents/sample_skl.jpg',
                    'status' => 'approved',
                ]);
            }

            // Buat data pembayaran jika status paid atau passed
            if (in_array($status, ['paid', 'verified', 'passed'])) {
                $amount = $hasSibling ? 240000 : 300000;
                Payment::create([
                    'reg_id' => $registration->id,
                    'amount' => $amount,
                    'sender_bank' => ($idx % 2 === 0) ? 'Bank Syariah Indonesia (BSI)' : 'Bank Mandiri',
                    'sender_name' => 'Orang Tua ' . $name,
                    'payment_method' => ($idx % 3 === 0) ? 'cash' : 'transfer',
                    'proof_file' => 'payments/sample_receipt.jpg',
                    'status' => 'verified',
                    'paid_at' => now()->subDays(rand(1, 10)),
                ]);
            }

            // Buat skor asesmen diagnostik jika passed
            if ($status === 'passed') {
                DiagnosticScore::create([
                    'reg_id' => $registration->id,
                    'btq_score' => rand(75, 98),
                    'tahfidz_juz' => rand(1, 5),
                    'literacy_score' => rand(70, 95),
                    'notes' => 'Potensi akademik baik dan santun.',
                    'tested_by' => 1,
                ]);
            }
        }
    }
}
