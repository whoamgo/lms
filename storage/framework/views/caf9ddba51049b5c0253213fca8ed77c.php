<?php $__env->startSection('title', 'Total Student Enroll'); ?>

<?php $__env->startSection('breadcrumbs'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a> / Total Student Enroll
<?php $__env->stopSection(); ?>

<?php $__env->startSection('admin-banner'); ?>
<div class="admin-banner">
    <div class="icon">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="admin-banner-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
        </svg>
    </div>
    <h1>Admin</h1>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content'); ?>
<br /><br />
<div class="stats-grid">
    <div class="stat-card">
        <div class="icon green">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path>
            </svg>
        </div>
        <div class="content">
            <h3>Total Students</h3>
            <div class="value"><?php echo e(number_format($totalStudents)); ?></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="icon blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
        </div>
        <div class="content">
            <h3>Active Students</h3>
            <div class="value"><?php echo e(number_format($activeStudents)); ?></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="icon yellow">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
            </svg>
        </div>
        <div class="content">
            <h3>New this month</h3>
            <div class="value"><?php echo e(number_format($newThisMonth)); ?></div>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="icon blue">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="stat-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
            </svg>
        </div>
        <div class="content">
            <h3>Total Enrollments</h3>
            <div class="value"><?php echo e(number_format($enrollments->count())); ?></div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">Student Enrollment Management</h2>
        <div>
            <form method="GET" action="<?php echo e(route('admin.student-enroll.export')); ?>" id="exportForm" class="inline-form">
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
    </div>
    
    <div class="table-container">
        <table class="data-table" id="enrollmentsTable">
            <thead>
                <tr>
                    <!-- <th><input type="checkbox" id="selectAll"></th> -->
                    <th>Student</th>
                    <th>Course</th>
                    <th>Batch</th>
                    <th>Trainers</th>
                    <th>Status</th>
                    <th>Progress</th>
                    <th>Enrolled Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php $__empty_1 = true; $__currentLoopData = $enrollments; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $enrollment): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <tr>
                    <!-- <td><input type="checkbox" class="row-checkbox"></td> -->
                    <td>
                        <div class="student-info-cell">
                            <div class="student-avatar">
                                <?php if($enrollment->student->avatar): ?>
                                    <img src="<?php echo e(asset('storage/' . $enrollment->student->avatar)); ?>" alt="<?php echo e($enrollment->student->name); ?>">
                                <?php else: ?>
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                <?php endif; ?>
                            </div>
                            <div>
                                <div class="student-name"><?php echo e($enrollment->student->name); ?></div>
                                <div class="student-email"><?php echo e($enrollment->student->email); ?></div>
                                <div class="student-phone"><?php echo e($enrollment->student->phone ?? 'N/A'); ?></div>
                            </div>
                        </div>
                    </td>
                    <td>
                        <div class="course-info-cell">
                            <div class="course-title"><?php echo e($enrollment->course->title); ?></div>
                            <div class="course-meta">
                                <?php if($enrollment->course->thumbnail): ?>
                                    <img src="<?php echo e(asset('storage/' . $enrollment->course->thumbnail)); ?>" alt="<?php echo e($enrollment->course->title); ?>" class="course-thumbnail">
                                <?php endif; ?>
                            </div>
                        </div>
                    </td>
                    <td>
                        <?php if($enrollment->batch): ?>
                            <div class="batch-info">
                                <div class="batch-name"><?php echo e($enrollment->batch->name); ?></div>
                                <div class="batch-date"><?php echo e($enrollment->batch->start_date->format('d M Y')); ?> - <?php echo e($enrollment->batch->end_date->format('d M Y')); ?></div>
                            </div>
                        <?php else: ?>
                            <span class="text-muted">No Batch</span>
                        <?php endif; ?>
                    </td>
                    <td>
                        <div class="trainers-list">
                            <?php $__empty_2 = true; $__currentLoopData = $enrollment->course->trainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_2 = false; ?>
                                <span class="trainer-badge"><?php echo e($trainer->name); ?></span>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_2): ?>
                                <span class="text-muted">No Trainers</span>
                            <?php endif; ?>
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-<?php echo e($enrollment->status === 'enrolled' ? 'success' : ($enrollment->status === 'completed' ? 'info' : 'warning')); ?>">
                            <?php echo e(ucfirst($enrollment->status)); ?>

                        </span>
                    </td>
                    <td>
                        <div class="progress-cell">
                            <div class="progress-bar-container">
                                <div class="progress-bar-fill" data-progress="<?php echo e($enrollment->progress_percentage ?? 0); ?>"></div>
                            </div>
                            <span class="progress-text"><?php echo e($enrollment->progress_percentage ?? 0); ?>%</span>
                        </div>
                    </td>
                    <td><?php echo e($enrollment->enrolled_at ? $enrollment->enrolled_at->format('d M Y') : $enrollment->created_at->format('d M Y')); ?></td>
                    <td>
                        <div class="action-buttons">
                            <button class="btn-action btn-view" onclick="viewEnrollmentDetails(<?php echo e($enrollment->id); ?>)" title="View Details">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                </svg>
                            </button>
                            <button class="btn-action btn-delete" onclick="confirmDeleteEnrollment(<?php echo e($enrollment->id); ?>, '<?php echo e($enrollment->student->name); ?>', '<?php echo e($enrollment->course->title); ?>')" title="Delete">
                                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <tr>
                    <td colspan="9" class="text-center">No enrollments found.</td>
                </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Enrollment Details Modal -->
