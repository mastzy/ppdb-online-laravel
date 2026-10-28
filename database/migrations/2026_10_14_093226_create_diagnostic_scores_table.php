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
        Schema::create('diagnostic_scores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reg_id')->constrained('registrations')->cascadeOnDelete();
            $table->decimal('btq_score', 5, 2)->nullable();
            $table->unsignedTinyInteger('tahfidz_juz')->default(0);
            $table->decimal('literacy_score', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->foreignId('tested_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('diagnostic_scores');
    }
};
