<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserOnboardingStep;

class UserOnboardingStepSeeder extends Seeder
{
    public function run(): void
    {
        UserOnboardingStep::factory(10)->create();
    }
}