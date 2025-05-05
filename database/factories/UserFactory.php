<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
    protected $model = User::class;
    protected static ?string $password = null;

    public function definition(): array
    {
        return [
            'first_name' => $this->faker->firstName,
            'last_name' => $this->faker->lastName,
            'email' => $this->faker->unique()->safeEmail,
            'password' => static::$password ??= Hash::make('password'),
            'role_id' => 3, // Intern role
            'assigned_mentor_id' => null,
            'status' => $this->faker->randomElement(['active', 'inactive', 'completed']),
            'remember_token' => Str::random(10),
            'email_verified_at' => now(),
            'created_at' => $this->faker->dateTimeBetween('-6 months', 'now'),
            'updated_at' => function (array $attributes) {
                return $this->faker->dateTimeBetween($attributes['created_at'], 'now');
            },
        ];
    }

    public function mentor()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 2,
                'assigned_mentor_id' => null,
            ];
        });
    }

    public function admin()
    {
        return $this->state(function (array $attributes) {
            return [
                'role_id' => 1,
                'assigned_mentor_id' => null,
            ];
        });
    }
}