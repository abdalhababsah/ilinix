<?php

namespace Database\Seeders;

use App\Models\InternCertificate;
use App\Models\User;
use App\Models\CertificateProgram;
use App\Models\Voucher;
use Illuminate\Database\Seeder;

class InternCertificateSeeder extends Seeder
{
    public function run(): void
    {
        // Get all interns
        $interns = User::where('role_id', 3)->get();
        
        // Get all certificate programs
        $certificates = CertificateProgram::all();
        
        // Get available voucher IDs (as integers)
        $voucherIds = Voucher::pluck('id')->toArray();
        
        $internCertificates = [];
        
        // Assign 2 certificates to each intern
        foreach ($interns as $intern) {
            // Get 2 random certificate IDs for this intern
            $assignedCertificateIds = $certificates->random(2)->pluck('id')->toArray();
            
            foreach ($assignedCertificateIds as $certificateId) {
                $startedAt = fake()->dateTimeBetween('-6 months', '-1 week');
                $completedAt = fake()->optional(0.3)->dateTimeBetween($startedAt, 'now');
                
                $examStatus = 'not_taken'; // Default value matching the enum
                
                if ($completedAt) {
                    // If completed, randomly assign passed or failed
                    $examStatus = fake()->randomElement(['passed', 'failed']);
                } elseif (fake()->boolean(50)) {
                    $examStatus = 'scheduled';
                }
                
                // Randomly assign a voucher ID (from existing vouchers) or null
                $voucherId = !empty($voucherIds) && fake()->boolean(20) 
                    ? fake()->randomElement($voucherIds) 
                    : null;
                
                $internCertificates[] = [
                    'user_id' => $intern->id,
                    'certificate_id' => $certificateId,
                    'started_at' => $startedAt,
                    'completed_at' => $completedAt,
                    'exam_status' => $examStatus,
                    'voucher_id' => $voucherId, // Use integer ID, not UUID string
                    'created_at' => $startedAt,
                    'updated_at' => now(),
                ];
            }
        }
        
        // Insert in smaller chunks to help identify any issues
        $chunks = array_chunk($internCertificates, 10);
        foreach ($chunks as $chunk) {
            InternCertificate::insert($chunk);
        }
        
        $this->command->info('Assigned 2 certificates to each intern');
    }
}