<div class="modal fade" id="enrollmentDetailsModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Enrollment Details</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body" id="enrollmentDetailsContent">
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
<div class="modal fade" id="deleteEnrollmentModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Confirm Delete</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <p>Are you sure you want to delete this enrollment?</p>
                <div class="delete-info">
                    <p><strong>Student:</strong> <span id="deleteStudentName"></span></p>
                    <p><strong>Course:</strong> <span id="deleteCourseName"></span></p>
                </div>
                <p class="text-danger"><small>This action cannot be undone.</small></p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <form id="deleteEnrollmentForm" method="POST" class="inline-form">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
 

<?php $__env->startPush('scripts'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
// Initialize DataTable
$(document).ready(function() {
    // Destroy existing DataTable instance if it exists
    if ($.fn.DataTable.isDataTable('#enrollmentsTable')) {
        $('#enrollmentsTable').DataTable().destroy();
    }
    
    $('#enrollmentsTable').DataTable({
        order: [[6, 'desc']],
        pageLength: 25,
        responsive: true,
        autoWidth: false,
        scrollX: true,
        processing: true,
        language: {
            search: "",
            searchPlaceholder: "Search enrollments...",
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
            { orderable: false, targets: [0, 7] } // Disable sorting on checkbox and actions columns
        ],
        drawCallback: function() {
            // Re-apply progress bar widths after table redraw
            $('.progress-bar-fill').each(function() {
                const progress = $(this).data('progress') || 0;
                $(this).css('width', progress + '%');
            });
        }
    });
    
    // Select all checkbox
    $('#selectAll').on('change', function() {
        $('.row-checkbox').prop('checked', this.checked);
    });
    
    // Set progress bar widths
    $('.progress-bar-fill').each(function() {
        const progress = $(this).data('progress') || 0;
        $(this).css('width', progress + '%');
    });
});

// View enrollment details
function viewEnrollmentDetails(enrollmentId) {
    const modal = new bootstrap.Modal(document.getElementById('enrollmentDetailsModal'));
    const content = document.getElementById('enrollmentDetailsContent');
    
    content.innerHTML = '<div class="text-center"><div class="spinner-border" role="status"><span class="visually-hidden">Loading...</span></div></div>';
    modal.show();
    
    fetch(`<?php echo e(url('admin/student-enroll')); ?>/${enrollmentId}/details`, {
        method: 'GET',
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        },
        credentials: 'same-origin'
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.success) {
            const enrollment = data.enrollment;
            const quizAttempts = data.quizAttempts || [];
            
            let html = `
                <div class="enrollment-details-section">
                    <h6>Student Information</h6>
                    <div class="enrollment-details-grid">
                        <div class="enrollment-details-item">
                            <label>Name</label>
                            <div class="value">${enrollment.student.name}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Email</label>
                            <div class="value">${enrollment.student.email}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Phone</label>
                            <div class="value">${enrollment.student.phone || 'N/A'}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Enrolled Date</label>
                            <div class="value">${enrollment.enrolled_at ? new Date(enrollment.enrolled_at).toLocaleDateString() : 'N/A'}</div>
                        </div>
                    </div>
                </div>
                
                <div class="enrollment-details-section">
                    <h6>Course Information</h6>
                    <div class="enrollment-details-grid">
                        <div class="enrollment-details-item">
                            <label>Course Title</label>
                            <div class="value">${enrollment.course.title}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Status</label>
                            <div class="value"><span class="badge badge-${enrollment.status === 'enrolled' ? 'success' : (enrollment.status === 'completed' ? 'info' : 'warning')}">${enrollment.status}</span></div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Progress</label>
                            <div class="value">${enrollment.progress_percentage || 0}%</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Video Progress</label>
                            <div class="value">${data.completedVideos || 0} / ${data.totalVideos || 0} videos</div>
                        </div>
                    </div>
                </div>
                
                ${enrollment.batch ? `
                <div class="enrollment-details-section">
                    <h6>Batch Information</h6>
                    <div class="enrollment-details-grid">
                        <div class="enrollment-details-item">
                            <label>Batch Name</label>
                            <div class="value">${enrollment.batch.name}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Start Date</label>
                            <div class="value">${enrollment.batch.start_date ? new Date(enrollment.batch.start_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>End Date</label>
                            <div class="value">${enrollment.batch.end_date ? new Date(enrollment.batch.end_date).toLocaleDateString() : 'N/A'}</div>
                        </div>
                        <div class="enrollment-details-item">
                            <label>Class Time</label>
                            <div class="value">${enrollment.batch.class_time ? formatTime(enrollment.batch.class_time) : 'N/A'}</div>
                        </div>
                        ${enrollment.batch.close_time ? `
                        <div class="enrollment-details-item">
                            <label>Close Time</label>
                            <div class="value">${formatTime(enrollment.batch.close_time)}</div>
                        </div>
                        ` : ''}
                    </div>
                </div>
                ` : ''}
                
                ${enrollment.course.trainers && enrollment.course.trainers.length > 0 ? `
                <div class="enrollment-details-section">
                    <h6>Assigned Trainers</h6>
                    <div class="enrollment-details-grid">
                        ${enrollment.course.trainers.map(trainer => `
                            <div class="enrollment-details-item">
                                <label>Trainer</label>
                                <div class="value">${trainer.name}</div>
                            </div>
                        `).join('')}
                    </div>
                </div>
                ` : ''}
            `;
            
            if (quizAttempts && quizAttempts.length > 0) {
                html += `
                    <div class="enrollment-details-section">
                        <h6>Quiz Reports</h6>
                        <table class="quiz-reports-table">
                            <thead>
                                <tr>
                                    <th>Quiz Title</th>
                                    <th>Score</th>
                                    <th>Percentage</th>
                                    <th>Status</th>
                                    <th>Completed At</th>
                                </tr>
                            </thead>
                            <tbody>
                                ${quizAttempts.map(attempt => `
                                    <tr>
                                        <td>${attempt.quiz_title || 'N/A'}</td>
                                        <td>${attempt.score || 0} / ${attempt.total_points || 0}</td>
                                        <td>${attempt.percentage || 0}%</td>
                                        <td><span class="badge badge-${attempt.status === 'completed' ? 'success' : 'warning'}">${attempt.status}</span></td>
                                        <td>${attempt.completed_at ? new Date(attempt.completed_at).toLocaleString() : 'N/A'}</td>
                                    </tr>
                                `).join('')}
                            </tbody>
                        </table>
                    </div>
                `;
            } else {
                html += `
                    <div class="enrollment-details-section">
                        <h6>Quiz Reports</h6>
                        <p class="text-muted">No quiz attempts found for this enrollment.</p>
                    </div>
                `;
            }
            
            content.innerHTML = html;
        } else {
            content.innerHTML = `<div class="alert alert-error">${data.message || 'Error loading enrollment details.'}</div>`;
        }
    })
    .catch(error => {
        console.error('Error:', error);
        content.innerHTML = '<div class="alert alert-error">Error loading enrollment details. Please try again.</div>';
    });
}

// Helper function to format time
function formatTime(timeString) {
    if (!timeString) return 'N/A';
    try {
        // Handle both "HH:MM:SS" and "HH:MM" formats
        const parts = timeString.split(':');
        if (parts.length >= 2) {
            const hours = parseInt(parts[0]);
            const minutes = parts[1];
            const ampm = hours >= 12 ? 'PM' : 'AM';
            const displayHours = hours % 12 || 12;
            return `${displayHours}:${minutes} ${ampm}`;
        }
        return timeString;
    } catch (e) {
        return timeString;
    }
}

// Confirm delete enrollment
function confirmDeleteEnrollment(enrollmentId, studentName, courseName) {
    document.getElementById('deleteStudentName').textContent = studentName;
    document.getElementById('deleteCourseName').textContent = courseName;
    document.getElementById('deleteEnrollmentForm').action = `<?php echo e(url('admin/student-enroll')); ?>/${enrollmentId}`;
    
    const modal = new bootstrap.Modal(document.getElementById('deleteEnrollmentModal'));
    modal.show();
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/ok/resources/views/admin/student-enroll/index.blade.php ENDPATH**/ ?>