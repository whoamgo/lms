<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Certificate;
use App\Models\Video;
use App\Models\LiveClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        try {
            $student = Auth::user();
            
            // Cache stats for 5 minutes
            $cacheKey = "student_dashboard_stats_{$student->id}";
            $stats = Cache::remember($cacheKey, 300, function() use ($student) {
                $enrolledCourses = Enrollment::where('student_id', $student->id)->count();
                $completedCourses = Enrollment::where('student_id', $student->id)
                    ->where('status', 'completed')
                    ->count();
                
                // Calculate learning hours (placeholder - can be enhanced with video progress tracking)
                $learningHours = 0;
                try {
                    if (Schema::hasTable('video_progress')) {
                        $learningHours = DB::table('video_progress')
                            ->join('videos', 'video_progress.video_id', '=', 'videos.id')
                            ->where('video_progress.student_id', $student->id)
                            ->where('video_progress.completed', true)
                            ->sum('videos.duration');
                        $learningHours = round($learningHours / 60, 0);
                    }
                } catch (\Exception $e) {
                    // Table doesn't exist, use default
                    $learningHours = 0;
                }
                
                // Calculate average score from quiz attempts
                $averageScore = DB::table('quiz_attempts')
                    ->where('student_id', $student->id)
                    ->where('status', 'completed')
                    ->avg('percentage');
                $averageScore = round($averageScore ?? 0, 0);
                
                return [
                    'enrolledCourses' => $enrolledCourses,
                    'completedCourses' => $completedCourses,
                    'learningHours' => $learningHours,
                    'averageScore' => $averageScore,
                ];
            });
            
            // Get continue learning courses (in progress, not completed)
            $continueLearning = Enrollment::where('student_id', $student->id)
                ->where('status', 'enrolled')
                ->where('progress_percentage', '<', 100)
                ->with('course')
                ->orderBy('updated_at', 'desc')
                ->limit(6)
                ->get();
            
            // Get upcoming live classes
            $upcomingClasses = LiveClass::where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->whereHas('course', function($q) use ($student) {
                    $q->whereHas('enrollments', function($query) use ($student) {
                        $query->where('student_id', $student->id);
                    });
                })
                ->with('course')
                ->orderBy('scheduled_at', 'asc')
                ->limit(5)
                ->get();
            
            return view('student.dashboard', compact(
                'stats',
                'continueLearning',
                'upcomingClasses'
            ));
        } catch (\Exception $e) {
            \Log::error('Student Dashboard Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading the dashboard.');
        }
    }
}
