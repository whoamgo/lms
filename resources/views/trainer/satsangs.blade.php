@extends('layouts.trainer')

@section('title', 'Schedule Career Satsang')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.skillspace') }}">SkillSpace</a> / Schedule Career Satsang
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
        <a href="{{ route('trainer.satsangs.create') }}" class="btn btn-primary">+ Add New Satsang</a>
    </div>
</div>

<div class="card">
    <div class="table-container">
        <table class="data-table" id="satsangsTable">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Scheduled Date</th>
                    <th>Time</th>
                    <th>Timezone</th>
                    <th>Visibility</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($satsangs as $satsang)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $satsang->title }}</div>
                    </td>
                    <td>
                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $satsang->description ?? 'N/A' }}
                        </div>
                    </td>
                    <td>{{ $satsang->scheduled_at->format('M d, Y') }}</td>
                    <td>{{ $satsang->time }}</td>
                    <td>{{ $satsang->timezone }}</td>
                    <td>
                        <span class="badge badge-info">{{ ucfirst($satsang->visibility) }}</span>
                    </td>
                    <td>
                        <span class="badge badge-{{ $satsang->status === 'scheduled' ? 'success' : ($satsang->status === 'live' ? 'info' : 'danger') }}">
                            {{ ucfirst($satsang->status) }}
                        </span>
                    </td>
                    <td>
                        @if($satsang->meeting_link && ($satsang->status === 'scheduled' || $satsang->status === 'live'))
                            <a href="{{ $satsang->meeting_link }}" target="_blank" class="btn btn-purple btn-sm">Join</a>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection

@push('scripts')
<script>
$(document).ready(function() {
    // Check if DataTable is already initialized and destroy it first
    if ($.fn.DataTable.isDataTable('#satsangsTable')) {
        $('#satsangsTable').DataTable().destroy();
    }
    
    $('#satsangsTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[2, 'desc']]
    });
});
</script>
@endpush
@endsection
