<?php

namespace Database\Seeders;

use App\Models\Batch;
use App\Models\Course;
use Illuminate\Database\Seeder;

class BatchesSeeder extends Seeder
{
    public function run(): void
    {
        $courses = Course::all();
        
        if ($courses->isEmpty()) {
            $this->command->warn('No courses found. Please run CoursesSeeder first.');
            return;
        }

        $batchNames = [
            'Morning Batch', 'Evening Batch', 'Weekend Batch', 'Fast Track Batch', 'Regular Batch',
            'Intensive Batch', 'Part-time Batch', 'Full-time Batch', 'Online Batch', 'Offline Batch',
            'Hybrid Batch', 'Beginner Batch', 'Advanced Batch', 'Professional Batch', 'Master Batch'
        ];

        $statuses = ['active', 'completed', 'upcoming'];
        
        // Create 15 batches
        $batchCount = 0;
        while ($batchCount < 15) {
            foreach ($courses as $index => $course) {
                if ($batchCount >= 15) break;
                
                $batchIndex = $batchCount % count($batchNames);
                Batch::create([
                    'course_id' => $course->id,
                    'name' => $batchNames[$batchIndex] . ' - ' . $course->title,
                    'description' => 'This batch covers all aspects of ' . $course->title . ' in detail.',
                    'start_date' => $course->start_date,
                    'end_date' => $course->end_date,
                    'class_time' => now()->setTime(10 + (($batchCount % 8) * 2), 0),
                    'max_students' => rand(20, 50),
                    'status' => $statuses[array_rand($statuses)],
                ]);
                $batchCount++;
            }
        }
    }
}
