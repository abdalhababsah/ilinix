<?php
namespace Database\Factories;

use App\Models\OnboardingStep;
use Illuminate\Database\Eloquent\Factories\Factory;

class OnboardingStepFactory extends Factory
{
    protected $model = OnboardingStep::class;

    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph,
            'resource_link' => $this->faker->url,
            'step_order' => $this->faker->numberBetween(1, 10),
        ];
    }
}