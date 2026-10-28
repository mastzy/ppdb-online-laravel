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
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('reg_id')->constrained('registrations')->cascadeOnDelete();
            $table->enum('doc_type', ['kk', 'akta', 'skl', 'passfoto']);
            $table->string('file_path');
            $table->enum('status', ['pending', 'approved', 'revision_needed'])->default('pending');
            $table->text('revision_note')->nullable();
            $table->timestamps();

            $table->index(['reg_id', 'doc_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('documents');
    }
};
