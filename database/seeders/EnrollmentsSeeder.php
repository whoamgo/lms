<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Database\Seeder;

class EnrollmentsSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $courses = Course::all();
        $batches = Batch::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No students or courses found. Please run UsersSeeder and CoursesSeeder first.');
            return;
        }

        $statuses = ['enrolled', 'completed', 'dropped'];
        
        // Create 15 enrollments
        for ($i = 0; $i < 15; $i++) {
            $student = $students->random();
            $course = $courses->random();
            $batch = $batches->where('course_id', $course->id)->first();
            $status = $statuses[array_rand($statuses)];
            
            Enrollment::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'batch_id' => $batch ? $batch->id : null,
                'status' => $status,
                'enrolled_at' => now()->subDays(rand(1, 90)),
                'completed_at' => $status === 'completed' ? now()->subDays(rand(1, 30)) : null,
                'progress_percentage' => $status === 'completed' ? 100 : rand(0, 95),
            ]);
        }
    }
}
