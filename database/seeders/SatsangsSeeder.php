<?php

namespace Database\Seeders;

use App\Models\Satsang;
use App\Models\User;
use Illuminate\Database\Seeder;

class SatsangsSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = User::where('role', 'trainer')->get();

        if ($trainers->isEmpty()) {
            $this->command->warn('No trainers found. Please run UsersSeeder first.');
            return;
        }

        $titles = [
            'Career Guidance Session',
            'Industry Insights Discussion',
            'Career Path Planning',
            'Professional Development Talk',
            'Career Opportunities in Tech',
            'Interview Preparation Tips',
            'Resume Building Workshop',
            'Networking Strategies',
            'Salary Negotiation Guide',
            'Career Transition Advice',
            'Freelancing Opportunities',
            'Entrepreneurship Journey',
            'Work-Life Balance',
            'Skill Development Roadmap',
            'Future of Technology'
        ];

        $visibilities = ['private', 'unlisted', 'public'];
        $statuses = ['scheduled', 'live', 'completed', 'cancelled'];
        $timezones = ['UTC +05:30 (India)', 'UTC +00:00 (GMT)', 'UTC -05:00 (EST)', 'UTC +01:00 (CET)'];
        
        for ($i = 0; $i < 15; $i++) {
            $trainer = $trainers->random();
            $status = $statuses[array_rand($statuses)];
            $scheduledAt = now()->addDays(rand(-15, 30))->setTime(rand(10, 20), rand(0, 59));
            
            Satsang::create([
                'trainer_id' => $trainer->id,
                'title' => $titles[$i % count($titles)],
                'description' => 'Join us for an insightful session on ' . $titles[$i % count($titles)],
                'visibility' => $visibilities[array_rand($visibilities)],
                'scheduled_at' => $scheduledAt,
                'time' => $scheduledAt->format('H:i'),
                'timezone' => $timezones[array_rand($timezones)],
                'create_playlist' => rand(0, 1) === 1,
                'status' => $status,
                'meeting_link' => $status !== 'cancelled' ? 'https://meet.google.com/' . str()->random(10) : null,
            ]);
        }
    }
}
