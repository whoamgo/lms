@extends('layouts.admin')

@section('title', 'Activity Logs')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Activity Logs
@endsection

@section('content')
<div class="card">
    <h2>Activity Logs</h2>
    
    <form method="GET" action="{{ route('admin.activity-logs.index') }}" class="search-filter-bar">
        <input type="text" name="search" class="search-input" placeholder="Search activities..." value="{{ request('search') }}">
        <button type="submit" class="btn btn-primary">Search</button>
    </form>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Description</th>
                    <th>IP Address</th>
                    <th>Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($log->action) }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="text-align: center; padding: 40px; color: #6b7280;">No activity logs found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
