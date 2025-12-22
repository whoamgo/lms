<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\QuizQuestion;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class QuizController extends Controller
{
    public function index()
    {
        try {
            $trainer = Auth::user();
            $quizzes = Quiz::where('trainer_id', $trainer->id)
                ->with('course', 'questions', 'attempts')
                ->withCount('attempts')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return view('trainer.quizzes', compact('quizzes'));
        } catch (\Exception $e) {
            \Log::error('Error fetching quizzes: ' . $e->getMessage());
            return redirect()->route('trainer.dashboard')->with('error', 'An error occurred while loading quizzes.');
        }
    }

    public function create()
    {
        $trainer = Auth::user();
        $courses = $trainer->assignedCourses()->get();
        
        return view('trainer.create-quiz', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'quiz_type' => 'required|in:practice,assessment,exam',
            'course_id' => 'nullable|exists:courses,id',
            'time_limit' => 'nullable|integer|min:1',
            'status' => 'required|in:draft,published,archived',
        ]);

        $validated['trainer_id'] = Auth::id();
        $validated['total_questions'] = 0;

        $quiz = Quiz::create($validated);

        \App\Models\ActivityLog::log('created', $quiz, 'Quiz created: ' . $quiz->title);

        return response()->json([
            'success' => true,
            'message' => 'Quiz created successfully!',
            'quiz_id' => $quiz->id
        ]);
    }

    public function addQuestion(Request $request, $quizId)
    {
        $quiz = Quiz::where('trainer_id', Auth::id())->findOrFail($quizId);
        
        $validated = $request->validate([
            'question' => 'required|string',
            'options' => 'required|array|min:2',
            'options.*' => 'required|string',
            'correct_answer_index' => 'required|integer|min:0',
            'points' => 'nullable|integer|min:1',
        ]);

        $validated['quiz_id'] = $quiz->id;
        $validated['order'] = $quiz->questions()->count() + 1;
        $validated['points'] = $validated['points'] ?? 1;

        $question = QuizQuestion::create($validated);
        
        $quiz->increment('total_questions');

        return response()->json([
            'success' => true,
            'message' => 'Question added successfully!',
            'question' => $question
        ]);
    }

    public function show($id)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)
                ->with(['course', 'questions', 'attempts.student'])
                ->findOrFail($id);
            
            // Increment views
            $quiz->increment('views');
            
            // Calculate statistics
            $totalAttempts = $quiz->attempts()->count();
            $completedAttempts = $quiz->completedAttempts()->count();
            $averageScore = $quiz->completedAttempts()->avg('percentage') ?? 0;
            $averageTime = $quiz->completedAttempts()->avg('time_taken') ?? 0;
            $passRate = $totalAttempts > 0 ? ($completedAttempts / $totalAttempts) * 100 : 0;
            
            // Get recent attempts
            $recentAttempts = $quiz->attempts()
                ->with('student')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Question-wise statistics
            $questionStats = [];
            foreach ($quiz->questions as $question) {
                $correctCount = 0;
                $totalAnswers = 0;
                
                foreach ($quiz->completedAttempts as $attempt) {
                    $answers = is_array($attempt->answers) ? $attempt->answers : json_decode($attempt->answers, true);
                    if (is_array($answers) && isset($answers[$question->id])) {
                        $totalAnswers++;
                        if ($answers[$question->id] == $question->correct_answer_index) {
                            $correctCount++;
                        }
                    }
                }
                
                $questionStats[] = [
                    'question' => $question,
                    'correct_count' => $correctCount,
                    'total_answers' => $totalAnswers,
                    'accuracy' => $totalAnswers > 0 ? ($correctCount / $totalAnswers) * 100 : 0,
                ];
            }
            
            return view('trainer.quiz-report', compact(
                'quiz', 
                'totalAttempts', 
                'completedAttempts', 
                'averageScore', 
                'averageTime', 
                'passRate',
                'recentAttempts',
                'questionStats'
            ));
        } catch (\Exception $e) {
            \Log::error('Error fetching quiz report: ' . $e->getMessage());
            return redirect()->route('trainer.quizzes.index')->with('error', 'Quiz not found.');
        }
    }

    public function edit($id)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)->findOrFail($id);
            $courses = $trainer->assignedCourses()->get();
            
            return response()->json([
                'success' => true,
                'quiz' => $quiz,
                'courses' => $courses
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching quiz for edit: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found.'
            ], 404);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)->findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'quiz_type' => 'required|in:practice,assessment,exam',
                'course_id' => 'nullable|exists:courses,id',
                'time_limit' => 'nullable|integer|min:1',
                'status' => 'required|in:draft,published,archived',
            ]);

            $quiz->update($validated);

            \App\Models\ActivityLog::log('updated', $quiz, 'Quiz updated: ' . $quiz->title);

            return response()->json([
                'success' => true,
                'message' => 'Quiz updated successfully!',
                'quiz' => $quiz
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            \Log::error('Error updating quiz: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while updating the quiz.'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)->findOrFail($id);
            
            $quizTitle = $quiz->title;
            $quiz->delete();

            \App\Models\ActivityLog::log('deleted', null, 'Quiz deleted: ' . $quizTitle);

            return response()->json([
                'success' => true,
                'message' => 'Quiz deleted successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting quiz: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the quiz.'
            ], 500);
        }
    }

    public function viewQuestions($id)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)
                ->with('questions')
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'questions' => $quiz->questions
            ]);
        } catch (\Exception $e) {
            \Log::error('Error fetching quiz questions: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Quiz not found.'
            ], 404);
        }
    }

    public function deleteQuestion($quizId, $questionId)
    {
        try {
            $trainer = Auth::user();
            $quiz = Quiz::where('trainer_id', $trainer->id)->findOrFail($quizId);
            $question = QuizQuestion::where('quiz_id', $quiz->id)->findOrFail($questionId);
            
            $question->delete();
            $quiz->decrement('total_questions');
            
            return response()->json([
                'success' => true,
                'message' => 'Question deleted successfully!'
            ]);
        } catch (\Exception $e) {
            \Log::error('Error deleting question: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while deleting the question.'
            ], 500);
        }
    }
}

