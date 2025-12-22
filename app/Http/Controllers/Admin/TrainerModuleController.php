<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Batch;
use App\Models\LiveClass;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class TrainerModuleController extends Controller
{
    // Dashboard
    public function dashboard()
    {
        $user = Auth::user();
        // For admin, show aggregated data; for trainer, show their data
        if ($user->role === 'trainer') {
            $trainer = $user;
            $assignedCourses = $trainer->assignedCourses()->count();
            $activeBatches = Batch::whereHas('course', function($q) use ($trainer) {
                $q->whereHas('trainers', function($query) use ($trainer) {
                    $query->where('users.id', $trainer->id);
                });
            })->where('status', 'active')->count();
            
            $upcomingClasses = LiveClass::where('trainer_id', $trainer->id)
                ->where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->count();
            
            $uploadedVideos = Video::where('trainer_id', $trainer->id)->count();
        } else {
            // Admin view - show all trainer data
            $assignedCourses = Course::whereHas('trainers')->count();
            $activeBatches = Batch::where('status', 'active')->count();
            $upcomingClasses = LiveClass::where('status', 'scheduled')
                ->where('scheduled_at', '>', now())
                ->count();
            $uploadedVideos = Video::count();
        }
        
        return view('admin.trainer-module.dashboard', compact(
            'assignedCourses',
            'activeBatches',
            'upcomingClasses',
            'uploadedVideos'
        ));
    }

    // Profile
    public function profile()
    {
        $user = Auth::user();
        // For admin, use first trainer; for trainer, use themselves
        if ($user->role === 'trainer') {
            $trainer = $user;
        } else {
            $trainer = User::where('role', 'trainer')->first();
            if (!$trainer) {
                return redirect()->route('admin.dashboard')->with('error', 'No trainers found.');
            }
        }
        return view('admin.trainer-module.profile', compact('trainer'));
    }

    public function updateProfile(Request $request)
    {
        $trainer = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $trainer->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($trainer->avatar && file_exists(public_path($trainer->avatar))) {
                unlink(public_path($trainer->avatar));
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $validated['avatar'] = 'uploads/avatars/' . $avatarName;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $trainer->update($validated);

        \App\Models\ActivityLog::log('updated', $trainer, 'Profile updated');

        return redirect()->route('admin.trainer-module.profile')->with('success', 'Profile updated successfully!');
    }

    // Assigned Courses
    public function assignedCourses()
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $courses = $user->assignedCourses()->with('batches', 'enrollments')->get();
        } else {
            $courses = Course::whereHas('trainers')->with('batches', 'enrollments')->get();
        }
        
        return view('admin.trainer-module.assigned-courses', compact('courses'));
    }

    // Active Batches
    public function activeBatches()
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $batches = Batch::whereHas('course', function($q) use ($user) {
                $q->whereHas('trainers', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            })->where('status', 'active')
              ->with('course', 'enrollments')
              ->get();
        } else {
            $batches = Batch::where('status', 'active')->with('course', 'enrollments')->get();
        }
        
        return view('admin.trainer-module.active-batches', compact('batches'));
    }

    // Upcoming Live Classes
    public function liveClasses(Request $request)
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $query = LiveClass::where('trainer_id', $user->id);
        } else {
            $query = LiveClass::query();
        }
        
        $query->with('course', 'batch')->orderBy('scheduled_at', 'desc');
        
        if ($request->has('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }
        
        $liveClasses = $query->get();
        
        return view('admin.trainer-module.live-classes', compact('liveClasses'));
    }

    public function createLiveClass()
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $courses = $user->assignedCourses()->get();
            $batches = Batch::whereHas('course', function($q) use ($user) {
                $q->whereHas('trainers', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            })->where('status', 'active')->get();
        } else {
            $courses = Course::all();
            $batches = Batch::where('status', 'active')->get();
        }
        
        return view('admin.trainer-module.create-live-class', compact('courses', 'batches'));
    }

    public function storeLiveClass(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'scheduled_at' => 'required|date|after:now',
            'meeting_link' => 'nullable|url',
            'duration' => 'nullable|integer|min:1',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/live-classes'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/live-classes/' . $thumbnailName;
        }

        $user = Auth::user();
        // If admin, use first trainer or allow selection
        if ($user->role === 'trainer') {
            $validated['trainer_id'] = $user->id;
        } else {
            // For admin, use first trainer or require trainer selection
            $trainer = User::where('role', 'trainer')->first();
            if (!$trainer) {
                return redirect()->back()->with('error', 'No trainers available.');
            }
            $validated['trainer_id'] = $trainer->id;
        }
        $validated['status'] = 'scheduled';

        $liveClass = LiveClass::create($validated);

        \App\Models\ActivityLog::log('created', $liveClass, 'Live class created: ' . $liveClass->title);

        return redirect()->route('admin.trainer-module.live-classes')->with('success', 'Live class created successfully!');
    }

    public function editLiveClass($id)
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $liveClass = LiveClass::where('trainer_id', $user->id)->findOrFail($id);
            $courses = $user->assignedCourses()->get();
            $batches = Batch::whereHas('course', function($q) use ($user) {
                $q->whereHas('trainers', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            })->where('status', 'active')->get();
        } else {
            $liveClass = LiveClass::findOrFail($id);
            $courses = Course::all();
            $batches = Batch::where('status', 'active')->get();
        }
        
        return view('admin.trainer-module.edit-live-class', compact('liveClass', 'courses', 'batches'));
    }

    public function updateLiveClass(Request $request, $id)
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $liveClass = LiveClass::where('trainer_id', $user->id)->findOrFail($id);
        } else {
            $liveClass = LiveClass::findOrFail($id);
        }
        
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

        return redirect()->route('admin.trainer-module.live-classes')->with('success', 'Live class updated successfully!');
    }

    // Uploaded Videos
    public function videos()
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $videos = Video::where('trainer_id', $user->id)
                ->with('course', 'batch')
                ->orderBy('created_at', 'desc')
                ->get();
        } else {
            $videos = Video::with('course', 'batch')
                ->orderBy('created_at', 'desc')
                ->get();
        }
        
        return view('admin.trainer-module.videos', compact('videos'));
    }

    public function createVideo()
    {
        $user = Auth::user();
        if ($user->role === 'trainer') {
            $courses = $user->assignedCourses()->get();
            $batches = Batch::whereHas('course', function($q) use ($user) {
                $q->whereHas('trainers', function($query) use ($user) {
                    $query->where('users.id', $user->id);
                });
            })->where('status', 'active')->get();
        } else {
            $courses = Course::all();
            $batches = Batch::where('status', 'active')->get();
        }
        
        return view('admin.trainer-module.create-video', compact('courses', 'batches'));
    }

    public function storeVideo(Request $request)
    {
        $validated = $request->validate([
            'course_id' => 'required|exists:courses,id',
            'batch_id' => 'nullable|exists:batches,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'required|url',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|integer|min:1',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/videos'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/videos/' . $thumbnailName;
        }

        $user = Auth::user();
        if ($user->role === 'trainer') {
            $validated['trainer_id'] = $user->id;
        } else {
            $trainer = User::where('role', 'trainer')->first();
            if (!$trainer) {
                return redirect()->back()->with('error', 'No trainers available.');
            }
            $validated['trainer_id'] = $trainer->id;
        }
        $validated['status'] = 'active';

        $video = Video::create($validated);

        \App\Models\ActivityLog::log('created', $video, 'Video uploaded: ' . $video->title);

        return redirect()->route('admin.trainer-module.videos')->with('success', 'Video uploaded successfully!');
    }
}

