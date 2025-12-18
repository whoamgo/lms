<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunityQuery;
use App\Models\User;
use Illuminate\Http\Request;

class CommunityQueryController extends Controller
{
    public function index(Request $request)
    {
        $query = CommunityQuery::with(['student', 'assignedTrainer', 'course']);
        
        if ($request->has('status')) {
            $query->where('status', $request->status);
        }
        
        $queries = $query->orderBy('created_at', 'desc')->paginate(15);
        $trainers = User::where('role', 'trainer')->get();
        
        return view('admin.community-queries.index', compact('queries', 'trainers'));
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
