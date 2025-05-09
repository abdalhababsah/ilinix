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
        Schema::create('certificate_programs', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->unsignedBigInteger('provider_id');
            $table->enum('level', ['beginner', 'intermediate', 'advanced']);
            $table->enum('type', ['digital', 'classroom', 'hybrid']);
            $table->text('description')->nullable();
            $table->string('image_path')->nullable();
            $table->foreign('provider_id')->references('id')->on('providers')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificate_programs');
    }
};
