<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\Satsang;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SatsangController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $satsangs = Satsang::where('trainer_id', $trainer->id)
            ->orderBy('scheduled_at', 'desc')
            ->get();
        
        return view('trainer.satsangs', compact('satsangs'));
    }

    public function create()
    {
        return view('trainer.create-satsang');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'visibility' => 'required|in:private,unlisted,public',
            'scheduled_at' => 'required|date',
            'time' => 'required|date_format:H:i',
            'timezone' => 'required|string',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'create_playlist' => 'nullable|boolean',
            'meeting_link' => 'nullable|url',
        ]);

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail');
            $thumbnailName = time() . '_' . $thumbnail->getClientOriginalName();
            $thumbnail->move(public_path('uploads/satsangs'), $thumbnailName);
            $validated['thumbnail'] = 'uploads/satsangs/' . $thumbnailName;
        }

        // Combine date and time if they come separately
        if (isset($validated['scheduled_at']) && isset($validated['time'])) {
            $scheduledDateTime = $validated['scheduled_at'] . ' ' . $validated['time'];
            $validated['scheduled_at'] = $scheduledDateTime;
        }
        
        $validated['trainer_id'] = Auth::id();
        $validated['status'] = 'scheduled';
        $validated['create_playlist'] = $request->has('create_playlist') ? true : false;

        $satsang = Satsang::create($validated);

        \App\Models\ActivityLog::log('created', $satsang, 'Satsang scheduled: ' . $satsang->title);

        return response()->json([
            'success' => true,
            'message' => 'Career Satsang scheduled successfully!',
            'satsang' => $satsang
        ]);
    }
}
