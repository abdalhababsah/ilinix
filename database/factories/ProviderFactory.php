<?php

namespace Database\Factories;

use App\Models\Provider;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProviderFactory extends Factory
{
    protected $model = Provider::class;

    public function definition(): array
    {
        $providerNames = [
            'Microsoft', 'AWS', 'Google Cloud', 'Cisco', 'CompTIA',
            'Oracle', 'Salesforce', 'IBM', 'Adobe', 'Red Hat'
        ];

        return [
            'name' => $this->faker->unique()->randomElement($providerNames),
            'logo' => 'providers/logos/' . $this->faker->uuid . '.png',
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}