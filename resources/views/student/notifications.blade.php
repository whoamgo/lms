@extends('layouts.student')

@section('title', 'Notifications')

@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}">Home</a> / Notifications
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-banner-content">
        <div class="profile-avatar welcome-banner-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" class="icon-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>Student</p>
        </div>
    </div>
</div>

<!-- Notifications Page -->
<div class="notifications-page-container">
    <div class="notifications-header">
        <h2 class="notifications-page-title">Notifications</h2>
        <button class="btn btn-purple" onclick="markAllAsRead()" id="markAllReadPageBtn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            Mark All as Read
        </button>
    </div>
    
    <div class="notifications-stats">
        <div class="notification-stat-card">
            <div class="notification-stat-value">{{ isset($allNotifications) ? $allNotifications->where('is_read', false)->count() : $notifications->where('is_read', false)->count() }}</div>
            <div class="notification-stat-label">Unread</div>
        </div>
        <div class="notification-stat-card">
            <div class="notification-stat-value">{{ isset($allNotifications) ? $allNotifications->where('is_read', true)->count() : $notifications->where('is_read', true)->count() }}</div>
            <div class="notification-stat-label">Read</div>
        </div>
        <div class="notification-stat-card">
            <div class="notification-stat-value">{{ isset($allNotifications) ? $allNotifications->count() : $notifications->count() }}</div>
            <div class="notification-stat-label">Total</div>
        </div>
    </div>
    
    <div class="notifications-list">
        @forelse($notifications as $notification)
            <div class="notification-list-item {{ !$notification->is_read ? 'unread' : '' }}" 
                 data-notification-id="{{ $notification->id }}"
                 @if($notification->link) onclick="window.location.href='{{ $notification->link }}'" @endif>
                <div class="notification-list-avatar">
                    {{ strtoupper(substr($notification->title, 0, 1)) }}
                </div>
                <div class="notification-list-content">
                    <div class="notification-list-header">
                        <h4 class="notification-list-title">{{ $notification->title }}</h4>
                        @if(!$notification->is_read)
                            <span class="notification-unread-dot"></span>
                        @endif
                    </div>
                    <p class="notification-list-message">{{ $notification->message }}</p>
                    <div class="notification-list-footer">
                        <span class="notification-list-time">{{ $notification->created_at->diffForHumans() }}</span>
                        <span class="notification-list-type badge-{{ $notification->type ?? 'info' }}">{{ ucfirst($notification->type ?? 'info') }}</span>
                    </div>
                </div>
                @if(!$notification->is_read)
                    <button class="notification-mark-read-btn" onclick="event.stopPropagation(); markAsRead({{ $notification->id }})">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </button>
                @endif
            </div>
        @empty
            <div class="notifications-empty">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                </svg>
                <p class="notifications-empty-text">No notifications found.</p>
            </div>
        @endforelse
        
        @if(isset($hasMore) && $hasMore && !$showAll)
            <div style="text-align: center; margin-top: 24px;">
                <a href="{{ route('student.notifications.index', ['show_all' => true]) }}" class="btn btn-purple">
                    View More ({{ $allNotifications->count() - 3 }} more)
                </a>
            </div>
        @endif
    </div>
</div>
@endsection

@push('styles')
<style>
/* Notifications Page Styles */
.notifications-page-container {
    margin-top: 32px;
}

.notifications-header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 24px;
}

.notifications-page-title {
    font-size: 1.5rem;
    font-weight: 600;
    color: #343541;
    margin: 0;
}

.notifications-stats {
    display: grid;
    grid-template-columns: repeat(3, 1fr);
    gap: 16px;
    margin-bottom: 32px;
}

