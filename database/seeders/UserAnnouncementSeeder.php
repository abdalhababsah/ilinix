<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\UserAnnouncement;

class UserAnnouncementSeeder extends Seeder
{
    public function run(): void
    {
        UserAnnouncement::factory(10)->create();
    }
}