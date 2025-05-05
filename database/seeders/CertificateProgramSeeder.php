<?php

namespace Database\Seeders;

use App\Models\CertificateProgram;
use App\Models\CertificateCourse;
use App\Models\Provider;
use Illuminate\Database\Seeder;

class CertificateProgramSeeder extends Seeder
{
    public function run(): void
    {
        $providerIds = Provider::pluck('id')->toArray();
        
        $certificateTitles = [
            'Cloud Solutions Architect', 'Data Engineering Professional',
            'DevOps Engineer', 'Security Specialist', 'Network Administrator',
            'AI Engineer', 'Database Administrator', 'Full Stack Developer',
            'UX Designer', 'Project Management Professional'
        ];
        
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
        
        // Create 10 certificate programs
        foreach ($certificateTitles as $index => $title) {
            // Create the certificate program
            $certificate = CertificateProgram::create([
                'title' => $title,
                'provider_id' => $providerIds[$index % count($providerIds)],
                'level' => fake()->randomElement(['beginner', 'intermediate', 'advanced']),
                'image_path' => 'certificates/' . strtolower(str_replace(' ', '-', $title)) . '.jpg',
                'type' => fake()->randomElement(['digital', 'classroom', 'hybrid']),
                'description' => fake()->paragraph(3),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
            
            // Create 5 courses for each certificate
            for ($i = 1; $i <= 5; $i++) {
                $courseTitle = $courseTopics[($i - 1) % count($courseTopics)] . ' ' . 
                               $subjectAreas[($index + $i) % count($subjectAreas)];
                
                CertificateCourse::create([
                    'certificate_program_id' => $certificate->id,
                    'title' => $courseTitle,
                    'description' => fake()->paragraph(2),
                    'resource_link' => fake()->url,
                    'digital_link' => fake()->url,
                    'estimated_minutes' => fake()->numberBetween(30, 180),
                    'step_order' => $i,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
        
        $this->command->info('Created 10 certificate programs with 5 courses each (50 total courses)');
    }
}