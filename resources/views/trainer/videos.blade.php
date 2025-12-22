@extends('layouts.trainer')

@section('title', 'Uploaded Videos')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Uploaded videos
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 80px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 20px;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -40px; border: 4px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
            <p style="color: #6b7280; margin: 4px 0 0 0;">Trainer</p>
        </div>
    </div>
</div>

<p style="text-align: center; color: #6b7280; margin-bottom: 32px; font-size: 0.875rem;">
    Manage your Course Lectures, tutorials and recorded sessions all in one Place.
</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px; color: #343541;">{{ str_pad($totalVideos, 2, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size: 0.875rem; color: #6b7280;">Total Videos</div>
    </div>
    
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px; color: #343541;">{{ str_pad($liveThisWeek, 2, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size: 0.875rem; color: #6b7280;">Live This Week</div>
    </div>
    
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px; color: #343541;">{{ number_format($totalWatchHours) }}+</div>
        <div style="font-size: 0.875rem; color: #6b7280;">Total Watch Hours</div>
    </div>
    
    <div style="background: white; padding: 24px; border-radius: 12px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 8px;">
            <div style="font-size: 2.5rem; font-weight: 600; color: #343541;">{{ $averageRating }}</div>
            <svg fill="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: #fbbf24;">
                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
        </div>
        <div style="font-size: 0.875rem; color: #6b7280;">Average Video Rating</div>
    </div>
</div>

<div class="search-filter-bar">
    <input type="text" class="search-input" id="searchInput" placeholder="Search by video title or course name...">
    <select class="filter-select" id="dateFilter">
        <option value="">Filter by Upload Date</option>
        <option value="newest">Newest First</option>
        <option value="oldest">Oldest First</option>
    </select>
    <a href="{{ route('trainer.videos.create') }}" class="btn btn-primary" style="background: #dc2626; color: white;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; margin-right: 8px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
        </svg>
        Upload New Videos
    </a>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table" id="videosTable">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Video Title</th>
                    <th>Course</th>
                    <th>Duration</th>
                    <th>Views</th>
                    <th>Uploaded On</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($videos as $video)
                <tr>
                    <td>
                        @if($video->thumbnail)
                            <img src="{{ asset($video->thumbnail) }}" alt="{{ $video->title }}" class="thumbnail-img">
                        @else
                            <div class="thumbnail-img" style="background: #e5e5e6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $video->title }}</div>
                        @if($video->description)
                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">{{ Str::limit($video->description, 50) }}</div>
                        @endif
                    </td>
                    <td>{{ $video->course->title ?? 'N/A' }}</td>
                    <td>
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
                    </td>
                    <td>{{ number_format($video->views ?? 0) }}</td>
                    <td>{{ $video->created_at->format('M d, Y') }}</td>
                    <td>
                        <span class="badge badge-{{ $video->status === 'active' ? 'success' : 'warning' }}">
                            {{ ucfirst($video->status === 'active' ? 'Published' : 'Draft') }}
                        </span>
                    </td>
                    <td>
                        <div style="display: flex; gap: 8px;">
                            <a href="{{ route('trainer.videos.watch', \App\Helpers\EncryptionHelper::encryptIdForUrl($video->id)) }}" class="btn btn-purple btn-sm">Watch</a>
                            <a href="{{ route('trainer.videos.show', $video->id) }}" class="btn btn-primary btn-sm">View / Edit</a>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/trainer-videos.js') }}"></script>
@endpush

