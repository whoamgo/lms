@extends('layouts.trainer')

@section('title', 'View / Edit Video')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.videos') }}">Uploaded videos</a> / View / Edit
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 60px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 20px 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -30px; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
                <p style="color: #6b7280; margin: 2px 0 0 0; font-size: 0.875rem;">Trainer</p>
            </div>
        </div>
        <a href="{{ route('trainer.videos.edit', $video->id) }}" class="btn btn-primary">Edit Video</a>
    </div>
</div>

<div class="card">
    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 32px;">
        <div>
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 16px; color: #343541;">Video Details</h3>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Video Title</label>
                <div style="font-size: 1rem; color: #343541;">{{ $video->title }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Description</label>
                <div style="font-size: 0.875rem; color: #6b7280; line-height: 1.6;">{{ $video->description ?? 'No description provided' }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Course</label>
                <div style="font-size: 1rem; color: #343541;">{{ $video->course->title ?? 'N/A' }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Batch</label>
                <div style="font-size: 1rem; color: #343541;">{{ $video->batch->name ?? 'N/A' }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Duration</label>
                <div style="font-size: 1rem; color: #343541;">
                    @if($video->duration_minutes)
                        @php
                            $hours = floor($video->duration_minutes / 60);
                            $minutes = $video->duration_minutes % 60;
                        @endphp
                        @if($hours > 0)
                            {{ $hours }}h {{ $minutes }}m
                        @else
                            {{ $minutes }}m
                        @endif
                    @else
                        N/A
                    @endif
                </div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Views</label>
                <div style="font-size: 1rem; color: #343541;">{{ number_format($video->views ?? 0) }}</div>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Status</label>
                <span class="badge badge-{{ $video->status === 'active' ? 'success' : 'warning' }}">
                    {{ ucfirst($video->status === 'active' ? 'Published' : 'Draft') }}
                </span>
            </div>
            
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Uploaded On</label>
                <div style="font-size: 1rem; color: #343541;">{{ $video->created_at->format('M d, Y h:i A') }}</div>
            </div>
            
            @if($video->scheduled_at)
            <div style="margin-bottom: 24px;">
                <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Scheduled At</label>
                <div style="font-size: 1rem; color: #343541;">{{ $video->scheduled_at->format('M d, Y h:i A') }}</div>
            </div>
            @endif
        </div>
        
        <div>
            <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 16px; color: #343541;">Video Preview</h3>
            
            @if($video->thumbnail)
                <div style="margin-bottom: 24px;">
                    <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}" style="width: 100%; border-radius: 8px; border: 1px solid #e5e5e6;">
                </div>
            @endif
            
            @if($video->video_url)
                <div style="margin-bottom: 24px;">
                    @if(str_contains($video->video_url, 'youtube.com') || str_contains($video->video_url, 'youtu.be'))
                        @php
                            $videoId = null;
                            if (preg_match('/(?:youtube\.com\/watch\?v=|youtu\.be\/)([^&\n?#]+)/', $video->video_url, $matches)) {
                                $videoId = $matches[1];
                            }
                        @endphp
                        @if($videoId)
                            <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{ $videoId }}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen style="border-radius: 8px;"></iframe>
                        @else
                            <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary" style="width: 100%;">Watch Video</a>
                        @endif
                    @elseif(str_contains($video->video_url, 'uploads/videos'))
                        <video controls style="width: 100%; border-radius: 8px;">
                            <source src="{{ asset($video->video_url) }}" type="video/mp4">
                            Your browser does not support the video tag.
                        </video>
                    @else
                        <a href="{{ $video->video_url }}" target="_blank" class="btn btn-primary" style="width: 100%;">Watch Video</a>
                    @endif
                </div>
            @endif
            
            <div style="display: flex; gap: 12px;">
                <a href="{{ route('trainer.videos.edit', $video->id) }}" class="btn btn-primary" style="flex: 1;">Edit Video</a>
                <a href="{{ route('trainer.videos') }}" class="btn" style="background: #f3f4f6; color: #343541; flex: 1;">Back to List</a>
            </div>
        </div>
    </div>
</div>
@endsection
