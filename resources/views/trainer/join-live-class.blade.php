@extends('layouts.trainer')

@section('title', 'Join Live Class - ' . $liveClass->title)

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.live-classes') }}">Live Classes</a> / Join
@endsection

@section('content')
<div class="live-class-container">
    <!-- Live Class Header -->
    <div class="live-class-header">
        <div class="live-class-thumbnail">
            @if($liveClass->thumbnail)
                <img src="{{ asset($liveClass->thumbnail) }}" alt="{{ $liveClass->title }}">
            @else
                <div class="thumbnail-placeholder">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                </div>
            @endif
            <div class="live-indicator">
                <span class="live-dot"></span>
                <span>LIVE</span>
            </div>
        </div>
        <div class="live-class-info">
            <h1>{{ $liveClass->title }}</h1>
            @if($liveClass->description)
                <p class="class-description">{{ $liveClass->description }}</p>
            @endif
            <div class="class-meta">
                @if($liveClass->course)
                    <span class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                        {{ $liveClass->course->title }}
                    </span>
                @endif
                @if($liveClass->duration)
                    <span class="meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        @php
                            $hours = floor($liveClass->duration / 60);
                            $minutes = $liveClass->duration % 60;
                        @endphp
                        @if($hours > 0 && $minutes > 0)
                            {{ $hours }}h {{ $minutes }}m
                        @elseif($hours > 0)
                            {{ $hours }}h
                        @else
                            {{ $minutes }}m
                        @endif
                    </span>
                @endif
                <span class="meta-item">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    {{ $liveClass->scheduled_at->format('M d, Y g:i A') }}
                </span>
            </div>
        </div>
    </div>

    <!-- Main Content Area -->
    <div class="live-class-content">
        <!-- Video/Meeting Section -->
        <div class="video-section">
            @if($liveClass->meeting_link)
                <div class="video-container">
                    @if(strpos($liveClass->meeting_link, 'zoom.us') !== false || strpos($liveClass->meeting_link, 'meet.google.com') !== false || strpos($liveClass->meeting_link, 'teams.microsoft.com') !== false)
                        <iframe src="{{ $liveClass->meeting_link }}" allow="camera; microphone; fullscreen; speaker; display-capture" style="width: 100%; height: 100%; border: none; border-radius: 12px;"></iframe>
                    @else
                        <div class="meeting-link-container">
                            <div class="meeting-link-content">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9333ea; margin-bottom: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                                <h3>Join Meeting</h3>
                                <p>Click the button below to join the live meeting</p>
                                <a href="{{ $liveClass->meeting_link }}" target="_blank" class="btn btn-primary btn-large">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; margin-right: 8px;">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    Join Meeting
                                </a>
                            </div>
                        </div>
                    @endif
                </div>
            @else
                <div class="no-meeting-link">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9ca3af;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <p>No meeting link available</p>
                </div>
            @endif

            <!-- Control Buttons -->
            <div class="live-class-controls">
                <button type="button" class="btn btn-danger" id="endClassBtn" onclick="endLiveClass('{{ \App\Helpers\EncryptionHelper::encryptIdForUrl($liveClass->id) }}')">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                    </svg>
                    End Class
                </button>
                <a href="{{ route('trainer.live-classes') }}" class="btn" style="background: #f3f4f6; color: #343541;">
                    Back to Classes
                </a>
            </div>
        </div>

        <!-- Sidebar -->
        <div class="live-class-sidebar">
            <!-- Related Videos -->
            @if($relatedVideos->count() > 0)
            <div class="sidebar-section">
                <h3>Related Videos</h3>
                <div class="video-list">
                    @foreach($relatedVideos as $video)
                    <div class="video-item">
                        @if($video->thumbnail)
                            <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}" class="video-thumb">
                        @else
                            <div class="video-thumb-placeholder">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="video-item-info">
                            <a href="{{ route('trainer.videos.show', $video->id) }}" class="video-title">{{ Str::limit($video->title, 40) }}</a>
                            <div class="video-meta">
                                @if($video->duration_minutes)
                                    <span>{{ $video->duration_minutes }} min</span>
                                @endif
                                @if($video->views)
                                    <span>{{ number_format($video->views) }} views</span>
                                @endif
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Playlists -->
            @if($playlists->count() > 0)
            <div class="sidebar-section">
                <h3>Course Playlists</h3>
                <div class="playlist-list">
                    @foreach($playlists as $playlist)
                    <div class="playlist-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #9333ea; margin-right: 12px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path>
                        </svg>
                        <div class="playlist-info">
                            <a href="#" class="playlist-title">{{ $playlist->title }}</a>
                            <span class="playlist-count">{{ $playlist->videos->count() }} videos</span>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Class Resources -->
            <div class="sidebar-section">
                <h3>Class Resources</h3>
                <div class="resources-list">
                    @if($liveClass->course)
                        <a href="{{ route('trainer.assigned-courses') }}" class="resource-item">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                            View Course
                        </a>
                    @endif
                    <a href="{{ route('trainer.live-classes.edit', \App\Helpers\EncryptionHelper::encryptIdForUrl($liveClass->id)) }}" class="resource-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                        </svg>
                        Edit Class
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
.live-class-container {
    max-width: 1400px;
    margin: 0 auto;
}

