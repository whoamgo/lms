<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'Admin Dashboard'); ?> - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.dataTables.min.css">
    <link rel="stylesheet" href="<?php echo e(asset('css/admin.css')); ?>">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <!-- Mobile Menu Toggle -->
    <button class="mobile-menu-toggle" id="mobileMenuToggle" type="button">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
    
    <!-- Mobile Overlay -->
    <div class="mobile-overlay" id="mobileOverlay"></div>
    
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2>Admin</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="<?php echo e(route('admin.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a></li>
            <li><a href="<?php echo e(route('admin.student-enroll.index')); ?>" class="<?php echo e(request()->routeIs('admin.student-enroll.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Total Student Enroll
            </a></li>
            <li><a href="<?php echo e(route('admin.courses.index')); ?>" class="<?php echo e(request()->routeIs('admin.courses.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Active Courses Count
            </a></li>
            <li><a href="<?php echo e(route('admin.community-queries.index')); ?>" class="<?php echo e(request()->routeIs('admin.community-queries.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                All Community Query
            </a></li>
            <li><a href="<?php echo e(route('admin.instructors.index')); ?>" class="<?php echo e(request()->routeIs('admin.instructors.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Trainer Dashboard
            </a></li>
            <li><a href="<?php echo e(route('admin.hiring.index')); ?>" class="<?php echo e(request()->routeIs('admin.hiring.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Hiring Portal
            </a></li>
            <li><a href="<?php echo e(route('admin.assign-course.index')); ?>" class="<?php echo e(request()->routeIs('admin.assign-course.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Assign Course
            </a></li>
            <li><a href="<?php echo e(route('admin.trainer-module.dashboard')); ?>" class="<?php echo e(request()->routeIs('admin.trainer-module.*') ? 'active' : ''); ?>">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Trainer Module
            </a></li>
        </ul>
        <div class="sidebar-account">
            <h3>Account</h3>
            <a href="<?php echo e(route('admin.settings.index')); ?>" class="sidebar-account-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="sidebar-account-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Settings
            </a>
            <a href="<?php echo e(route('admin.profile.index')); ?>" class="sidebar-account-link">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="sidebar-account-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <form action="<?php echo e(route('admin.logout')); ?>" method="POST" class="sidebar-account-form">
                <?php echo csrf_field(); ?>
                <button type="submit" class="sidebar-account-button">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="sidebar-account-icon"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
    
    <div class="main-content">
        <div class="topbar">
            <div class="breadcrumbs">
                <?php if (! empty(trim($__env->yieldContent('breadcrumbs')))): ?>
                    <?php echo trim($__env->yieldContent('breadcrumbs')); ?>

                <?php else: ?>
                    <a href="<?php echo e(route('admin.dashboard')); ?>">Home</a>
                <?php endif; ?>
            </div>
            <div class="topbar-right">
                <!-- Header Search -->
                <div class="header-search">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="headerSearch" placeholder="Search menu...">
                </div>
                
                <!-- Theme Toggle -->
                <button class="theme-toggle" id="themeToggle" type="button">
                    <svg id="lightIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="theme-icon theme-icon-hidden">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                     <svg id="darkIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" class="theme-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>  
                </button>
                
                <!-- Notifications -->
                <div class="notification-wrapper">
                    <div class="notification-icon" id="notificationIcon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="notification-badge" id="notificationBadge">0</span>
                    </div>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-dropdown-header">
                            <h3>Notifications</h3>
                            <button onclick="markAllAsRead()" class="notification-mark-all-btn">Mark all as read</button>
                        </div>
                        <div id="notificationList">
                            <div class="notification-empty">No notifications</div>
                        </div>
                        <div class="notification-dropdown-footer">
                            <a href="<?php echo e(route('admin.notifications.index')); ?>">View all notifications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <?php echo $__env->yieldContent('admin-banner'); ?>
        
        <div class="content-area">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>
    
    <!-- Success/Error Messages -->
    <?php if(session('success')): ?>
    <div class="alert alert-success alert-fixed">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <?php echo e(session('success')); ?>

    </div>
    <?php endif; ?>

    <?php if(session('error')): ?>
    <div class="alert alert-error alert-fixed">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <?php echo e(session('error')); ?>

    </div>
    <?php endif; ?>

    <?php if($errors->any()): ?>
    <div class="alert alert-error alert-fixed">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul class="alert-error-list">
                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <li><?php echo e($error); ?></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
        </div>
    </div>
    <?php endif; ?>

    <script src="<?php echo e(asset('js/admin.js')); ?>"></script>
    <script>
        // Mobile menu toggle
        const mobileMenuToggle = document.getElementById('mobileMenuToggle');
        const sidebar = document.getElementById('sidebar');
        const mobileOverlay = document.getElementById('mobileOverlay');
        
        if (mobileMenuToggle) {
            mobileMenuToggle.addEventListener('click', function() {
                sidebar.classList.toggle('mobile-open');
                mobileOverlay.classList.toggle('active');
                document.body.style.overflow = sidebar.classList.contains('mobile-open') ? 'hidden' : '';
            });
        }
        
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function() {
                sidebar.classList.remove('mobile-open');
                mobileOverlay.classList.remove('active');
                document.body.style.overflow = '';
            });
        }
        
        // Notification dropdown toggle
        document.getElementById('notificationIcon')?.addEventListener('click', function(e) {
            e.stopPropagation();
            const dropdown = document.getElementById('notificationDropdown');
            dropdown.classList.toggle('active');
            loadNotifications();
        });

        // Close dropdown when clicking outside
        document.addEventListener('click', function(e) {
            if (!e.target.closest('.notification-icon') && !e.target.closest('.notification-dropdown')) {
                document.getElementById('notificationDropdown')?.classList.remove('active');
            }
        });

        // Load notifications
        function loadNotifications() {
          //  alert("Sss")
            fetch('<?php echo e(route("admin.notifications.recent")); ?>')
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('notificationList');
                    if (data.length === 0) {
                        list.innerHTML = '<div class="notification-empty">No notifications...</div>';
                    } else {
                        list.innerHTML = data.map(notif => `
                            <div class="notification-item ${notif.is_read ? '' : 'unread'}" onclick="window.location.href='<?php echo e(url('admin/notifications')); ?>/${notif.id}'">
                                <div class="notification-item-title ${notif.is_read ? '' : 'notification-unread-title'}">${notif.title}</div>
                                <div class="notification-item-message">${notif.message.substring(0, 50)}...</div>
                            </div>
                        `).join('');
                    }
                });
        }

        function markAllAsRead() {
            fetch('<?php echo e(route("admin.notifications.mark-all-read")); ?>', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                loadNotifications();
                updateNotificationBadge();
            });
        }

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert-fixed').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);

        // Theme icon toggle
        document.addEventListener('DOMContentLoaded', function() {
            const html = document.documentElement;
            const theme = html.getAttribute('data-theme') || 'light';
            if (theme === 'dark') {
                document.getElementById('lightIcon').style.display = 'block';
                document.getElementById('darkIcon').style.display = 'none';
            }
            
            document.getElementById('themeToggle')?.addEventListener('click', function() {
                const currentTheme = html.getAttribute('data-theme');
                const newTheme = currentTheme === 'dark' ? 'light' : 'dark';
                html.setAttribute('data-theme', newTheme);
                localStorage.setItem('theme', newTheme);
                
                if (newTheme === 'dark') {
                    document.getElementById('lightIcon').style.display = 'block';
                    document.getElementById('darkIcon').style.display = 'none';
                } else {
                    document.getElementById('lightIcon').style.display = 'none';
                    document.getElementById('darkIcon').style.display = 'block';
                }
            });
        });
    </script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH /var/www/html/ok/resources/views/layouts/admin.blade.php ENDPATH**/ ?>