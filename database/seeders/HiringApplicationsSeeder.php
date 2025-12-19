<?php

namespace Database\Seeders;

use App\Models\HiringApplication;
use App\Models\User;
use Illuminate\Database\Seeder;

class HiringApplicationsSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = User::where('role', 'trainer')->get();

        if ($trainers->isEmpty()) {
            $this->command->warn('No trainers found. Please run UsersSeeder first.');
            return;
        }

        $positions = [
            'Senior Web Developer',
            'Full Stack Developer',
            'React.js Instructor',
            'Node.js Trainer',
            'Python Programming Teacher',
            'Data Science Mentor',
            'UI/UX Design Instructor',
            'Mobile App Development Trainer',
            'Digital Marketing Expert',
            'Graphic Design Teacher',
            'Content Writing Instructor',
            'Video Editing Trainer',
            'SEO Specialist',
            'DevOps Engineer',
            'Cloud Computing Expert'
        ];

        $coverLetters = [
            'I am excited to apply for this position. I have extensive experience in...',
            'With over 5 years of teaching experience, I believe I am the right candidate...',
            'I am passionate about education and have a strong background in...',
            'Having worked in the industry for many years, I can bring real-world experience...',
            'I am dedicated to helping students achieve their learning goals...',
        ];

        $statuses = ['pending', 'approved', 'rejected'];
        
        for ($i = 0; $i < 15; $i++) {
            $trainer = $trainers->random();
            $status = $statuses[array_rand($statuses)];
            
            HiringApplication::create([
                'trainer_id' => $trainer->id,
                'position' => $positions[$i % count($positions)],
                'cover_letter' => $coverLetters[array_rand($coverLetters)],
                'resume' => 'resumes/resume_' . $trainer->id . '.pdf',
                'status' => $status,
                'admin_notes' => $status === 'approved' 
                    ? 'Excellent candidate with strong qualifications.'
                    : ($status === 'rejected' ? 'Does not meet the requirements.' : null),
            ]);
        }
    }
}
