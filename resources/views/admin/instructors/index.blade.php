@extends('layouts.admin')

@section('title', 'Trainer Dashboard')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Trainer Dashboard
@endsection

@section('content')
<br /><br />
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">Instructor Management</h2>
        <div class="export-form-container">
            <form method="GET" action="{{ route('admin.instructors.export') }}" id="exportForm" class="inline-form">
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
            <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary">Add New Instructor</a>
        </div>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="instructorsTable">
            <thead>
                <tr>
                    <!-- <th><input type="checkbox" id="selectAll"></th> -->
                    <th>Instructor</th>
                    <th>Contact</th>
                    <th>Assigned Courses</th>
                    <th>Status</th>
                    <th>Join Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($instructors as $instructor)
                <tr>
                    <!-- <td><input type="checkbox" class="row-checkbox"></td> -->
                    <td>
                        <div class="instructor-info-cell">
                            <div class="instructor-avatar">
                                @if($instructor->avatar)
                                    <img src="{{ asset('storage/' . $instructor->avatar) }}" alt="{{ $instructor->name }}">
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <div>
                                <div class="instructor-name">{{ $instructor->name }}</div>
                                <div class="instructor-id">ID: #{{ strtoupper(substr(md5($instructor->id), 0, 9)) }}</div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div>{{ $instructor->email }}</div>
                        <div class="instructor-phone">{{ $instructor->phone ?? 'N/A' }}</div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $instructor->assigned_courses_count }} Courses</span>
                        @if($instructor->assignedCourses->count() > 0)
                            <div class="courses-preview">
                                @foreach($instructor->assignedCourses->take(2) as $course)
                                    <span class="course-chip">{{ $course->title }}</span>
                                @endforeach
                                @if($instructor->assignedCourses->count() > 2)
                                    <span class="course-chip-more">+{{ $instructor->assignedCourses->count() - 2 }} more</span>
                                @endif
                            </div>
                        @endif
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.instructors.toggle-status', $instructor->id) }}" class="inline-form">
                            @csrf
                            @method('PUT')
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $instructor->status === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                    </td>
                    <td>{{ $instructor->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="viewInstructorDetails({{ $instructor->id }})" title="View Details">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="btn-action btn-edit" title="Edit">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"></path>
                                </svg>
                            </a>
                            <button class="btn-action btn-delete" onclick="confirmDeleteInstructor({{ $instructor->id }}, '{{ $instructor->name }}')" title="Delete">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Instructor Details Modal -->
<div class="modal fade" id="instructorDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Instructor Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="instructorDetailsContent">
                <div class="text-center">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteInstructorModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this instructor?</p>
                <div class="delete-info">
                    <p><strong>Instructor:</strong> <span id="deleteInstructorName"></span></p>
                </div>
                <p class="text-danger"><small>This will also remove all course assignments. This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteInstructorForm" method="POST" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
 

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Initialize DataTable
$(document).ready(function() {
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#instructorsTable')) {
        $('#instructorsTable').DataTable().destroy();
    }
    
    $('#instructorsTable').DataTable({
        order: [[4, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search instructors...",
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
            { orderable: false, targets: [0, 5] }
        ]
    });
    
    // Select all checkbox
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
    });
});

// View instructor details
function viewInstructorDetails(instructorId) {
    const modal = new bootstrap.Modal(document.getElementById('instructorDetailsModal'));
    const content = document.getElementById('instructorDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    modal.show();
    
    fetch(`{{ url('admin/instructors') }}/${instructorId}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const instructor = data.instructor;
            
            let html = `
                <div class="instructor-details-section">
                    <h6>Instructor Information</h6>
                    <div class="instructor-details-grid">
                        <div class="instructor-details-item">
                            <label>Name</label>
                            <div class="value">${instructor.name}</div>
                        </div>
                        <div class="instructor-details-item">
                            <label>Email</label>
                            <div class="value">${instructor.email}</div>
                        </div>
                        <div class="instructor-details-item">
                            <label>Phone</label>
                            <div class="value">${instructor.phone || 'N/A'}</div>
                        </div>
                        <div class="instructor-details-item">
                            <label>Status</label>
                            <div class="value"><span class="badge badge-${instructor.status === 'active' ? 'success' : 'danger'}">${instructor.status}</span></div>
                        </div>
                        <div class="instructor-details-item">
                            <label>Join Date</label>
                            <div class="value">${new Date(instructor.created_at).toLocaleDateString()}</div>
                        </div>
                        <div class="instructor-details-item">
                            <label>Total Courses Assigned</label>
                            <div class="value">${instructor.assigned_courses_count || 0} Courses</div>
                        </div>
                    </div>
                </div>
            `;
            
            if (instructor.assigned_courses && instructor.assigned_courses.length > 0) {
                html += `
                    <div class="instructor-details-section">
                        <h6>Assigned Courses (${instructor.assigned_courses.length})</h6>
                        <div class="assigned-courses-list">
                            ${instructor.assigned_courses.map(course => {
                                const batches = course.batches ? course.batches.length : 0;
                                const enrollments = course.enrollments ? course.enrollments.length : 0;
                                const videos = course.videos ? course.videos.length : 0;
                                return `
                                    <div class="assigned-course-item">
                                        <h6>${course.title}</h6>
                                        <div class="assigned-course-meta">
                                            <span>Batches: ${batches}</span>
                                            <span>Students: ${enrollments}</span>
                                            <span>Videos: ${videos}</span>
                                        </div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="instructor-details-section">
                        <h6>Assigned Courses</h6>
                        <p class="text-muted">No courses assigned to this instructor.</p>
                    </div>
                `;
            }
            
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-danger">Error loading instructor details.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-danger">Error loading instructor details.</div>';
    });
}

// Confirm delete instructor
function confirmDeleteInstructor(instructorId, instructorName) {
    document.getElementById('deleteInstructorName').textContent = instructorName;
    document.getElementById('deleteInstructorForm').action = `{{ url('admin/instructors') }}/${instructorId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteInstructorModal'));
    modal.show();
}
</script>
@endpush
