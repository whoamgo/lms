@extends('layouts.admin')

@section('title', 'Notification Details')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / <a href="' . route('admin.notifications.index') . '">Notifications</a> /Details
@endsection

@section('content')
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2>{{ $notification->title }}</h2>
        <span class="badge badge-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : 'info') }}">
            {{ ucfirst($notification->type) }}
        </span>
    </div>
    
    <div style="margin-bottom: 16px;">
        <strong>Date:</strong> {{ $notification->created_at ? $notification->created_at->format('d/m/Y') : 'N/A' }}
    </div>
    
    <div style="margin-bottom: 24px;">
        <strong>Message:</strong>
        <div style="margin-top: 8px; padding: 16px; background: #f9fafb; border-radius: 8px;">
            {{ $notification->message }}
        </div>
    </div>
    
    @if($notification->link)
    <div style="margin-bottom: 24px;">
        <a href="{{ $notification->link }}" class="btn btn-primary">View Related Item</a>
    </div>
    @endif
    
    <div>
        <a href="{{ route('admin.notifications.index') }}" class="btn btn-secondary">Back to Notifications</a>
    </div>
</div>
@endsection
