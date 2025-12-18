@extends('layouts.admin')

@section('title', 'Total Student Enroll')
 


@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Total Student Enroll
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
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div class="content">
            <h3>Total Students</h3>
            <div class="value">{{ number_format($totalStudents) }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="icon blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="content">
            <h3>Active Students</h3>
            <div class="value">{{ number_format($activeStudents) }}</div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="icon yellow">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </div>
        <div class="content">
            <h3>New this month</h3>
            <div class="value">{{ number_format($newThisMonth) }}</div>
        </div>
    </div>
</div>

<div class="card">
    <h2>Student Enrollment Management</h2>
    
    <form method="GET" action="{{ route('admin.student-enroll.index') }}" class="search-filter-bar">
        <input type="text" name="search" class="search-input" placeholder="Search students, courses..." value="{{ request('search') }}">
        <button type="button" class="btn btn-secondary">Filter</button>
        <button type="button" class="btn btn-secondary">Export</button>
        <input type="date" class="btn btn-warning" style="padding: 12px 16px;">
    </form>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th><input type="checkbox"></th>
                    <th>Student Name</th>
                    <th>Contact</th>
                    <th>Enrolled</th>
                    <th>Completed</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Location</th>
                </tr>
            </thead>
            <tbody>
                @forelse($students as $student)
                <tr>
                    <td><input type="checkbox"></td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="width: 32px; height: 32px; background: #dbeafe; border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #2563eb;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <div style="font-weight: 500;">{{ $student->name }}</div>
                                <div style="font-size: 0.75rem; color: #6b7280;">ID: #{{ strtoupper(substr(md5($student->id), 0, 9)) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $student->email }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $student->phone ?? 'N/A' }}</div>
                    </td>
                    <td><span class="badge badge-success">{{ $student->enrollments_count }} Courses</span></td>
                    <td><span class="badge badge-info">{{ $student->completed_enrollments_count }} Course</span></td>
                    <td>
                        <form method="POST" action="{{ route('admin.student-enroll.toggle-status', $student->id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $student->status === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                    </td>
                    <td>{{ $student->created_at->format('d M Y') }}</td>
                    <td>{{ $student->address ?? 'N/A' }}</td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="text-align: center; padding: 40px; color: #6b7280;">No students found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $students->links() }}
    </div>
</div>
@endsection

