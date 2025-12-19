@extends('layouts.trainer-module')

@section('title', 'Trainer Dashboard')

@section('content')
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Dashboard Overview</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
        <div style="background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); padding: 24px; border-radius: 12px; color: white;">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 8px;">Assigned Courses</div>
            <div style="font-size: 2.5rem; font-weight: 600;">{{ $assignedCourses }}</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #f093fb 0%, #f5576c 100%); padding: 24px; border-radius: 12px; color: white;">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 8px;">Active Batches</div>
            <div style="font-size: 2.5rem; font-weight: 600;">{{ $activeBatches }}</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #4facfe 0%, #00f2fe 100%); padding: 24px; border-radius: 12px; color: white;">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 8px;">Upcoming Classes</div>
            <div style="font-size: 2.5rem; font-weight: 600;">{{ $upcomingClasses }}</div>
        </div>
        
        <div style="background: linear-gradient(135deg, #43e97b 0%, #38f9d7 100%); padding: 24px; border-radius: 12px; color: white;">
            <div style="font-size: 0.875rem; opacity: 0.9; margin-bottom: 8px;">Uploaded Videos</div>
            <div style="font-size: 2.5rem; font-weight: 600;">{{ $uploadedVideos }}</div>
        </div>
    </div>
</div>
@endsection
