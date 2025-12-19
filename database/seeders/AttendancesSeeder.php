<?php

namespace Database\Seeders;

use App\Models\Attendance;
use App\Models\User;
use App\Models\LiveClass;
use Illuminate\Database\Seeder;

class AttendancesSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $liveClasses = LiveClass::all();

        if ($students->isEmpty() || $liveClasses->isEmpty()) {
            $this->command->warn('No students or live classes found. Please run UsersSeeder and LiveClassesSeeder first.');
            return;
        }

        $statuses = ['present', 'absent', 'late'];
        
        // Create 15 attendance records
        for ($i = 0; $i < 15; $i++) {
            $student = $students->random();
            $liveClass = $liveClasses->random();
            $status = $statuses[array_rand($statuses)];
            
            Attendance::create([
                'student_id' => $student->id,
                'live_class_id' => $liveClass->id,
                'status' => $status,
                'marked_at' => $status === 'present' || $status === 'late' 
                    ? $liveClass->scheduled_at->copy()->addMinutes(rand(0, 30))
                    : null,
            ]);
        }
    }
}
