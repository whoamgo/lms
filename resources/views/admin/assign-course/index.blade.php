@extends('layouts.admin')

@section('title', 'Assign Course')

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Assign Course
@endsection

@section('content')
<br><br>
<div class="card">
    <h2 style="margin-bottom: 24px; font-size: 1.25rem; font-weight: 600;">Recently Created Courses</h2>
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
        <p style="color: var(--text-secondary, #6b7280); text-align: center; padding: 40px;">No courses found.</p>
    @endif
</div>
@endsection

@push('styles')
<style>
.recent-courses-list {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.recent-course-item {
    display: flex;
    align-items: center;
    gap: 16px;
    padding: 16px;
    background: var(--bg-secondary, #f9fafb);
    border-radius: 8px;
    transition: all 0.2s;
}

.recent-course-item:hover {
    background: var(--bg-secondary, #f3f4f6);
}

.recent-course-thumbnail {
    width: 80px;
    height: 80px;
    border-radius: 8px;
    overflow: hidden;
    flex-shrink: 0;
    background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
}

.recent-course-thumbnail img {
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.recent-course-placeholder {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    color: white;
}

.recent-course-placeholder svg {
    width: 40px;
    height: 40px;
}

.recent-course-content {
    flex: 1;
    min-width: 0;
}

.recent-course-title {
    font-size: 1rem;
    font-weight: 600;
    color: var(--text-primary, #1a1a1a);
    margin: 0 0 8px 0;
}

.recent-course-trainers {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
    align-items: center;
}

.trainer-tag {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 4px 12px;
    background: #2563eb;
    color: white;
    border-radius: 20px;
    font-size: 0.75rem;
    font-weight: 500;
}

.trainer-tag .remove-trainer {
    cursor: pointer;
    width: 16px;
    height: 16px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.2);
    transition: background 0.2s;
    font-size: 14px;
    line-height: 1;
}

.trainer-tag .remove-trainer:hover {
    background: rgba(255, 255, 255, 0.3);
}

.no-trainer-text {
    font-size: 0.875rem;
    color: var(--text-secondary, #6b7280);
    font-style: italic;
}

.recent-course-actions {
    flex-shrink: 0;
}

.trainer-select {
    padding: 8px 16px;
    border: 1px solid var(--border-color, #e5e5e6);
    border-radius: 6px;
    font-size: 0.875rem;
    background: var(--bg-primary, white);
    color: var(--text-primary, #1a1a1a);
    cursor: pointer;
    min-width: 200px;
}

.trainer-select:focus {
    outline: none;
    border-color: #2563eb;
    box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
}

@media (max-width: 768px) {
    .recent-course-item {
        flex-direction: column;
        align-items: flex-start;
    }
    
    .recent-course-actions {
        width: 100%;
    }
    
    .trainer-select {
        width: 100%;
    }
}
</style>
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

function removeTrainer(courseId, trainerId, element) {
    if (!confirm('Are you sure you want to remove this trainer from the course?')) {
        return;
    }
    
    fetch(`{{ url('admin/assign-course') }}/${courseId}/remove-trainer/${trainerId}`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': '{{ csrf_token() }}',
            'Content-Type': 'application/json',
            'Accept': 'application/json'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // Remove trainer tag
            const trainerTag = element.closest('.trainer-tag');
            trainerTag.remove();
            
            // Add option back to select
            const courseItem = element.closest('.recent-course-item');
            const select = courseItem.querySelector('.trainer-select');
            const option = document.createElement('option');
            option.value = data.trainer.id;
            option.textContent = data.trainer.name;
            select.appendChild(option);
            
            // Check if no trainers left
            const trainersContainer = courseItem.querySelector('.recent-course-trainers');
            if (trainersContainer.querySelectorAll('.trainer-tag').length === 0) {
                const noTrainerText = document.createElement('span');
                noTrainerText.className = 'no-trainer-text';
                noTrainerText.textContent = 'No trainers assigned';
                trainersContainer.appendChild(noTrainerText);
            }
            
            showNotification('Trainer removed successfully!', 'success');
        } else {
            showNotification(data.message || 'Error removing trainer', 'error');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        showNotification('An error occurred while removing trainer', 'error');
    });
}

function showNotification(message, type) {
    // Create notification element
    const notification = document.createElement('div');
    notification.className = `alert alert-${type === 'success' ? 'success' : 'error'}`;
    notification.style.cssText = 'position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px; padding: 12px 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px;';
    notification.innerHTML = `
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
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
