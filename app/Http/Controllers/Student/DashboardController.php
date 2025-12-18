<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Enrollment;
use App\Models\Certificate;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $student = Auth::user();
        $enrolledCourses = Enrollment::where('student_id', $student->id)->count();
        $completedCourses = Enrollment::where('student_id', $student->id)
            ->where('status', 'completed')
            ->count();
        $certificates = Certificate::where('student_id', $student->id)->count();
        
        return view('student.dashboard', compact(
            'enrolledCourses',
            'completedCourses',
            'certificates'
        ));
    }
}
