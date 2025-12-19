// Admin Panel JavaScript
document.addEventListener('DOMContentLoaded', function() {
    // Theme Toggle
    const themeToggle = document.getElementById('themeToggle');
    const html = document.documentElement;
    
    // Check saved theme
    const savedTheme = localStorage.getItem('theme') || 'light';
    html.setAttribute('data-theme', savedTheme);
    
    if (themeToggle) {
        themeToggle.addEventListener('click', function() {
            const currentTheme = html.getAttribute('data-theme');
            const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
            html.setAttribute('data-theme', newTheme);
            localStorage.setItem('theme', newTheme);
        });
    }
    
    // Image Upload Preview
    const imageInputs = document.querySelectorAll('input[type="file"][accept*="image"]');
    imageInputs.forEach(input => {
        input.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Show confirmation modal
                if (confirm('Are you sure you want to upload this image?')) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        const preview = input.closest('.form-group').querySelector('.image-preview');
                        if (preview) {
                            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 8px; margin-top: 12px;">`;
                        }
                    };
                    reader.readAsDataURL(file);
                } else {
                    input.value = '';
                }
            }
        });
    });
    
    // Toggle Buttons
    const toggleButtons = document.querySelectorAll('.toggle-switch');
    toggleButtons.forEach(toggle => {
        toggle.addEventListener('change', function() {
            const form = this.closest('form');
            if (form) {
                form.submit();
            }
        });
    });
    
    // Notification Badge Update
    function updateNotificationBadge() {
        fetch('/admin/notifications/unread-count')
            .then(response => response.json())
            .then(data => {
                const badge = document.getElementById('notificationBadge');
                if (badge) {
                    if (data.count > 0) {
                        badge.textContent = data.count;
                        badge.style.display = 'flex';
                    } else {
                        badge.style.display = 'none';
                    }
                }
            });
    }
    
    // Update notification badge every 30 seconds
    setInterval(updateNotificationBadge, 30000);
    updateNotificationBadge();
    
    // Initialize DataTables if present (only for tables that don't have a specific handler)
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.data-table').each(function() {
            const table = $(this);
            const tableId = table.attr('id');
            
            // Skip tables with specific handlers
            const skipTables = ['videosTable', 'quizzesTable', 'satsangsTable', 'liveClassesTable', 'questionStatsTable', 'attemptsTable'];
            if (tableId && skipTables.includes(tableId)) {
                return; // Skip this table, it will be initialized by its specific handler
            }
            
            // Check if already initialized
            if ($.fn.DataTable.isDataTable(table)) {
                return;
            }
            
            const hasActions = table.find('th:contains("Actions")').length > 0;
            const lastSortableIndex = table.find('thead th').length - (hasActions ? 2 : 1); // Exclude Actions and checkbox columns from sorting
            
            table.DataTable({
                pageLength: 25,
                lengthMenu: [[10, 25, 50, 100, -1], [10, 25, 50, 100, "All"]],
                responsive: true,
                order: [[lastSortableIndex >= 0 ? lastSortableIndex : 0, 'desc']],
                dom: '<"table-header-wrapper"<"table-header-left"l><"table-header-right"f>>rt<"table-footer-wrapper"<"table-footer-left"i><"table-footer-right"p>>',
                language: {
                    search: "",
                    searchPlaceholder: "Search...",
                    lengthMenu: "Show _MENU_ entries",
                    info: "Showing _START_ to _END_ of _TOTAL_ entries",
                    infoEmpty: "No entries to show",
                    infoFiltered: "(filtered from _MAX_ total entries)",
                    zeroRecords: "No matching records found",
                    emptyTable: "No data available in table",
                    paginate: {
                        first: "First",
                        last: "Last",
                        next: "Next",
                        previous: "Previous"
                    }
                },
                columnDefs: [
                    {
                        targets: [0], // Checkbox column
                        orderable: false,
                        searchable: false
                    },
                    {
                        targets: -1, // Actions column (last column)
                        orderable: false,
                        searchable: false
                    }
                ],
                initComplete: function() {
                    // Add custom styling after initialization
                    this.api().columns().every(function() {
                        const column = this;
                        const header = $(column.header());
                        if (header.text().trim() !== '' && !header.find('input, select').length) {
                            // Add sort icons
                            header.append('<span class="sort-icon"></span>');
                        }
                    });
                },
                drawCallback: function() {
                    // Reinitialize tooltips or other interactive elements if needed
                }
            });
        });
    }
    
    // Header Search
    const headerSearch = document.getElementById('headerSearch');
    if (headerSearch) {
        headerSearch.addEventListener('input', function() {
            const searchTerm = this.value.toLowerCase();
            const menuItems = document.querySelectorAll('.sidebar-menu a');
            menuItems.forEach(item => {
                const text = item.textContent.toLowerCase();
                if (text.includes(searchTerm) || searchTerm === '') {
                    item.closest('li').style.display = '';
                } else {
                    item.closest('li').style.display = 'none';
                }
            });
        });
    }
});

