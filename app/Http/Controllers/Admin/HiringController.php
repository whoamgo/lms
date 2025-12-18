<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HiringController extends Controller
{
    public function index()
    {
        $jobs = DB::table('jobs')->orderBy('created_at', 'desc')->paginate(15);
        return view('admin.hiring.index', compact('jobs'));
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
        $job = DB::table('jobs')->where('id', $id)->first();
        DB::table('jobs')->where('id', $id)->delete();
        
        \App\Models\ActivityLog::log('deleted', null, 'Job deleted: ' . ($job->job_title ?? 'Unknown'));

        return redirect()->route('admin.hiring.index')->with('success', 'Job deleted successfully!');
    }
}
