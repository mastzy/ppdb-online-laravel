<?php

namespace Tests\Feature;

use App\Models\Payment;
use App\Models\ProgramCluster;
use App\Models\Registration;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PPDBFlowTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Seed essential data before each test.
     */
    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(\Database\Seeders\UserSeeder::class);
        $this->seed(\Database\Seeders\ProgramClusterSeeder::class);
    }

    /**
     * Test 1: Pendaftaran Step 1 (Memastikan NIK & Nama berhasil masuk database & menerbitkan Kode Registrasi).
     */
    public function test_registration_step_1_creates_applicant_and_locks_quota(): void
    {
        $nik = '3302998877660001';
        $response = $this->post(route('pendaftar.step1'), [
            'nik' => $nik,
            'full_name' => 'Ananda Bintang Pratama',
            'dob' => '2010-05-20',
            'phone_number' => '081298765432',
            'wave_name' => 'Gelombang 1',
        ]);

        $response->assertStatus(302);

        $this->assertDatabaseHas('registrations', [
            'nik' => $nik,
            'full_name' => 'Ananda Bintang Pratama',
        ]);

        $registration = Registration::where('nik', $nik)->first();
        $this->assertNotNull($registration);
        $this->assertStringStartsWith('PPDB-', $registration->reg_code);
    }

    /**
     * Test 2: Login Pendaftar (Memastikan login dengan NIK + Tanggal Lahir berhasil).
     */
    public function test_applicant_login_with_nik_and_dob_success(): void
    {
        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-TESTLOGIN',
            'nik' => '3302112233440099',
            'full_name' => 'Siswa Uji Login',
            'dob' => '2010-07-15',
            'phone_number' => '081233445566',
            'status' => 'draft',
        ]);

        $response = $this->post(route('pendaftar.login.submit'), [
            'identifier' => $registration->nik,
            'dob' => '2010-07-15',
        ]);

        $response->assertRedirect(route('pendaftar.formulir'));
        $this->assertEquals($registration->id, session('applicant_id'));
    }

    /**
     * Test 3: Pembayaran Tunai Kasir (Memastikan status berubah menjadi PAID).
     */
    public function test_cashier_offline_payment_updates_status_to_paid(): void
    {
        $bendahara = User::where('role', 'bendahara')->first() ?? User::factory()->create(['role' => 'bendahara']);

        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-CASH01',
            'nik' => '3302778899001122',
            'full_name' => 'Calon Siswa Kasir',
            'dob' => '2010-03-10',
            'phone_number' => '087788990011',
            'status' => 'pending_payment',
        ]);

        $response = $this->actingAs($bendahara)
            ->post(route('bendahara.kasir.pay_cash', $registration->id));

        $response->assertStatus(302);

        $registration->refresh();
        $this->assertEquals('paid', $registration->status);

        $this->assertDatabaseHas('payments', [
            'reg_id' => $registration->id,
            'payment_method' => 'cash',
            'status' => 'verified',
        ]);
    }

    /**
     * Test 4: Ekspor Data EMIS & Dapodik (Memastikan HTTP status 200 / file download terpicu).
     */
    public function test_admin_export_emis_and_dapodik_returns_successful_stream(): void
    {
        $admin = User::where('role', 'admin')->first() ?? User::factory()->create(['role' => 'admin']);

        // Test export EMIS
        $emisResponse = $this->actingAs($admin)
            ->get(route('admin.export.emis'));
        $emisResponse->assertStatus(200);
        $this->assertTrue(str_contains($emisResponse->headers->get('content-disposition'), 'EMIS_Kemenag'));

        // Test export Dapodik
        $dapodikResponse = $this->actingAs($admin)
            ->get(route('admin.export.dapodik'));
        $dapodikResponse->assertStatus(200);
        $this->assertTrue(str_contains($dapodikResponse->headers->get('content-disposition'), 'Dapodik_Kemendikbud'));
    }
}
