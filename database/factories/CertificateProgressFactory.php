<?php

namespace Database\Factories;

use App\Models\CertificateProgress;
use App\Models\InternCertificate;
use Illuminate\Database\Eloquent\Factories\Factory;

class CertificateProgressFactory extends Factory
{
    protected $model = CertificateProgress::class;

    public function definition(): array
    {
        $studyStatuses = [
            'not_started',
            'in_progress',
            'completed',
            'needs_help'
        ];

        $createdAt = $this->faker->dateTimeBetween('-3 months', 'now');
        $studyStatus = $this->faker->randomElement($studyStatuses);
        
        $voucher = null;
        $exam = null;
        
        if ($studyStatus == 'completed') {
            $voucher = $this->faker->optional(0.8)->dateTimeBetween('-1 month', '-1 week');
            $exam = $voucher ? $this->faker->optional(0.9)->dateTimeBetween($voucher, 'now') : null;
        } elseif ($studyStatus == 'in_progress' && $this->faker->boolean(30)) {
            $voucher = $this->faker->dateTimeBetween('-1 month', '-1 day');
            $exam = $this->faker->optional(0.5)->dateTimeBetween('now', '+2 weeks');
        }

        return [
            'intern_certificate_id' => InternCertificate::inRandomOrder()->first()->id ?? InternCertificate::factory(),
            'study_status' => $studyStatus,
            'notes' => $this->faker->paragraph,
            'voucher_requested_at' => $voucher,
            'exam_date' => $exam,
            'updated_by_mentor' => $this->faker->boolean(40),
            'created_at' => $createdAt,
            'updated_at' => $this->faker->dateTimeBetween($createdAt, 'now'),
        ];
    }
}