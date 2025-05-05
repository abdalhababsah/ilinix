<?php

namespace Database\Seeders;

use App\Models\ProgressUpdate;
use App\Models\InternCertificate;
use App\Models\CertificateCourse;
use Illuminate\Database\Seeder;

class ProgressUpdateSeeder extends Seeder
{
    public function run(): void
    {
        // Get all intern certificates
        $internCertificates = InternCertificate::with(['user', 'certificate.courses'])->get();
        
        $progressUpdates = [];
        
        // Create progress updates for all courses in each intern's certificates
        foreach ($internCertificates as $internCertificate) {
            $courses = $internCertificate->certificate->courses;
            
            // Skip if no courses found
            if ($courses->isEmpty()) continue;
            
            // Generate progress update for each course
            foreach ($courses as $course) {
                $isCompleted = fake()->boolean(70);
                $createdAt = fake()->dateTimeBetween(
                    $internCertificate->started_at, 
                    $internCertificate->completed_at ?? 'now'
                );
                $completedAt = $isCompleted ? fake()->dateTimeBetween($createdAt, 'now') : null;
                
                $progressUpdates[] = [
                    'intern_id' => $internCertificate->user_id,
                    'certificate_id' => $internCertificate->certificate_id,
                    'course_id' => $course->id,
                    'is_completed' => $isCompleted,
                    'comment' => fake()->paragraph(2),
                    'proof_url' => $isCompleted ? fake()->optional(0.7)->url : null,
                    'updated_by_mentor' => fake()->boolean(30),
                    'completed_at' => $completedAt,
                    'created_at' => $createdAt,
                    'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
                ];
            }
        }
        
        // Insert in chunks for better performance
        $chunks = array_chunk($progressUpdates, 50);
        foreach ($chunks as $chunk) {
            ProgressUpdate::insert($chunk);
        }
        
        $this->command->info('Created progress updates for all courses in assigned certificates');
    }
}