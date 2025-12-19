<?php

namespace Database\Seeders;

use App\Models\QuizQuestion;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizQuestionsSeeder extends Seeder
{
    public function run(): void
    {
        $quizzes = Quiz::all();

        if ($quizzes->isEmpty()) {
            $this->command->warn('No quizzes found. Please run QuizzesSeeder first.');
            return;
        }

        $questions = [
            'What is the main purpose of this concept?',
            'Which of the following is correct?',
            'What would be the output of this code?',
            'Which method is best for this scenario?',
            'What is the time complexity of this algorithm?',
            'Which statement is true?',
            'What does this function return?',
            'Which approach is more efficient?',
            'What is the correct syntax?',
            'Which option is the best practice?',
        ];

        $answerOptions = [
            ['Option A', 'Option B', 'Option C', 'Option D'],
            ['True', 'False', 'Maybe', 'Not sure'],
            ['Method 1', 'Method 2', 'Method 3', 'Method 4'],
            ['Approach A', 'Approach B', 'Approach C', 'Approach D'],
            ['O(n)', 'O(log n)', 'O(n²)', 'O(1)'],
        ];
        
        foreach ($quizzes->take(12) as $quiz) {
            // Create 3-5 questions per quiz
            $numQuestions = rand(3, 5);
            
            for ($i = 0; $i < $numQuestions; $i++) {
                $options = $answerOptions[array_rand($answerOptions)];
                $correctIndex = rand(0, count($options) - 1);
                
                QuizQuestion::create([
                    'quiz_id' => $quiz->id,
                    'question' => $questions[($quiz->id * $numQuestions + $i) % count($questions)],
                    'options' => $options,
                    'correct_answer_index' => $correctIndex,
                    'points' => rand(1, 5),
                    'order' => $i + 1,
                ]);
            }
        }
    }
}
