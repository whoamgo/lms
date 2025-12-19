@extends('layouts.student')

@section('title', 'Dashboard')

@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}">Home</a> / Dashboard
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-banner-content">
        <div class="profile-avatar welcome-banner-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" class="icon-white">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>Student</p>
        </div>
    </div>
    <div class="welcome-banner-stats">
        <div class="welcome-banner-stat-item">
            <div class="welcome-banner-stat-label">Enrolled</div>
            <div class="welcome-banner-stat-value">{{ $stats['enrolledCourses'] }} Courses</div>
        </div>
        <div class="welcome-banner-stat-item">
            <div class="welcome-banner-stat-label">In Progress</div>
            <div class="welcome-banner-stat-value">{{ $stats['enrolledCourses'] - $stats['completedCourses'] }} Courses</div>
        </div>
        <div class="welcome-banner-stat-item">
            <div class="welcome-banner-stat-label">Completed</div>
            <div class="welcome-banner-stat-value">{{ $stats['completedCourses'] }} Courses</div>
        </div>
    </div>
</div>

<!-- Stats Cards -->
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Enroll Courses</h3>
            <div class="value">{{ $stats['enrolledCourses'] }}</div>
        </div>
        <div class="stat-card-icon red">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Completed Courses</h3>
            <div class="value">{{ $stats['completedCourses'] }}</div>
        </div>
        <div class="stat-card-icon green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Learning Hours</h3>
            <div class="value">{{ $stats['learningHours'] }}H</div>
        </div>
        <div class="stat-card-icon blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-card-content">
            <h3>Average Score</h3>
            <div class="value">{{ $stats['averageScore'] }}%</div>
        </div>
        <div class="stat-card-icon yellow">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path>
            </svg>
        </div>
    </div>
</div>

<!-- Two Column Layout -->
<div class="dashboard-two-column">
    <!-- Continue Learning Section -->
    <div class="continue-learning-section">
        <div class="section-header">
            <div>
                <h2>Continue Learning</h2>
                <p>Pick up where you left off</p>
            </div>
        </div>
        
        <div id="continueLearningContainer" class="continue-learning-grid">
            @foreach($continueLearning as $index => $enrollment)
            <div class="continue-learning-card continue-learning-item @if($index >= 3) hidden-item @endif" data-index="{{ $index }}">
                <div class="continue-learning-icon">
                    <svg fill="none" stroke="white" viewBox="0 0 24 24" class="continue-learning-icon-svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div class="continue-learning-content">
                    <h3>{{ $enrollment->course->title ?? 'Course' }}</h3>
                    <p>Continue your learning journey</p>
                    <div class="continue-learning-time">
                        @php
                            $firstVideo = \App\Models\Video::where('course_id', $enrollment->course_id)
                                ->where('status', 'active')
                                ->orderBy('order', 'asc')
                                ->orderBy('created_at', 'asc')
                                ->first();
                        @endphp
                        @if($firstVideo)
                            <a href="{{ route('student.videos.watch', \App\Helpers\EncryptionHelper::encryptIdForUrl($firstVideo->id)) }}" class="btn btn-sm btn-purple continue-learning-btn">Continue Learning</a>
                        @else
                            <span>No videos available</span>
                        @endif
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        
        @if($continueLearning->count() > 3)
        <div class="show-more-container">
            <button id="showMoreContinueBtn" class="show-more-btn">
                View All Course
            </button>
        </div>
        @endif
    </div>
    
    <!-- Upcoming Course Section -->
    <div class="upcoming-course-section">
        <div class="section-header">
            <h2>Upcoming Course</h2>
            <a href="{{ route('student.enroll-courses') }}" class="view-all-link">View All</a>
        </div>
        
        <div class="upcoming-course-list">
            @forelse($upcomingClasses as $class)
            <div class="upcoming-course-item">
                <div>
                    <h4>{{ $class->title }}</h4>
                    <p>{{ $class->course->title ?? 'Course' }}</p>
                </div>
                <div class="upcoming-course-date">
                    {{ $class->scheduled_at->format('M d, Y - h:i A') }}
                </div>
            </div>
            @empty
            <div class="upcoming-course-item">
                <p class="text-muted">No upcoming classes</p>
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $container = $('#continueLearningContainer');
    const $showMoreBtn = $('#showMoreContinueBtn');
    const totalItems = {{ $continueLearning->count() }};
    let showingAll = false;
    
    if (totalItems > 3) {
        $('.continue-learning-item').each(function() {
            const index = $(this).data('index');
            if (index >= 3) {
                $(this).hide();
            }
        });
        
        $showMoreBtn.on('click', function() {
            const $btn = $(this);
            
            if (!showingAll) {
                $('.continue-learning-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideDown(300);
                    }
                });
                showingAll = true;
                $btn.html('Show Less');
            } else {
                $('.continue-learning-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideUp(300);
                    }
                });
                showingAll = false;
                $btn.html('View All Course');
                
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $container.offset().top - 100
                    }, 300);
                }, 300);
            }
        });
    }
});
</script>
@endpush
