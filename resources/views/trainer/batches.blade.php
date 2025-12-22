@extends('layouts.trainer')

@section('title', 'Active Batches')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / Active Batch
@endsection
<style>
    span.badge.badge-success {
    margin-bottom: 11px;
}
</style>
@section('content')
<div class="profile-banner">
    <div class="profile-banner-gradient"></div>
    <div class="profile-banner-content">
        <div class="profile-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" class="icon-white" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>Trainer</p>
        </div>
        <a href="{{ route('trainer.batches.create') }}" class="btn btn-primary ms-auto">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
            </svg>
            Add Batch
        </a>
    </div>
</div>

<div class="card card-no-padding">
    <div id="batchesContainer" class="batches-grid">
        @foreach($batches as $index => $batch)
        <div class="batch-card batch-item @if($index >= 3) hidden-item @endif" data-index="{{ $index }}">
            <div class="batch-card-header">
                <div class="relative-container">
                    @if($batch->thumbnail)
                        <img src="{{ asset('storage/' . $batch->thumbnail) }}" alt="{{ $batch->name }}" class="batch-thumbnail-img">
                    @else
                        <div class="batch-card-icon">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-purple" style="width: 40px; height: 40px;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
            <div class="batch-card-body">
                <div class="batch-card-actions-top">
                    <button class="card-menu-btn" type="button">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="icon-gray" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 5v.01M12 12v.01M12 19v.01M12 6a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2zm0 7a1 1 0 110-2 1 1 0 010 2z"></path>
                        </svg>
                    </button>
                    <div class="batch-action-buttons">
                        <button class="btn-action-small btn-view" onclick="viewBatchDetails({{ $batch->id }})" title="View Details">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                            </svg>
                        </button>
                        <button class="btn-action-small btn-delete" onclick="confirmDeleteBatch({{ $batch->id }}, '{{ $batch->name }}')" title="Delete">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <span class="badge badge-success badge-mb">{{ $batch->course->title ?? 'Batch' }}</span>
                <h3 class="card-title">{{ $batch->name }}</h3>
                <p class="card-subtitle">{{ number_format($batch->enrollments->count()) }} / {{ $batch->max_students ?? '∞' }} Students</p>
                <div class="batch-meta-info">
                    <div class="batch-meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        <span>{{ $batch->start_date ? $batch->start_date->format('d M Y') : 'N/A' }}</span>
                    </div>
                    @if($batch->class_time)
                    <div class="batch-meta-item">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <span>{{ \Carbon\Carbon::parse($batch->class_time)->format('h:i A') }}</span>
                    </div>
                    @endif
                </div>
                <div class="card-actions">
                    <span class="badge badge-success">Published</span>
                    <a href="{{ route('trainer.batches.edit', $batch->id) }}" class="btn btn-sm btn-edit btn-dark">Edit</a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @if($batches->count() > 3)
    <div class="show-more-container">
        <button id="showMoreBatchesBtn" class="show-more-btn">
            Show More ({{ $batches->count() - 3 }} more)
        </button>
    </div>
    @endif
</div>

<!-- Batch Details Modal -->
<div class="modal fade" id="batchDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Batch Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="batchDetailsContent">
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
<div class="modal fade" id="deleteBatchModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this batch?</p>
                <div class="delete-info">
                    <p><strong>Batch:</strong> <span id="deleteBatchName"></span></p>
                </div>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteBatchForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
<style>
.batch-thumbnail-img {
    width: 100%;
    height: 200px;
    object-fit: cover;
    border-radius: 12px 12px 0 0;
}

.batch-card-actions-top {
    position: absolute;
    top: 12px;
    right: 12px;
    display: flex;
    gap: 8px;
    align-items: center;
}

.batch-action-buttons {
    display: flex;
    gap: 4px;
}

.btn-action-small {
    width: 28px;
    height: 28px;
    border: none;
    border-radius: 6px;
    display: flex;
    align-items: center;
    justify-content: center;
    cursor: pointer;
    transition: all 0.2s;
    background: rgba(255, 255, 255, 0.9);
    backdrop-filter: blur(4px);
}

.btn-action-small svg {
    width: 14px;
    height: 14px;
}

.btn-view {
    color: #2563eb;
}

.btn-view:hover {
    background: #dbeafe;
}

.btn-delete {
    color: #dc2626;
}

.btn-delete:hover {
    background: #fee2e2;
}

.batch-meta-info {
    display: flex;
    flex-direction: column;
    gap: 8px;
    margin: 12px 0;
    font-size: 0.875rem;
    color: #6b7280;
}

.batch-meta-item {
    display: flex;
    align-items: center;
    gap: 8px;
}

.delete-info {
    background: #f9fafb;
    padding: 12px;
    border-radius: 6px;
    margin: 12px 0;
}

.delete-info p {
    margin: 4px 0;
}

.text-danger {
    color: #dc2626;
}

.text-center {
    text-align: center;
    padding: 40px;
}

