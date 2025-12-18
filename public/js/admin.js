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
    
    // Initialize DataTables if present
    if (typeof $ !== 'undefined' && $.fn.DataTable) {
        $('.data-table').DataTable({
            pageLength: 25,
            responsive: true,
            order: [[0, 'desc']],
            language: {
                search: "Search:",
                lengthMenu: "Show _MENU_ entries",
                info: "Showing _START_ to _END_ of _TOTAL_ entries",
                infoEmpty: "No entries to show",
                paginate: {
                    first: "First",
                    last: "Last",
                    next: "Next",
                    previous: "Previous"
                }
            }
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

