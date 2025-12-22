@extends('layouts.admin')

@section('title', 'Notifications')
 


@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Notifications
@endsection

@section('content')
<br /><br />
<div class="card">
    <h2>All Notifications</h2>
    
    <div class="table-container">
        <table class="data-table">
            <thead>
                <tr>
                    <th>Type</th>
                    <th>Title</th>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($notifications as $notification)
                <tr class="{{ $notification->is_read ? '' : 'unread' }}">
                    <td>
                        <span class="badge badge-{{ $notification->type === 'error' ? 'danger' : ($notification->type === 'success' ? 'success' : 'info') }}">
                            {{ ucfirst($notification->type) }}
                        </span>
                    </td>
                    <td>{{ $notification->title }}</td>
                    <td>{{ Str::limit($notification->message, 50) }}</td>
                

                     <td>{{ $notification->created_at ? $notification->created_at->format('d/m/Y') : 'N/A' }}</td>
                    <td>
                        <span class="badge {{ $notification->is_read ? 'badge-success' : 'badge-danger' }}">
                            {{ $notification->is_read ? 'Read' : 'Unread' }}
                        </span>
                    </td>
                    <td>
                        <a href="{{ route('admin.notifications.show', $notification->id) }}" class="btn btn-primary btn-sm">View</a>
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
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('.data-table')) {
        $('.data-table').DataTable().destroy();
    }
    
    $('.data-table').DataTable({
        order: [[3, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search notifications...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries found",
            infoFiltered: "(filtered from _MAX_ total entries)",
            paginate: {
                first: "First",
                last: "Last",
                next: "Next",
                previous: "Previous"
            },
            processing: "Loading..."
        },
        dom: '<"table-header-wrapper"<"table-header-left"l><"table-header-right"f>>rt<"table-footer-wrapper"<"table-footer-left"i><"table-footer-right"p>>',
        columnDefs: [
            { orderable: false, targets: [5] }
        ]
    });
});
</script>
@endpush
