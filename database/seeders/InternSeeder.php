<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class InternSeeder extends Seeder
{
    public function run(): void
    {
        // Get all mentor IDs
        $mentorIds = User::where('role_id', 2)->pluck('id')->toArray();
        
        // Create 100 interns
        $interns = [];
        for ($i = 1; $i <= 100; $i++) {
            $interns[] = [
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => "intern{$i}@example.com",
                'password' => Hash::make('password'),
                'role_id' => 3, // Intern role
                'assigned_mentor_id' => fake()->randomElement($mentorIds),
                'status' => fake()->randomElement(['active', 'inactive', 'completed']),
                'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
                'updated_at' => now(),
            ];
        }
        
        // Insert in chunks for better performance
        $chunks = array_chunk($interns, 20);
        foreach ($chunks as $chunk) {
            User::insert($chunk);
        }
        
        $this->command->info('Created 100 interns');
    }
}