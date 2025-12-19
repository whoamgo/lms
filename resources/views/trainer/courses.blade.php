@extends('layouts.trainer')

@section('title', 'Assigned Courses')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Assigned Courses
@endsection

@section('content')
<div class="profile-banner">
    <div class="profile-banner-gradient"></div>
    <div class="profile-banner-content">
        <div class="profile-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" class="icon-white" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>Trainer</p>
        </div>
    </div>
</div>

<div class="card card-no-padding">
    <div id="coursesContainer" class="courses-grid">
        @foreach($courses as $index => $course)
        <div class="course-card course-item @if($index >= 3) hidden-item @endif" data-index="{{ $index }}">
            <div class="course-card-header">
                <div class="relative-container">
                    <div class="course-card-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-purple" style="width: 40px; height: 40px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                    <div class="tech-tag html5">HTML5</div>
                    <div class="tech-tag bootstrap">B</div>
                    <div class="tech-tag js">JS</div>
                    <div class="tech-tag php">PHP</div>
                    <div class="tech-tag mysql">MySQL</div>
                    <div class="tech-tag jquery">jQuery</div>
                </div>
            </div>
            <div class="course-card-body">
                <button class="card-menu-btn" type="button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-gray" style="width: 20px; height: 20px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                    </svg>
                </button>
                <span class="badge badge-success badge-mb">Active</span>
                <h3 class="card-title">{{ $course->title }}</h3>
                <p class="card-subtitle">{{ number_format($course->enrollments->count()) }} Students</p>
                <div class="card-actions card-actions-mt">
                    <a href="{{ route('trainer.videos') }}?course={{ $course->id }}" class="btn btn-sm btn-primary">View Videos</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($courses->count() > 3)
    <div class="show-more-container">
        <button id="showMoreCoursesBtn" class="show-more-btn">
            Show More ({{ $courses->count() - 3 }} more)
        </button>
    </div>
    @endif
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    const $coursesContainer = $('#coursesContainer');
    const $showMoreBtn = $('#showMoreCoursesBtn');
    const totalCourses = {{ $courses->count() }};
    let showingAll = false;
    
    if (totalCourses > 3) {
        $('.course-item').each(function() {
            const index = $(this).data('index');
            if (index >= 3) {
                $(this).hide();
            }
        });
        
        $showMoreBtn.on('click', function() {
            const $btn = $(this);
            
            if (!showingAll) {
                $('.course-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideDown(300);
                    }
                });
                showingAll = true;
                $btn.html('Show Less');
            } else {
                $('.course-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideUp(300);
                    }
                });
                showingAll = false;
                $btn.html('Show More (' + (totalCourses - 3) + ' more)');
                
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $coursesContainer.offset().top - 100
                    }, 300);
                }, 300);
            }
        });
    }
});
</script>
@endpush
