<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = User::where('role', 'trainer')->with('assignedCourses')->get();
        return view('admin.instructors.index', compact('instructors'));
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
