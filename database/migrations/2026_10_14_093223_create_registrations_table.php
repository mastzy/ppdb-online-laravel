<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('registrations', function (Blueprint $table) {
            $table->id();
            $table->string('reg_code')->unique();
            $table->string('nik', 16);
            $table->string('nisn', 10)->nullable();
            $table->string('full_name');
            $table->date('dob');
            $table->string('phone_number', 20)->nullable();
            $table->string('wave_name')->default('Gelombang 1');
            $table->foreignId('cluster_id')->nullable()->constrained('program_clusters')->nullOnDelete();
            $table->boolean('is_boarding')->default(false);
            $table->enum('status', [
                'draft',
                'pending_payment',
                'paid',
                'verified',
                'passed',
                'rejected',
            ])->default('draft');
            // Step 3: Data Orang Tua & Diskon Sibling
            $table->string('parent_name')->nullable();
            $table->string('parent_phone', 20)->nullable();
            $table->string('parent_job')->nullable();
            $table->string('sibling_nisn', 10)->nullable();
            $table->string('sibling_name')->nullable();
            $table->boolean('has_sibling_discount')->default(false);
            $table->timestamps();

            // Index untuk pencarian dan autentikasi calon siswa tanpa password
            $table->index('nik');
            $table->index(['nik', 'dob']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('registrations');
    }
};
