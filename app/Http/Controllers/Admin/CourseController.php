<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Batch;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        $courses = Course::with('batches', 'enrollments')->get();
        
        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        return view('admin.courses.create');
    }

    public function store(Request $request)
    {
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
        
        \App\Models\ActivityLog::log('created', $course, 'Course created: ' . $course->title);

        return redirect()->route('admin.courses.index')->with('success', 'Course created successfully!');
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
