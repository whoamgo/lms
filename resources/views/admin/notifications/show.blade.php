@extends('layouts.admin')

@section('title', 'Notification Details')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / <a href="' . route('admin.notifications.index') . '">Notifications</a> /Details
@endsection

@section('content')
<br><br>
<div class="card">
    <div class="notification-header">
        <h2>{{ $notification->title }}</h2>
        <span class="badge badge-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : 'info') }}">
            {{ ucfirst($notification->type) }}
        </span>
    </div>
    
    <div class="notification-date">
        <strong>Date:</strong> {{ $notification->created_at ? $notification->created_at->format('d/m/Y') : 'N/A' }}
    </div>
    
    <div class="notification-message-section">
        <strong>Message:</strong>
        <div class="notification-message-box">
            {{ $notification->message }}
        </div>
    </div>
    
    @if($notification->link)
    <div class="notification-link-section">
        <a href="{{ $notification->link }}" class="btn btn-primary">View Related Item</a>
    </div>
    @endif
    
    <div>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-dark">Back to Notifications</a>
    </div>
</div>
@endsection
