<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\ProgramCluster;
use App\Models\Registration;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PaymentModuleTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test REQ 1: Halaman Pembayaran Pendaftar menampilkan nominal resmi bulat,
     * rekening bank sekolah, serta form upload struk dengan validasi nama bank & pemilik rekening.
     */
    public function test_applicant_payment_page_and_proof_upload(): void
    {
        Storage::fake('public');

        $cluster = ProgramCluster::first();

        // Buat data pendaftar aktif
        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-0001',
            'nik' => '3201012345678901',
            'nisn' => '0071234567',
            'full_name' => 'Ahmad Faiz Robbani',
            'dob' => '2010-05-12',
            'phone_number' => '081234567890',
            'cluster_id' => $cluster->id,
            'is_boarding' => true,
            'status' => 'pending_payment',
        ]);

        // 1. Akses halaman pembayaran dengan session applicant_id
        $response = $this->withSession(['applicant_id' => $registration->id])
            ->get(route('pendaftar.pembayaran'));

        $response->assertStatus(200);
        $response->assertSee('Modul Pembayaran Mandiri');
        $response->assertSee('Rp 300.000'); // Nominal resmi bulat
        $response->assertSee('Bank Syariah Indonesia (BSI)');
        $response->assertSee('7123456789');
        $response->assertSee('PPDB MA AL-HIKMAH TERPADU');

        // 2. Upload struk dengan validasi: gagal jika Nama Bank & Nama Rekening kosong
        $invalidUpload = $this->withSession(['applicant_id' => $registration->id])
            ->post(route('pendaftar.pembayaran.store'), []);

        $invalidUpload->assertSessionHasErrors(['sender_bank', 'sender_name', 'proof_file']);

        // 3. Upload struk valid
        $file = UploadedFile::fake()->create('struk_transfer.jpg', 500, 'image/jpeg');

        $validUpload = $this->withSession(['applicant_id' => $registration->id])
            ->post(route('pendaftar.pembayaran.store'), [
                'sender_bank' => 'Bank Mandiri',
                'sender_name' => 'Haji Abdullah (Ayah)',
                'proof_file' => $file,
            ]);

        $validUpload->assertRedirect(route('pendaftar.pembayaran'));
        $validUpload->assertSessionHas('success');

        // Pastikan payment tersimpan di database
        $this->assertDatabaseHas('payments', [
            'reg_id' => $registration->id,
            'amount' => 300000.00,
            'sender_bank' => 'Bank Mandiri',
            'sender_name' => 'Haji Abdullah (Ayah)',
            'payment_method' => 'transfer',
            'status' => 'pending',
        ]);

        $payment = Payment::where('reg_id', $registration->id)->first();
        $this->assertNotNull($payment->proof_file);
        Storage::disk('public')->assertExists($payment->proof_file);
    }

    /**
     * Test REQ 2: Mode Kasir Offline (Dashboard Bendahara)
     * - Pencarian cepat via NIK / Kode Reg
     * - Tombol "Bayar Tunai di Tempat" langsung mengubah status pendaftaran menjadi PAID
     */
    public function test_bendahara_cashier_mode_and_offline_cash_payment(): void
    {
        $bendahara = User::where('username', 'bendahara')->first();
        $cluster = ProgramCluster::first();

        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-0002',
            'nik' => '3201019988776655',
            'nisn' => '0089887766',
            'full_name' => 'Siti Nur Azizah',
            'dob' => '2010-08-20',
            'phone_number' => '089876543210',
            'cluster_id' => $cluster->id,
            'status' => 'pending_payment',
        ]);

        // 1. Akses dashboard kasir oleh bendahara
        $response = $this->actingAs($bendahara)->get(route('bendahara.kasir', ['q' => 'PPDB-2026-0002']));
        $response->assertStatus(200);
        $response->assertSee('Mode Kasir Offline PPDB');
        $response->assertSee('Siti Nur Azizah');
        $response->assertSee('Bayar Tunai di Tempat');

        // 2. Akses pencarian via AJAX API
        $searchResponse = $this->actingAs($bendahara)->getJson(route('bendahara.kasir.search', ['query' => '3201019988776655']));
        $searchResponse->assertStatus(200);
        $searchResponse->assertJsonFragment([
            'nik' => '3201019988776655',
            'full_name' => 'Siti Nur Azizah',
            'reg_code' => 'PPDB-2026-0002',
        ]);

        // 3. Eksekusi Tombol "Bayar Tunai di Tempat"
        $cashResponse = $this->actingAs($bendahara)->post(route('bendahara.kasir.pay_cash', $registration->id));
        $cashResponse->assertRedirect(route('bendahara.kasir', ['q' => 'PPDB-2026-0002']));
        $cashResponse->assertSessionHas('success');

        // Verifikasi status pendaftaran langsung menjadi PAID
        $registration->refresh();
        $this->assertEquals('paid', $registration->status);
        $this->assertTrue($registration->isPaid());

        // Verifikasi record payment kasir tunai dibuat dan diverifikasi oleh bendahara
        $this->assertDatabaseHas('payments', [
            'reg_id' => $registration->id,
            'amount' => 300000.00,
            'sender_bank' => 'KASIR TUNAI',
            'payment_method' => 'cash',
            'status' => 'verified',
            'verified_by' => $bendahara->id,
        ]);
    }

    /**
     * Test REQ 3: Generator Kuitansi PDF (barryvdh/laravel-dompdf, QR Code, dan Stempel Digital).
     */
    public function test_pdf_receipt_generation_with_qr_code_and_stamp(): void
    {
        $bendahara = User::where('username', 'bendahara')->first();
        $cluster = ProgramCluster::first();

        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-0003',
            'nik' => '3201011122334455',
            'nisn' => '0091122334',
            'full_name' => 'Muhammad Bilal Al-Ghifari',
            'dob' => '2010-03-10',
            'phone_number' => '087711223344',
            'cluster_id' => $cluster->id,
            'status' => 'paid',
        ]);

        // Buat record pembayaran terverifikasi
        $registration->payments()->create([
            'amount' => 300000.00,
            'sender_bank' => 'KASIR TUNAI',
            'sender_name' => 'Muhammad Bilal Al-Ghifari',
            'payment_method' => 'cash',
            'status' => 'verified',
            'verified_by' => $bendahara->id,
            'paid_at' => now(),
        ]);

        // 1. Download PDF Kuitansi sebagai Panitia/Bendahara
        $pdfResponse = $this->actingAs($bendahara)->get(route('kuitansi.pdf', $registration->id));
        $pdfResponse->assertStatus(200);
        $pdfResponse->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('Kuitansi_PPDB_PPDB-2026-0003.pdf', $pdfResponse->headers->get('content-disposition'));

        // 2. Download PDF Kuitansi sebagai Siswa yang login via session applicant_id
        $applicantPdfResponse = $this->withSession(['applicant_id' => $registration->id])
            ->get(route('kuitansi.pdf', $registration->id));
        $applicantPdfResponse->assertStatus(200);
        $applicantPdfResponse->assertHeader('content-type', 'application/pdf');

        // 3. Scan QR Code Validasi Keabsahan Kuitansi (Public Route)
        $encryptedHash = Crypt::encryptString((string) $registration->id);
        $verifyResponse = $this->get(route('verify.receipt', ['hash' => $encryptedHash]));
        $verifyResponse->assertStatus(200);
        $verifyResponse->assertSee('Kuitansi Pembayaran Sah');
        $verifyResponse->assertSee('Muhammad Bilal Al-Ghifari');
        $verifyResponse->assertSee('PPDB-2026-0003');
        $verifyResponse->assertSee('Rp 300.000');
        $verifyResponse->assertSee('LUNAS (PAID)');
    }
}
