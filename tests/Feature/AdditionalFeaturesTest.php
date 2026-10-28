<?php

namespace Tests\Feature;

use App\Models\ProgramCluster;
use App\Models\Registration;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdditionalFeaturesTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(DatabaseSeeder::class);
    }

    /**
     * Test REQ 1: Fitur Ekspor Data Admin (Format EMIS Kemenag & Dapodik Kemendikbud)
     */
    public function test_admin_export_emis_and_dapodik_for_passed_students(): void
    {
        $admin = User::where('username', 'admin')->first();
        $cluster = ProgramCluster::first();

        // 1. Siswa yang Lulus (passed)
        $passedStudent = Registration::create([
            'reg_code' => 'PPDB-2026-LULUS1',
            'nik' => '3201018899001122',
            'nisn' => '0081122334',
            'full_name' => 'Fathimah Az-Zahra',
            'dob' => '2010-04-15',
            'phone_number' => '081298765432',
            'parent_name' => 'Dr. H. Ahmad Fauzi',
            'parent_phone' => '081298765400',
            'parent_job' => 'Dosen / Peneliti',
            'cluster_id' => $cluster->id,
            'is_boarding' => true,
            'status' => 'passed',
        ]);

        // Beri diagnostic assessment
        $passedStudent->diagnosticScore()->create([
            'btq_score' => 95.50,
            'tahfidz_juz' => 3,
            'literacy_score' => 88.00,
        ]);

        // 2. Siswa yang masih pending / draft (tidak boleh masuk export passed)
        Registration::create([
            'reg_code' => 'PPDB-2026-DRAFT1',
            'nik' => '3201018899009999',
            'nisn' => '0089999999',
            'full_name' => 'Calon Masih Draft',
            'dob' => '2010-01-01',
            'status' => 'pending_payment',
        ]);

        // Export EMIS
        $emisResponse = $this->actingAs($admin)->get(route('admin.export.emis'));
        $emisResponse->assertStatus(200);
        $emisResponse->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('EMIS_Kemenag_PPDB_Lulus_', $emisResponse->headers->get('content-disposition'));

        $emisContent = $emisResponse->streamedContent();
        $this->assertStringContainsString('FATHIMAH AZ-ZAHRA', $emisContent);
        $this->assertStringContainsString('3201018899001122', $emisContent);
        $this->assertStringContainsString('RUMPUN_PEMINATAN_KURIKULUM', $emisContent);
        $this->assertStringContainsString('SKOR_BTQ_ALQURAN', $emisContent);
        $this->assertStringNotContainsString('Calon Masih Draft', $emisContent);

        // Export Dapodik
        $dapodikResponse = $this->actingAs($admin)->get(route('admin.export.dapodik'));
        $dapodikResponse->assertStatus(200);
        $dapodikResponse->assertHeader('content-type', 'text/csv; charset=UTF-8');
        $this->assertStringContainsString('Dapodik_Kemendikbud_PPDB_Lulus_', $dapodikResponse->headers->get('content-disposition'));

        $dapodikContent = $dapodikResponse->streamedContent();
        $this->assertStringContainsString('Fathimah Az-Zahra', $dapodikContent);
        $this->assertStringContainsString('Rombel_Peminatan_Tujuan', $dapodikContent);
        $this->assertStringNotContainsString('Calon Masih Draft', $dapodikContent);
    }

    /**
     * Test REQ 2: Fitur Ringkasan Stopmap (One-Page Resume PDF)
     */
    public function test_stopmap_one_page_resume_pdf_generation(): void
    {
        $admin = User::where('username', 'admin')->first();
        $cluster = ProgramCluster::first();

        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-STOPMAP',
            'nik' => '3201015544332211',
            'nisn' => '0075544332',
            'full_name' => 'Hasan Basri',
            'dob' => '2010-09-09',
            'phone_number' => '085611223344',
            'parent_name' => 'H. Basri',
            'parent_phone' => '085611223300',
            'cluster_id' => $cluster->id,
            'is_boarding' => false,
            'status' => 'paid',
        ]);

        // Berkas dokumen upload
        $registration->documents()->create([
            'doc_type' => 'kk',
            'file_path' => 'documents/kk_sample.jpg',
            'status' => 'approved',
        ]);

        // Download Stopmap PDF oleh Panitia/Admin
        $response = $this->actingAs($admin)->get(route('stopmap.pdf', $registration->id));
        $response->assertStatus(200);
        $response->assertHeader('content-type', 'application/pdf');
        $this->assertStringContainsString('Stopmap_Resume_PPDB-2026-STOPMAP.pdf', $response->headers->get('content-disposition'));

        // Download Stopmap PDF oleh Calon Siswa (session applicant_id)
        $studentResponse = $this->withSession(['applicant_id' => $registration->id])
            ->get(route('stopmap.pdf', $registration->id));
        $studentResponse->assertStatus(200);
        $studentResponse->assertHeader('content-type', 'application/pdf');
    }

    /**
     * Test REQ 3: Halaman "Welcome Hub" Interaktif bagi Siswa yang Dinyatakan LULUS
     */
    public function test_welcome_hub_for_passed_students(): void
    {
        $cluster = ProgramCluster::first();

        // 1. Siswa dinyatakan LULUS (status: passed)
        $passedStudent = Registration::create([
            'reg_code' => 'PPDB-2026-WELCOMEOK',
            'nik' => '3201017788990011',
            'full_name' => 'Zaid bin Tsabit',
            'dob' => '2010-02-14',
            'phone_number' => '081399887766',
            'cluster_id' => $cluster->id,
            'is_boarding' => true,
            'status' => 'passed',
        ]);

        $response = $this->withSession(['applicant_id' => $passedStudent->id])
            ->get(route('pendaftar.welcome_hub'));

        $response->assertStatus(200);
        $response->assertSee('Welcome Hub');
        $response->assertSee('Ahlan Wa Sahlan, Selamat Bergabung!');
        $response->assertSee('Komunitas Wali Santri Baru 2026');
        $response->assertSee('Gabung ke Grup WhatsApp Paguyuban');
        $response->assertSee('Petunjuk Seragam', false);
        $response->assertSee('Seragam Putih - Abu-Abu Resmi');
        $response->assertSee(route('stopmap.pdf', $passedStudent->id));

        // 2. Siswa yang belum lulus (status: draft / pending_payment) diarahkan ke halaman pembayaran
        $pendingStudent = Registration::create([
            'reg_code' => 'PPDB-2026-PENDING',
            'nik' => '3201017788990022',
            'full_name' => 'Calon Belum Lulus',
            'dob' => '2010-02-14',
            'status' => 'pending_payment',
        ]);

        $pendingResponse = $this->withSession(['applicant_id' => $pendingStudent->id])
            ->get(route('pendaftar.welcome_hub'));

        $pendingResponse->assertRedirect(route('pendaftar.pembayaran'));
        $pendingResponse->assertSessionHas('info');
    }
}
