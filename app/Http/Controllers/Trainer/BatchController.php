<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Batch;
use App\Models\Course;
use App\Helpers\LogHelper;
use App\Helpers\NotificationHelper;

class BatchController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $batches = Batch::whereHas('course', function($q) use ($trainer) {
            $q->whereHas('trainers', function($query) use ($trainer) {
                $query->where('users.id', $trainer->id);
            });
        })->where('status', 'active')
          ->with('course', 'enrollments')
          ->get();
        
        return view('trainer.batches', compact('batches'));
    }

    public function create()
    {
        $trainer = Auth::user();
        $courses = $trainer->assignedCourses()->get();
        
        return view('trainer.create-batch', compact('courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'class_time' => 'nullable|date_format:H:i',
            'max_students' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/batches'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/batches/' . $thumbnailName;
        }

        $validated['status'] = 'active';

        $batch = Batch::create($validated);

        \App\Models\ActivityLog::log('created', $batch, 'Batch created: ' . $batch->name);
        
        // Send notification to admin
        $course = Course::find($validated['course_id']);
        if ($course) {
            NotificationHelper::adminBatchCreated($batch->name, $course->title);
        }

        return redirect()->route('trainer.active-batches')->with('success', 'Batch created successfully!');
    }

    public function edit($id)
    {
        $trainer = Auth::user();
        $batch = Batch::whereHas('course', function($q) use ($trainer) {
            $q->whereHas('trainers', function($query) use ($trainer) {
                $query->where('users.id', $trainer->id);
            });
        })->findOrFail($id);
        
        $courses = $trainer->assignedCourses()->get();
        
        return view('trainer.edit-batch', compact('batch', 'courses'));
    }

    public function update(Request $request, $id)
    {
        $trainer = Auth::user();
        $batch = Batch::whereHas('course', function($q) use ($trainer) {
            $q->whereHas('trainers', function($query) use ($trainer) {
                $query->where('users.id', $trainer->id);
            });
        })->findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'course_id' => 'required|exists:courses,id',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'class_time' => 'nullable|date_format:H:i',
            'max_students' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($batch->thumbnail && file_exists(public_path($batch->thumbnail))) {
                unlink(public_path($batch->thumbnail));
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/batches'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/batches/' . $thumbnailName;
        }

        $batch->update($validated);

        \App\Models\ActivityLog::log('updated', $batch, 'Batch updated: ' . $batch->name);

        return redirect()->route('trainer.active-batches')->with('success', 'Batch updated successfully!');
    }
    
    /**
     * Get batch details for modal
     */
    public function getBatchDetails($id)
    {
        try {
            $trainer = Auth::user();
            $batch = Batch::whereHas('course', function($q) use ($trainer) {
                $q->whereHas('trainers', function($query) use ($trainer) {
                    $query->where('users.id', $trainer->id);
                });
            })
            ->with(['course', 'enrollments.student'])
            ->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'batch' => $batch,
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'trainer', ['action' => 'get_batch_details']);
            return response()->json([
                'success' => false,
                'message' => 'Error loading batch details.'
            ], 500);
        }
    }
    
    /**
     * Delete batch
     */
    public function destroy($id)
    {
        try {
            $trainer = Auth::user();
            $batch = Batch::whereHas('course', function($q) use ($trainer) {
                $q->whereHas('trainers', function($query) use ($trainer) {
                    $query->where('users.id', $trainer->id);
                });
            })->findOrFail($id);
            
            $batchName = $batch->name;
            $batch->delete();
            
            \App\Models\ActivityLog::log('deleted', $batch, "Batch deleted: {$batchName}");
            
            return redirect()->back()->with('success', 'Batch deleted successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'trainer', ['action' => 'delete_batch']);
            return redirect()->back()->with('error', 'Error deleting batch.');
        }
    }
}

