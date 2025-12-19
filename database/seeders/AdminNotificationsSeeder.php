<?php

namespace Database\Seeders;

use App\Models\AdminNotification;
use App\Models\User;
use Illuminate\Database\Seeder;

class AdminNotificationsSeeder extends Seeder
{
    public function run(): void
    {
        $users = User::all();

        if ($users->isEmpty()) {
            $this->command->warn('No users found. Please run UsersSeeder first.');
            return;
        }

        $types = ['info', 'warning', 'error', 'success'];
        $titles = [
            'New Enrollment',
            'Course Completed',
            'Payment Received',
            'System Update',
            'Maintenance Scheduled',
            'New Query Posted',
            'Certificate Issued',
            'Live Class Starting',
            'Batch Full',
            'New Trainer Joined',
            'Student Registered',
            'Report Generated',
            'Backup Completed',
            'Security Alert',
            'Feature Update'
        ];

        $messages = [
            'A new student has enrolled in a course.',
            'A student has completed their course successfully.',
            'Payment has been received for a course enrollment.',
            'System has been updated to the latest version.',
            'Scheduled maintenance will occur tonight.',
            'A new community query has been posted.',
            'A certificate has been issued to a student.',
            'A live class is starting in 10 minutes.',
            'A batch has reached maximum capacity.',
            'A new trainer has joined the platform.',
            'A new student has registered on the platform.',
            'Monthly report has been generated.',
            'System backup has been completed successfully.',
            'Unusual activity detected in the system.',
            'New features have been added to the platform.'
        ];
        
        for ($i = 0; $i < 15; $i++) {
            $user = $users->random();
            
            AdminNotification::create([
                'user_id' => $user->id,
                'type' => $types[array_rand($types)],
                'title' => $titles[$i % count($titles)],
                'message' => $messages[$i % count($messages)],
                'link' => '/admin/dashboard',
                'is_read' => rand(0, 1) === 1,
            ]);
        }
    }
}
