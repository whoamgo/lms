@extends('layouts.admin')

@section('title', 'Assign Course')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Assign Course
@endsection

@section('content')
<div class="card">
    <h2 class="card-subtitle">Recently Created Courses</h2>
    @if($courses->count() > 0)
        <div class="recent-courses-list">
            @foreach($courses as $course)
                <div class="recent-course-item">
                    <div class="recent-course-thumbnail">
                        @if($course->thumbnail)
                            <img src="{{ asset('storage/' . $course->thumbnail) }}" alt="{{ $course->title }}">
                        @else
                            <div class="recent-course-placeholder">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                    </div>
                    <div class="recent-course-content">
                        <h3 class="recent-course-title">{{ $course->title }}</h3>
                        <div class="recent-course-trainers">
                            @if($course->trainers->count() > 0)
                                @foreach($course->trainers as $trainer)
                                    <span class="trainer-tag">
                                        {{ $trainer->name }}
                                        <span class="remove-trainer" onclick="removeTrainer({{ $course->id }}, {{ $trainer->id }}, this)">×</span>
                                    </span>
                                @endforeach
                            @else
                                <span class="no-trainer-text">No trainers assigned</span>
                            @endif
                        </div>
                    </div>
                    <div class="recent-course-actions">
                        <select class="trainer-select" data-course-id="{{ $course->id }}" onchange="assignTrainer(this, {{ $course->id }})">
                            <option value="">----Select Trainer----</option>
                            @php
                                $assignedTrainerIds = $course->trainers->pluck('id')->toArray();
                            @endphp
                            @foreach($trainers as $trainer)
                                @if(!in_array($trainer->id, $assignedTrainerIds))
                                    <option value="{{ $trainer->id }}">{{ $trainer->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <p class="text-muted text-center no-data-message">No courses found.</p>
    @endif
</div>

<!-- Remove Trainer Confirmation Modal -->
<div class="modal fade" id="removeTrainerModal" tabindex="-1" aria-labelledby="removeTrainerModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="removeTrainerModalLabel">Remove Trainer</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to remove this trainer from the course?</p>
                <p class="text-muted" id="removeTrainerInfo"></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-danger" id="confirmRemoveTrainer">Yes, Remove</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
@endpush

@push('scripts')
<script>
function assignTrainer(selectElement, courseId) {
    const trainerId = selectElement.value;
    if (!trainerId) return;
    
    // Disable select while processing
    selectElement.disabled = true;
    
    fetch(`{{ url('admin/assign-course') }}/${courseId}/assign-trainer`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        },
        body: JSON.stringify({ trainer_id: trainerId })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Add trainer tag
            const courseItem = selectElement.closest('.recent-course-item');
            const trainersContainer = courseItem.querySelector('.recent-course-trainers');
            
            // Remove "No trainers assigned" text if exists
            const noTrainerText = trainersContainer.querySelector('.no-trainer-text');
            if (noTrainerText) {
                noTrainerText.remove();
            }
            
            // Create trainer tag
            const trainerTag = document.createElement('span');
            trainerTag.className = 'trainer-tag';
            trainerTag.innerHTML = `
                ${data.trainer.name}
                <span class="remove-trainer" onclick="removeTrainer(${courseId}, ${data.trainer.id}, this)">×</span>
            `;
            trainersContainer.appendChild(trainerTag);
            
            // Remove option from select
            const option = selectElement.querySelector(`option[value="${trainerId}"]`);
            if (option) {
                option.remove();
            }
            
            // Reset select
            selectElement.value = '';
            selectElement.disabled = false;
            
            // Show success message
            showNotification('Trainer assigned successfully!', 'success');
        } else {
            selectElement.disabled = false;
            showNotification(data.message || 'Error assigning trainer', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        selectElement.disabled = false;
        showNotification('An error occurred while assigning trainer', 'error');
    });
}

let pendingRemoveAction = null;

function removeTrainer(courseId, trainerId, element) {
    // Get trainer and course names for display
    const trainerTag = element.closest('.trainer-tag');
    const trainerName = trainerTag ? trainerTag.textContent.replace('×', '').trim() : 'this trainer';
    const courseItem = element.closest('.recent-course-item');
    const courseTitle = courseItem ? courseItem.querySelector('.recent-course-title')?.textContent?.trim() : 'the course';
    
    // Store the action details
    pendingRemoveAction = {
        courseId: courseId,
        trainerId: trainerId,
        element: element,
        trainerName: trainerName,
        courseTitle: courseTitle
    };
    
    // Update modal content
    document.getElementById('removeTrainerInfo').textContent = `Trainer: ${trainerName} will be removed from ${courseTitle}.`;
    
    // Show Bootstrap modal
    const modal = new bootstrap.Modal(document.getElementById('removeTrainerModal'));
    modal.show();
}

// Handle confirm button click
document.addEventListener('DOMContentLoaded', function() {
    const confirmBtn = document.getElementById('confirmRemoveTrainer');
    if (confirmBtn) {
        confirmBtn.addEventListener('click', function() {
            if (!pendingRemoveAction) return;
            
            const { courseId, trainerId, element } = pendingRemoveAction;
            const btn = this;
            btn.disabled = true;
            btn.textContent = 'Removing...';
            
            fetch(`{{ url('admin/assign-course') }}/${courseId}/remove-trainer/${trainerId}`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json',
                    'Accept': 'application/json'
                }
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error('Network response was not ok');
                }
                return response.json();
            })
            .then(data => {
                if (data.success) {
                    // Close modal
                    const modal = bootstrap.Modal.getInstance(document.getElementById('removeTrainerModal'));
                    modal.hide();
                    
                    // Remove trainer tag
                    const trainerTag = element.closest('.trainer-tag');
                    if (trainerTag) {
                        trainerTag.remove();
                    }
                    
                    // Add option back to select
                    const courseItem = element.closest('.recent-course-item');
                    if (courseItem) {
                        const select = courseItem.querySelector('.trainer-select');
                        if (select && data.trainer) {
                            const option = document.createElement('option');
                            option.value = data.trainer.id;
                            option.textContent = data.trainer.name;
                            select.appendChild(option);
                        }
                        
                        // Check if no trainers left
                        const trainersContainer = courseItem.querySelector('.recent-course-trainers');
                        if (trainersContainer && trainersContainer.querySelectorAll('.trainer-tag').length === 0) {
                            const noTrainerText = document.createElement('span');
                            noTrainerText.className = 'no-trainer-text';
                            noTrainerText.textContent = 'No trainers assigned';
                            trainersContainer.appendChild(noTrainerText);
                        }
                    }
                    
                    showNotification('Trainer removed successfully!', 'success');
                } else {
                    showNotification(data.message || 'Error removing trainer', 'error');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showNotification('An error occurred while removing trainer', 'error');
            })
            .finally(() => {
                btn.disabled = false;
                btn.textContent = 'Yes, Remove';
                pendingRemoveAction = null;
            });
        });
    }
    
    // Reset pending action when modal is closed
    const modal = document.getElementById('removeTrainerModal');
    if (modal) {
        modal.addEventListener('hidden.bs.modal', function() {
            pendingRemoveAction = null;
        });
    }
});

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'error'} alert-fixed`;
    notification.innerHTML = `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            ${type === 'success' 
                ? '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
                : '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>'
            }
        </svg>
        ${message}
    `;
    
    document.body.appendChild(notification);
    
    // Auto remove after 3 seconds
    setTimeout(() => {
        notification.style.transition = 'opacity 0.5s';
        notification.style.opacity = '0';
        setTimeout(() => notification.remove(), 500);
    }, 3000);
}
</script>
@endpush

