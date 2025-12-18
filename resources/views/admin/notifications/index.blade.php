@extends('layouts.admin')

@section('title', 'Notifications')
 


@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Notifications
@endsection

@section('content')
<br /><br />
<div class="card">
    <h2>All Notifications</h2>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($notifications as $notification)
                <tr class="{{ $notification->is_read ? '' : 'unread' }}">
                    <td>
                        <span class="badge badge-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : 'info') }}">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </td>
                    <td>{{ $notification->title }}</td>
                    <td>{{ Str::limit($notification->message, 50) }}</td>
                

                     <td>{{ $notification->created_at ? $notification->created_at->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $notification->is_read ? 'badge-success' : 'badge-danger' }}">
                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.notifications.show', $notification->id) }}" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem;">View</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">No notifications found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $notifications->links() }}
    </div>
</div>
@endsection
