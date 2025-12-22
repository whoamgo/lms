@extends('layouts.video-player')

@section('title', $video->title)

@section('content')
<!-- Header -->
<div class="video-header">
    <a href="{{ route('trainer.videos') }}" class="back-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        Back
    </a>
    <div class="course-title">{{ $video->course->title ?? 'Video' }}</div>
    <div></div> <!-- Spacer for flex layout -->
</div>

<!-- Main Content -->
<div class="video-main-content">
    <!-- Video Player Section -->
    <div class="video-player-section">
        <!-- Video Player -->
        <div class="video-wrapper">
            @if($video->video_url)
                @if(str_contains($video->video_url, 'youtube.com') || str_contains($video->video_url, 'youtu.be'))
                    @php
                        $videoId = null;
                        if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $video->video_url, $matches)) {
                            $videoId = $matches[1];
                        }
                    @endphp
                    @if($videoId)
                        <iframe 
                            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary" style="width: 100%; padding: 40px; text-align: center;">Watch Video</a>
                    @endif
                @elseif(str_contains($video->video_url, 'uploads/videos'))
                    <video id="videoPlayer" controls style="width: 100%; height: auto;">
                        <source src="{{ asset($video->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary" style="width: 100%; padding: 40px; text-align: center;">Watch Video</a>
                @endif
            @else
                <div style="padding: 60px; text-align: center; color: #9ca3af;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <p>No video available</p>
                </div>
            @endif
        </div>

        <!-- Video Info -->
        <div class="video-info">
            <div class="video-title-section">
                <div class="video-title">
                    <span>{{ $video->title }}</span>
                    <span class="completed-badge">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                        Completed
                    </span>
                </div>
            </div>

            <div class="video-actions">
                <button class="action-btn" onclick="saveVideo()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 5a2 2 0 012-2h10a2 2 0 012 2v16l-7-3.5L5 21V5z"></path>
                    </svg>
                    Save
                </button>
                <button class="action-btn" onclick="shareVideo()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.684 13.342C8.886 12.938 9 12.482 9 12c0-.482-.114-.938-.316-1.342m0 2.684a3 3 0 110-2.684m0 2.684l6.632 3.316m-6.632-6l6.632-3.316m0 0a3 3 0 105.367-2.684 3 3 0 00-5.367 2.684zm0 9.316a3 3 0 105.368 2.684 3 3 0 00-5.368-2.684z"></path>
                    </svg>
                    Share
                </button>
                <button class="action-btn" onclick="downloadVideo()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"></path>
                    </svg>
                    Download
                </button>
            </div>

            <div class="video-description">
                <div class="description-title">{{ $video->title }}</div>
                <p style="color: #d1d5db; font-size: 0.875rem; line-height: 1.6; margin-bottom: 16px;">
                    {{ $video->description ?? 'No description available.' }}
                </p>
                
                @if($video->description)
                <div class="learning-objectives">
                    <h4>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"></path>
                        </svg>
                        What You'll Learn in This Class:
                    </h4>
                    <ul>
                        @php
                            // Extract learning points from description or create default ones
                            $learningPoints = [];
                            if ($video->description) {
                                $lines = explode("\n", $video->description);
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (!empty($line) && (str_starts_with($line, '-') || str_starts_with($line, '•') || str_starts_with($line, '*'))) {
                                        $learningPoints[] = trim($line, '-•* ');
                                    }
                                }
                            }
                            if (empty($learningPoints)) {
                                $learningPoints = [
                                    'Understanding the core concepts',
                                    'Practical implementation techniques',
                                    'Best practices and tips',
                                    'Real-world applications'
                                ];
                            }
                        @endphp
                        @foreach(array_slice($learningPoints, 0, 4) as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Playlist Sidebar -->
    <div class="playlist-sidebar">
        <div class="playlist-header">
            <button class="playlist-btn">Playlist</button>
            <div class="course-progress">
                <div class="progress-header">
                    <span class="progress-title">Course Content ({{ $completedVideos }}/{{ $totalVideos }})</span>
                </div>
                <div class="progress-bar">
                    <div class="progress-fill" style="width: {{ $progress }}%;"></div>
                </div>
            </div>
        </div>

        <div class="lesson-list">
            @foreach($courseVideos as $index => $courseVideo)
                <div class="lesson-item {{ $courseVideo->id === $video->id ? 'active' : '' }}" 
                     onclick="window.location.href='{{ route('trainer.videos.watch', \App\Helpers\EncryptionHelper::encryptIdForUrl($courseVideo->id)) }}'">
                    <div class="lesson-status {{ $courseVideo->id === $video->id || $index < $completedVideos ? 'completed' : 'locked' }}">
                        @if($courseVideo->id === $video->id || $index < $completedVideos)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="lesson-info">
                        <div class="lesson-title">{{ $courseVideo->title }}</div>
                        <div class="lesson-duration">
                            @if($courseVideo->duration_minutes)
                                @php
                                    $totalMinutes = $courseVideo->duration_minutes;
                                    $hours = floor($totalMinutes / 60);
                                    $minutes = $totalMinutes % 60;
                                @endphp
                                @if($hours > 0)
                                    {{ $hours }}:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                                @else
                                    0:{{ str_pad($minutes, 2, '0', STR_PAD_LEFT) }}
                                @endif
                            @else
                                N/A
                            @endif
                        </div>
                    </div>
                    <div class="lesson-play-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function saveVideo() {
    // Implement save functionality
    alert('Save functionality coming soon!');
}

function shareVideo() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $video->title }}',
            text: '{{ $video->description }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}

function downloadVideo() {
    @if($video->video_url && str_contains($video->video_url, 'uploads/videos'))
        window.location.href = '{{ asset($video->video_url) }}';
    @else
        alert('Download not available for this video.');
    @endif
}
</script>
@endpush

