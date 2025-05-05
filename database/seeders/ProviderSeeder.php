<?php

namespace Database\Seeders;

use App\Models\Provider;
use Illuminate\Database\Seeder;

class ProviderSeeder extends Seeder
{
    public function run(): void
    {
        $providers = [
            'Microsoft', 'AWS', 'Google Cloud', 'Cisco', 'CompTIA',
            'Oracle', 'Salesforce', 'IBM', 'Adobe', 'Red Hat'
        ];
        
        foreach ($providers as $providerName) {
            Provider::create([
                'name' => $providerName,
                'logo' => 'providers/' . strtolower(str_replace(' ', '-', $providerName)) . '.png',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
        
        $this->command->info('Created 10 certification providers');
    }
}