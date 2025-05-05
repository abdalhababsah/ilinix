<?php

namespace Database\Factories;

use App\Models\ProgressUpdate;
use App\Models\User;
use App\Models\CertificateProgram;
use App\Models\CertificateCourse;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProgressUpdateFactory extends Factory
{
    protected $model = ProgressUpdate::class;

    public function definition(): array
    {
        $createdAt = $this->faker->dateTimeBetween('-3 months', 'now');
        $isCompleted = $this->faker->boolean(70);
        $completedAt = $isCompleted ? $this->faker->dateTimeBetween($createdAt, 'now') : null;

        return [
            'intern_id' => User::where('role_id', 3)->inRandomOrder()->first()->id ?? User::factory(),
            'certificate_id' => CertificateProgram::inRandomOrder()->first()->id ?? CertificateProgram::factory(),
            'course_id' => CertificateCourse::inRandomOrder()->first()->id ?? CertificateCourse::factory(),
            'is_completed' => $isCompleted,
            'comment' => $this->faker->paragraph(2),
            'proof_url' => $isCompleted ? $this->faker->url : null,
            'updated_by_mentor' => $this->faker->boolean(30),
            'completed_at' => $completedAt,
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }

    public function forCourse(CertificateCourse $course)
    {
        return $this->state(function (array $attributes) use ($course) {
            return [
                'certificate_id' => $course->certificate_program_id,
                'course_id' => $course->id,
            ];
        });
    }
}