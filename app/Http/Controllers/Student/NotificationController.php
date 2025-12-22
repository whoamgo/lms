<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Helpers\LogHelper;

class NotificationController extends Controller
{
    public function index(Request $request)
    {
        try {
            $student = Auth::user();
            
            // Validate user is authenticated and is a student
            if (!$student || $student->role !== 'student') {
                return redirect()->route('student.login')->with('error', 'Please login to view notifications.');
            }
            
            // Get all notifications
            $allNotifications = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->orderBy('created_at', 'desc')
              ->get();
            
            // Default show 3, with option to show all
            $showAll = $request->get('show_all', false);
            $notifications = $showAll ? $allNotifications : $allNotifications->take(3);
            $hasMore = $allNotifications->count() > 3;
            
            return view('student.notifications', compact('notifications', 'allNotifications', 'hasMore', 'showAll'));
        } catch (\Exception $e) {
            \App\Helpers\LogHelper::exception($e, 'student', ['action' => 'notifications_index']);
            return redirect()->back()->with('error', 'An error occurred while loading notifications.');
        }
    }

    public function getUnreadCount()
    {
        try {
            $student = Auth::user();
            
            if (!$student || $student->role !== 'student') {
                return response()->json(['count' => 0]);
            }
            
            $count = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->where('is_read', false)->count();
            
            return response()->json(['count' => $count]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'get_unread_count']);
            return response()->json(['count' => 0]);
        }
    }

    public function getRecent()
    {
        try {
            $student = Auth::user();
            
            if (!$student || $student->role !== 'student') {
                return response()->json([]);
            }
            
            $notifications = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)
                      ->orWhereNull('user_id');
            })->orderBy('created_at', 'desc')
              ->limit(10)
              ->get()
              ->map(function($notification) {
                  return [
                      'id' => $notification->id,
                      'title' => htmlspecialchars($notification->title, ENT_QUOTES, 'UTF-8'),
                      'message' => htmlspecialchars($notification->message, ENT_QUOTES, 'UTF-8'),
                      'type' => $notification->type,
                      'is_read' => $notification->is_read,
                      'created_at' => $notification->created_at->diffForHumans(),
                      'link' => $notification->link,
                  ];
              });
            
            return response()->json($notifications);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'get_recent_notifications']);
            return response()->json([]);
        }
    }

    public function markAsRead($id)
    {
        try {
            $student = Auth::user();
            
            // Validate user is authenticated and is a student
            if (!$student || $student->role !== 'student') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            // Validate ID is numeric
            if (!is_numeric($id)) {
                return response()->json(['success' => false, 'message' => 'Invalid notification ID'], 400);
            }
            
            $notification = AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)->orWhereNull('user_id');
            })->findOrFail($id);
            
            $notification->update(['is_read' => true]);
            
            return response()->json(['success' => true]);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            LogHelper::exception($e, 'student', ['action' => 'mark_as_read', 'notification_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'mark_as_read', 'notification_id' => $id]);
            return response()->json(['success' => false, 'message' => 'Error occurred'], 500);
        }
    }

    public function markAllAsRead()
    {
        try {
            $student = Auth::user();
            
            // Validate user is authenticated and is a student
            if (!$student || $student->role !== 'student') {
                return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
            }
            
            AdminNotification::where(function($query) use ($student) {
                $query->where('user_id', $student->id)->orWhereNull('user_id');
            })->update(['is_read' => true]);
            
            return response()->json(['success' => true]);
        } catch (\Exception $e) {
            LogHelper::exception($e, 'student', ['action' => 'mark_all_as_read']);
            return response()->json(['success' => false, 'message' => 'Error occurred'], 500);
        }
    }
}
