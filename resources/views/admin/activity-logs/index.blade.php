@extends('layouts.admin')

@section('title', 'Activity Logs')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Activity Logs
@endsection

@section('content')
<div class="card">
    <h2>Activity Logs</h2>
    
    <div class="table-container">
        <table class="data-table" id="activityLogsTable">
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
                @foreach($logs as $log)
                <tr>
                    <td>{{ $log->user->name ?? 'System' }}</td>
                    <td><span class="badge badge-info">{{ ucfirst($log->action) }}</span></td>
                    <td>{{ $log->description }}</td>
                    <td>{{ $log->ip_address }}</td>
                    <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
