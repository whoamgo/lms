@extends('layouts.admin')

@section('title', 'Active Courses Count')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Active Courses Count
@endsection

@section('admin-banner')
<div class="admin-banner">
    <div class="icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 32px; height: 32px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    <h1>Admin</h1>
</div>
@endsection

@section('content')
<h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Active courses & Batch Count</h2>
<br /><br />
<div class="card">
    <form method="GET" action="{{ route('admin.courses.index') }}" class="search-filter-bar">
        <input type="text" name="search" class="search-input" placeholder="Search students, courses..." value="{{ request('search') }}">
        <button type="button" class="btn btn-primary">Filter</button>
        <input type="date" class="btn btn-warning" style="padding: 12px 16px;">
    </form>
    
    <div style="margin-bottom: 16px;">
        <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Create New Course</a>
    </div>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Course Name</th>
                    <th>Active batch name</th>
                    <th>Enrolled student</th>
                    <th>Status</th>
                    <th>Start date</th>
                    <th>End date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 32px; height: 32px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            {{ $course->title }}
                        </div>
                    </td>
                    <td>
                        @if($course->batches->where('status', 'active')->count() > 0)
                            {{ $course->batches->where('status', 'active')->first()->name }}
                        @else
                            No active batch
                        @endif
                    </td>
                    <td>{{ $course->enrollments()->count() }}</td>
                    <td>
                        <form method="POST" action="{{ route('admin.courses.toggle-status', $course->id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $course->status === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                        <span style="margin-left: 8px; font-size: 0.75rem; color: #6b7280;">{{ ucfirst($course->status) }}</span>
                    </td>
                    <td>{{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</td>
                    <td>{{ $course->end_date ? $course->end_date->format('d M Y') : 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">No courses found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $courses->links() }}
    </div>
</div>
@endsection

