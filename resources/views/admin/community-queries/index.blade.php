@extends('layouts.admin')

@section('title', 'All Community Query')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / All Community Query
@endsection
@section('content')
<br /><br />
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">All Community Queries</h2>
        <form method="GET" action="{{ route('admin.community-queries.export') }}" id="exportForm" class="inline-form">
            <div class="export-form-container">
                <input type="date" name="start_date" id="exportStartDate" class="form-control" placeholder="Start Date">
                <input type="date" name="end_date" id="exportEndDate" class="form-control" placeholder="End Date">
                <button type="submit" class="btn btn-success">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Export to Excel
                </button>
            </div>
        </form>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="queriesTable">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Subject</th>
                    <th>Question</th>
                    <th>Course</th>
                    <th>Assigned To</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($queries as $query)
                <tr>
                    <td>{{ $query->student->name ?? 'N/A' }}</td>
                    <td>{{ $query->subject }}</td>
                    <td class="question-cell">{{ Str::limit($query->question, 100) }}</td>
                    <td>{{ $query->course->title ?? 'N/A' }}</td>
                    <td>
                        @if($query->assignedTrainer)
                            {{ $query->assignedTrainer->name }}
                        @else
                            <form method="POST" action="{{ route('admin.community-queries.assign', $query->id) }}" class="inline-form">
                                @csrf
                                <select name="trainer_id" onchange="this.form.submit()" class="trainer-assign-select">
                                    <option value="">Assign Trainer</option>
                                    @foreach($trainers as $trainer)
                                        <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                    @endforeach
                                </select>
                            </form>
                        @endif
                    </td>
                    <td>
                        <span class="badge {{ $query->status === 'resolved' ? 'badge-success' : ($query->status === 'assigned' ? 'badge-info' : 'badge-danger') }}">
                            {{ ucfirst($query->status) }}
                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openReplyModal({{ $query->id }}, '{{ addslashes($query->question) }}')">Reply</button>
                            @if($query->status !== 'closed')
                            <button type="button" class="btn btn-dark btn-sm" onclick="openCloseModal({{ $query->id }})">Close</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Reply Modal -->
<div class="modal fade" id="replyModal" tabindex="-1" aria-labelledby="replyModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="replyModalLabel">Reply to Query</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="replyForm" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Question</label>
                        <textarea id="replyQuestion" readonly rows="3" class="form-control readonly-textarea"></textarea>
                    </div>
                    <div class="form-group">
                        <label>Your Reply*</label>
                        <textarea name="answer" rows="6" required placeholder="Enter your reply..." class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('replyForm').submit();">Send Reply</button>
            </div>
        </div>
    </div>
</div>

<!-- Close Modal -->
<div class="modal fade" id="closeModal" tabindex="-1" aria-labelledby="closeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="closeModalLabel">Close Query</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to close this query?</p>
                <form id="closeForm" method="POST">
                    @csrf
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('closeForm').submit();">Yes, Close</button>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
$(document).ready(function() {
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#queriesTable')) {
        $('#queriesTable').DataTable().destroy();
    }
    
    $('#queriesTable').DataTable({
        order: [[9, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search queries...",
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
            { orderable: false, targets: [6] }
        ]
    });
});

function openReplyModal(id, question) {
    document.getElementById('replyQuestion').value = question;
    document.getElementById('replyForm').action = '{{ url("admin/community-queries") }}/' + id + '/reply';
    const modal = new bootstrap.Modal(document.getElementById('replyModal'));
    modal.show();
}

function openCloseModal(id) {
    document.getElementById('closeForm').action = '{{ url("admin/community-queries") }}/' + id + '/close';
    const modal = new bootstrap.Modal(document.getElementById('closeModal'));
    modal.show();
}

// Reset form when modal is hidden
document.getElementById('replyModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('replyForm').reset();
});
</script>
@endpush
@endsection

