<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HiringApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Helpers\LogHelper;

class HiringController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobs')->orderBy('created_at', 'desc')->get();
        
        // Get application counts for each job
        $jobsWithCounts = $jobs->map(function($job) {
            $job->application_count = HiringApplication::where('position', $job->job_title)->count();
            return $job;
        });
        
        return view('admin.hiring.index', compact('jobsWithCounts'));
    }
    
    /**
     * Get job details for modal
     */
    public function getJobDetails($id)
    {
        try {
            $job = DB::table('jobs')->where('id', $id)->first();
            
            if (!$job) {
                return response()->json([
                    'success' => false,
                    'message' => 'Job not found.'
                ], 404);
            }
            
            // Get applications for this job
            $applications = HiringApplication::where('position', $job->job_title)
                ->with('trainer')
                ->orderBy('created_at', 'desc')
                ->get();
            
            return response()->json([
                'success' => true,
                'job' => $job,
                'applications' => $applications,
                'application_count' => $applications->count(),
            ]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'get_job_details']);
            return response()->json([
                'success' => false,
                'message' => 'Error loading job details.'
            ], 500);
        }
    }

    public function create()
    {
        return view('admin.hiring.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'job_title' => 'required|string|max:255',
            'job_location' => 'required|string|max:255',
            'salary_range' => 'required|string|max:255',
            'category' => 'required|string|max:255',
            'job_description' => 'nullable|string',
        ]);

        DB::table('jobs')->insert([
            'job_title' => $validated['job_title'],
            'job_location' => $validated['job_location'],
            'salary_range' => $validated['salary_range'],
            'category' => $validated['category'],
            'job_description' => $validated['job_description'] ?? null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        \App\Models\ActivityLog::log('created', null, 'Job posted: ' . $validated['job_title']);

        return redirect()->route('admin.hiring.index')->with('success', 'Job posted successfully!');
    }

    public function destroy($id)
    {
        try {
            $job = DB::table('jobs')->where('id', $id)->first();
            $jobTitle = $job->job_title ?? 'Unknown';
            
            DB::table('jobs')->where('id', $id)->delete();
            
            \App\Models\ActivityLog::log('deleted', null, "Job deleted: {$jobTitle}");

            return redirect()->route('admin.hiring.index')->with('success', 'Job deleted successfully!');
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'delete_job']);
            return redirect()->back()->with('error', 'Error deleting job.');
        }
    }
}
