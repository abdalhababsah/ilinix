<?php

namespace Database\Factories;

use App\Models\UserAnnouncement;
use App\Models\User;
use App\Models\Announcement;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserAnnouncementFactory extends Factory
{
    protected $model = UserAnnouncement::class;

    public function definition(): array
    {
        return [
            'announcement_id' => Announcement::factory(),
            'intern_id' => User::factory(),
            'read_at' => now(),
        ];
    }
}