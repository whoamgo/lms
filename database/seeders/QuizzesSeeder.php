<?php

namespace Database\Seeders;

use App\Models\Quiz;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class QuizzesSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = User::where('role', 'trainer')->get();
        $courses = Course::all();

        if ($trainers->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No trainers or courses found. Please run UsersSeeder and CoursesSeeder first.');
            return;
        }

        $quizTypes = ['practice', 'assessment', 'exam'];
        $statuses = ['draft', 'published', 'archived'];
        
        for ($i = 0; $i < 15; $i++) {
            $trainer = $trainers->random();
            $course = $courses->random();
            
            Quiz::create([
                'trainer_id' => $trainer->id,
                'course_id' => $course->id,
                'title' => 'Quiz ' . ($i + 1) . ' - ' . $course->title,
                'description' => 'Test your knowledge of ' . $course->title . ' with this comprehensive quiz.',
                'quiz_type' => $quizTypes[array_rand($quizTypes)],
                'status' => $statuses[array_rand($statuses)],
                'time_limit' => rand(15, 120), // minutes
                'total_questions' => rand(5, 20),
            ]);
        }
    }
}
