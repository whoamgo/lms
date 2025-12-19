@extends('layouts.trainer')

@section('title', 'Trainer Dashboard')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Dashboard
@endsection

@section('content')
<div class="card">
    <h2>Trainer Dashboard</h2>
    
    <div class="stats-grid">
        <div class="stat-card">
            <h3>Assigned Courses</h3>
            <div class="value">{{ $assignedCourses }}</div>
        </div>
        
        <div class="stat-card">
            <h3>Active Batches</h3>
            <div class="value">{{ $activeBatches }}</div>
        </div>
        
        <div class="stat-card">
            <h3>Upcoming Classes</h3>
            <div class="value">{{ $upcomingClasses }}</div>
        </div>
        
        <div class="stat-card" style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%);">
            <h3>Uploaded Videos</h3>
            <div class="value">{{ $uploadedVideos }}</div>
        </div>
    </div>
</div>
@endsection
