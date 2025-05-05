<?php

namespace Database\Seeders;

use App\Models\CertificateProgress;
use App\Models\InternCertificate;
use Illuminate\Database\Seeder;

class CertificateProgressSeeder extends Seeder
{
    public function run(): void
    {
        // Get all intern certificates
        $internCertificates = InternCertificate::all();
        
        $progressEntries = [];
        
        // Create 1-3 progress entries for each intern certificate
        foreach ($internCertificates as $internCertificate) {
            $progressCount = fake()->numberBetween(1, 3);
            
            for ($i = 0; $i < $progressCount; $i++) {
                $createdAt = fake()->dateTimeBetween(
                    $internCertificate->started_at, 
                    $internCertificate->completed_at ?? 'now'
                );
                
                // Initialize with default status
                $studyStatus = 'not_started';
                
                // Set appropriate study status based on position in progress timeline
                if ($i == $progressCount - 1) { // Latest progress
                    if ($internCertificate->completed_at) {
                        // If certificate is completed, use a completion-related status
                        if ($internCertificate->exam_status == 'passed') {
                            $studyStatus = 'passed';
                        } elseif ($internCertificate->exam_status == 'failed') {
                            $studyStatus = 'failed';
                        } else {
                            $studyStatus = 'took_exam';
                        }
                    } else {
                        // If not completed, use a progress status
                        $studyStatus = fake()->randomElement([
                            'in_progress', 
                            'studying_for_exam', 
                            'requested_voucher'
                        ]);
                    }
                } elseif ($i > 0) {
                    // Middle progress entries
                    $studyStatus = 'in_progress';
                }
                
                $voucherRequested = null;
                $examDate = null;
                
                // Set appropriate dates based on status
                if ($studyStatus == 'requested_voucher' || $studyStatus == 'took_exam' || 
                    $studyStatus == 'passed' || $studyStatus == 'failed') {
                    $voucherRequested = fake()->dateTimeBetween($createdAt, '+1 week');
                    
                    if ($studyStatus == 'took_exam' || $studyStatus == 'passed' || $studyStatus == 'failed') {
                        $examDate = fake()->dateTimeBetween($voucherRequested, '+2 weeks');
                    }
                }
                
                $progressEntries[] = [
                    'intern_certificate_id' => $internCertificate->id,
                    'study_status' => $studyStatus,
                    'notes' => fake()->optional(0.7)->paragraph,
                    'voucher_requested_at' => $voucherRequested,
                    'exam_date' => $examDate,
                    'updated_by_mentor' => fake()->boolean(40),
                    'created_at' => $createdAt,
                    'updated_at' => fake()->dateTimeBetween($createdAt, 'now'),
                ];
            }
        }
        
        // Insert in smaller chunks to identify issues more easily
        $chunks = array_chunk($progressEntries, 20);
        foreach ($chunks as $chunk) {
            CertificateProgress::insert($chunk);
        }
        
        $this->command->info('Created certificate progress entries for all intern certificates');
    }
}