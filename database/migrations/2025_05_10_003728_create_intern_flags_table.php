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
        Schema::create('intern_flags', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('intern_id')->constrained('users')->onDelete('cascade');
            $table->text('reason')->nullable();
            $table->string('status')->default('pending'); // pending, reviewed, cleared, escalated
            $table->boolean('email_sent')->default(false);
            $table->foreignId('reviewed_by')->nullable()->constrained('users');
            $table->text('review_notes')->nullable();
            $table->timestamp('reviewed_at')->nullable();
            $table->timestamp('flagged_at');
            $table->timestamps();
            
            // Add indexes
            $table->index(['intern_id', 'flagged_at']);
            $table->index(['mentor_id', 'flagged_at']);
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_flags');
    }
};
