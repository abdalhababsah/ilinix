<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CertificateCourse;

class CertificateCourseSeeder extends Seeder
{
    public function run(): void
    {
        CertificateCourse::factory(15)->create();
    }
}