<?php

namespace Database\Seeders;

use App\Models\QuizAttempt;
use App\Models\Quiz;
use App\Models\User;
use Illuminate\Database\Seeder;

class QuizAttemptsSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = Quiz::all();
        $students = User::where('role', 'student')->get();

        if ($quizzes->isEmpty() || $students->isEmpty()) {
            $this->command->warn('No quizzes or students found. Please run QuizzesSeeder and UsersSeeder first.');
            return;
        }

        $statuses = ['completed', 'in_progress', 'abandoned'];
        
        // Create 15 quiz attempts
        for ($i = 0; $i < 15; $i++) {
            $quiz = $quizzes->random();
            $student = $students->random();
            $status = $statuses[array_rand($statuses)];
            
            // Generate answers based on questions
            $answers = [];
            $score = 0;
            $totalPoints = 0;
            
            foreach ($quiz->questions as $question) {
                $totalPoints += $question->points;
                $studentAnswer = rand(0, count($question->options) - 1);
                $answers[$question->id] = $studentAnswer;
                
                if ($studentAnswer == $question->correct_answer_index) {
                    $score += $question->points;
                }
            }
            
            $percentage = $totalPoints > 0 ? ($score / $totalPoints) * 100 : 0;
            $startedAt = now()->subDays(rand(0, 30))->subHours(rand(0, 23));
            $completedAt = $status === 'completed' ? $startedAt->copy()->addMinutes(rand(5, $quiz->time_limit ?? 60)) : null;
            $timeTaken = $completedAt ? $startedAt->diffInSeconds($completedAt) : null;
            
            QuizAttempt::create([
                'quiz_id' => $quiz->id,
                'student_id' => $student->id,
                'score' => $score,
                'total_points' => $totalPoints,
                'percentage' => $percentage,
                'answers' => $answers,
                'started_at' => $startedAt,
                'completed_at' => $completedAt,
                'status' => $status,
                'time_taken' => $timeTaken,
            ]);
        }
    }
}
