<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Batch;
use App\Models\LiveClass;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        
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
        
        $uploadedVideos = \App\Models\Video::where('trainer_id', $trainer->id)->count();
        
        return view('trainer.dashboard', compact(
            'assignedCourses',
            'activeBatches',
            'upcomingClasses',
            'uploadedVideos'
        ));
    }
}
