<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        $notifications = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)
                  ->orWhereNull('user_id');
        })->orderBy('created_at', 'desc')
          ->get();
        
        // Calculate counts by type
        $newEnrollments = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->where('type', 'enrollment')->where('is_read', false)->count();
        
        $newComments = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->where('type', 'comment')->where('is_read', false)->count();
        
        $videoUpdates = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->where('type', 'video')->where('is_read', false)->count();
        
        $systemAlerts = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->where('type', 'system')->where('is_read', false)->count();
        
        return view('trainer.notifications', compact('notifications', 'newEnrollments', 'newComments', 'videoUpdates', 'systemAlerts'));
    }

    public function getUnreadCount()
    {
        $trainer = Auth::user();
        $count = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)
                  ->orWhereNull('user_id');
        })->where('is_read', false)->count();
        
        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $trainer = Auth::user();
        $notifications = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)
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
                  'created_at_raw' => $notification->created_at->format('Y-m-d H:i:s'),
              ];
          });
        
        return response()->json($notifications);
    }

    public function markAsRead($id)
    {
        $trainer = Auth::user();
        $notification = AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->findOrFail($id);
        
        $notification->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        $trainer = Auth::user();
        AdminNotification::where(function($query) use ($trainer) {
            $query->where('user_id', $trainer->id)->orWhereNull('user_id');
        })->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }
}
