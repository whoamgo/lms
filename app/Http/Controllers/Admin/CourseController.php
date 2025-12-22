<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\LogHelper;
use App\Helpers\NotificationHelper;
use Illuminate\Support\Facades\Auth;
use App\Exports\CoursesExport;
use Maatwebsite\Excel\Facades\Excel;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cacheKey = 'admin_courses_' . md5(json_encode($request->all()));
            
            $courses = Cache::remember($cacheKey, 300, function () {
                return Course::with([
                    'batches',
                    'enrollments',
                    'trainers',
                    'videos'
                ])
                ->withCount(['enrollments', 'batches', 'videos', 'trainers'])
                ->get();
            });
            
            return view('admin.courses.index', compact('courses'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'courses_index']);
            return redirect()->back()->with('error', 'Error loading courses.');
        }
    }
    
    /**
     * Export courses to Excel
     */
    public function export(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $fileName = 'courses_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(
                new CoursesExport($startDate, $endDate),
                $fileName
            );
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'export_courses']);
            return redirect()->back()->with('error', 'Error exporting courses.');
        }
    }
    
    /**
     * Get course details for modal
     */
    public function getCourseDetails($id)
    {
        try {
            $course = Course::with([
                'trainers',
                'batches.enrollments',
                'enrollments.student',
                'videos'
            ])
            ->withCount(['enrollments', 'batches', 'videos', 'trainers'])
            ->findOrFail($id);
            
            // Calculate total students
            $totalStudents = $course->enrollments->count();
            
            // Get batch details
            $activeBatches = $course->batches->where('status', 'active');
            $totalBatches = $course->batches->count();
            
            return response()->json([
                'success' => true,
                'course' => $course,
                'totalStudents' => $totalStudents,
                'activeBatches' => $activeBatches,
                'totalBatches' => $totalBatches,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'get_course_details']);
            return response()->json([
                'success' => false,
                'message' => 'Error loading course details.'
            ], 500);
        }
    }
    
    /**
     * Delete course
     */
    public function destroy($id)
    {
        try {
            $course = Course::findOrFail($id);
            $courseName = $course->title;
            
            // Detach all trainers before deleting
            $course->trainers()->detach();
            
            $course->delete();
            
            // Clear cache
            Cache::forget('admin_courses_*');
            
            \App\Models\ActivityLog::log('deleted', $course, "Course deleted: {$courseName}");
            
            return redirect()->back()->with('success', 'Course deleted successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'delete_course']);
            return redirect()->back()->with('error', 'Error deleting course.');
        }
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'status' => 'required|in:active,completed,draft',
                'start_date' => 'nullable|date',
                'end_date' => 'nullable|date|after:start_date',
                'duration_days' => 'nullable|integer',
                'price' => 'nullable|numeric|min:0',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('uploads/courses'), $thumbnailName);
                $validated['thumbnail'] = 'uploads/courses/' . $thumbnailName;
            }

            $course = Course::create($validated);
            
            // Clear cache
            Cache::forget('admin_courses_*');
            
            \App\Models\ActivityLog::log('created', $course, 'Course created: ' . $course->title);
            
            // Send notification to admin (if created by trainer, this would be different)
            $creator = Auth::user();
            if ($creator->role === 'trainer') {
                NotificationHelper::adminCourseCreated($creator->name, $course->title);
            }

            return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'create_course']);
            return redirect()->back()->with('error', 'Error creating course.')->withInput();
        }
    }

    public function toggleStatus($id)
    {
        $course = Course::findOrFail($id);
        $newStatus = $course->status === 'active' ? 'draft' : 'active';
        $course->update(['status' => $newStatus]);
        
        \App\Models\ActivityLog::log('updated', $course, 'Course status changed to: ' . $newStatus);

        return redirect()->back()->with('success', 'Course status updated successfully!');
    }
}
