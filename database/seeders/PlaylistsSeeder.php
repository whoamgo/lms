<?php

namespace Database\Seeders;

use App\Models\Playlist;
use App\Models\User;
use Illuminate\Database\Seeder;

class PlaylistsSeeder extends Seeder
{
    public function run(): void
    {
        $trainers = User::where('role', 'trainer')->get();

        if ($trainers->isEmpty()) {
            $this->command->warn('No trainers found. Please run UsersSeeder first.');
            return;
        }

        $playlistTitles = [
            'Web Development Basics',
            'Advanced JavaScript',
            'React Complete Course',
            'Node.js Backend Series',
            'Full Stack Projects',
            'Python Programming',
            'Data Science Fundamentals',
            'Mobile App Development',
            'UI/UX Design Principles',
            'Digital Marketing Strategies',
            'Graphic Design Mastery',
            'Content Writing Guide',
            'Video Editing Tutorials',
            'Animation Techniques',
            'SEO Best Practices'
        ];

        $descriptions = [
            'A comprehensive playlist covering all the basics.',
            'Learn advanced concepts and techniques.',
            'Complete course from beginner to advanced.',
            'Step-by-step tutorials and examples.',
            'Real-world projects and case studies.',
        ];
        
        for ($i = 0; $i < 15; $i++) {
            $trainer = $trainers->random();
            
            Playlist::create([
                'trainer_id' => $trainer->id,
                'title' => $playlistTitles[$i % count($playlistTitles)],
                'description' => $descriptions[array_rand($descriptions)],
            ]);
        }
    }
}
