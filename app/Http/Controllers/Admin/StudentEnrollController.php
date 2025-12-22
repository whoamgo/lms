<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use App\Models\QuizAttempt;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Cache;
use App\Helpers\LogHelper;
use App\Exports\StudentEnrollmentsExport;
use Maatwebsite\Excel\Facades\Excel;

class StudentEnrollController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cacheKey = 'admin_student_enrollments_' . md5(json_encode($request->all()));
            
            $data = Cache::remember($cacheKey, 300, function () use ($request) {
                // Get all enrollments with related data
                $enrollments = Enrollment::with(['student', 'course', 'batch', 'course.trainers'])
                    ->withCount(['student'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                
                // Get students with enrollment counts
                $students = User::where('role', 'student')
                    ->withCount(['enrollments', 'completedEnrollments'])
                    ->get();
                
                $totalStudents = User::where('role', 'student')->count();
                $activeStudents = User::where('role', 'student')->where('status', 'active')->count();
                $newThisMonth = User::where('role', 'student')
                    ->whereMonth('created_at', now()->month)
                    ->whereYear('created_at', now()->year)
                    ->count();
                
                return compact('enrollments', 'students', 'totalStudents', 'activeStudents', 'newThisMonth');
            });
            
            return view('admin.student-enroll.index', $data);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'student_enrollments_index']);
            return redirect()->back()->with('error', 'Error loading student enrollments.');
        }
    }
    
    /**
     * Export enrollments to Excel
     */
    public function export(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $fileName = 'student_enrollments_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(
                new StudentEnrollmentsExport($startDate, $endDate),
                $fileName
            );
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'export_enrollments']);
            return redirect()->back()->with('error', 'Error exporting enrollments.');
        }
    }
    
    /**
     * Get enrollment details for modal
     */
    public function getEnrollmentDetails($id)
    {
        try {
            $enrollment = Enrollment::with([
                'student',
                'course.trainers',
                'batch',
                'course.videos'
            ])->findOrFail($id);
            
            // Ensure course and student exist
            if (!$enrollment->course) {
                LogHelper::exception(new \Exception('Course not found'), 'admin', ['enrollment_id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Course not found for this enrollment.'
                ], 404);
            }
            
            if (!$enrollment->student) {
                LogHelper::exception(new \Exception('Student not found'), 'admin', ['enrollment_id' => $id]);
                return response()->json([
                    'success' => false,
                    'message' => 'Student not found for this enrollment.'
                ], 404);
            }
            
            // Get quiz attempts for this student in this course
            $quizAttempts = [];
            try {
                $quizAttempts = QuizAttempt::where('student_id', $enrollment->student_id)
                    ->whereHas('quiz', function($q) use ($enrollment) {
                        $q->where('course_id', $enrollment->course_id);
                    })
                    ->with('quiz')
                    ->orderBy('completed_at', 'desc')
                    ->get();
            } catch (\Exception $e) {
                // If quiz attempts query fails, continue with empty array
                LogHelper::exception($e, 'admin', ['action' => 'get_quiz_attempts']);
            }
            
            // Calculate video progress
            $totalVideos = 0;
            $completedVideos = 0;
            try {
                $totalVideos = $enrollment->course->videos()->where('status', 'active')->count();
                if (Schema::hasTable('video_progress') && $totalVideos > 0) {
                    $videoIds = $enrollment->course->videos()->pluck('id')->toArray();
                    if (!empty($videoIds)) {
                        $completedVideos = DB::table('video_progress')
                            ->where('student_id', $enrollment->student_id)
                            ->whereIn('video_id', $videoIds)
                            ->where('completed', true)
                            ->count();
                    }
                }
            } catch (\Exception $e) {
                // If video progress calculation fails, continue with defaults
                LogHelper::exception($e, 'admin', ['action' => 'calculate_video_progress']);
            }
            
            $videoProgress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
            
            // Prepare enrollment data for JSON response
            $enrollmentData = [
                'id' => $enrollment->id,
                'status' => $enrollment->status,
                'progress_percentage' => $enrollment->progress_percentage ?? 0,
                'enrolled_at' => $enrollment->enrolled_at ? $enrollment->enrolled_at->format('Y-m-d') : ($enrollment->created_at ? $enrollment->created_at->format('Y-m-d') : null),
                'completed_at' => $enrollment->completed_at ? $enrollment->completed_at->format('Y-m-d') : null,
                'student' => [
                    'id' => $enrollment->student->id,
                    'name' => $enrollment->student->name,
                    'email' => $enrollment->student->email,
                    'phone' => $enrollment->student->phone ?? null,
                ],
                'course' => [
                    'id' => $enrollment->course->id,
                    'title' => $enrollment->course->title,
                    'description' => $enrollment->course->description ?? null,
                    'status' => $enrollment->course->status,
                    'trainers' => $enrollment->course->trainers->map(function($trainer) {
                        return [
                            'id' => $trainer->id,
                            'name' => $trainer->name,
                            'email' => $trainer->email,
                        ];
                    }),
                ],
                'batch' => $enrollment->batch ? [
                    'id' => $enrollment->batch->id,
                    'name' => $enrollment->batch->name,
                    'start_date' => $enrollment->batch->start_date ? $enrollment->batch->start_date->format('Y-m-d') : null,
                    'end_date' => $enrollment->batch->end_date ? $enrollment->batch->end_date->format('Y-m-d') : null,
                    'class_time' => $enrollment->batch->class_time ?? null,
                    'close_time' => $enrollment->batch->close_time ?? null,
                ] : null,
            ];
            
            // Prepare quiz attempts data
            $quizAttemptsData = $quizAttempts->map(function($attempt) {
                return [
                    'id' => $attempt->id,
                    'quiz_id' => $attempt->quiz_id,
                    'quiz_title' => $attempt->quiz ? $attempt->quiz->title : 'N/A',
                    'score' => $attempt->score ?? 0,
                    'total_points' => $attempt->total_points ?? 0,
                    'percentage' => $attempt->percentage ?? 0,
                    'status' => $attempt->status ?? 'pending',
                    'completed_at' => $attempt->completed_at ? $attempt->completed_at->format('Y-m-d H:i:s') : null,
                ];
            });
            
            return response()->json([
                'success' => true,
                'enrollment' => $enrollmentData,
                'quizAttempts' => $quizAttemptsData,
                'videoProgress' => $videoProgress,
                'completedVideos' => $completedVideos,
                'totalVideos' => $totalVideos,
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            LogHelper::exception($e, 'admin', ['action' => 'get_enrollment_details', 'enrollment_id' => $id]);
            return response()->json([
                'success' => false,
                'message' => 'Enrollment not found.'
            ], 404);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'get_enrollment_details', 'enrollment_id' => $id]);
            // Only show detailed error in development
            $errorMessage = config('app.debug') ? 'Error loading enrollment details: ' . $e->getMessage() : 'Error loading enrollment details.';
            return response()->json([
                'success' => false,
                'message' => $errorMessage
            ], 500);
        }
    }
    
    /**
     * Delete enrollment
     */
    public function destroy($id)
    {
        try {
            $enrollment = Enrollment::findOrFail($id);
            $studentName = $enrollment->student->name;
            $courseName = $enrollment->course->title;
            
            $enrollment->delete();
            
            \App\Models\ActivityLog::log('deleted', $enrollment, "Enrollment deleted: {$studentName} - {$courseName}");
            
            return redirect()->back()->with('success', 'Enrollment deleted successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'delete_enrollment']);
            return redirect()->back()->with('error', 'Error deleting enrollment.');
        }
    }

    public function toggleStatus($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->update([
            'status' => $student->status === 'active' ? 'inactive' : 'active'
        ]);
        
        \App\Models\ActivityLog::log('updated', $student, 'Student status changed to: ' . $student->status);

        return redirect()->back()->with('success', 'Student status updated successfully!');
    }
}
