// Trainer Videos - DataTable and Filters
$(document).ready(function() {
    // Check if DataTable is already initialized and destroy it first
    if ($.fn.DataTable.isDataTable('#videosTable')) {
        $('#videosTable').DataTable().destroy();
    }
    
    const table = $('#videosTable').DataTable({
        pageLength: 25,
        lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
        order: [[5, 'desc']], // Sort by Uploaded On
        columnDefs: [
            { orderable: false, targets: [0, 7] } // Thumbnail and Actions
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

    // Search functionality - search by video title or course name
    $('#searchInput').on('keyup', function() {
        table.search(this.value).draw();
    });

    // Filter by upload date
    $('#dateFilter').on('change', function() {
        if (this.value === 'newest') {
            table.order([5, 'desc']).draw();
        } else if (this.value === 'oldest') {
            table.order([5, 'asc']).draw();
        } else {
            table.order([5, 'desc']).draw();
        }
    });
});

