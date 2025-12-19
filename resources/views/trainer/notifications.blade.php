@extends('layouts.trainer')

@section('title', 'Notifications')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Notifications
@endsection

@section('content')
<div class="profile-banner">
    <div class="profile-banner-gradient"></div>
    <div class="profile-banner-content">
        <div class="profile-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>Trainer</p>
        </div>
    </div>
</div>

<p class="notification-info-text">Stay updated with your all latest Course Activities, student instructions, and system alerts.</p>

<!-- Notification Summary Cards -->
<div class="stats-grid">
    <div class="stat-card" style="background: linear-gradient(135deg, #10b981 0%, #059669 100%);">
        <h3>New Student Enrolment</h3>
        <div class="value">{{ $newEnrollments }}</div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%);">
        <h3>New Comments / Questions</h3>
        <div class="value">{{ $newComments }}</div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%);">
        <h3>Video Upload Update</h3>
        <div class="value">{{ $videoUpdates }}</div>
    </div>
    
    <div class="stat-card" style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%);">
        <h3>System / Platform Alerts</h3>
        <div class="value">{{ $systemAlerts }}</div>
    </div>
</div>

<!-- Filters -->
<div class="search-filter-bar">
    <select class="filter-select" id="filterBy">
        <option value="all">Filter By Course / Student / System</option>
        <option value="enrollment">Student Enrolment</option>
        <option value="comment">Comments / Questions</option>
        <option value="video">Video Updates</option>
        <option value="system">System Alerts</option>
    </select>
    <select class="filter-select" id="filterTime">
        <option value="all">All this month</option>
        <option value="today">Today</option>
        <option value="week">This Week</option>
        <option value="month">This Month</option>
    </select>
    <select class="filter-select" id="filterStatus">
        <option value="all">--Filter--</option>
        <option value="unread">Unread</option>
        <option value="read">Read</option>
    </select>
    <button class="btn btn-danger" id="markAllReadBtnPage">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Mark all as read
    </button>
</div>

<!-- Notifications List -->
<div class="card" style="padding: 0;">
    <div class="notifications-list">
        @forelse($notifications as $notification)
        <div class="notification-item-list {{ !$notification->is_read ? 'unread' : '' }}" data-id="{{ $notification->id }}" data-type="{{ $notification->type }}">
            <div class="notification-avatar" style="background: {{ $notification->type === 'enrollment' ? 'linear-gradient(135deg, #10b981 0%, #059669 100%)' : ($notification->type === 'comment' ? 'linear-gradient(135deg, #9333ea 0%, #7e22ce 100%)' : ($notification->type === 'video' ? 'linear-gradient(135deg, #ec4899 0%, #db2777 100%)' : 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)')) }};">
                @if($notification->type === 'enrollment')
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                @elseif($notification->type === 'comment')
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path>
                    </svg>
                @elseif($notification->type === 'video')
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                @else
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path>
                    </svg>
                @endif
            </div>
            <div class="notification-content">
                <div class="notification-title">{{ $notification->title }}</div>
                <div class="notification-message">{{ $notification->message }}</div>
                <div class="notification-time">{{ $notification->created_at->diffForHumans() }}</div>
            </div>
        </div>
        @empty
        <div class="text-center p-5">
            <p class="text-muted">No notifications found.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Notification Toggle -->
<div class="notification-toggle-bar">
    <span>Keep Your Notification On</span>
    <label class="toggle-switch">
        <input type="checkbox" checked>
        <span class="toggle-slider"></span>
    </label>
</div>
@endsection

@push('styles')
<style>
.notification-info-text {
    text-align: center;
    color: #9333ea;
    margin-bottom: 32px;
    font-size: 1rem;
    font-weight: 600;
}

.notifications-list {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 16px;
    padding: 24px;
}

.notification-item-list {
    background: white;
    border: 1px solid #e5e7eb;
    border-radius: 12px;
    padding: 16px;
    display: flex;
    gap: 12px;
    cursor: pointer;
    transition: all 0.2s;
}

.notification-item-list:hover {
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    transform: translateY(-2px);
}

.notification-item-list.unread {
    background: #eff6ff;
    border-left: 3px solid #2563eb;
}

.notification-toggle-bar {
    background: #10b981;
    color: white;
    padding: 16px 24px;
    border-radius: 12px;
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-top: 24px;
}

.toggle-switch {
    position: relative;
    display: inline-block;
    width: 48px;
    height: 24px;
}

.toggle-switch input {
    opacity: 0;
    width: 0;
    height: 0;
}

.toggle-slider {
    position: absolute;
    cursor: pointer;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background-color: rgba(255,255,255,0.3);
    transition: .4s;
    border-radius: 24px;
}

.toggle-slider:before {
    position: absolute;
    content: "";
    height: 18px;
    width: 18px;
    left: 3px;
    bottom: 3px;
    background-color: white;
    transition: .4s;
    border-radius: 50%;
}

.toggle-switch input:checked + .toggle-slider {
    background-color: #2563eb;
}

.toggle-switch input:checked + .toggle-slider:before {
    transform: translateX(24px);
}

@media (max-width: 768px) {
    .notifications-list {
        grid-template-columns: 1fr;
        padding: 16px;
    }
    
    .notification-toggle-bar {
        flex-direction: column;
        gap: 12px;
        text-align: center;
    }
}
</style>
@endpush

@push('scripts')
<script>
$(document).ready(function() {
    // Mark all as read
    $('#markAllReadBtnPage').on('click', function() {
        $.ajax({
            url: '{{ route("trainer.notifications.mark-all-read") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    location.reload();
                }
            }
        });
    });
    
    // Mark as read on click
    $('.notification-item-list').on('click', function() {
        const id = $(this).data('id');
        $.ajax({
            url: `/trainer/notifications/${id}/read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                location.reload();
            }
        });
    });
    
    // Filters
    $('#filterBy, #filterTime, #filterStatus').on('change', function() {
        // Implement filtering logic
        filterNotifications();
    });
    
    function filterNotifications() {
        const type = $('#filterBy').val();
        const time = $('#filterTime').val();
        const status = $('#filterStatus').val();
        
        $('.notification-item-list').each(function() {
            let show = true;
            
            if (type !== 'all' && $(this).data('type') !== type) {
                show = false;
            }
            
            if (status !== 'all') {
                const isUnread = $(this).hasClass('unread');
                if (status === 'unread' && !isUnread) show = false;
                if (status === 'read' && isUnread) show = false;
            }
            
            if (show) {
                $(this).show();
            } else {
                $(this).hide();
            }
        });
    }
});
</script>
@endpush