.modal-body .batch-details-section {
    margin-bottom: 24px;
}

.batch-details-section h6 {
    font-size: 0.875rem;
    font-weight: 600;
    color: var(--text-secondary, #6b7280);
    text-transform: uppercase;
    letter-spacing: 0.5px;
    margin-bottom: 12px;
}

.batch-details-grid {
    display: grid;
    grid-template-columns: repeat(2, 1fr);
    gap: 16px;
}

.batch-details-item {
    padding: 12px;
    background: #f9fafb;
    border-radius: 6px;
}

.batch-details-item label {
    font-size: 0.75rem;
    color: var(--text-secondary, #6b7280);
    display: block;
    margin-bottom: 4px;
}

.batch-details-item .value {
    font-weight: 500;
    color: var(--text-primary, #1a1a1a);
}

.students-list {
    display: flex;
    flex-direction: column;
    gap: 12px;
    margin-top: 12px;
}

.student-item-detail {
    padding: 12px;
    background: #f9fafb;
    border-radius: 6px;
    border-left: 3px solid #2563eb;
}

@media (max-width: 768px) {
    .batch-details-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
$(document).ready(function() {
    const $batchesContainer = $('#batchesContainer');
    const $showMoreBtn = $('#showMoreBatchesBtn');
    const totalBatches = {{ $batches->count() }};
    let showingAll = false;
    
    if (totalBatches > 3) {
        $('.batch-item').each(function() {
            const index = $(this).data('index');
            if (index >= 3) {
                $(this).hide();
            }
        });
        
        $showMoreBtn.on('click', function() {
            const $btn = $(this);
            
            if (!showingAll) {
                $('.batch-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideDown(300);
                    }
                });
                showingAll = true;
                $btn.html('Show Less');
            } else {
                $('.batch-item').each(function() {
                    const index = $(this).data('index');
                    if (index >= 3) {
                        $(this).slideUp(300);
                    }
                });
                showingAll = false;
                $btn.html('Show More (' + (totalBatches - 3) + ' more)');
                
                setTimeout(function() {
                    $('html, body').animate({
                        scrollTop: $batchesContainer.offset().top - 100
                    }, 300);
                }, 300);
            }
        });
    }
});

// View batch details
function viewBatchDetails(batchId) {
    const modal = new bootstrap.Modal(document.getElementById('batchDetailsModal'));
    const content = document.getElementById('batchDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    modal.show();
    
    fetch(`{{ url('trainer/batches') }}/${batchId}/details`, {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            const batch = data.batch;
            
            let html = `
                <div class="batch-details-section">
                    <h6>Batch Information</h6>
                    <div class="batch-details-grid">
                        <div class="batch-details-item">
                            <label>Batch Name</label>
                            <div class="value">${batch.name}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Course</label>
                            <div class="value">${batch.course ? batch.course.title : 'N/A'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Start Date</label>
                            <div class="value">${batch.start_date ? new Date(batch.start_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>End Date</label>
                            <div class="value">${batch.end_date ? new Date(batch.end_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Class Time</label>
                            <div class="value">${batch.class_time ? new Date(batch.class_time).toLocaleTimeString() : 'N/A'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Close Time</label>
                            <div class="value">${batch.close_time ? new Date('2000-01-01 ' + batch.close_time).toLocaleTimeString() : 'N/A'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Max Students</label>
                            <div class="value">${batch.max_students || '∞'}</div>
                        </div>
                        <div class="batch-details-item">
                            <label>Enrolled Students</label>
                            <div class="value">${batch.enrollments ? batch.enrollments.length : 0}</div>
                        </div>
                    </div>
                    ${batch.description ? `<div class="batch-details-item" style="grid-column: 1 / -1; margin-top: 12px;"><label>Description</label><div class="value">${batch.description}</div></div>` : ''}
                </div>
            `;
            
            if (batch.enrollments && batch.enrollments.length > 0) {
                html += `
                    <div class="batch-details-section">
                        <h6>Enrolled Students (${batch.enrollments.length})</h6>
                        <div class="students-list">
                            ${batch.enrollments.map(enrollment => `
                                <div class="student-item-detail">
                                    <strong>${enrollment.student ? enrollment.student.name : 'Unknown'}</strong>
                                    <div class="text-muted-small">${enrollment.student ? enrollment.student.email : 'N/A'}</div>
                                </div>
                            `).join('')}
                        </div>
                    </div>
                `;
            }
            
            content.innerHTML = html;
        } else {
            content.innerHTML = '<div class="alert alert-danger">Error loading batch details.</div>';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-danger">Error loading batch details.</div>';
    });
}

// Confirm delete batch
function confirmDeleteBatch(batchId, batchName) {
    document.getElementById('deleteBatchName').textContent = batchName;
    document.getElementById('deleteBatchForm').action = `{{ url('trainer/batches') }}/${batchId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteBatchModal'));
    modal.show();
}
</script>
@endpush
