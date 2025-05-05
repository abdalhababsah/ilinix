<?php

namespace Database\Factories;

use App\Models\CertificateCourse;
use App\Models\CertificateProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateCourseFactory extends Factory
{
    protected $model = CertificateCourse::class;

    public function definition(): array
    {
        $courseTopics = [
            'Introduction to', 'Foundations of', 'Advanced', 'Mastering',
            'Practical', 'Applied', 'Fundamentals of', 'Professional',
            'Essential', 'Strategic'
        ];

        $subjectAreas = [
            'Cloud Architecture', 'Machine Learning', 'Cybersecurity',
            'Database Management', 'Network Infrastructure', 'Software Development',
            'DevOps Practices', 'API Design', 'UI/UX Design', 'Project Management'
        ];

        return [
            'certificate_program_id' => CertificateProgram::inRandomOrder()->first()->id ?? CertificateProgram::factory(),
            'title' => $this->faker->randomElement($courseTopics) . ' ' . $this->faker->randomElement($subjectAreas),
            'description' => $this->faker->paragraph,
            'resource_link' => $this->faker->url,
            'digital_link' => $this->faker->url,
            'estimated_minutes' => $this->faker->numberBetween(30, 180),
            'step_order' => $this->faker->numberBetween(1, 5),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}