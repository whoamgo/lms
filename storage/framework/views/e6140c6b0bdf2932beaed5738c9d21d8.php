<?php $__env->startSection('title', 'All Community Query'); ?>
 
<?php $__env->startSection('breadcrumbs'); ?>
    <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a> / All Community Query
<?php $__env->stopSection(); ?>
<?php $__env->startSection('content'); ?>
<br /><br />
<div class="card">
    <div class="card-header-actions">
        <h2 class="card-title-inline">All Community Queries</h2>
        <form method="GET" action="<?php echo e(route('admin.community-queries.export')); ?>" id="exportForm" class="inline-form">
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
                <?php $__currentLoopData = $queries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $query): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <tr>
                    <td><?php echo e($query->student->name ?? 'N/A'); ?></td>
                    <td><?php echo e($query->subject); ?></td>
                    <td class="question-cell"><?php echo e(Str::limit($query->question, 100)); ?></td>
                    <td><?php echo e($query->course->title ?? 'N/A'); ?></td>
                    <td>
                        <?php if($query->assignedTrainer): ?>
                            <?php echo e($query->assignedTrainer->name); ?>

                        <?php else: ?>
                            <form method="POST" action="<?php echo e(route('admin.community-queries.assign', $query->id)); ?>" class="inline-form">
                                <?php echo csrf_field(); ?>
                                <select name="trainer_id" onchange="this.form.submit()" class="trainer-assign-select">
                                    <option value="">Assign Trainer</option>
                                    <?php $__currentLoopData = $trainers; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $trainer): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($trainer->id); ?>"><?php echo e($trainer->name); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </form>
                        <?php endif; ?>
                    </td>
                    <td>
                        <span class="badge <?php echo e($query->status === 'resolved' ? 'badge-success' : ($query->status === 'assigned' ? 'badge-info' : 'badge-danger')); ?>">
                            <?php echo e(ucfirst($query->status)); ?>

                        </span>
                    </td>
                    <td>
                        <div class="action-buttons">
                            <button type="button" class="btn btn-primary btn-sm" onclick="openReplyModal(<?php echo e($query->id); ?>, '<?php echo e(addslashes($query->question)); ?>')">Reply</button>
                            <?php if($query->status !== 'closed'): ?>
                            <button type="button" class="btn btn-dark btn-sm" onclick="openCloseModal(<?php echo e($query->id); ?>)">Close</button>
                            <?php endif; ?>
                        </div>
                    </td>
                </tr>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
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
                    <?php echo csrf_field(); ?>
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
                    <?php echo csrf_field(); ?>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-dark" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-primary" onclick="document.getElementById('closeForm').submit();">Yes, Close</button>
            </div>
        </div>
    </div>
</div>

<?php $__env->startPush('scripts'); ?>
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
    document.getElementById('replyForm').action = '<?php echo e(url("admin/community-queries")); ?>/' + id + '/reply';
    const modal = new bootstrap.Modal(document.getElementById('replyModal'));
    modal.show();
}

function openCloseModal(id) {
    document.getElementById('closeForm').action = '<?php echo e(url("admin/community-queries")); ?>/' + id + '/close';
    const modal = new bootstrap.Modal(document.getElementById('closeModal'));
    modal.show();
}

// Reset form when modal is hidden
document.getElementById('replyModal').addEventListener('hidden.bs.modal', function () {
    document.getElementById('replyForm').reset();
});
</script>
<?php $__env->stopPush(); ?>
<?php $__env->stopSection(); ?>


<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /var/www/html/ok/resources/views/admin/community-queries/index.blade.php ENDPATH**/ ?>