<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\OnboardingStep;

class OnboardingStepSeeder extends Seeder
{
    public function run(): void
    {
        OnboardingStep::factory(5)->create();
    }
}