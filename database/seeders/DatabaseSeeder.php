<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->command->info('Starting database seeding...');
        
        // Seed in order to maintain relationships
        $this->command->info('Seeding Users...');
        $this->call(UsersSeeder::class);
        
        $this->command->info('Seeding Courses...');
        $this->call(CoursesSeeder::class);
        
        $this->command->info('Seeding Course-Trainer relationships...');
        $this->seedCourseTrainerRelationships();
        
        $this->command->info('Seeding Batches...');
        $this->call(BatchesSeeder::class);
        
        $this->command->info('Seeding Enrollments...');
        $this->call(EnrollmentsSeeder::class);
        
        $this->command->info('Seeding Videos...');
        $this->call(VideosSeeder::class);
        
        $this->command->info('Seeding Live Classes...');
        $this->call(LiveClassesSeeder::class);
        
        $this->command->info('Seeding Certificates...');
        $this->call(CertificatesSeeder::class);
        
        $this->command->info('Seeding Attendances...');
        $this->call(AttendancesSeeder::class);
        
        $this->command->info('Seeding Community Queries...');
        $this->call(CommunityQueriesSeeder::class);
        
        $this->command->info('Seeding Activity Logs...');
        $this->call(ActivityLogsSeeder::class);
        
        $this->command->info('Seeding Login History...');
        $this->call(LoginHistorySeeder::class);
        
        $this->command->info('Seeding Admin Notifications...');
        $this->call(AdminNotificationsSeeder::class);
        
        $this->command->info('Seeding Hiring Applications...');
        $this->call(HiringApplicationsSeeder::class);
        
        $this->command->info('Seeding Quizzes...');
        $this->call(QuizzesSeeder::class);
        
        $this->command->info('Seeding Quiz Questions...');
        $this->call(QuizQuestionsSeeder::class);
        
        $this->command->info('Seeding Quiz Attempts...');
        $this->call(QuizAttemptsSeeder::class);
        
        $this->command->info('Seeding Playlists...');
        $this->call(PlaylistsSeeder::class);
        
        $this->command->info('Seeding Satsangs...');
        $this->call(SatsangsSeeder::class);
        
        $this->command->info('Database seeding completed successfully!');
    }

    private function seedCourseTrainerRelationships(): void
    {
        $courses = \App\Models\Course::all();
        $trainers = \App\Models\User::where('role', 'trainer')->get();

        if ($courses->isEmpty() || $trainers->isEmpty()) {
            return;
        }

        // Assign trainers to courses
        foreach ($courses as $course) {
            // Assign 1-3 trainers per course
            $numTrainers = rand(1, 3);
            $selectedTrainers = $trainers->random($numTrainers);
            
            foreach ($selectedTrainers as $trainer) {
                $course->trainers()->attach($trainer->id);
            }
        }
    }
}
