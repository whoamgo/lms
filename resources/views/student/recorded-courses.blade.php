@extends('layouts.student')

@section('title', 'Recorded Courses')

@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}">Home</a> / Recorded course
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-banner-content">
        <div class="profile-avatar welcome-banner-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
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
</div>

<!-- Recorded Courses Section -->
<div class="recorded-courses-section">
    <div class="recorded-courses-header">
        <div>
            <h2 class="recorded-courses-title">Recorded Courses</h2>
            <p class="recorded-courses-subtitle">Access your complete library of video course playlists.</p>
        </div>
        <div class="search-container">
            <input type="text" id="courseSearch" placeholder="Search courses..." 
                   value="{{ $search }}"
                   class="form-control search-input">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="search-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
            </svg>
        </div>
    </div>
    
    <!-- Courses Grid -->
    <div class="courses-grid" id="coursesGrid">
        @forelse($courses->take(3) as $course)
            <div class="course-card recorded-course-card" data-course-id="{{ $course['id'] }}">
                <div class="course-card-thumbnail">
                    @if($course['thumbnail'])
                        <img src="{{ asset('storage/' . $course['thumbnail']) }}" alt="{{ $course['title'] }}">
                    @else
                        <div style="background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 60px; height: 60px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="course-card-content">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541; margin-bottom: 12px;">{{ $course['title'] }}</h3>
                    <div style="display: flex; gap: 16px; margin-bottom: 16px; color: #6b7280; font-size: 0.875rem;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $course['total_videos'] }} Videos</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $course['total_duration'] }}</span>
                        </div>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 0.75rem; color: #6b7280;">
                            <span>Progress</span>
                            <span>{{ $course['progress'] }}%</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $course['progress'] }}%; height: 100%; background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); transition: width 0.3s;"></div>
                        </div>
                    </div>
                    <button class="btn btn-course-action {{ $course['progress'] > 0 ? 'btn-continue' : 'btn-start' }}" 
                            onclick="openCourseModal({{ $course['id'] }})">
                        @if($course['progress'] > 0)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Continue
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Course
                        @endif
                    </button>
                </div>
            </div>
        @empty
            <div class="card" style="grid-column: 1 / -1; text-align: center; padding: 48px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9ca3af; margin: 0 auto 16px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                </svg>
                <p style="color: #6b7280; font-size: 1rem;">No recorded courses found.</p>
            </div>
        @endforelse
        
        <!-- Hidden courses (shown after "Show More") -->
        @foreach($courses->slice(3) as $course)
            <div class="course-card recorded-course-card hidden-item" data-course-id="{{ $course['id'] }}">
                <div class="course-card-thumbnail">
                    @if($course['thumbnail'])
                        <img src="{{ asset('storage/' . $course['thumbnail']) }}" alt="{{ $course['title'] }}">
                    @else
                        <div style="background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); height: 100%; display: flex; align-items: center; justify-content: center; color: white; font-size: 2rem;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 60px; height: 60px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="course-card-content">
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541; margin-bottom: 12px;">{{ $course['title'] }}</h3>
                    <div style="display: flex; gap: 16px; margin-bottom: 16px; color: #6b7280; font-size: 0.875rem;">
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $course['total_videos'] }} Videos</span>
                        </div>
                        <div style="display: flex; align-items: center; gap: 6px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            <span>{{ $course['total_duration'] }}</span>
                        </div>
                    </div>
                    <div style="margin-bottom: 16px;">
                        <div style="display: flex; justify-content: space-between; margin-bottom: 4px; font-size: 0.75rem; color: #6b7280;">
                            <span>Progress</span>
                            <span>{{ $course['progress'] }}%</span>
                        </div>
                        <div style="width: 100%; height: 8px; background: #e5e7eb; border-radius: 4px; overflow: hidden;">
                            <div style="width: {{ $course['progress'] }}%; height: 100%; background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%); transition: width 0.3s;"></div>
                        </div>
                    </div>
                    <button class="btn btn-course-action {{ $course['progress'] > 0 ? 'btn-continue' : 'btn-start' }}" 
                            onclick="openCourseModal({{ $course['id'] }})">
                        @if($course['progress'] > 0)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"></path>
                            </svg>
                            Continue
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Start Course
                        @endif
                    </button>
                </div>
            </div>
        @endforeach
    </div>
    
    @if($courses->count() > 3)
        <div class="show-more-container">
            <button onclick="showMoreCourses()" class="btn btn-purple show-more-btn" id="showMoreBtn">Show More</button>
        </div>
    @endif
</div>

