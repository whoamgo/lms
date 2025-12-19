<?php

namespace Database\Seeders;

use App\Models\LiveClass;
use App\Models\Course;
use App\Models\Batch;
use App\Models\User;
use Illuminate\Database\Seeder;

class LiveClassesSeeder extends Seeder
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

        $classTitles = [
            'Introduction Session',
            'Core Concepts Overview',
            'Hands-on Practice',
            'Q&A Session',
            'Project Discussion',
            'Advanced Topics',
            'Review and Recap',
            'Final Assessment',
            'Guest Lecture',
            'Workshop Session',
            'Group Activity',
            'Case Study Analysis',
            'Industry Insights',
            'Career Guidance',
            'Mock Interview'
        ];

        $statuses = ['scheduled', 'live', 'completed'];
        
        for ($i = 0; $i < 15; $i++) {
            $course = $courses->random();
            $trainer = $trainers->random();
            $batch = $batches->where('course_id', $course->id)->first();
            $status = $statuses[array_rand($statuses)];
            
            $scheduledAt = now()->addDays(rand(-30, 30))->setTime(rand(9, 18), rand(0, 59));
            
            LiveClass::create([
                'course_id' => $course->id,
                'batch_id' => $batch ? $batch->id : null,
                'trainer_id' => $trainer->id,
                'title' => $classTitles[$i % count($classTitles)] . ' - ' . $course->title,
                'description' => 'Join us for an interactive live class on ' . $classTitles[$i % count($classTitles)],
                'scheduled_at' => $scheduledAt,
                'started_at' => $status === 'completed' ? $scheduledAt->copy()->addMinutes(5) : null,
                'ended_at' => $status === 'completed' ? $scheduledAt->copy()->addHours(2) : null,
                'meeting_link' => 'https://meet.google.com/' . str()->random(10),
                'status' => $status,
                'duration' => rand(60, 180), // in minutes
            ]);
        }
    }
}
