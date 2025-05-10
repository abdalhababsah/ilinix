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
        Schema::create('intern_nudges', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('intern_id')->constrained('users')->onDelete('cascade');
            $table->text('message')->nullable();
            $table->timestamp('nudged_at');
            $table->boolean('email_sent')->default(false);
            $table->timestamp('response_at')->nullable();
            $table->timestamps();
            
            // Add indexes
            $table->index(['intern_id', 'nudged_at']);
            $table->index(['mentor_id', 'nudged_at']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('intern_nudges');
    }
};
