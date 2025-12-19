<?php

namespace Database\Seeders;

use App\Models\ActivityLog;
use App\Models\User;
use App\Models\Course;
use App\Models\Video;
use Illuminate\Database\Seeder;

class ActivityLogsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();
        $courses = Course::all();
        $videos = Video::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UsersSeeder first.');
            return;
        }

        $actions = ['created', 'updated', 'deleted', 'viewed', 'downloaded', 'enrolled', 'completed'];
        $descriptions = [
            'created a new course',
            'updated course information',
            'viewed dashboard',
            'uploaded a video',
            'enrolled in a course',
            'completed a lesson',
            'downloaded certificate',
            'updated profile',
            'created a batch',
            'scheduled a live class',
            'answered a query',
            'updated settings',
            'viewed reports',
            'exported data',
            'performed system backup'
        ];
        
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            $action = $actions[array_rand($actions)];
            $model = null;
            $modelType = null;
            $modelId = null;
            
            // Randomly assign a model
            if (rand(0, 1) && $courses->isNotEmpty()) {
                $model = $courses->random();
                $modelType = Course::class;
                $modelId = $model->id;
            } elseif ($videos->isNotEmpty()) {
                $model = $videos->random();
                $modelType = Video::class;
                $modelId = $model->id;
            }
            
            ActivityLog::create([
                'user_id' => $user->id,
                'action' => $action,
                'model_type' => $modelType,
                'model_id' => $modelId,
                'description' => $user->name . ' ' . $descriptions[$i % count($descriptions)],
                'ip_address' => '192.168.1.' . rand(1, 255),
                'user_agent' => 'Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36',
            ]);
        }
    }
}