.live-class-header {
    background: white;
    border-radius: 12px;
    padding: 24px;
    margin-bottom: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
    display: flex;
    gap: 24px;
    align-items: center;
}

.live-class-thumbnail {
    position: relative;
    width: 200px;
    height: 120px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
}

.live-class-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.thumbnail-placeholder {
    width: 100%;
    height: 100%;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.live-indicator {
    position: absolute;
    top: 8px;
    right: 8px;
    background: #ef4444;
    color: white;
    padding: 4px 12px;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 600;
    display: flex;
    align-items: center;
    gap: 6px;
}

.live-dot {
    width: 8px;
    height: 8px;
    background: white;
    border-radius: 50%;
    animation: pulse 2s infinite;
}

@keyframes pulse {
    0%, 100% { opacity: 1; }
    50% { opacity: 0.5; }
}

.live-class-info h1 {
    font-size: 1.75rem;
    font-weight: 600;
    color: #343541;
    margin: 0 0 8px 0;
}

.class-description {
    color: #6b7280;
    margin: 0 0 16px 0;
    line-height: 1.6;
}

.class-meta {
    display: flex;
    gap: 24px;
    flex-wrap: wrap;
}

.meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
    color: #6b7280;
    font-size: 0.875rem;
}

.meta-item svg {
    width: 18px;
    height: 18px;
}

.live-class-content {
    display: grid;
    grid-template-columns: 1fr 350px;
    gap: 24px;
}

.video-section {
    background: white;
    border-radius: 12px;
    padding: 24px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.video-container {
    width: 100%;
    height: 500px;
    background: #000;
    border-radius: 12px;
    overflow: hidden;
    margin-bottom: 20px;
}

.meeting-link-container {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    background: linear-gradient(135deg, #f3f4f6 0%, #e5e7eb 100%);
}

.meeting-link-content {
    text-align: center;
    padding: 40px;
}

.meeting-link-content h3 {
    font-size: 1.5rem;
    font-weight: 600;
    color: #343541;
    margin: 0 0 8px 0;
}

.meeting-link-content p {
    color: #6b7280;
    margin: 0 0 24px 0;
}

.btn-large {
    padding: 14px 28px;
    font-size: 1rem;
    font-weight: 600;
}

.no-meeting-link {
    width: 100%;
    height: 100%;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
}

.live-class-controls {
    display: flex;
    gap: 12px;
}

.live-class-sidebar {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.sidebar-section {
    background: white;
    border-radius: 12px;
    padding: 20px;
    box-shadow: 0 1px 3px rgba(0,0,0,0.1);
}

.sidebar-section h3 {
    font-size: 1.125rem;
    font-weight: 600;
    color: #343541;
    margin: 0 0 16px 0;
}

.video-list, .playlist-list, .resources-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
}

.video-item {
    display: flex;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    transition: background 0.2s;
}

.video-item:hover {
    background: #f9fafb;
}

.video-thumb {
    width: 80px;
    height: 60px;
    border-radius: 6px;
    object-fit: cover;
    flex-shrink: 0;
}

.video-thumb-placeholder {
    width: 80px;
    height: 60px;
    background: #e5e7eb;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    color: #9ca3af;
    flex-shrink: 0;
}

.video-item-info {
    flex: 1;
    min-width: 0;
}

.video-title {
    display: block;
    font-weight: 500;
    color: #343541;
    margin-bottom: 4px;
    text-decoration: none;
    font-size: 0.875rem;
}

.video-title:hover {
    color: #9333ea;
}

.video-meta {
    display: flex;
    gap: 12px;
    font-size: 0.75rem;
    color: #6b7280;
}

.playlist-item {
    display: flex;
    align-items: center;
    padding: 12px;
    border-radius: 8px;
    transition: background 0.2s;
}

.playlist-item:hover {
    background: #f9fafb;
}

.playlist-info {
    flex: 1;
}

.playlist-title {
    display: block;
    font-weight: 500;
    color: #343541;
    text-decoration: none;
    font-size: 0.875rem;
    margin-bottom: 4px;
}

.playlist-title:hover {
    color: #9333ea;
}

.playlist-count {
    font-size: 0.75rem;
    color: #6b7280;
}

.resource-item {
    display: flex;
    align-items: center;
    gap: 12px;
    padding: 12px;
    border-radius: 8px;
    color: #343541;
    text-decoration: none;
    transition: background 0.2s;
}

.resource-item:hover {
    background: #f9fafb;
    color: #9333ea;
}

.resource-item svg {
    width: 20px;
    height: 20px;
}

@media (max-width: 1024px) {
    .live-class-content {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script>
function endLiveClass(encryptedId) {
    if (!confirm('Are you sure you want to end this live class? This action cannot be undone.')) {
        return;
    }
    
    $.ajax({
        url: `/trainer/live-classes/${encryptedId}/end`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                setTimeout(function() {
                    window.location.href = response.redirect;
                }, 1500);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to end live class.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('error', errorMessage);
        }
    });
}

// Alert Function
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    const icon = type === 'success' 
        ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        : '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    
    const alert = $(`
        <div class="${alertClass}" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px; padding: 12px 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            ${icon}
            <div>${message}</div>
        </div>
    `);
    
    $('body').append(alert);
    
    setTimeout(function() {
        alert.fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}
</script>
@endpush