<!-- Course Details Modal -->
<div class="modal fade" id="courseModal" tabindex="-1" aria-hidden="true" data-bs-backdrop="true" data-bs-keyboard="true">
    <div class="modal-dialog modal-lg modal-dialog-centered">
        <div class="modal-content" style="border-radius: 12px; border: none; box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1);">
            <div class="modal-header">
                <h5 class="modal-title" id="courseModalTitle">Course Title</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p id="courseModalDescription" class="course-modal-description"></p>
                
                <div class="course-modal-stats">
                    <div class="course-modal-stat-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="course-modal-stat-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                        </svg>
                        <span id="courseModalVideos">0 videos</span>
                    </div>
                    <div class="course-modal-stat-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="course-modal-stat-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="courseModalDuration">0h 00m</span>
                    </div>
                    <div class="course-modal-stat-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="course-modal-stat-icon">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span id="courseModalCompleted">0 completed</span>
                    </div>
                </div>
                
                <div class="course-modal-progress-section">
                    <div class="course-modal-progress-header">
                        <span>Course Progress - <span id="courseModalProgress">0%</span></span>
                    </div>
                    <div class="course-modal-progress-bar-container">
                        <div id="courseModalProgressBar" class="course-modal-progress-bar-fill"></div>
                    </div>
                </div>
                
                <div class="course-modal-content-section">
                    <h6 class="course-modal-content-title">Course Content (<span id="courseContentCount">0/0</span>)</h6>
                    <div id="courseVideosList" class="course-videos-list">
                        <!-- Videos will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<!-- All styles moved to student.css -->
@endpush

@push('scripts')
<script>
let allCoursesShown = false;

function showMoreCourses() {
    const hiddenItems = document.querySelectorAll('.recorded-course-card.hidden-item');
    const btn = document.getElementById('showMoreBtn');
    
    hiddenItems.forEach(item => {
        item.classList.remove('hidden-item');
        item.style.display = 'block';
    });
    
    if (btn) {
        btn.style.display = 'none';
    }
    allCoursesShown = true;
}

// Search functionality
let searchTimeout;
document.getElementById('courseSearch').addEventListener('input', function() {
    clearTimeout(searchTimeout);
    const searchTerm = this.value;
    
    searchTimeout = setTimeout(() => {
        if (searchTerm.length >= 2 || searchTerm.length === 0) {
            const url = new URL(window.location.href);
            if (searchTerm) {
                url.searchParams.set('search', searchTerm);
            } else {
                url.searchParams.delete('search');
            }
            window.location.href = url.toString();
        }
    }, 500);
});

// Course Modal
function openCourseModal(courseId) {
    const modalElement = document.getElementById('courseModal');
    const modal = new bootstrap.Modal(modalElement, {
        backdrop: true,
        keyboard: true
    });
    
    // Show loading state
    document.getElementById('courseModalTitle').textContent = 'Loading...';
    document.getElementById('courseVideosList').innerHTML = '<div style="text-align: center; padding: 40px;"><div class="spinner-border text-purple" role="status"></div></div>';
    
    // Remove blur from backdrop when modal is shown
    modalElement.addEventListener('shown.bs.modal', function() {
        const backdrop = document.querySelector('.modal-backdrop');
        if (backdrop) {
            backdrop.style.backdropFilter = 'none';
            backdrop.style.webkitBackdropFilter = 'none';
            backdrop.style.filter = 'none';
        }
    });
    
    modal.show();
    
    // Fetch course details
    const detailsUrl = `{{ url('/student/recorded-courses') }}/${courseId}/details`;
    fetch(detailsUrl, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const course = data.course;
            
            // Update modal content
            document.getElementById('courseModalTitle').textContent = course.title;
            document.getElementById('courseModalDescription').textContent = course.description || 'No description available.';
            document.getElementById('courseModalVideos').textContent = course.total_videos + ' videos';
            document.getElementById('courseModalDuration').textContent = course.total_duration;
            document.getElementById('courseModalCompleted').textContent = course.completed_count + ' completed';
            
            // Update progress bar dynamically
            const progress = course.progress || 0;
            document.getElementById('courseModalProgress').textContent = progress + '%';
            const progressBar = document.getElementById('courseModalProgressBar');
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.setAttribute('aria-valuemin', 0);
            progressBar.setAttribute('aria-valuemax', 100);
            
            document.getElementById('courseContentCount').textContent = course.completed_count + '/' + course.total_videos;
            
            // Render videos list
            const videosList = document.getElementById('courseVideosList');
            videosList.innerHTML = '';
            
            course.videos.forEach((video, index) => {
                const videoItem = document.createElement('div');
                videoItem.className = 'video-item' + (video.completed ? ' completed' : '');
                
                videoItem.innerHTML = `
                    <div class="video-icon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <div class="video-info">
                        <div class="video-title">${index + 1}. ${video.title}</div>
                        <div class="video-status ${video.completed ? 'completed' : 'pending'}">
                            ${video.completed ? '✔Completed' : 'Pending'}
                            ${!video.completed ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; display: inline-block; margin-left: 4px; vertical-align: middle;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path></svg>' : ''}
                            <span class="video-duration">${video.duration_formatted}</span>
                        </div>
                    </div>
                    <button class="btn-play-video" onclick="playVideo('${video.encrypted_id}')" ${!video.completed && index > 0 && !course.videos[index - 1].completed ? 'disabled' : ''}>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        </svg>
                        Play
                    </button>
                `;
                
                videosList.appendChild(videoItem);
            });
        } else {
            alert('Error loading course details. Please try again.');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('Error loading course details. Please try again.');
    });
}

function playVideo(encryptedId) {
    // Redirect to video player page with encrypted ID
    window.location.href = `{{ url('/student/videos') }}/${encryptedId}/watch`;
}
</script>
@endpush

