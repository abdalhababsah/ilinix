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
        Schema::create('certificate_progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_certificate_id')->constrained('intern_certificates')->cascadeOnDelete();
            $table->enum('study_status', ['not_started', 'in_progress', 'studying_for_exam', 'requested_voucher', 'took_exam', 'passed', 'failed'])->default('not_started');
            $table->text('notes')->nullable();
            $table->timestamp('voucher_requested_at')->nullable();
            $table->timestamp('exam_date')->nullable();
            $table->boolean('updated_by_mentor')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_progress');
    }
};
