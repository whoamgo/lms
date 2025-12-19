// Student Portal JavaScript - Same as Trainer

$(document).ready(function() {
    // Mobile Menu Toggle
    $('#mobileMenuToggle').on('click', function() {
        $('#sidebar').toggleClass('active');
        $('#sidebarOverlay').toggleClass('active');
    });
    
    $('#sidebarOverlay').on('click', function() {
        $('#sidebar').removeClass('active');
        $(this).removeClass('active');
    });
    
    // Notification Icon Click
    $('#notificationIcon').on('click', function(e) {
        e.stopPropagation();
        $('#notificationDropdown').toggleClass('active');
        loadNotifications();
    });
    
    // Close dropdown when clicking outside
    $(document).on('click', function(e) {
        if (!$(e.target).closest('.notification-icon-wrapper').length) {
            $('#notificationDropdown').removeClass('active');
        }
    });
    
    // Mark all as read
    $('#markAllReadBtn').on('click', function(e) {
        e.stopPropagation();
        $.ajax({
            url: '{{ route("student.notifications.mark-all-read") }}',
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function(response) {
                if (response.success) {
                    loadNotificationCount();
                    loadNotifications();
                    loadSidebarNotifications();
                }
            }
        });
    });
    
    // Load notification count
    function loadNotificationCount() {
        $.ajax({
            url: '{{ route("student.notifications.unread-count") }}',
            type: 'GET',
            success: function(response) {
                const count = response.count || 0;
                $('#headerNotificationCount').text(count);
                $('#sidebarNotificationCount').text(count);
                
                if (count > 0) {
                    $('#headerNotificationCount').show();
                    $('#sidebarNotificationCount').show();
                } else {
                    $('#headerNotificationCount').hide();
                    $('#sidebarNotificationCount').hide();
                }
            }
        });
    }
    
    // Load notifications for dropdown
    function loadNotifications() {
        $.ajax({
            url: '{{ route("student.notifications.recent") }}',
            type: 'GET',
            success: function(notifications) {
                let html = '';
                if (notifications.length === 0) {
                    html = '<div style="padding: 24px; text-align: center; color: #9ca3af;">No notifications</div>';
                } else {
                    notifications.forEach(function(notif) {
                        const avatarColor = getAvatarColor(notif.type);
                        const linkAttr = notif.link ? `data-link="${notif.link}"` : '';
                        html += `
                            <div class="notification-item ${!notif.is_read ? 'unread' : ''}" data-id="${notif.id}" ${linkAttr}>
                                <div class="notification-avatar" style="background: ${avatarColor};">
                                    ${getNotificationIcon(notif.type)}
                                </div>
                                <div class="notification-content">
                                    <div class="notification-title">${notif.title}</div>
                                    <div class="notification-message">${notif.message}</div>
                                    <div class="notification-time">${notif.created_at}</div>
                                </div>
                            </div>
                        `;
                    });
                }
                $('#notificationDropdownList').html(html);
                
                // Mark as read on click
                $(document).off('click', '.notification-item').on('click', '.notification-item', function() {
                    const id = $(this).data('id');
                    const link = $(this).data('link');
                    markAsRead(id);
                    if (link) {
                        setTimeout(function() {
                            window.location.href = link;
                        }, 300);
                    }
                });
            }
        });
    }
    
    // Load sidebar notifications
    function loadSidebarNotifications() {
        $.ajax({
            url: '{{ route("student.notifications.recent") }}',
            type: 'GET',
            success: function(notifications) {
                let html = '';
                const sidebarNotifications = notifications.slice(0, 3);
                if (sidebarNotifications.length === 0) {
                    html = '<div class="sidebar-notification-item"><div class="notification-text">No notifications</div></div>';
                } else {
                    sidebarNotifications.forEach(function(notif) {
                        html += `
                            <div class="sidebar-notification-item ${!notif.is_read ? 'unread' : ''}" data-id="${notif.id}">
                                <div class="notification-text">${notif.title}</div>
                                <div class="notification-time">${notif.created_at}</div>
                            </div>
                        `;
                    });
                }
                $('#sidebarNotificationsList').html(html);
            }
        });
    }
    
    // Mark notification as read
    function markAsRead(id) {
        $.ajax({
            url: `/student/notifications/${id}/read`,
            type: 'POST',
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            },
            success: function() {
                loadNotificationCount();
                loadNotifications();
                loadSidebarNotifications();
            }
        });
    }
    
    // Get avatar color based on type
    function getAvatarColor(type) {
        const colors = {
            'enrollment': 'linear-gradient(135deg, #10b981 0%, #059669 100%)',
            'comment': 'linear-gradient(135deg, #9333ea 0%, #7e22ce 100%)',
            'video': 'linear-gradient(135deg, #ec4899 0%, #db2777 100%)',
            'system': 'linear-gradient(135deg, #f59e0b 0%, #d97706 100%)',
        };
        return colors[type] || 'linear-gradient(135deg, #667eea 0%, #764ba2 100%)';
    }
    
    // Get notification icon
    function getNotificationIcon(type) {
        const icons = {
            'enrollment': '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"></path></svg>',
            'comment': '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>',
            'video': '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>',
            'system': '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>',
        };
        return icons[type] || '<svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path></svg>';
    }
    
    // Initial load
    loadNotificationCount();
    loadSidebarNotifications();
    
    // Refresh notifications every 30 seconds
    setInterval(function() {
        loadNotificationCount();
        loadSidebarNotifications();
    }, 30000);
});
