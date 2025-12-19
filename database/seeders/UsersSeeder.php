<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    public function run(): void
    {
        // Create 1 Admin
        User::updateOrCreate(
            ['email' => 'admin@lms.com'],
            [
                'name' => 'Admin User',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'status' => 'active',
                'phone' => '+1234567890',
                'address' => '123 Admin Street, City',
            ]
        );

        // Create 10 Trainers
        $trainerNames = [
            'John Trainer', 'Sarah Instructor', 'Mike Coach', 'Emily Teacher', 'David Mentor',
            'Lisa Guide', 'Robert Tutor', 'Jennifer Educator', 'Michael Facilitator', 'Amanda Trainer'
        ];

        for ($i = 0; $i < 10; $i++) {
            User::updateOrCreate(
                ['email' => 'trainer' . ($i + 1) . '@lms.com'],
                [
                    'name' => $trainerNames[$i] ?? "Trainer " . ($i + 1),
                    'password' => Hash::make('password'),
                    'role' => 'trainer',
                    'status' => $i < 8 ? 'active' : 'inactive',
                    'phone' => '+123456789' . $i,
                    'address' => ($i + 1) . ' Trainer Avenue, City',
                ]
            );
        }

        // Create 15 Students
        $studentNames = [
            'Alice Student', 'Bob Learner', 'Charlie Scholar', 'Diana Pupil', 'Eve Apprentice',
            'Frank Novice', 'Grace Beginner', 'Henry Trainee', 'Ivy Cadet', 'Jack Freshman',
            'Kate Sophomore', 'Liam Junior', 'Mia Senior', 'Noah Graduate', 'Olivia Postgrad'
        ];

        for ($i = 0; $i < 15; $i++) {
            User::updateOrCreate(
                ['email' => 'student' . ($i + 1) . '@lms.com'],
                [
                    'name' => $studentNames[$i] ?? "Student " . ($i + 1),
                    'password' => Hash::make('password'),
                    'role' => 'student',
                    'status' => $i < 12 ? 'active' : 'inactive',
                    'phone' => '+198765432' . str_pad($i, 1, '0', STR_PAD_LEFT),
                    'address' => ($i + 1) . ' Student Road, City',
                ]
            );
        }
    }
}
