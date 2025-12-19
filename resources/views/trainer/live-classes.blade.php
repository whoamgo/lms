@extends('layouts.trainer')

@section('title', 'Upcoming Live Classes')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Upcoming Live Classes
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
    Manage, Schedule and track your upcoming live Sessions with your students!
</p>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px;">{{ str_pad($totalUpcoming, 2, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Total Upcoming Classes</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #9333ea 0%, #7e22ce 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px;">{{ str_pad($liveThisWeek, 2, '0', STR_PAD_LEFT) }}</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Live This Week</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #ec4899 0%, #db2777 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px;">{{ $totalHosted }}+</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Total Hosted Sessions</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #f97316 0%, #ef4444 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2.5rem; font-weight: 600; margin-bottom: 8px;">{{ $nextClassStartsIn ?? 'N/A' }}</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Next Class Starts In</div>
    </div>
</div>

<div class="search-filter-bar">
    <input type="text" class="search-input" id="searchInput" placeholder="Search by session name...">
    <select class="filter-select" id="statusFilter">
        <option value="all">All Sessions</option>
        <option value="scheduled">Upcoming</option>
        <option value="live">Live</option>
        <option value="completed">Completed</option>
    </select>
    <select class="filter-select" id="sortFilter">
        <option value="">Sort By</option>
        <option value="date_asc">Date (Ascending)</option>
        <option value="date_desc">Date (Descending)</option>
    </select>
    <a href="{{ route('trainer.live-classes.create') }}" class="btn btn-primary">Add New Class</a>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table" id="liveClassesTable">
            <thead>
                <tr>
                    <th>Thumbnail</th>
                    <th>Class Title</th>
                    <th>Date & Time</th>
                    <th>Duration</th>
                    <th>Status</th>
                    <th>Join</th>
                    <th>Edit</th>
                </tr>
            </thead>
            <tbody>
                @foreach($liveClasses as $class)
                <tr>
                    <td>
                        @if($class->thumbnail)
                            <img src="{{ asset($class->thumbnail) }}" alt="{{ $class->title }}" class="thumbnail-img">
                        @else
                            <div class="thumbnail-img" style="background: #e5e5e6; display: flex; align-items: center; justify-content: center; color: #9ca3af;">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                </svg>
                            </div>
                        @endif
                    </td>
                    <td>
                        <div style="font-weight: 500;">{{ $class->title }}</div>
                        @if($class->course)
                            <div style="font-size: 0.75rem; color: #6b7280; margin-top: 4px;">{{ $class->course->title }}</div>
                        @endif
                    </td>
                    <td>
                        <div>{{ $class->scheduled_at->format('M d, Y') }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $class->scheduled_at->format('g:i A') }}</div>
                    </td>
                    <td>
                        @if($class->duration)
                            @php
                                $hours = floor($class->duration / 60);
                                $minutes = $class->duration % 60;
                            @endphp
                            @if($hours > 0 && $minutes > 0)
                                {{ $hours }} {{ $hours == 1 ? 'hour' : 'hours' }} {{ $minutes }} {{ $minutes == 1 ? 'min' : 'mins' }}
                            @elseif($hours > 0)
                                {{ $hours }} {{ $hours == 1 ? 'hour' : 'hours' }}
                            @else
                                {{ $minutes }} {{ $minutes == 1 ? 'min' : 'mins' }}
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($class->status === 'scheduled')
                            <span class="status-badge status-upcoming">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upcoming
                            </span>
                        @elseif($class->status === 'live')
                            <span class="status-badge status-live">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Live
                            </span>
                        @elseif($class->status === 'completed')
                            <span class="status-badge status-completed">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Completed
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($class->status === 'live' && $class->meeting_link)
                            <a href="{{ route('trainer.live-classes.join', \App\Helpers\EncryptionHelper::encryptIdForUrl($class->id)) }}" class="btn btn-purple btn-sm">Join</a>
                        @elseif($class->status === 'scheduled' && $class->scheduled_at <= now()->addMinutes(15))
                            <button class="btn btn-success btn-sm" onclick="startLiveClass('{{ \App\Helpers\EncryptionHelper::encryptIdForUrl($class->id) }}')" title="Start Class">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 14px; height: 14px; margin-right: 4px;">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Start
                            </button>
                        @else
                            <button class="btn btn-purple btn-sm" disabled style="opacity: 0.5; cursor: not-allowed;">Join</button>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('trainer.live-classes.edit', \App\Helpers\EncryptionHelper::encryptIdForUrl($class->id)) }}" class="btn btn-pink btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script src="{{ asset('js/trainer-live-classes.js') }}"></script>
@endpush
