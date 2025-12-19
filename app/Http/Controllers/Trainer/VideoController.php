<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Video;
use App\Models\Course;
use App\Models\Batch;
use App\Models\Playlist;
use App\Helpers\EncryptionHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        try {
            $trainer = Auth::user();
            $videos = Video::where('trainer_id', $trainer->id)
                ->with('course', 'batch')
                ->orderBy('created_at', 'desc')
                ->get();
            
            // Calculate stats
            $totalVideos = $videos->count();
            
            $liveThisWeek = Video::where('trainer_id', $trainer->id)
                ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
                ->count();
            
            // Calculate total watch hours (assuming views * duration_minutes / 60)
            $totalWatchHours = Video::where('trainer_id', $trainer->id)
                ->selectRaw('SUM(COALESCE(views, 0) * COALESCE(duration_minutes, 0) / 60.0) as total_hours')
                ->value('total_hours') ?? 0;
            
            // Average rating (if you have a ratings table, otherwise default)
            $averageRating = 4.8; // Default or calculate from ratings table
            
            return view('trainer.videos', compact('videos', 'totalVideos', 'liveThisWeek', 'totalWatchHours', 'averageRating'));
        } catch (\Exception $e) {
            Log::error('Error fetching videos: ' . $e->getMessage());
            return redirect()->route('trainer.dashboard')->with('error', 'An error occurred while loading videos.');
        }
    }

    public function create()
    {
        try {
            $trainer = Auth::user();
            $courses = $trainer->assignedCourses()->get();
            $batches = Batch::whereHas('course', function($q) use ($trainer) {
                $q->whereHas('trainers', function($query) use ($trainer) {
                    $query->where('users.id', $trainer->id);
                });
            })->where('status', 'active')->get();
            
            return view('trainer.create-video', compact('courses', 'batches'));
        } catch (\Exception $e) {
            Log::error('Error loading create video page: ' . $e->getMessage());
            return redirect()->route('trainer.videos')->with('error', 'An error occurred while loading the page.');
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'visibility' => 'required|in:private,unlisted,public',
                'scheduled_at' => 'nullable|date',
                'scheduled_time' => 'nullable|date_format:H:i',
                'timezone' => 'nullable|string',
                'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400', // 100MB max
            'video_url' => 'nullable|url',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'course_id' => 'nullable|exists:courses,id',
                'batch_id' => 'nullable|exists:batches,id',
                'duration_minutes' => 'nullable|integer|min:1',
            ]);

            DB::beginTransaction();

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                $videoFile = $request->file('video_file');
                $videoName = time() . '_' . $videoFile->getClientOriginalName();
                $videoFile->move(public_path('uploads/videos'), $videoName);
                $validated['video_url'] = 'uploads/videos/' . $videoName;
            } else {
                // If no file, use video_url from request if provided
                if ($request->has('video_url') && $request->input('video_url')) {
                    $validated['video_url'] = $request->input('video_url');
                } else {
                    throw new \Illuminate\Validation\ValidationException(
                        validator([], []),
                        ['video_file' => ['Either a video file or video URL is required.']]
                    );
                }
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('uploads/videos/thumbnails'), $thumbnailName);
                $validated['thumbnail'] = 'uploads/videos/thumbnails/' . $thumbnailName;
            }

            $validated['trainer_id'] = Auth::id();
            $validated['status'] = $validated['visibility'] === 'public' ? 'active' : 'inactive';

            // Combine scheduled date and time if provided
            if ($request->has('scheduled_at') && $request->has('scheduled_time')) {
                $validated['scheduled_at'] = $request->input('scheduled_at') . ' ' . $request->input('scheduled_time');
            }

            unset($validated['visibility'], $validated['scheduled_time'], $validated['timezone'], $validated['video_file']);

            $video = Video::create($validated);

            \App\Models\ActivityLog::log('created', $video, 'Video uploaded: ' . $video->title);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video uploaded successfully!',
                    'video' => $video
                ]);
            }

            return redirect()->route('trainer.videos')->with('success', 'Video uploaded successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error uploading video: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while uploading the video.'.$e->getMessage()
                ], 500);
            }
            return back()->with('error', 'An error occurred while uploading the video.')->withInput();
        }
    }

    public function show($id)
    {
        try {
            $trainer = Auth::user();
            $video = Video::where('trainer_id', $trainer->id)
                ->with('course', 'batch')
                ->findOrFail($id);
            
            return view('trainer.show-video', compact('video'));
        } catch (\Exception $e) {
            Log::error('Error fetching video: ' . $e->getMessage());
            return redirect()->route('trainer.videos')->with('error', 'Video not found.');
        }
    }

    public function watch($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('trainer.videos')->with('error', 'Invalid video ID.');
        }
        
        try {
            $trainer = Auth::user();
            $video = Video::where('trainer_id', $trainer->id)
                ->with('course', 'batch')
                ->findOrFail($id);
            
            // Increment views
            $video->increment('views');
            
            // Get all videos from the same course for playlist
            $courseVideos = collect();
            if ($video->course_id) {
                $courseVideos = Video::where('course_id', $video->course_id)
                    ->where('trainer_id', $trainer->id)
                    ->where('status', 'active')
                    ->orderBy('created_at', 'asc')
                    ->get();
            }
            
            // Calculate progress (completed videos / total videos)
            $totalVideos = $courseVideos->count();
            $completedVideos = 0; // You can implement completion tracking later
            $progress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
            
            return view('trainer.watch-video', compact('video', 'courseVideos', 'totalVideos', 'completedVideos', 'progress'));
        } catch (\Exception $e) {
            Log::error('Error fetching video for watch: ' . $e->getMessage());
            return redirect()->route('trainer.videos')->with('error', 'Video not found.');
        }
    }

    public function edit($id)
    {
        try {
            $trainer = Auth::user();
            $video = Video::where('trainer_id', $trainer->id)->findOrFail($id);
            $courses = $trainer->assignedCourses()->get();
            $batches = Batch::whereHas('course', function($q) use ($trainer) {
                $q->whereHas('trainers', function($query) use ($trainer) {
                    $query->where('users.id', $trainer->id);
                });
            })->where('status', 'active')->get();
            
            return view('trainer.edit-video', compact('video', 'courses', 'batches'));
        } catch (\Exception $e) {
            Log::error('Error loading edit video page: ' . $e->getMessage());
            return redirect()->route('trainer.videos')->with('error', 'Video not found.');
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $trainer = Auth::user();
            $video = Video::where('trainer_id', $trainer->id)->findOrFail($id);
            
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
                'visibility' => 'required|in:private,unlisted,public',
                'scheduled_at' => 'nullable|date',
                'scheduled_time' => 'nullable|date_format:H:i',
                'timezone' => 'nullable|string',
                'video_file' => 'nullable|file|mimes:mp4,avi,mov,wmv,flv,webm|max:102400',
                'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'course_id' => 'nullable|exists:courses,id',
                'batch_id' => 'nullable|exists:batches,id',
                'duration_minutes' => 'nullable|integer|min:1',
            ]);

            DB::beginTransaction();

            // Handle video file upload
            if ($request->hasFile('video_file')) {
                // Delete old video file if exists
                if ($video->video_url && file_exists(public_path($video->video_url))) {
                    unlink(public_path($video->video_url));
                }
                
                $videoFile = $request->file('video_file');
                $videoName = time() . '_' . $videoFile->getClientOriginalName();
                $videoFile->move(public_path('uploads/videos'), $videoName);
                $validated['video_url'] = 'uploads/videos/' . $videoName;
            }

            // Handle thumbnail upload
            if ($request->hasFile('thumbnail')) {
                // Delete old thumbnail if exists
                if ($video->thumbnail && file_exists(public_path($video->thumbnail))) {
                    unlink(public_path($video->thumbnail));
                }
                
                $thumbnail = $request->file('thumbnail');
                $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
                $thumbnail->move(public_path('uploads/videos/thumbnails'), $thumbnailName);
                $validated['thumbnail'] = 'uploads/videos/thumbnails/' . $thumbnailName;
            }

            $validated['status'] = $validated['visibility'] === 'public' ? 'active' : 'inactive';

            // Combine scheduled date and time if provided
            if ($request->has('scheduled_at') && $request->has('scheduled_time')) {
                $validated['scheduled_at'] = $request->input('scheduled_at') . ' ' . $request->input('scheduled_time');
            }

            unset($validated['visibility'], $validated['scheduled_time'], $validated['timezone'], $validated['video_file']);

            $video->update($validated);

            \App\Models\ActivityLog::log('updated', $video, 'Video updated: ' . $video->title);

            DB::commit();

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Video updated successfully!',
                    'video' => $video
                ]);
            }

            return redirect()->route('trainer.videos')->with('success', 'Video updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            DB::rollBack();
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Validation failed',
                    'errors' => $e->errors()
                ], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error updating video: ' . $e->getMessage());
            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'An error occurred while updating the video.'
                ], 500);
            }
            return back()->with('error', 'An error occurred while updating the video.')->withInput();
        }
    }

    public function storePlaylist(Request $request)
    {
        try {
            $validated = $request->validate([
                'title' => 'required|string|max:255',
                'description' => 'nullable|string',
            ]);

            $playlist = Playlist::create([
                'trainer_id' => Auth::id(),
                'title' => $validated['title'],
                'description' => $validated['description'] ?? null,
            ]);

            \App\Models\ActivityLog::log('created', $playlist, 'Playlist created: ' . $playlist->title);

            return response()->json([
                'success' => true,
                'message' => 'Playlist created successfully!',
                'playlist' => $playlist
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            Log::error('Error creating playlist: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'An error occurred while creating the playlist.'
            ], 500);
        }
    }
}
