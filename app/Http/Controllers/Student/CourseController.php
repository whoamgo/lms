<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Enrollment;
use App\Models\Course;
use App\Models\Video;
use App\Models\Attendance;
use App\Helpers\EncryptionHelper;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class CourseController extends Controller
{
    public function index(Request $request)
    {
        try {
            $student = Auth::user();
            $tab = $request->get('tab', 'all');
            
            $query = Enrollment::where('student_id', $student->id)
                ->with('course');
            
            if ($tab === 'active') {
                $query->where('status', 'enrolled')
                      ->where('progress_percentage', '<', 100);
            } elseif ($tab === 'completed') {
                $query->where('status', 'completed');
            }
            
            $enrollments = $query->orderBy('updated_at', 'desc')->get();
            
            return view('student.enroll-courses', compact('enrollments', 'tab'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'enroll_courses']);
            return redirect()->back()->with('error', 'An error occurred while loading courses.');
        }
    }

    public function certificates(Request $request)
    {
        try {
            $student = Auth::user();
            $tab = $request->get('tab', 'current');
            
            $query = \App\Models\Certificate::where('student_id', $student->id)
                ->with('course');
            
            $now = now();
            
            if ($tab === 'past') {
                // Past certificates (issued more than 30 days ago)
                $query->where('issued_at', '<', now()->subDays(30));
            } elseif ($tab === 'upcoming') {
                // Upcoming certificates - for courses that are about to be completed
                // Get enrollments that are nearly complete
                $upcomingCourseIds = Enrollment::where('student_id', $student->id)
                    ->where('status', 'enrolled')
                    ->where('progress_percentage', '>=', 90)
                    ->pluck('course_id');
                $query->whereIn('course_id', $upcomingCourseIds)
                      ->where('issued_at', '>', now());
            } else {
                // Current certificates (issued within last 30 days)
                $query->where('issued_at', '>=', now()->subDays(30));
            }
            
            $certificates = $query->orderBy('issued_at', 'desc')->get();
            
            return view('student.certificates', compact('certificates', 'tab', 'student'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'certificates']);
            return redirect()->back()->with('error', 'An error occurred while loading certificates.');
        }
    }

    public function downloadCertificate($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Invalid certificate ID.');
        }
        
        try {
            $student = Auth::user();
            $certificate = \App\Models\Certificate::where('student_id', $student->id)
                ->with('course', 'student')
                ->findOrFail($id);
            
            return $this->generateCertificatePDF($certificate);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'certificate_download', 'certificate_id' => $id ?? null]);
            return redirect()->back()->with('error', 'An error occurred while generating the certificate.');
        }
    }

    private function generateCertificatePDF($certificate)
    {
        try {
            $pdf = Pdf::loadView('student.certificate-pdf', compact('certificate'));
            $pdf->setPaper('a4', 'portrait');
            $pdf->setOption('enable-local-file-access', true);
            $pdf->setOption('isHtml5ParserEnabled', true);
            $pdf->setOption('isRemoteEnabled', true);
            $pdf->setOption('defaultFont', 'Times New Roman');
            return $pdf->download('certificate-' . $certificate->certificate_number . '.pdf');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'pdf_generation', 'certificate_id' => $certificate->id]);
            // Fallback: Return HTML view that can be printed as PDF
            return view('student.certificate-pdf', compact('certificate'));
        }
    }

    public function attendance(Request $request)
    {
        try {
            $student = Auth::user();
            
            // Get filter parameters
            $courseFilter = $request->get('course', 'all');
            $year = $request->get('year', date('Y'));
            $month = $request->get('month', date('m'));
            $dateRange = $request->get('range', 'this_month');
            
            // Calculate date range based on selection
            $startDate = now();
            $endDate = now();
            
            if ($dateRange === 'last_month') {
                $startDate = Carbon::now()->subMonth()->startOfMonth();
                $endDate = Carbon::now()->subMonth()->endOfMonth();
                $year = $startDate->format('Y');
                $month = $startDate->format('m');
            } elseif ($dateRange === 'custom') {
                $customStart = $request->get('start_date');
                $customEnd = $request->get('end_date');
                if ($customStart && $customEnd) {
                    try {
                        $startDate = Carbon::createFromFormat('d/m/Y', $customStart);
                        $endDate = Carbon::createFromFormat('d/m/Y', $customEnd);
                    } catch (\Exception $e) {
                        $startDate = Carbon::now()->startOfMonth();
                        $endDate = Carbon::now()->endOfMonth();
                    }
                } else {
                    $startDate = Carbon::now()->startOfMonth();
                    $endDate = Carbon::now()->endOfMonth();
                }
            } else {
                // This month
                $startDate = Carbon::create($year, $month, 1)->startOfMonth();
                $endDate = Carbon::create($year, $month, 1)->endOfMonth();
            }
            
            // Get student's enrolled courses for filter
            $enrolledCourses = Enrollment::where('student_id', $student->id)
                ->with('course')
                ->get()
                ->pluck('course')
                ->unique('id')
                ->values();
            
            // Get attendances
            $attendanceQuery = Attendance::where('student_id', $student->id)
                ->with(['liveClass.course', 'liveClass.batch'])
                ->whereDate('created_at', '>=', $startDate->copy()->startOfDay())
                ->whereDate('created_at', '<=', $endDate->copy()->endOfDay());
            
            // Filter by course if selected
            if ($courseFilter !== 'all') {
                $attendanceQuery->whereHas('liveClass', function($q) use ($courseFilter) {
                    $q->where('course_id', $courseFilter);
                });
            }
            
            $allAttendances = $attendanceQuery->orderBy('created_at', 'desc')->get();
            
            // Pagination for table display
            $perPage = 15;
            $page = (int) $request->get('page', 1);
            $totalCount = $allAttendances->count();
            $attendances = $allAttendances->slice(($page - 1) * $perPage, $perPage)->values();
            $hasMore = $totalCount > ($page * $perPage);
            
            // If AJAX request, return JSON for load more
            if ($request->ajax() || $request->wantsJson()) {
                $html = view('student.attendance-rows', compact('attendances'))->render();
                return response()->json([
                    'html' => $html,
                    'hasMore' => $hasMore,
                    'page' => $page
                ]);
            }
            
            // Calculate statistics (use all attendances, not paginated)
            $recorded = $allAttendances->count();
            $presentDays = $allAttendances->where('status', 'present')->count();
            $absentDays = $allAttendances->where('status', 'absent')->count();
            $lateDays = $allAttendances->where('status', 'late')->count();
            $totalDays = $recorded > 0 ? $recorded : 1;
            $attendancePercentage = round(($presentDays / $totalDays) * 100, 0);
            
            // Group by week for chart (use all attendances)
            $weeklyData = [];
            $currentWeek = $startDate->copy()->startOfWeek();
            while ($currentWeek->lte($endDate)) {
                $weekEnd = $currentWeek->copy()->endOfWeek();
                $weekAttendances = $allAttendances->filter(function($att) use ($currentWeek, $weekEnd) {
                    return $att->created_at->gte($currentWeek) && $att->created_at->lte($weekEnd);
                });
                
                $weeklyData[] = [
                    'week' => 'Week ' . $currentWeek->weekOfMonth,
                    'present' => $weekAttendances->where('status', 'present')->count(),
                    'absent' => $weekAttendances->where('status', 'absent')->count(),
                    'recorded' => $weekAttendances->count(),
                ];
                
                $currentWeek->addWeek();
            }
            
            // Prepare calendar data (use all attendances)
            $calendarData = [];
            $currentDate = $startDate->copy()->startOfMonth();
            $endOfMonth = $startDate->copy()->endOfMonth();
            
            while ($currentDate->lte($endOfMonth)) {
                $dayAttendances = $allAttendances->filter(function($att) use ($currentDate) {
                    return $att->created_at->format('Y-m-d') === $currentDate->format('Y-m-d');
                });
                
                $status = null;
                if ($dayAttendances->count() > 0) {
                    $firstAttendance = $dayAttendances->first();
                    $status = $firstAttendance->status;
                }
                
                $calendarData[] = [
                    'date' => $currentDate->format('Y-m-d'),
                    'day' => $currentDate->day,
                    'status' => $status,
                ];
                
                $currentDate->addDay();
            }
            
            // Get years and months for dropdowns
            $years = range(date('Y') - 2, date('Y') + 1);
            $months = [
                '01' => 'January', '02' => 'February', '03' => 'March', '04' => 'April',
                '05' => 'May', '06' => 'June', '07' => 'July', '08' => 'August',
                '09' => 'September', '10' => 'October', '11' => 'November', '12' => 'December'
            ];
            
            return view('student.attendance', compact(
                'student',
                'enrolledCourses',
                'attendances',
                'allAttendances',
                'recorded',
                'presentDays',
                'absentDays',
                'attendancePercentage',
                'weeklyData',
                'calendarData',
                'courseFilter',
                'year',
                'month',
                'dateRange',
                'startDate',
                'endDate',
                'years',
                'months',
                'page',
                'hasMore',
                'perPage'
            ));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'attendance']);
            return redirect()->back()->with('error', 'An error occurred while loading attendance.');
        }
    }

    public function recordedCourses(Request $request)
    {
        try {
            $student = Auth::user();
            $search = $request->get('search', '');
            
            // Get enrolled courses with videos
            $enrollments = Enrollment::where('student_id', $student->id)
                ->with(['course.videos' => function($query) {
                    $query->orderBy('order', 'asc');
                }])
                ->get();
            
            $courses = $enrollments->map(function($enrollment) {
                $course = $enrollment->course;
                if ($course) {
                    $videos = $course->videos ?? collect([]);
                    $totalVideos = $videos->count();
                    $totalDuration = $videos->sum('duration_minutes') * 60; // Convert minutes to seconds
                    $totalHours = floor($totalDuration / 3600);
                    $totalMinutes = floor(($totalDuration % 3600) / 60);
                    
                    // Calculate progress dynamically
                    $completedVideos = 0;
                    if (Schema::hasTable('video_progress')) {
                        $completedVideos = DB::table('video_progress')
                            ->where('student_id', Auth::id())
                            ->whereIn('video_id', $videos->pluck('id'))
                            ->where('completed', true)
                            ->count();
                    }
                    
                    $progress = 0;
                    if ($totalVideos > 0) {
                        $progress = round(($completedVideos / $totalVideos) * 100, 0);
                    }
                    
                    return [
                        'id' => $course->id,
                        'title' => $course->title,
                        'description' => $course->description,
                        'thumbnail' => $course->thumbnail,
                        'total_videos' => $totalVideos,
                        'total_duration' => $totalHours . 'h ' . $totalMinutes . 'm',
                        'total_duration_seconds' => $totalDuration,
                        'completed_videos' => $completedVideos,
                        'progress' => $progress,
                        'videos' => $videos,
                        'enrollment' => $enrollment,
                    ];
                }
                return null;
            })->filter()->values();
            
            // Filter by search
            if ($search) {
                $courses = $courses->filter(function($course) use ($search) {
                    return stripos($course['title'], $search) !== false;
                })->values();
            }
            
            return view('student.recorded-courses', compact('courses', 'search', 'student'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'recorded_courses']);
            return redirect()->back()->with('error', 'An error occurred while loading recorded courses.');
        }
    }
    
    public function getCourseDetails($courseId)
    {
        try {
            $student = Auth::user();
            
            // Verify student is enrolled
            $enrollment = Enrollment::where('student_id', $student->id)
                ->where('course_id', $courseId)
                ->firstOrFail();
            
            $course = $enrollment->course;
            $videos = $course->videos()->orderBy('order', 'asc')->get();
            
            // Get completion status for each video
            $completedVideoIds = collect([]);
            if (Schema::hasTable('video_progress')) {
                $completedVideoIds = DB::table('video_progress')
                    ->where('student_id', $student->id)
                    ->whereIn('video_id', $videos->pluck('id'))
                    ->where('completed', true)
                    ->pluck('video_id');
            }
            
            $totalVideos = $videos->count();
            $completedCount = $completedVideoIds->count();
            $totalDuration = $videos->sum('duration_minutes') * 60; // Convert minutes to seconds
            $totalHours = floor($totalDuration / 3600);
            $totalMinutes = floor(($totalDuration % 3600) / 60);
            
            // Calculate progress dynamically
            $progress = 0;
            if ($totalVideos > 0) {
                $progress = round(($completedCount / $totalVideos) * 100, 0);
            }
            
            $videosWithStatus = $videos->map(function($video) use ($completedVideoIds) {
                $durationSeconds = ($video->duration_minutes ?? 0) * 60;
                return [
                    'id' => $video->id,
                    'encrypted_id' => EncryptionHelper::encryptIdForUrl($video->id),
                    'title' => $video->title,
                    'description' => $video->description,
                    'duration' => $durationSeconds,
                    'duration_formatted' => $this->formatDuration($durationSeconds),
                    'order' => $video->order,
                    'completed' => $completedVideoIds->contains($video->id),
                ];
            });
            
            return response()->json([
                'success' => true,
                'course' => [
                    'id' => $course->id,
                    'title' => $course->title,
                    'description' => $course->description,
                    'total_videos' => $totalVideos,
                    'total_duration' => $totalHours . 'h ' . str_pad($totalMinutes, 2, '0', STR_PAD_LEFT) . 'm',
                    'completed_count' => $completedCount,
                    'progress' => $progress,
                    'videos' => $videosWithStatus,
                ]
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'get_course_details', 'course_id' => $courseId]);
            return response()->json([
                'success' => false,
                'message' => 'Error loading course details.'
            ], 500);
        }
    }
    
    private function formatDuration($seconds)
    {
        $hours = floor($seconds / 3600);
        $minutes = floor(($seconds % 3600) / 60);
        $secs = $seconds % 60;
        
        if ($hours > 0) {
            return sprintf('%d:%02d:%02d', $hours, $minutes, $secs);
        }
        return sprintf('%d:%02d', $minutes, $secs);
    }

    public function support()
    {
        try {
            $student = Auth::user();
            return view('student.support', compact('student'));
        } catch (\Exception $e) {
            \Log::error('Student Support Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading support.');
        }
    }

    public function watchVideo($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return redirect()->route('student.enroll-courses')->with('error', 'Invalid video ID.');
        }
        
        try {
            $student = Auth::user();
            
            // Get video and check if student is enrolled in the course
            $video = Video::with('course', 'batch', 'trainer')
                ->findOrFail($id);
            
            // Check if student is enrolled in this course
            $enrollment = Enrollment::where('student_id', $student->id)
                ->where('course_id', $video->course_id)
                ->first();
            
            if (!$enrollment) {
                return redirect()->route('student.enroll-courses')->with('error', 'You are not enrolled in this course.');
            }
            
            // Increment video views
            $video->increment('views');
            
            // Get all videos from the same course for playlist
            $courseVideos = Video::where('course_id', $video->course_id)
                ->where('status', 'active')
                ->orderBy('order', 'asc')
                ->orderBy('created_at', 'asc')
                ->get();
            
            // Calculate progress (completed videos / total videos)
            $totalVideos = $courseVideos->count();
            
            // Get completed videos count (you can implement video_progress table later)
            $completedVideos = 0;
            try {
                if (\Schema::hasTable('video_progress')) {
                    $completedVideos = \DB::table('video_progress')
                        ->where('student_id', $student->id)
                        ->whereIn('video_id', $courseVideos->pluck('id'))
                        ->where('completed', true)
                        ->count();
                }
            } catch (\Exception $e) {
                // Table doesn't exist, use default
            }
            
            $progress = $totalVideos > 0 ? round(($completedVideos / $totalVideos) * 100) : 0;
            
            // Check if current video is completed
            $isCompleted = false;
            try {
                if (\Schema::hasTable('video_progress')) {
                    $isCompleted = \DB::table('video_progress')
                        ->where('student_id', $student->id)
                        ->where('video_id', $video->id)
                        ->where('completed', true)
                        ->exists();
                }
            } catch (\Exception $e) {
                // Table doesn't exist
            }
            
            // Get current video index for determining locked status
            $currentIndex = $courseVideos->search(function($item) use ($video) {
                return $item->id === $video->id;
            });
            
            return view('student.watch-video', compact('video', 'courseVideos', 'totalVideos', 'completedVideos', 'progress', 'isCompleted', 'currentIndex', 'enrollment'));
        } catch (\Exception $e) {
            Log::error('Error fetching video for student watch: ' . $e->getMessage());
            return redirect()->route('student.enroll-courses')->with('error', 'Video not found.');
        }
    }

    public function markVideoCompleted($encryptedId)
    {
        try {
            $id = EncryptionHelper::decryptIdFromUrl($encryptedId);
        } catch (\Exception $e) {
            return response()->json(['success' => false, 'message' => 'Invalid video ID'], 400);
        }
        
        try {
            $student = Auth::user();
            $video = Video::findOrFail($id);
            
            // Check enrollment
            $enrollment = Enrollment::where('student_id', $student->id)
                ->where('course_id', $video->course_id)
                ->first();
            
            if (!$enrollment) {
                return response()->json(['success' => false, 'message' => 'Not enrolled'], 403);
            }
            
            // Mark video as completed (create or update video_progress table entry)
            try {
                if (\Schema::hasTable('video_progress')) {
                    \DB::table('video_progress')->updateOrInsert(
                        [
                            'student_id' => $student->id,
                            'video_id' => $video->id
                        ],
                        [
                            'completed' => true,
                            'progress_percentage' => 100,
                            'updated_at' => now()
                        ]
                    );
                }
            } catch (\Exception $e) {
                // Table doesn't exist, that's okay
            }
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            Log::error('Error marking video as completed: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error occurred'], 500);
        }
    }
}
