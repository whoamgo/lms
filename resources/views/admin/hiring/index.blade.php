@extends('layouts.admin')

@section('title', 'Hiring Portal')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Hiring Portal
@endsection

@section('content')
<br /><br />
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">Hiring Portal</h2>
        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#jobModal">Add New Job</button>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="hiringTable">
            <thead>
                <tr>
                    <th><input type="checkbox" id="selectAll"></th>
                    <th>Job Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Salary Range</th>
                    <th>Applications</th>
                    <th>Posted Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobsWithCounts as $job)
                <tr>
                    <td><input type="checkbox" class="row-checkbox"></td>
                    <td>
                        <div class="job-title-cell">
                            <strong>{{ $job->job_title }}</strong>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-info">{{ $job->category }}</span>
                    </td>
                    <td>{{ $job->job_location }}</td>
                    <td>{{ $job->salary_range }}</td>
                    <td>
                        <span class="badge badge-success">{{ $job->application_count ?? 0 }} Applied</span>
                    </td>
                    <td>{{ \Carbon\Carbon::parse($job->created_at)->format('d M Y') }}</td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="viewJobDetails({{ $job->id }})" title="View Details">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDeleteJob({{ $job->id }}, '{{ $job->job_title }}')" title="Delete">
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

<!-- Job Details Modal -->
<div class="modal fade" id="jobDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Job Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="jobDetailsContent">
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
<div class="modal fade" id="deleteJobModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this job posting?</p>
                <div class="delete-info">
                    <p><strong>Job Title:</strong> <span id="deleteJobTitle"></span></p>
                </div>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteJobForm" method="POST" class="inline-form">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Add Job Modal -->
<div class="modal fade" id="jobModal" tabindex="-1" aria-labelledby="jobModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="jobModalLabel">Add New Job</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('admin.hiring.store') }}" id="addJobForm">
                    @csrf
                    
                    <div class="form-group">
                        <label>Job Title*</label>
                        <input type="text" name="job_title" required placeholder="Enter job title" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Job Location*</label>
                        <input type="text" name="job_location" required placeholder="Enter job location" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Salary Range*</label>
                        <input type="text" name="salary_range" required placeholder="Enter salary range" class="form-control">
                    </div>
                    
                    <div class="form-group">
                        <label>Category*</label>
                        <select name="category" required class="form-control">
                            <option value="">-- Select Category --</option>
                            <option value="Development">Development</option>
                            <option value="Design">Design</option>
                            <option value="Marketing">Marketing</option>
                            <option value="Teaching">Teaching</option>
                        </select>
                    </div>
                    
                    <div class="form-group">
                        <label>Job Description</label>
                        <textarea name="job_description" rows="4" placeholder="Write about the job..." class="form-control"></textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="submit" form="addJobForm" class="btn btn-warning">Save Job</button>
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
    if ($.fn.DataTable.isDataTable('#hiringTable')) {
        $('#hiringTable').DataTable().destroy();
    }
    
    $('#hiringTable').DataTable({
        order: [[6, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search jobs...",
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

// View job details
function viewJobDetails(jobId) {
    const modal = new bootstrap.Modal(document.getElementById('jobDetailsModal'));
    const content = document.getElementById('jobDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    modal.show();
    
    fetch(`{{ url('admin/hiring') }}/${jobId}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const job = data.job;
            const applications = data.applications || [];
            
            let html = `
                <div class="job-details-section">
                    <h6>Job Information</h6>
                    <div class="job-details-grid">
                        <div class="job-details-item">
                            <label>Job Title</label>
                            <div class="value">${job.job_title}</div>
                        </div>
                        <div class="job-details-item">
                            <label>Category</label>
                            <div class="value"><span class="badge badge-info">${job.category}</span></div>
                        </div>
                        <div class="job-details-item">
                            <label>Location</label>
                            <div class="value">${job.job_location}</div>
                        </div>
                        <div class="job-details-item">
                            <label>Salary Range</label>
                            <div class="value">${job.salary_range}</div>
                        </div>
                        <div class="job-details-item">
                            <label>Posted Date</label>
                            <div class="value">${new Date(job.created_at).toLocaleDateString()}</div>
                        </div>
                        <div class="job-details-item">
                            <label>Total Applications</label>
                            <div class="value"><span class="badge badge-success">${data.application_count || 0} Applied</span></div>
                        </div>
                    </div>
                    ${job.job_description ? `
                        <div class="job-details-item job-details-item-full">
                            <label>Description</label>
                            <div class="value">${job.job_description}</div>
                        </div>
                    ` : ''}
                </div>
            `;
            
            if (applications.length > 0) {
                html += `
                    <div class="job-details-section">
                        <h6>Applications (${applications.length})</h6>
                        <div class="applications-list">
                            ${applications.map(app => `
                                <div class="application-item">
                                    <h6>${app.trainer ? app.trainer.name : 'Unknown Trainer'}</h6>
                                    <div class="application-meta">
                                        <span>Status: <span class="badge badge-${app.status === 'approved' ? 'success' : (app.status === 'rejected' ? 'danger' : 'warning')}">${app.status || 'Pending'}</span></span>
                                        <span>Applied: ${new Date(app.created_at).toLocaleDateString()}</span>
                                    </div>
                                    ${app.cover_letter ? `<div style="margin-top: 8px; font-size: 0.875rem; color: var(--text-secondary, #6b7280);">${app.cover_letter.substring(0, 200)}${app.cover_letter.length > 200 ? '...' : ''}</div>` : ''}
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            } else {
                html += `
                    <div class="job-details-section">
                        <h6>Applications</h6>
                        <p class="text-muted">No applications received for this job yet.</p>
                    </div>
                `;
            }
            
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-danger">Error loading job details.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-danger">Error loading job details.</div>';
    });
}

// Confirm delete job
function confirmDeleteJob(jobId, jobTitle) {
    document.getElementById('deleteJobTitle').textContent = jobTitle;
    document.getElementById('deleteJobForm').action = `{{ url('admin/hiring') }}/${jobId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteJobModal'));
    modal.show();
}
</script>
@endpush
