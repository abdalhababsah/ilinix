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
        Schema::create('certificate_courses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('certificate_program_id')->constrained('certificate_programs')->cascadeOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->text('resource_link')->nullable();
            $table->text('digital_link')->nullable();
            $table->integer('estimated_minutes')->nullable();
            $table->integer('step_order')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_courses');
    }
};
