@extends('layouts.admin')

@section('title', 'Active Courses Count')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Active Courses Count
@endsection

@section('admin-banner')
<div class="admin-banner">
    <div class="icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="admin-banner-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    <h1>Admin</h1>
</div>
@endsection

@section('content')
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">Active Courses & Batch Count</h2>
        <div class="export-form-container">
            <form method="GET" action="{{ route('admin.courses.export') }}" id="exportForm" class="inline-form">
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
            <a href="{{ route('admin.courses.create') }}" class="btn btn-primary">Create New Course</a>
        </div>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="coursesTable">
            <thead>
                <tr>
                    <!-- <th><input type="checkbox" id="selectAll"></th> -->
                    <th>Course</th>
                    <th>Trainers</th>
                    <th>Batches</th>
                    <th>Students</th>
                    <th>Videos</th>
                    <th>Status</th>
                    <th>Dates</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <!-- <td><input type="checkbox" class="row-checkbox"></td> -->
                    <td>
                        <div class="course-info-cell">
                            @if($course->thumbnail)
                                <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}" class="course-thumbnail-small">
                            @else
                                <div class="course-icon-small">
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                            @endif
                            <div>
                                <div class="course-title-cell">{{ $course->title }}</div>
                                <div class="course-meta-cell">
                                    @if($course->batches->where('status', 'active')->count() > 0)
                                        Active: {{ $course->batches->where('status', 'active')->first()->name }}
                                    @else
                                        No active batch
                                    @endif
                                </div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="trainers-list-cell">
                            @forelse($course->trainers->take(2) as $trainer)
                                <span class="trainer-badge-small">{{ $trainer->name }}</span>
                            @empty
                                <span class="text-muted">No Trainers</span>
                            @endforelse
                            @if($course->trainers->count() > 2)
                                <span class="trainer-badge-more">+{{ $course->trainers->count() - 2 }}</span>
                            @endif
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $course->batches_count }} Batches</span>
                        <div class="text-muted-small">{{ $course->batches->where('status', 'active')->count() }} Active</div>
                    </td>
                    <td>
                        <span class="badge badge-success">{{ $course->enrollments_count }} Students</span>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $course->videos_count }} Videos</span>
                    </td>
                    <td>
                        <form method="POST" action="{{ route('admin.courses.toggle-status', $course->id) }}" class="inline-form">
                            @csrf
                            @method('PUT')
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $course->status === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                    </td>
                    <td>
                        <div class="date-cell">
                            <div>{{ $course->start_date ? $course->start_date->format('d M Y') : 'N/A' }}</div>
                            <div class="text-muted-small">{{ $course->end_date ? $course->end_date->format('d M Y') : 'N/A' }}</div>
                        </div>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="viewCourseDetails({{ $course->id }})" title="View Details">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDeleteCourse({{ $course->id }}, '{{ $course->title }}')" title="Delete">
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

<!-- Course Details Modal -->
<div class="modal fade" id="courseDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-xl">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Course Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="courseDetailsContent">
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
<div class="modal fade" id="deleteCourseModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this course?</p>
                <div class="delete-info">
                    <p><strong>Course:</strong> <span id="deleteCourseName"></span></p>
                </div>
                <p class="text-danger"><small>This will also remove all enrollments, batches, and assignments. This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteCourseForm" method="POST" class="inline-form">
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
    if ($.fn.DataTable.isDataTable('#coursesTable')) {
        $('#coursesTable').DataTable().destroy();
    }
    
    $('#coursesTable').DataTable({
        order: [[6, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search courses...",
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
            { orderable: false, targets: [0, 7] }
        ]
    });
    
    // Select all checkbox
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
    });
});

// View course details
function viewCourseDetails(courseId) {
    const modal = new bootstrap.Modal(document.getElementById('courseDetailsModal'));
    const content = document.getElementById('courseDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    modal.show();
    
    fetch(`{{ url('admin/courses') }}/${courseId}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const course = data.course;
            
            let html = `
                <div class="course-details-section">
                    <h6>Course Information</h6>
                    <div class="course-details-grid">
                        <div class="course-details-item">
                            <label>Course Title</label>
                            <div class="value">${course.title}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Status</label>
                            <div class="value"><span class="badge badge-${course.status === 'active' ? 'success' : 'warning'}">${course.status}</span></div>
                        </div>
                        <div class="course-details-item">
                            <label>Start Date</label>
                            <div class="value">${course.start_date ? new Date(course.start_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="course-details-item">
                            <label>End Date</label>
                            <div class="value">${course.end_date ? new Date(course.end_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Duration</label>
                            <div class="value">${course.duration_days || 0} Days</div>
                        </div>
                        <div class="course-details-item">
                            <label>Price</label>
                            <div class="value">${course.price ? '$' + course.price : 'Free'}</div>
                        </div>
                    </div>
                    ${course.description ? `<div class="course-details-item course-details-item-full"><label>Description</label><div class="value">${course.description}</div></div>` : ''}
                </div>
                
                <div class="course-details-section">
                    <h6>Statistics</h6>
                    <div class="course-details-grid">
                        <div class="course-details-item">
                            <label>Total Students</label>
                            <div class="value">${data.totalStudents || 0}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Total Batches</label>
                            <div class="value">${data.totalBatches || 0}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Active Batches</label>
                            <div class="value">${data.activeBatches ? data.activeBatches.length : 0}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Total Videos</label>
                            <div class="value">${course.videos_count || 0}</div>
                        </div>
                        <div class="course-details-item">
                            <label>Assigned Trainers</label>
                            <div class="value">${course.trainers_count || 0}</div>
                        </div>
                    </div>
                </div>
            `;
            
            if (course.trainers && course.trainers.length > 0) {
                html += `
                    <div class="course-details-section">
                        <h6>Assigned Trainers (${course.trainers.length})</h6>
                        <div class="trainers-list-detail">
                            ${course.trainers.map(trainer => `
                                <div class="trainer-item-detail">
                                    <strong>${trainer.name}</strong>
                                    <div class="text-muted-small">${trainer.email || 'N/A'}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
            
            if (data.activeBatches && data.activeBatches.length > 0) {
                html += `
                    <div class="course-details-section">
                        <h6>Active Batches (${data.activeBatches.length})</h6>
                        <div class="batches-list">
                            ${data.activeBatches.map(batch => {
                                const enrollments = batch.enrollments ? batch.enrollments.length : 0;
                                return `
                                    <div class="batch-item-detail">
                                        <strong>${batch.name}</strong>
                                        <div class="text-muted-small">
                                            ${batch.start_date ? new Date(batch.start_date).toLocaleDateString() : 'N/A'} - 
                                            ${batch.end_date ? new Date(batch.end_date).toLocaleDateString() : 'N/A'}
                                        </div>
                                        <div class="text-muted-small">Students: ${enrollments} / ${batch.max_students || '∞'}</div>
                                    </div>
                                `;
                            }).join('')}
                        </div>
                    </div>
                `;
            }
            
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-danger">Error loading course details.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-danger">Error loading course details.</div>';
    });
}

// Confirm delete course
function confirmDeleteCourse(courseId, courseName) {
    document.getElementById('deleteCourseName').textContent = courseName;
    document.getElementById('deleteCourseForm').action = `{{ url('admin/courses') }}/${courseId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteCourseModal'));
    modal.show();
}
</script>
@endpush
