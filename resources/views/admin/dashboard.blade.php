@extends('layouts.admin')

@section('title', 'Admin Dashboard')
@section('page-title', 'Dashboard')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Dashboard
@endsection

@section('content')
    <div class="stats-grid">
        <a href="{{ route('admin.student-enroll.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="icon green">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="content">
                <h3>Total Students</h3>
                <div class="value">{{ $totalStudents }}</div>
            </div>
        </a>
        
        <a href="{{ route('admin.courses.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4.5 12.75l7.5 4.5 7.5-4.5"/>
                </svg>
            </div>
            <div class="content">
                <h3>Active Courses</h3>
                <div class="value">{{ $activeCourses }}</div>
            </div>
        </a>
        
        <a href="{{ route('admin.student-enroll.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="icon yellow">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h18v4H3zM5 7v11a2 2 0 002 2h10a2 2 0 002-2V7"/>
                </svg>
            </div>
            <div class="content">
                <h3>Total Enrollments</h3>
                <div class="value">{{ $totalEnrollments }}</div>
            </div>
        </a>
        
        <a href="{{ route('admin.instructors.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="icon blue">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="content">
                <h3>Total Trainers</h3>
                <div class="value">{{ $totalTrainers }}</div>
            </div>
        </a>
        
        <a href="{{ route('admin.community-queries.index') }}" class="stat-card" style="text-decoration: none; color: inherit;">
            <div class="icon yellow">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width:24px;height:24px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M21 10c0 6-9 10-9 10S3 16 3 10a9 9 0 1118 0z"/>
                </svg>
            </div>
            <div class="content">
                <h3>Pending Queries</h3>
                <div class="value">{{ $pendingQueries }}</div>
            </div>
        </a>
    </div>
    
    <div class="card">
        <h2 style="margin-bottom: 16px; font-size: 1.25rem; font-weight: 600;">Quick Actions</h2>
        <div style="display: flex; gap: 12px; flex-wrap: wrap;">
            <a href="#" class="btn btn-primary">Create Course</a>
            <a href="#" class="btn btn-primary">Assign Trainer</a>
            <a href="#" class="btn btn-primary">View Enrollments</a>
            <a href="#" class="btn btn-primary">Manage Queries</a>
        </div>
    </div>
@endsection

