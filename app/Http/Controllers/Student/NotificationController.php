<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        try {
            $student = Auth::user();
            $notifications = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->orderBy('created_at', 'desc')
              ->get();
            
            return view('student.notifications', compact('notifications'));
        } catch (\Exception $e) {
            \Log::error('Student Notifications Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading notifications.');
        }
    }

    public function getUnreadCount()
    {
        try {
            $student = Auth::user();
            $count = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->where('is_read', false)->count();
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            return response()->json(['count' => 0]);
        }
    }

    public function getRecent()
    {
        try {
            $student = Auth::user();
            $notifications = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->orderBy('created_at', 'desc')
              ->limit(10)
              ->get()
              ->map(function($notification) {
                  return [
                      'id' => $notification->id,
                      'title' => $notification->title,
                      'message' => $notification->message,
                      'type' => $notification->type,
                      'is_read' => $notification->is_read,
                      'created_at' => $notification->created_at->diffForHumans(),
                      'link' => $notification->link,
                  ];
              });
            
            return response()->json($notifications);
        } catch (\Exception $e) {
            return response()->json([]);
        }
    }

    public function markAsRead($id)
    {
        try {
            $student = Auth::user();
            $notification = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)->orWhereNull('user_id');
            })->findOrFail($id);
            
            $notification->update(['is_read' => true]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $student = Auth::user();
            AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)->orWhereNull('user_id');
            })->update(['is_read' => true]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            return response()->json(['success' => false], 500);
        }
    }
}
