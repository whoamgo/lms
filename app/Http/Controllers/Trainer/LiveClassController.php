<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\LiveClass;
use App\Models\Course;
use App\Models\Batch;
use App\Helpers\EncryptionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LiveClassController extends Controller
{
    public function index(Request $request)
    {
        $trainer = Auth::user();
        $liveClasses = LiveClass::where('trainer_id', $trainer->id)
            ->with('course', 'batch')
            ->orderBy('scheduled_at', 'desc')
            ->get();
        
        // Calculate stats
        $totalUpcoming = LiveClass::where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->count();
        
        $liveThisWeek = LiveClass::where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->whereBetween('scheduled_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        
        $totalHosted = LiveClass::where('trainer_id', $trainer->id)
            ->where('status', 'completed')
            ->count();
        
        $nextClass = LiveClass::where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->orderBy('scheduled_at', 'asc')
            ->first();
        
        $nextClassStartsIn = null;
        if ($nextClass) {
            $diff = now()->diffInHours($nextClass->scheduled_at);
            $nextClassStartsIn = $diff > 48 ? "In {$diff}+ hrs" : "In {$diff} hrs";
        }
        
        return view('trainer.live-classes', compact('liveClasses', 'totalUpcoming', 'liveThisWeek', 'totalHosted', 'nextClassStartsIn'));
    }

    public function create()
    {
        $trainer = Auth::user();
        $courses = $trainer->assignedCourses()->get();
        $batches = Batch::whereHas('course', function($q) use ($trainer) {
            $q->whereHas('trainers', function($query) use ($trainer) {
                $query->where('users.id', $trainer->id);
            });
        })->where('status', 'active')->get();
        
        return view('trainer.create-live-class', compact('courses', 'batches'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date_format:Y-m-d H:i|after:now',
            'meeting_link' => 'nullable|url',
            'duration' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_id' => 'nullable|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/live-classes'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/live-classes/' . $thumbnailName;
        }

        $validated['trainer_id'] = Auth::id();
        $validated['status'] = 'scheduled';

        $liveClass = LiveClass::create($validated);

        \App\Models\ActivityLog::log('created', $liveClass, 'Live class created: ' . $liveClass->title);

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Class created successfully!',
                'liveClass' => $liveClass
            ]);
        }

        return redirect()->route('trainer.live-classes')->with('success', 'Live class created successfully!');
    }

    public function edit($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid class ID');
        }
        
        $trainer = Auth::user();
        $liveClass = LiveClass::where('trainer_id', $trainer->id)->findOrFail($id);
        $courses = $trainer->assignedCourses()->get();
        $batches = Batch::whereHas('course', function($q) use ($trainer) {
            $q->whereHas('trainers', function($query) use ($trainer) {
                $query->where('users.id', $trainer->id);
            });
        })->where('status', 'active')->get();
        
        return view('trainer.edit-live-class', compact('liveClass', 'courses', 'batches'));
    }

    public function update(Request $request, $encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            abort(404, 'Invalid class ID');
        }
        
        $trainer = Auth::user();
        $liveClass = LiveClass::where('trainer_id', $trainer->id)->findOrFail($id);
        
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date',
            'meeting_link' => 'nullable|url',
            'duration' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            if ($liveClass->thumbnail && file_exists(public_path($liveClass->thumbnail))) {
                unlink(public_path($liveClass->thumbnail));
            }
            
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/live-classes'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/live-classes/' . $thumbnailName;
        }

        $liveClass->update($validated);

        \App\Models\ActivityLog::log('updated', $liveClass, 'Live class updated: ' . $liveClass->title);

        return redirect()->route('trainer.live-classes')->with('success', 'Live class updated successfully!');
    }

    public function join($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('trainer.live-classes')->with('error', 'Invalid class ID.');
        }
        
        try {
            $trainer = Auth::user();
            $liveClass = LiveClass::where('trainer_id', $trainer->id)
                ->with(['course', 'batch'])
                ->findOrFail($id);
            
            // Check if class is live
            if ($liveClass->status !== 'live') {
                return redirect()->route('trainer.live-classes')->with('error', 'This class is not currently live.');
            }
            
            // Get related videos/playlist if any
            $relatedVideos = collect();
            if ($liveClass->course_id) {
                $relatedVideos = \App\Models\Video::where('course_id', $liveClass->course_id)
                    ->where('status', 'published')
                    ->orderBy('created_at', 'desc')
                    ->limit(5)
                    ->get();
            }
            
            // Get playlist if course has one
            $playlists = collect();
            if ($liveClass->course_id) {
                $playlists = \App\Models\Playlist::whereHas('videos', function($q) use ($liveClass) {
                    $q->where('course_id', $liveClass->course_id);
                })->get();
            }
            
            return view('trainer.join-live-class', compact('liveClass', 'relatedVideos', 'playlists'));
        } catch (\Exception $e) {
            \Log::error('Error joining live class: ' . $e->getMessage());
            return redirect()->route('trainer.live-classes')->with('error', 'Live class not found.');
        }
    }

    public function start($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid class ID.'
            ], 400);
        }
        
        try {
            $trainer = Auth::user();
            $liveClass = LiveClass::where('trainer_id', $trainer->id)->findOrFail($id);
            
            // Check if class is scheduled
            if ($liveClass->status !== 'scheduled') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only scheduled classes can be started.'
                ], 400);
            }
            
            // Update status to live and set started_at
            $liveClass->update([
                'status' => 'live',
                'started_at' => now()
            ]);
            
            \App\Models\ActivityLog::log('updated', $liveClass, 'Live class started: ' . $liveClass->title);
            
            return response()->json([
                'success' => true,
                'message' => 'Live class started successfully!',
                'redirect' => route('trainer.live-classes.join', EncryptionHelper::encryptIdForUrl($liveClass->id))
            ]);
        } catch (\Exception $e) {
            \Log::error('Error starting live class: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to start live class.'
            ], 500);
        }
    }

    public function end($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid class ID.'
            ], 400);
        }
        
        try {
            $trainer = Auth::user();
            $liveClass = LiveClass::where('trainer_id', $trainer->id)->findOrFail($id);
            
            // Check if class is live
            if ($liveClass->status !== 'live') {
                return response()->json([
                    'success' => false,
                    'message' => 'Only live classes can be ended.'
                ], 400);
            }
            
            // Update status to completed and set ended_at
            $liveClass->update([
                'status' => 'completed',
                'ended_at' => now()
            ]);
            
            \App\Models\ActivityLog::log('updated', $liveClass, 'Live class ended: ' . $liveClass->title);
            
            return response()->json([
                'success' => true,
                'message' => 'Live class ended successfully!',
                'redirect' => route('trainer.live-classes')
            ]);
        } catch (\Exception $e) {
            \Log::error('Error ending live class: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Failed to end live class.'
            ], 500);
        }
    }
}
