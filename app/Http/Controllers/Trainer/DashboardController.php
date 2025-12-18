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
        
        // Get assigned courses count
        $assignedCourses = DB::table('course_trainer')
            ->where('trainer_id', $trainer->id)
            ->count();
        
        // Get active batches count - simplified for now
        $activeBatches = Batch::where('status', 'active')->count();
        
        // Get upcoming classes count
        $upcomingClasses = LiveClass::where('trainer_id', $trainer->id)
            ->where('status', 'scheduled')
            ->where('scheduled_at', '>', now())
            ->count();
        
        return view('trainer.dashboard', compact(
            'assignedCourses',
            'activeBatches',
            'upcomingClasses'
        ));
    }
}
