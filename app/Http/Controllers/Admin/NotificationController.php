<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = AdminNotification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->orderBy('created_at', 'desc')
            ->paginate(20);
        
        return view('admin.notifications.index', compact('notifications'));
    }

    public function show($id)
    {
        $notification = AdminNotification::findOrFail($id);
        
        if (!$notification->is_read) {
            $notification->update(['is_read' => true]);
        }
        
        return view('admin.notifications.show', compact('notification'));
    }

    public function markAsRead($id)
    {
        $notification = AdminNotification::findOrFail($id);
        $notification->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function markAllAsRead()
    {
        AdminNotification::where('user_id', Auth::id())
            ->orWhereNull('user_id')
            ->update(['is_read' => true]);
        
        return response()->json(['success' => true]);
    }

    public function getUnreadCount()
    {
        $count = AdminNotification::where(function($query) {
            $query->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
        })->where('is_read', false)->count();
        
        return response()->json(['count' => $count]);
    }

    public function getRecent()
    {
        $notifications = AdminNotification::where(function($query) {
            $query->where('user_id', Auth::id())
                  ->orWhereNull('user_id');
        })->orderBy('created_at', 'desc')
          ->limit(5)
          ->get();
        
        return response()->json($notifications);
    }
}
