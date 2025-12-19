// Trainer Live Classes - DataTable and Filters
$(document).ready(function() {
    // Check if DataTable is already initialized and destroy it first
    if ($.fn.DataTable.isDataTable('#liveClassesTable')) {
        $('#liveClassesTable').DataTable().destroy();
    }
    
    const table = $('#liveClassesTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[2, 'desc']],
        columnDefs: [
            { orderable: false, targets: [0, 5, 6] }
        ],
        language: {
            search: "",
            searchPlaceholder: "Search...",
            lengthMenu: "Show _MENU_ entries",
            info: "Showing _START_ to _END_ of _TOTAL_ entries",
            infoEmpty: "No entries to show",
            zeroRecords: "No matching records found"
        }
    });

    // Search functionality
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Status filter
    $('#statusFilter').on('change', function() {
        if (this.value === 'all') {
            table.column(4).search('').draw();
        } else {
            table.column(4).search(this.value, true, false).draw();
        }
    });

    // Sort filter
    $('#sortFilter').on('change', function() {
        if (this.value === 'date_asc') {
            table.order([2, 'asc']).draw();
        } else if (this.value === 'date_desc') {
            table.order([2, 'desc']).draw();
        }
    });
});

// Start Live Class
function startLiveClass(encryptedId) {
    if (!confirm('Are you sure you want to start this live class? Students will be able to join.')) {
        return;
    }
    
    $.ajax({
        url: `/trainer/live-classes/${encryptedId}/start`,
        type: 'POST',
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        },
        success: function(response) {
            if (response.success) {
                showAlert('success', response.message);
                setTimeout(function() {
                    window.location.href = response.redirect;
                }, 1000);
            }
        },
        error: function(xhr) {
            let errorMessage = 'Failed to start live class.';
            if (xhr.responseJSON && xhr.responseJSON.message) {
                errorMessage = xhr.responseJSON.message;
            }
            showAlert('error', errorMessage);
        }
    });
}

// Alert Function
function showAlert(type, message) {
    const alertClass = type === 'success' ? 'alert-success' : 'alert-error';
    const icon = type === 'success' 
        ? '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>'
        : '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>';
    
    const alert = $(`
        <div class="${alertClass}" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px; padding: 12px 16px; border-radius: 8px; display: flex; align-items: center; gap: 12px; box-shadow: 0 4px 6px rgba(0,0,0,0.1);">
            ${icon}
            <div>${message}</div>
        </div>
    `);
    
    $('body').append(alert);
    
    setTimeout(function() {
        alert.fadeOut(500, function() {
            $(this).remove();
        });
    }, 5000);
}
