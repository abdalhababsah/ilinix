<?php

namespace Database\Factories;

use App\Models\CertificateProgram;
use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateProgramFactory extends Factory
{
    protected $model = CertificateProgram::class;

    public function definition(): array
    {
        $certificateTitles = [
            'Cloud Solutions Architect', 'Data Engineering Professional',
            'DevOps Engineer', 'Security Specialist', 'Network Administrator',
            'AI Engineer', 'Database Administrator', 'Full Stack Developer',
            'UX Designer', 'Project Management Professional'
        ];

        return [
            'title' => $this->faker->unique()->randomElement($certificateTitles),
            'provider_id' => Provider::inRandomOrder()->first()->id ?? Provider::factory(),
            'level' => $this->faker->randomElement(['beginner', 'intermediate', 'advanced']),
            'image_path' => 'programs/images/' . $this->faker->uuid . '.jpg',
            'type' => $this->faker->randomElement(['digital', 'classroom', 'hybrid']),
            'description' => $this->faker->paragraph,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}