.notification-stat-card {
    background: white;
    border-radius: 12px;
    padding: 24px;
    text-align: center;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.notification-stat-value {
    font-size: 2rem;
    font-weight: 700;
    color: #343541;
    margin-bottom: 8px;
}

.notification-stat-label {
    font-size: 0.875rem;
    color: #6b7280;
}

.notifications-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.notification-list-item {
    background: white;
    border-radius: 12px;
    padding: 20px;
    display: flex;
    gap: 16px;
    align-items: flex-start;
    cursor: pointer;
    transition: all 0.2s;
    border: 2px solid transparent;
    position: relative;
}

.notification-list-item:hover {
    border-color: #9333ea;
    box-shadow: 0 4px 12px rgba(147, 51, 234, 0.1);
}

.notification-list-item.unread {
    background: #eff6ff;
    border-color: #2563eb;
}

.notification-list-avatar {
    width: 48px;
    height: 48px;
    border-radius: 50%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
    font-weight: 600;
    font-size: 1.25rem;
    flex-shrink: 0;
}

.notification-list-content {
    flex: 1;
    min-width: 0;
}

.notification-list-header {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-bottom: 8px;
}

.notification-list-title {
    font-size: 1rem;
    font-weight: 600;
    color: #343541;
    margin: 0;
}

.notification-unread-dot {
    width: 8px;
    height: 8px;
    background: #2563eb;
    border-radius: 50%;
    flex-shrink: 0;
}

.notification-list-message {
    font-size: 0.875rem;
    color: #6b7280;
    margin: 0 0 12px 0;
    line-height: 1.5;
}

.notification-list-footer {
    display: flex;
    align-items: center;
    gap: 16px;
}

.notification-list-time {
    font-size: 0.75rem;
    color: #9ca3af;
}

.notification-list-type {
    padding: 4px 12px;
    border-radius: 12px;
    font-size: 0.75rem;
    font-weight: 500;
}

.badge-info {
    background: #dbeafe;
    color: #1e40af;
}

.badge-success {
    background: #d1fae5;
    color: #065f46;
}

.badge-warning {
    background: #fef3c7;
    color: #92400e;
}

.badge-error {
    background: #fee2e2;
    color: #991b1b;
}

.notification-mark-read-btn {
    background: #f3f4f6;
    border: none;
    border-radius: 6px;
    padding: 8px;
    cursor: pointer;
    color: #6b7280;
    transition: all 0.2s;
    flex-shrink: 0;
}

.notification-mark-read-btn:hover {
    background: #e5e7eb;
    color: #2563eb;
}

.notifications-empty {
    text-align: center;
    padding: 80px 20px;
    background: white;
    border-radius: 12px;
}

.notifications-empty-text {
    color: #6b7280;
    font-size: 1rem;
    margin: 0;
}

@media (max-width: 768px) {
    .notifications-header {
        flex-direction: column;
        gap: 16px;
        align-items: flex-start;
    }
    
    .notifications-stats {
        grid-template-columns: 1fr;
    }
    
    .notification-list-item {
        padding: 16px;
    }
    
    .notification-list-header {
        flex-wrap: wrap;
    }
}
</style>
@endpush

@push('scripts')
<script>
function markAsRead(notificationId) {
    fetch(`{{ url('/student/notifications') }}/${notificationId}/read`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const item = document.querySelector(`[data-notification-id="${notificationId}"]`);
            if (item) {
                item.classList.remove('unread');
                const markBtn = item.querySelector('.notification-mark-read-btn');
                if (markBtn) {
                    markBtn.remove();
                }
                const dot = item.querySelector('.notification-unread-dot');
                if (dot) {
                    dot.remove();
                }
            }
            // Reload notification counts
            if (typeof loadNotificationCount === 'function') {
                loadNotificationCount();
            }
        }
    })
    .catch(error => {
        console.error('Error marking notification as read:', error);
    });
}

function markAllAsRead() {
    const btn = document.getElementById('markAllReadPageBtn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Marking...';
    }
    
    fetch('{{ route("student.notifications.mark-all-read") }}', {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove unread styling from all items
            document.querySelectorAll('.notification-list-item.unread').forEach(item => {
                item.classList.remove('unread');
                const markBtn = item.querySelector('.notification-mark-read-btn');
                if (markBtn) {
                    markBtn.remove();
                }
                const dot = item.querySelector('.notification-unread-dot');
                if (dot) {
                    dot.remove();
                }
            });
            
            // Reload notification counts
            if (typeof loadNotificationCount === 'function') {
                loadNotificationCount();
            }
            
            // Reload page to update stats
            setTimeout(() => {
                window.location.reload();
            }, 500);
        }
    })
    .catch(error => {
        console.error('Error marking all as read:', error);
    })
    .finally(() => {
        if (btn) {
            btn.disabled = false;
            btn.innerHTML = '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Mark All as Read';
        }
    });
}
</script>
@endpush

