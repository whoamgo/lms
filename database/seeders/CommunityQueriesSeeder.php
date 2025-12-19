<?php

namespace Database\Seeders;

use App\Models\CommunityQuery;
use App\Models\User;
use App\Models\Course;
use Illuminate\Database\Seeder;

class CommunityQueriesSeeder extends Seeder
{
    public function run(): void
    {
        $students = User::where('role', 'student')->get();
        $trainers = User::where('role', 'trainer')->get();
        $courses = Course::all();

        if ($students->isEmpty() || $courses->isEmpty()) {
            $this->command->warn('No students or courses found. Please run UsersSeeder and CoursesSeeder first.');
            return;
        }

        $subjects = [
            'How to install dependencies?',
            'Understanding async/await',
            'React hooks explanation',
            'Database connection issue',
            'API authentication problem',
            'Deployment error',
            'Code optimization question',
            'Best practices for state management',
            'Error handling strategies',
            'Testing approach',
            'Performance improvement',
            'Security concerns',
            'Code review request',
            'Project structure advice',
            'Career guidance needed'
        ];

        $questions = [
            'Can someone explain how this works?',
            'I am getting an error when trying to...',
            'What is the best way to implement...',
            'Has anyone faced this issue before?',
            'I need help with understanding...',
            'Can you provide an example of...',
            'What are the alternatives to...',
            'How do I optimize this code?',
            'Is there a better approach for...',
            'What are the common pitfalls in...',
        ];

        $statuses = ['open', 'assigned', 'resolved', 'closed'];
        
        for ($i = 0; $i < 15; $i++) {
            $student = $students->random();
            $course = $courses->random();
            $trainer = $trainers->random();
            $status = $statuses[array_rand($statuses)];
            
            CommunityQuery::create([
                'student_id' => $student->id,
                'course_id' => $course->id,
                'assigned_trainer_id' => in_array($status, ['assigned', 'resolved', 'closed']) ? $trainer->id : null,
                'subject' => $subjects[$i % count($subjects)],
                'question' => $questions[$i % count($questions)] . ' Related to ' . $course->title,
                'answer' => in_array($status, ['resolved', 'closed']) 
                    ? 'Here is the solution to your question. The best approach would be to...'
                    : null,
                'status' => $status,
            ]);
        }
    }
}
