<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\Payment;
use App\Models\ProgramCluster;
use App\Models\Registration;
use App\Models\User;
use Database\Seeders\DatabaseSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class DatabaseAndModelTest extends TestCase
{
    use RefreshDatabase;

    /**
     * Test seeded users and their role helper methods.
     */
    public function test_seeders_populate_default_users_and_clusters(): void
    {
        $this->seed(DatabaseSeeder::class);

        $admin = User::where('username', 'admin')->first();
        $this->assertNotNull($admin);
        $this->assertTrue($admin->isAdmin());
        $this->assertEquals('Administrator PPDB', $admin->name);

        $verifikator = User::where('username', 'verifikator')->first();
        $this->assertNotNull($verifikator);
        $this->assertTrue($verifikator->isVerifikator());

        $bendahara = User::where('username', 'bendahara')->first();
        $this->assertNotNull($bendahara);
        $this->assertTrue($bendahara->isBendahara());

        $penguji = User::where('username', 'penguji')->first();
        $this->assertNotNull($penguji);
        $this->assertTrue($penguji->isPenguji());

        $clusters = ProgramCluster::all();
        $this->assertCount(4, $clusters);
        $this->assertEquals(4, ProgramCluster::active()->count());
    }

    /**
     * Test registration creation and its relationships with cluster, payments, documents, and diagnostic score.
     */
    public function test_registration_and_related_models(): void
    {
        $this->seed(DatabaseSeeder::class);

        $cluster = ProgramCluster::first();
        $bendahara = User::where('role', 'bendahara')->first();
        $penguji = User::where('role', 'penguji')->first();

        $registration = Registration::create([
            'reg_code' => 'PPDB-2026-0001',
            'nik' => '3201012345678901',
            'nisn' => '0071234567',
            'full_name' => 'Fulan bin Fulan',
            'dob' => '2010-01-15',
            'phone_number' => '081234567890',
            'wave_name' => 'Gelombang 1',
            'cluster_id' => $cluster->id,
            'is_boarding' => true,
            'status' => 'draft',
        ]);

        $this->assertTrue($registration->isDraft());
        $this->assertTrue($registration->is_boarding);
        $this->assertEquals($cluster->id, $registration->cluster->id);

        // Test payment relationship
        $payment = $registration->payments()->create([
            'amount' => 300000.00,
            'sender_bank' => 'Bank Mandiri',
            'sender_name' => 'Orang Tua Fulan',
            'proof_file' => 'proofs/proof_sample.png',
            'payment_method' => 'transfer',
            'status' => 'verified',
            'verified_by' => $bendahara->id,
            'paid_at' => now(),
        ]);

        $this->assertCount(1, $registration->payments);
        $this->assertEquals($bendahara->id, $payment->verifier->id);
        $this->assertTrue($payment->isTransfer());
        $this->assertTrue($payment->isVerified());

        // Test document relationship
        $doc = $registration->documents()->create([
            'doc_type' => 'kk',
            'file_path' => 'documents/hash_kk.jpg',
            'status' => 'approved',
        ]);

        $this->assertCount(1, $registration->documents);
        $this->assertTrue($doc->isApproved());
        $this->assertEquals($registration->id, $doc->registration->id);

        // Test diagnostic score relationship
        $diagnostic = $registration->diagnosticScore()->create([
            'btq_score' => 92.50,
            'tahfidz_juz' => 4,
            'literacy_score' => 85.00,
            'notes' => 'Hafalan tartil dan lancar',
            'tested_by' => $penguji->id,
        ]);

        $this->assertNotNull($registration->diagnosticScore);
        $this->assertEquals(92.50, (float) $registration->diagnosticScore->btq_score);
        $this->assertEquals(4, $registration->diagnosticScore->tahfidz_juz);
        $this->assertEquals($penguji->id, $diagnostic->tester->id);

        // Test scopes
        $found = Registration::byRegCode('PPDB-2026-0001')->first();
        $this->assertNotNull($found);
        $this->assertEquals('Fulan bin Fulan', $found->full_name);

        $foundByAuth = Registration::byNikAndDob('3201012345678901', '2010-01-15')->first();
        $this->assertNotNull($foundByAuth);
        $this->assertEquals($registration->id, $foundByAuth->id);

        // Test cascade deletion
        $registration->delete();
        $this->assertDatabaseMissing('registrations', ['id' => $registration->id]);
        $this->assertDatabaseMissing('payments', ['id' => $payment->id]);
        $this->assertDatabaseMissing('documents', ['id' => $doc->id]);
        $this->assertDatabaseMissing('diagnostic_scores', ['id' => $diagnostic->id]);
    }
}
