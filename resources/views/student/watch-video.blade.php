@extends('layouts.video-player')

@section('title', $video->title)

@section('content')
<!-- Header -->
<div class="video-header">
    <a href="{{ route('student.enroll-courses') }}" class="back-btn">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
        </svg>
        ← Back
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
                            id="videoPlayer"
                            src="https://www.youtube.com/embed/{{ $videoId }}?autoplay=1" 
                            frameborder="0" 
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                            allowfullscreen>
                        </iframe>
                    @else
                        <div style="padding: 60px; text-align: center; background: #000;">
                            <a href="{{ $video->video_url }}" target="_blank" class="action-btn" style="display: inline-flex; text-decoration: none;">Watch Video</a>
                        </div>
                    @endif
                @elseif(str_contains($video->video_url, 'uploads/videos') || str_contains($video->video_url, 'storage'))
                    <video id="videoPlayer" controls style="width: 100%; height: auto; min-height: 500px;">
                        <source src="{{ asset($video->video_url) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div style="padding: 60px; text-align: center; background: #000;">
                        <a href="{{ $video->video_url }}" target="_blank" class="action-btn" style="display: inline-flex; text-decoration: none;">Watch Video</a>
                    </div>
                @endif
            @else
                <div style="padding: 60px; text-align: center; background: #000; color: #fff;">
                    <p>Video URL not available</p>
                </div>
            @endif
        </div>

        <!-- Video Info -->
        <div class="video-info">
            <div class="video-title-section">
                <div class="video-title">
                    {{ $video->title }}
                    @if($isCompleted)
                        <span class="completed-badge">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                            Completed
                        </span>
                    @endif
                </div>
            </div>

            <!-- Action Buttons -->
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

            <!-- Video Description -->
            <div class="video-description">
                <div class="description-title">Title - {{ $video->title }}</div>
                
                <div class="learning-objectives">
                    <h4>
                        <span>✨</span>
                        What You'll Learn in This Class:
                    </h4>
                    <ul>
                        @php
                            // Extract learning points from description
                            $learningPoints = [];
                            if ($video->description) {
                                $description = $video->description;
                                $lines = explode("\n", $description);
                                foreach ($lines as $line) {
                                    $line = trim($line);
                                    if (!empty($line) && (str_starts_with($line, '-') || str_starts_with($line, '•') || str_starts_with($line, '*'))) {
                                        $learningPoints[] = trim($line, '- •*');
                                    } elseif (!empty($line) && strlen($line) > 20 && !str_starts_with($line, '#')) {
                                        $learningPoints[] = $line;
                                    }
                                }
                                // If no bullet points found, split by sentences
                                if (empty($learningPoints)) {
                                    $sentences = preg_split('/(?<=[.!?])\s+/', $description);
                                    $learningPoints = array_filter(array_slice($sentences, 0, 5), function($s) {
                                        return strlen(trim($s)) > 20;
                                    });
                                }
                            }
                            
                            // Default learning points if none found
                            if (empty($learningPoints)) {
                                $learningPoints = [
                                    'How to install and use VS Code for web development',
                                    'Setting up your first HTML project',
                                    'Understanding HTML structure (tags, elements, attributes)',
                                    'Creating your first webpage step by step'
                                ];
                            }
                        @endphp
                        
                        @foreach(array_slice($learningPoints, 0, 4) as $point)
                            <li>{{ $point }}</li>
                        @endforeach
                    </ul>
                </div>
                
                @php
                    // Extract hashtags from description or create default ones based on course
                    $hashtags = [];
                    if ($video->description && preg_match_all('/#(\w+)/', $video->description, $matches)) {
                        $hashtags = $matches[1];
                    } else {
                        // Generate hashtags based on course title or video title
                        $titleWords = explode(' ', $video->title . ' ' . ($video->course->title ?? ''));
                        $hashtags = array_filter(array_map(function($word) {
                            return ucfirst(trim($word, '.,!?'));
                        }, $titleWords), function($word) {
                            return strlen($word) > 2;
                        });
                        $hashtags = array_slice($hashtags, 0, 6);
                        if (empty($hashtags)) {
                            $hashtags = ['HTML', 'HTMLTags', 'HTMLTutorial', 'WebDevelopment', 'Coding', 'LearnToCode'];
                        }
                    }
                @endphp
                
                <div style="margin-top: 20px; display: flex; flex-wrap: wrap; gap: 8px;">
                    @foreach(array_slice($hashtags, 0, 6) as $tag)
                        <span style="background: #2a2a2a; padding: 4px 12px; border-radius: 12px; font-size: 0.75rem; color: #9ca3af;">#{{ $tag }}</span>
                    @endforeach
                </div>
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
                @php
                    $isVideoCompleted = false;
                    $isLocked = false;
                    
                    // Check if video is completed
                    try {
                        if (\Schema::hasTable('video_progress')) {
                            $isVideoCompleted = \DB::table('video_progress')
                                ->where('student_id', Auth::id())
                                ->where('video_id', $courseVideo->id)
                                ->where('completed', true)
                                ->exists();
                        }
                    } catch (\Exception $e) {
                        // Table doesn't exist
                    }
                    
                    // Video is locked if previous videos are not completed (for sequential learning)
                    // For now, we'll allow access to all videos if enrolled
                    // You can implement sequential locking later
                    $isLocked = false; // Can be enhanced with sequential logic
                @endphp
                
                <div class="lesson-item {{ $courseVideo->id === $video->id ? 'active' : '' }}" 
                     @if(!$isLocked) onclick="window.location.href='{{ route('student.videos.watch', \App\Helpers\EncryptionHelper::encryptIdForUrl($courseVideo->id)) }}'" @endif
                     style="{{ $isLocked ? 'opacity: 0.6; cursor: not-allowed;' : 'cursor: pointer;' }}">
                    <div class="lesson-status {{ $isVideoCompleted ? 'completed' : ($isLocked ? 'locked' : '') }}">
                        @if($isVideoCompleted)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        @elseif($isLocked)
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        @else
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #6b7280;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        @endif
                    </div>
                    <div class="lesson-info">
                        <div class="lesson-title">{{ $courseVideo->title }}</div>
                        <div class="lesson-duration">
                            @if($isVideoCompleted)
                                <span style="color: #10b981; font-size: 0.7rem; margin-right: 8px; font-weight: 500;">Completed</span>
                            @elseif($isLocked)
                                <span style="color: #ef4444; font-size: 0.7rem; margin-right: 8px; font-weight: 500;">Locked</span>
                            @endif
                            @php
                                $duration = $courseVideo->duration_minutes ?? 0;
                                $minutes = floor($duration);
                                $seconds = round(($duration - $minutes) * 60);
                                $formattedDuration = $minutes . ':' . str_pad($seconds, 2, '0', STR_PAD_LEFT);
                            @endphp
                            {{ $formattedDuration }}
                        </div>
                    </div>
                    @if(!$isLocked)
                    <div class="lesson-play-btn">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                        </svg>
                    </div>
                    @endif
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
    alert('Video saved to your list!');
}

function shareVideo() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $video->title }}',
            text: 'Check out this video: {{ $video->title }}',
            url: window.location.href
        });
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href);
        alert('Link copied to clipboard!');
    }
}

function downloadVideo() {
    // Implement download functionality
    alert('Download feature coming soon!');
}

// Mark video as completed when video ends
document.addEventListener('DOMContentLoaded', function() {
    const videoPlayer = document.getElementById('videoPlayer');
    
    if (videoPlayer && videoPlayer.tagName === 'VIDEO') {
        videoPlayer.addEventListener('ended', function() {
            // Mark video as completed via AJAX
            $.ajax({
                url: '{{ route("student.videos.mark-completed", \App\Helpers\EncryptionHelper::encryptIdForUrl($video->id)) }}',
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                },
                success: function(response) {
                    if (response.success) {
                        // Reload page to update status
                        location.reload();
                    }
                }
            });
        });
    }
    
    // For YouTube iframes, we can't detect end event directly
    // You might need to use YouTube API for this
});
</script>
@endpush
