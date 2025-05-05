<?php

namespace Database\Factories;

use App\Models\Announcement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class AnnouncementFactory extends Factory
{
    protected $model = Announcement::class;

    public function definition(): array
    {
        return [
            'user_id' => User::factory(), // ✅ Required foreign key
            'title' => $this->faker->sentence(4),
            'message' => $this->faker->paragraph,
        ];
    }
}