@extends('layouts.trainer-module')

@section('title', 'Uploaded Videos')

@section('content')
<div class="top-bar">
    <div class="search-filter-bar">
        <input type="text" class="search-input" id="searchInput" placeholder="Search videos...">
    </div>
    <a href="{{ route('admin.trainer-module.create-video') }}" class="btn btn-primary">Upload New Video</a>
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
                    <th>Upload Date</th>
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
                        @if($video->duration)
                            {{ $video->duration }} {{ $video->duration == 1 ? 'min' : 'mins' }}
                        @else
                            N/A
                        @endif
                    </td>
                    <td>{{ $video->created_at->format('M d, Y') }}</td>
                    <td>
                        <a href="{{ $video->video_url }}" target="_blank" class="btn btn-purple btn-sm">View</a>
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
    $('#videosTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[4, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 5] }
        ]
    });

    $('#searchInput').on('keyup', function() {
        $('#videosTable').DataTable().search(this.value).draw();
    });
});
</script>
@endpush
@endsection
