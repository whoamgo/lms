<?php

namespace Database\Seeders;

use App\Models\Video;
use App\Models\Course;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Database\Seeder;

class VideosSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();
        $trainers = User::where('role', 'trainer')->get();
        $batches = Batch::all();

        if ($courses->isEmpty() || $trainers->isEmpty()) {
            $this->command->warn('No courses or trainers found. Please run CoursesSeeder and UsersSeeder first.');
            return;
        }

        $videoTitles = [
            'Introduction to Web Development',
            'HTML Basics and Structure',
            'CSS Styling Fundamentals',
            'JavaScript Variables and Functions',
            'React Components and Props',
            'State Management in React',
            'Node.js Server Setup',
            'Database Design and SQL',
            'API Development with Express',
            'Authentication and Security',
            'Deployment Strategies',
            'Testing and Debugging',
            'Performance Optimization',
            'Best Practices and Patterns',
            'Project Walkthrough'
        ];

        $statuses = ['active', 'inactive'];
        
        // Create 15 videos
        for ($i = 0; $i < 15; $i++) {
            $course = $courses->random();
            $trainer = $trainers->random();
            $batch = $batches->where('course_id', $course->id)->first();
            $videoIndex = $i % count($videoTitles);
            
            Video::create([
                'course_id' => $course->id,
                'batch_id' => $batch ? $batch->id : null,
                'trainer_id' => $trainer->id,
                'title' => $videoTitles[$videoIndex] . ' - ' . $course->title,
                'description' => 'Learn ' . $videoTitles[$videoIndex] . ' in this comprehensive video tutorial.',
                'video_url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
                'duration_minutes' => rand(15, 120),
                'order' => $i,
                'status' => $statuses[array_rand($statuses)],
                'views' => rand(50, 5000),
            ]);
        }
    }
}
