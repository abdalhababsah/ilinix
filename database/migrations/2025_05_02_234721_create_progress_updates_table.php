php artisan make:migration create_onboarding_steps_table
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
        Schema::create('progress_updates', function (Blueprint $table) {
            $table->id();
            $table->foreignId('intern_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('certificate_id')->constrained('certificate_programs')->cascadeOnDelete();
            $table->foreignId('course_id')->constrained('certificate_courses')->cascadeOnDelete();
            $table->boolean('is_completed')->default(false);
            $table->text('comment')->nullable();
            $table->text('proof_url')->nullable();
            $table->boolean('updated_by_mentor')->default(false);
            $table->timestamp('completed_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress_updates');
    }
};
