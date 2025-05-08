<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('users')->insert([
            [
                'first_name' => 'Admin',
                'last_name' => 'User',
                'email' => 'admin@gmail.com',
                'password' => Hash::make('password'),
                'role_id' => 1,
                'assigned_mentor_id' => null,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Mentor',
                'last_name' => 'User',
                'email' => 'mentor@example.com',
                'password' => Hash::make('password'),
       
                'role_id' => 2,
                'assigned_mentor_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'first_name' => 'Intern',
                'last_name' => 'User',
                'email' => 'intern@example.com',
                'password' => Hash::make('password'),
            
                'role_id' => 3,
                'assigned_mentor_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
        ]);
    }
}