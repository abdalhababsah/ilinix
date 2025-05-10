<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMentoringSessionsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mentoring_sessions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mentor_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('intern_id')->constrained('users')->onDelete('cascade');
            $table->string('title');
            $table->date('session_date');
            $table->time('session_time');
            $table->integer('duration')->default(30); // in minutes
            $table->text('agenda')->nullable();
            $table->enum('status', ['scheduled', 'completed', 'cancelled', 'rescheduled'])->default('scheduled');
            $table->text('notes')->nullable(); // post-session notes
            $table->dateTime('completed_at')->nullable();
            $table->boolean('intern_notified')->default(false);
            $table->string('meeting_link')->nullable();
            $table->string('ics_file')->nullable();

            $table->timestamps();

            // Add indexes for better performance
            $table->index('mentor_id');
            $table->index('intern_id');
            $table->index('session_date');
            $table->index('status');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mentoring_sessions');
    }
}