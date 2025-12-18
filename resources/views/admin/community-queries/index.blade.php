@extends('layouts.admin')

@section('title', 'All Community Query')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / All Community Query
@endsection
@section('content')
<div class="card">
    <h2>All Community Queries</h2>
    
    <div class="table-container">
        <table>
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
                @forelse($queries as $query)
                <tr>
                    <td>{{ $query->student->name ?? 'N/A' }}</td>
                    <td>{{ $query->subject }}</td>
                    <td style="max-width: 300px;">{{ Str::limit($query->question, 100) }}</td>
                    <td>{{ $query->course->title ?? 'N/A' }}</td>
                    <td>
                        @if($query->assignedTrainer)
                            {{ $query->assignedTrainer->name }}
                        @else
                            <form method="POST" action="{{ route('admin.community-queries.assign', $query->id) }}" style="display: inline;">
                                @csrf
                                <select name="trainer_id" onchange="this.form.submit()" style="padding: 6px; border-radius: 4px;">
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
                        <div style="display: flex; gap: 8px;">
                            <button type="button" class="btn btn-primary" style="padding: 6px 12px; font-size: 0.75rem;" onclick="openReplyModal({{ $query->id }}, '{{ addslashes($query->question) }}')">Reply</button>
                            @if($query->status !== 'closed')
                            <button type="button" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.75rem;" onclick="openCloseModal({{ $query->id }})">Close</button>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">No queries found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $queries->links() }}
    </div>
</div>

<!-- Reply Modal -->
<div id="replyModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeReplyModal()">&times;</button>
        <h2 style="margin-bottom: 24px;">Reply to Query</h2>
        <form id="replyForm" method="POST">
            @csrf
            <div class="form-group">
                <label>Question</label>
                <textarea id="replyQuestion" readonly rows="3" style="background: #f9fafb;"></textarea>
            </div>
            <div class="form-group">
                <label>Your Reply*</label>
                <textarea name="answer" rows="6" required placeholder="Enter your reply..."></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closeReplyModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Send Reply</button>
            </div>
        </form>
    </div>
</div>

<!-- Close Modal -->
<div id="closeModal" class="modal">
    <div class="modal-content">
        <button class="modal-close" onclick="closeCloseModal()">&times;</button>
        <h2 style="margin-bottom: 24px;">Close Query</h2>
        <p style="margin-bottom: 24px;">Are you sure you want to close this query?</p>
        <form id="closeForm" method="POST">
            @csrf
            <div style="display: flex; gap: 12px; justify-content: flex-end;">
                <button type="button" onclick="closeCloseModal()" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-primary">Yes, Close</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openReplyModal(id, question) {
        document.getElementById('replyQuestion').value = question;
        document.getElementById('replyForm').action = '{{ url("admin/community-queries") }}/' + id + '/reply';
        document.getElementById('replyModal').classList.add('active');
    }
    
    function closeReplyModal() {
        document.getElementById('replyModal').classList.remove('active');
        document.getElementById('replyForm').reset();
    }
    
    function openCloseModal(id) {
        document.getElementById('closeForm').action = '{{ url("admin/community-queries") }}/' + id + '/close';
        document.getElementById('closeModal').classList.add('active');
    }
    
    function closeCloseModal() {
        document.getElementById('closeModal').classList.remove('active');
    }
    
    // Close modals when clicking outside
    window.onclick = function(event) {
        const replyModal = document.getElementById('replyModal');
        const closeModal = document.getElementById('closeModal');
        if (event.target == replyModal) {
            closeReplyModal();
        }
        if (event.target == closeModal) {
            closeCloseModal();
        }
    }
</script>
@endsection

