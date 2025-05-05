<?php

namespace Database\Factories;

use App\Models\UserOnboardingStep;
use App\Models\User;
use App\Models\OnboardingStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserOnboardingStepFactory extends Factory
{
    protected $model = UserOnboardingStep::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'onboarding_step_id' => OnboardingStep::factory(),
            'is_completed' => $this->faker->boolean,
            'completed_at' => now(),
        ];
    }
}