@extends('layouts.trainer-module')

@section('title', 'Upcoming Live Classes')

@section('content')
<div class="top-bar">
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
    </div>
    <a href="{{ route('admin.trainer-module.create-live-class') }}" class="btn btn-primary">Add New Class</a>
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
                            {{ $class->duration }} {{ $class->duration == 1 ? 'hour' : 'hours' }}
                            @if($class->duration < 1)
                                {{ ($class->duration * 60) }} mins
                            @endif
                        @else
                            N/A
                        @endif
                    </td>
                    <td>
                        @if($class->status === 'scheduled')
                            <span class="status-badge status-upcoming">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Upcoming
                            </span>
                        @elseif($class->status === 'live')
                            <span class="status-badge status-live">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Live
                            </span>
                        @elseif($class->status === 'completed')
                            <span class="status-badge status-completed">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                </svg>
                                Completed
                            </span>
                        @endif
                    </td>
                    <td>
                        @if($class->meeting_link && ($class->status === 'scheduled' || $class->status === 'live'))
                            <a href="{{ $class->meeting_link }}" target="_blank" class="btn btn-purple btn-sm">Join</a>
                        @else
                            <button class="btn btn-purple btn-sm" disabled>Join</button>
                        @endif
                    </td>
                    <td>
                        <a href="{{ route('admin.trainer-module.edit-live-class', $class->id) }}" class="btn btn-pink btn-sm">Edit</a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    const table = $('#liveClassesTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[2, 'desc']], // Sort by date
        columnDefs: [
            { orderable: false, targets: [0, 5, 6] } // Disable sorting on thumbnail, join, edit
        ]
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        if (this.value === 'all') {
            table.column(4).search('').draw();
        } else {
            table.column(4).search(this.value, true, false).draw();
        }
    });

    // Sort filter
    $('#sortFilter').on('change', function() {
        if (this.value === 'date_asc') {
            table.order([2, 'asc']).draw();
        } else if (this.value === 'date_desc') {
            table.order([2, 'desc']).draw();
        }
    });
});
</script>
@endpush
@endsection
