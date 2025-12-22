<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityQuery;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use App\Helpers\LogHelper;
use App\Helpers\NotificationHelper;
use App\Exports\CommunityQueriesExport;
use Maatwebsite\Excel\Facades\Excel;

class CommunityQueryController extends Controller
{
    public function index(Request $request)
    {
        try {
            $cacheKey = 'admin_community_queries_' . md5(json_encode($request->all()));
            
            $data = Cache::remember($cacheKey, 300, function () {
                $queries = CommunityQuery::with(['student', 'assignedTrainer', 'course'])
                    ->orderBy('created_at', 'desc')
                    ->get();
                $trainers = User::where('role', 'trainer')->get();
                
                return compact('queries', 'trainers');
            });
            
            return view('admin.community-queries.index', $data);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'community_queries_index']);
            return redirect()->back()->with('error', 'Error loading community queries.');
        }
    }
    
    /**
     * Export community queries to Excel
     */
    public function export(Request $request)
    {
        try {
            $startDate = $request->input('start_date');
            $endDate = $request->input('end_date');
            
            $fileName = 'community_queries_' . date('Y-m-d_His') . '.xlsx';
            
            return Excel::download(
                new CommunityQueriesExport($startDate, $endDate),
                $fileName
            );
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'export_community_queries']);
            return redirect()->back()->with('error', 'Error exporting community queries.');
        }
    }

    public function assignTrainer(Request $request, $id)
    {
        $validated = $request->validate([
            'trainer_id' => 'required|exists:users,id',
        ]);

        $query = CommunityQuery::findOrFail($id);
        $query->update([
            'assigned_trainer_id' => $validated['trainer_id'],
            'status' => 'assigned',
        ]);

        \App\Models\ActivityLog::log('updated', $query, 'Trainer assigned to query: ' . $query->subject);
        
        // Send notification to trainer
        $trainer = User::find($validated['trainer_id']);
        $course = $query->course;
        if ($trainer && $course) {
            NotificationHelper::trainerCommunityQuery($trainer->id, $course->title);
        }

        return redirect()->back()->with('success', 'Trainer assigned successfully!');
    }

    public function reply(Request $request, $id)
    {
        $validated = $request->validate([
            'answer' => 'required|string',
        ]);

        $query = CommunityQuery::findOrFail($id);
        $query->update([
            'answer' => $validated['answer'],
            'status' => 'resolved',
        ]);

        \App\Models\ActivityLog::log('updated', $query, 'Query replied: ' . $query->subject);

        return redirect()->back()->with('success', 'Reply sent successfully!');
    }

    public function close($id)
    {
        $query = CommunityQuery::findOrFail($id);
        $query->update(['status' => 'closed']);

        \App\Models\ActivityLog::log('updated', $query, 'Query closed: ' . $query->subject);

        return redirect()->back()->with('success', 'Query closed successfully!');
    }
}
