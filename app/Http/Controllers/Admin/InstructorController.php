<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cache;
use App\Helpers\LogHelper;
use App\Exports\InstructorsExport;
use Maatwebsite\Excel\Facades\Excel;

class InstructorController extends Controller
{
    public function index()
    {
        try {
            $cacheKey = 'admin_instructors';
            
            $instructors = Cache::remember($cacheKey, 300, function () {
                return User::where('role', 'trainer')
                    ->with(['assignedCourses', 'assignedCourses.batches', 'assignedCourses.enrollments'])
                    ->withCount('assignedCourses')
                    ->get();
            });
            
            return view('admin.instructors.index', compact('instructors'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'instructors_index']);
            return redirect()->back()->with('error', 'Error loading instructors.');
        }
    }
    
    /**
     * Export instructors to Excel
     */
    public function export(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $fileName = 'instructors_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(
                new InstructorsExport($startDate, $endDate),
                $fileName
            );
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'export_instructors']);
            return redirect()->back()->with('error', 'Error exporting instructors.');
        }
    }
    
    /**
     * Get instructor details for modal
     */
    public function getInstructorDetails($id)
    {
        try {
            $instructor = User::where('role', 'trainer')
                ->with([
                    'assignedCourses.trainers',
                    'assignedCourses.batches',
                    'assignedCourses.enrollments',
                    'assignedCourses.videos'
                ])
                ->withCount('assignedCourses')
                ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'instructor' => $instructor,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'get_instructor_details']);
            return response()->json([
                'success' => false,
                'message' => 'Error loading instructor details.'
            ], 500);
        }
    }
    
    /**
     * Delete instructor
     */
    public function destroy($id)
    {
        try {
            $instructor = User::where('role', 'trainer')->findOrFail($id);
            $instructorName = $instructor->name;
            
            // Detach all courses before deleting
            $instructor->assignedCourses()->detach();
            
            $instructor->delete();
            
            // Clear cache
            Cache::forget('admin_instructors');
            
            \App\Models\ActivityLog::log('deleted', $instructor, "Instructor deleted: {$instructorName}");
            
            return redirect()->back()->with('success', 'Instructor deleted successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'delete_instructor']);
            return redirect()->back()->with('error', 'Error deleting instructor.');
        }
    }

    public function create()
    {
        $courses = Course::all();
        return view('admin.instructors.create', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
            'phone' => 'nullable|string',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $avatarPath = null;
        if ($request->hasFile('avatar')) {
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $avatarPath = 'uploads/avatars/' . $avatarName;
        }

        $user = User::create([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'trainer',
            'status' => 'active',
            'phone' => $validated['phone'] ?? null,
            'avatar' => $avatarPath,
        ]);

        if (isset($validated['courses'])) {
            $user->assignedCourses()->sync($validated['courses']);
        }

        // Clear cache
        Cache::forget('admin_instructors');
        
        \App\Models\ActivityLog::log('created', $user, 'Instructor created: ' . $user->name);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor created successfully!');
    }

    public function edit($id)
    {
        $instructor = User::where('role', 'trainer')->findOrFail($id);
        $courses = Course::all();
        $assignedCourseIds = $instructor->assignedCourses()->pluck('courses.id')->toArray();
        return view('admin.instructors.edit', compact('instructor', 'courses', 'assignedCourseIds'));
    }

    public function update(Request $request, $id)
    {
        $instructor = User::where('role', 'trainer')->findOrFail($id);
        
        $validated = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $instructor->id,
            'password' => 'nullable|string|min:8',
            'phone' => 'nullable|string',
            'courses' => 'nullable|array',
            'courses.*' => 'exists:courses,id',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            // Delete old avatar if exists
            if ($instructor->avatar && file_exists(public_path($instructor->avatar))) {
                unlink(public_path($instructor->avatar));
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $validated['avatar'] = 'uploads/avatars/' . $avatarName;
        }

        $instructor->update([
            'name' => $validated['first_name'] . ' ' . $validated['last_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'avatar' => $validated['avatar'] ?? $instructor->avatar,
        ]);

        if (!empty($validated['password'])) {
            $instructor->update(['password' => Hash::make($validated['password'])]);
        }

        if (isset($validated['courses'])) {
            $instructor->assignedCourses()->sync($validated['courses']);
        }

        // Clear cache
        Cache::forget('admin_instructors');
        
        \App\Models\ActivityLog::log('updated', $instructor, 'Instructor updated: ' . $instructor->name);

        return redirect()->route('admin.instructors.index')->with('success', 'Instructor updated successfully!');
    }

    public function toggleStatus($id)
    {
        $instructor = User::where('role', 'trainer')->findOrFail($id);
        $instructor->update([
            'status' => $instructor->status === 'active' ? 'inactive' : 'active'
        ]);
        
        \App\Models\ActivityLog::log('updated', $instructor, 'Instructor status changed to: ' . $instructor->status);

        return redirect()->back()->with('success', 'Instructor status updated successfully!');
    }
}
