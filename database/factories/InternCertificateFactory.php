<?php

namespace Database\Factories;

use App\Models\InternCertificate;
use App\Models\User;
use App\Models\CertificateProgram;
use Illuminate\Database\Eloquent\Factories\Factory;

class InternCertificateFactory extends Factory
{
    protected $model = InternCertificate::class;

    public function definition(): array
    {
        $startedAt = $this->faker->dateTimeBetween('-6 months', '-1 week');
        $completedAt = $this->faker->optional(0.3)->dateTimeBetween($startedAt, 'now');
        
        $examStatus = 'not_started';
        if ($completedAt) {
            $examStatus = $this->faker->randomElement(['scheduled', 'passed', 'failed']);
        } elseif ($this->faker->boolean(50)) {
            $examStatus = 'scheduled';
        }

        return [
            'user_id' => User::where('role_id', 3)->inRandomOrder()->first()->id ?? User::factory(),
            'certificate_id' => CertificateProgram::inRandomOrder()->first()->id ?? CertificateProgram::factory(),
            'started_at' => $startedAt,
            'completed_at' => $completedAt,
            'exam_status' => $examStatus,
            'voucher_id' => $this->faker->optional(0.2)->uuid,
            'created_at' => $startedAt,
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }
}