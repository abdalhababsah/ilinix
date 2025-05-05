<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // Clear tables to avoid duplication issues
        $this->truncateTables();
        
        // Base roles and users
        $this->call(RoleSeeder::class);
        $this->call(AdminMentorSeeder::class); // Creates admin and mentors
        $this->call(VoucherSeeder::class);

        $this->call(InternSeeder::class); // Creates 100 interns
        
        // Core entities
        $this->call(ProviderSeeder::class); // Create 10 providers
        $this->call(CertificateProgramSeeder::class); // Create 10 certificate programs with 5 courses each
        $this->call(InternCertificateSeeder::class); // Assign 2 certificates to each intern
        
        // Related progress & steps
        $this->call(CertificateProgressSeeder::class); // Create certificate progress entries
        $this->call(ProgressUpdateSeeder::class); // Create course progress updates
        
        // Announcements & Notifications
        $this->call(AnnouncementSeeder::class);
        $this->call(UserAnnouncementSeeder::class);
        $this->call(NotificationSeeder::class);
        
        // Onboarding
        $this->call(OnboardingStepSeeder::class);
        $this->call(UserOnboardingStepSeeder::class);
        
        // Vouchers
        $this->call(VoucherSeeder::class);
        
        $this->command->info('Database seeded with test data:');
        $this->command->info('- 100 interns');
        $this->command->info('- 10 certificate programs');
        $this->command->info('- 50 courses (5 per certificate)');
        $this->command->info('- Each intern has 2 assigned certificates');
        $this->command->info('- Progress updates for all courses in assigned certificates');
    }
    
    /**
     * Truncate tables to avoid duplication issues
     */
    private function truncateTables(): void
    {
        // Disable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        
        // Truncate tables in reverse dependency order
        DB::table('vouchers')->truncate();
        DB::table('user_onboarding_steps')->truncate();
        DB::table('onboarding_steps')->truncate();
        DB::table('notifications')->truncate();
        DB::table('user_announcements')->truncate();
        DB::table('announcements')->truncate();
        DB::table('progress_updates')->truncate();
        DB::table('certificate_progress')->truncate();
        DB::table('intern_certificates')->truncate();
        DB::table('certificate_courses')->truncate();
        DB::table('certificate_programs')->truncate();
        DB::table('providers')->truncate();
        
        // Don't truncate users if you want to keep specific users
        // DB::table('users')->truncate();
        // DB::table('roles')->truncate();
        
        // Enable foreign key checks
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}