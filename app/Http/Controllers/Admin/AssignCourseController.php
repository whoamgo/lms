<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;

class AssignCourseController extends Controller
{
    /**
     * Display the assign course page with recently created courses
     */
    public function index()
    {
        try {
            // Get recently created courses (last 10, ordered by created_at desc)
            $courses = Course::with('trainers')
                ->orderBy('created_at', 'desc')
                ->limit(10)
                ->get();
            
            // Get all trainers for the dropdown
            $trainers = User::where('role', 'trainer')
                ->where('status', 'active')
                ->orderBy('name')
                ->get();
            
            return view('admin.assign-course.index', compact('courses', 'trainers'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'assign_course_index']);
            return redirect()->back()->with('error', 'An error occurred while loading courses.');
        }
    }

    /**
     * Assign a trainer to a course
     */
    public function assignTrainer(Request $request, $courseId)
    {
        try {
            $request->validate([
                'trainer_id' => 'required|exists:users,id',
            ]);

            $course = Course::findOrFail($courseId);
            $trainer = User::findOrFail($request->trainer_id);

            // Check if trainer is already assigned
            if ($course->trainers()->where('trainer_id', $trainer->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainer is already assigned to this course.'
                ], 400);
            }

            // Assign trainer to course
            $course->trainers()->attach($trainer->id);

            \App\Models\ActivityLog::log('created', $course, "Trainer {$trainer->name} assigned to course: {$course->title}");

            return response()->json([
                'success' => true,
                'message' => 'Trainer assigned successfully.',
                'trainer' => [
                    'id' => $trainer->id,
                    'name' => $trainer->name,
                ]
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'assign_trainer', 'course_id' => $courseId]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while assigning trainer.'
            ], 500);
        }
    }

    /**
     * Remove a trainer from a course
     */
    public function removeTrainer(Request $request, $courseId, $trainerId)
    {
        try {
            // Validate IDs are numeric
            if (!is_numeric($courseId) || !is_numeric($trainerId)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Invalid course or trainer ID.'
                ], 400);
            }
            
            $course = Course::findOrFail($courseId);
            $trainer = User::where('role', 'trainer')->findOrFail($trainerId);

            // Check if trainer is assigned to this course
            if (!$course->trainers()->where('trainer_id', $trainer->id)->exists()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Trainer is not assigned to this course.'
                ], 400);
            }

            // Remove trainer from course
            $course->trainers()->detach($trainer->id);

            \App\Models\ActivityLog::log('deleted', $course, "Trainer {$trainer->name} removed from course: {$course->title}");

            return response()->json([
                'success' => true,
                'message' => 'Trainer removed successfully.',
                'trainer' => [
                    'id' => $trainer->id,
                    'name' => $trainer->name,
                ]
            ]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            LogHelper::exception($e, 'admin', ['action' => 'remove_trainer', 'course_id' => $courseId, 'trainer_id' => $trainerId]);
            return response()->json([
                'success' => false,
                'message' => 'Course or trainer not found.'
            ], 404);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'remove_trainer', 'course_id' => $courseId, 'trainer_id' => $trainerId]);
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while removing trainer.'
            ], 500);
        }
    }
}

