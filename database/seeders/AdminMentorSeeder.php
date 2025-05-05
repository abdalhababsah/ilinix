<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminMentorSeeder extends Seeder
{
    public function run(): void
    {
        // Create admin
        $admin = User::create([
            'first_name' => 'Admin',
            'last_name' => 'User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => 1, // Admin role
            'assigned_mentor_id' => null,
            'status' => 'active',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        
        // Create 5 mentors
        $mentors = [];
        for ($i = 1; $i <= 5; $i++) {
            $mentors[] = User::create([
                'first_name' => fake()->firstName(),
                'last_name' => fake()->lastName(),
                'email' => "mentor{$i}@example.com",
                'password' => Hash::make('password'),
                'role_id' => 2, // Mentor role
                'assigned_mentor_id' => null,
                'status' => 'active',
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
        
        $this->command->info('Created 1 admin and 5 mentors');
    }
}