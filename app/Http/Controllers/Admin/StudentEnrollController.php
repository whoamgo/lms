<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class StudentEnrollController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'student')->withCount(['enrollments', 'completedEnrollments']);
        
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%");
            });
        }
        
        $students = $query->paginate(15);
        
        $totalStudents = User::where('role', 'student')->count();
        $activeStudents = User::where('role', 'student')->where('status', 'active')->count();
        $newThisMonth = User::where('role', 'student')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        
        return view('admin.student-enroll.index', compact('students', 'totalStudents', 'activeStudents', 'newThisMonth'));
    }

    public function toggleStatus($id)
    {
        $student = User::where('role', 'student')->findOrFail($id);
        $student->update([
            'status' => $student->status === 'active' ? 'inactive' : 'active'
        ]);
        
        \App\Models\ActivityLog::log('updated', $student, 'Student status changed to: ' . $student->status);

        return redirect()->back()->with('success', 'Student status updated successfully!');
    }
}
