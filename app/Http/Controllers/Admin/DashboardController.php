<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\CommunityQuery;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalStudents = User::where('role', 'student')->count();
        $activeCourses = Course::where('status', 'active')->count();
        $totalEnrollments = Enrollment::count();
        $totalTrainers = User::where('role', 'trainer')->count();
        $pendingQueries = CommunityQuery::where('status', 'open')->count();
        
        return view('admin.dashboard', compact(
            'totalStudents',
            'activeCourses',
            'totalEnrollments',
            'totalTrainers',
            'pendingQueries'
        ));
    }
}
