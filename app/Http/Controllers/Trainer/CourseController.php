<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CourseController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $courses = $trainer->assignedCourses()->with('batches', 'enrollments')->get();
        
        return view('trainer.courses', compact('courses'));
    }
}

