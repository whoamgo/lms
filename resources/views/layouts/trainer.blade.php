<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trainer Dashboard') - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/trainer.css') }}">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    @stack('styles')
</head>
<body>
    <div class="sidebar-overlay" id="sidebarOverlay"></div>
    <div class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <div class="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2>Trainer</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('trainer.dashboard') }}" class="{{ request()->routeIs('trainer.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Dashboard
            </a></li>
            <li><a href="{{ route('trainer.profile') }}" class="{{ request()->routeIs('trainer.profile') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                My Profile
            </a></li>
            <li><a href="{{ route('trainer.assigned-courses') }}" class="{{ request()->routeIs('trainer.assigned-courses') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Assigned Courses
            </a></li>
            <li><a href="{{ route('trainer.active-batches') }}" class="{{ request()->routeIs('trainer.active-batches*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Active Batch
            </a></li>
            <li><a href="{{ route('trainer.live-classes') }}" class="{{ request()->routeIs('trainer.live-classes*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Upcoming Live Classes
            </a></li>
            <li><a href="{{ route('trainer.videos') }}" class="{{ request()->routeIs('trainer.videos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                Uploaded Videos
            </a></li>
            <li><a href="{{ route('trainer.skillspace') }}" class="{{ request()->routeIs('trainer.skillspace*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                SkillSpace
            </a></li>
        </ul>
        
        <!-- Notifications Section in Sidebar -->
        <div class="sidebar-notifications">
            <div class="sidebar-notifications-header">
                <span class="sidebar-notifications-title">Notifications</span>
                <span class="notification-badge" id="sidebarNotificationCount">0</span>
            </div>
            <div id="sidebarNotificationsList">
                <!-- Notifications will be loaded here via AJAX -->
            </div>
            <a href="{{ route('trainer.notifications.index') }}" class="btn btn-sm btn-primary" style="width: 100%; margin-top: 12px; text-align: center;">View All</a>
        </div>
        
        <a href="{{ route('trainer.skillspace') }}" class="skillspace-btn">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
            SkillSpace
        </a>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-toggle d-md-none me-3" id="mobileMenuToggle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="breadcrumbs">
                    @hasSection('breadcrumbs')
                        {!! trim($__env->yieldContent('breadcrumbs')) !!}
                    @else
                        <a href="{{ route('trainer.dashboard') }}">Home</a>
                    @endif
                </div>
            </div>
            <div class="header-actions">
                <!-- Notification Icon with Dropdown -->
                <div class="notification-icon-wrapper position-relative">
                    <div class="notification-icon" id="notificationIcon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                    </div>
                    <span class="notification-count-badge" id="headerNotificationCount">0</span>
                    
                    <!-- Notification Dropdown -->
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div class="notification-dropdown-header">
                            <span class="notification-dropdown-title">Notifications</span>
                            <button class="mark-all-read-btn" id="markAllReadBtn">Mark all as read</button>
                        </div>
                        <div id="notificationDropdownList">
                            <!-- Notifications will be loaded here -->
                        </div>
                        <div style="padding: 12px; text-align: center; border-top: 1px solid #e5e5e6;">
                            <a href="{{ route('trainer.notifications.index') }}" class="btn btn-sm btn-primary">View All Notifications</a>
                        </div>
                    </div>
                </div>
                
                <form action="{{ route('trainer.logout') }}" method="POST" class="d-inline">
                    @csrf
                    <button type="submit" class="btn" style="background: #f3f4f6; color: #343541; border: 1px solid #e5e5e6;">Logout</button>
                </form>
            </div>
        </div>
        
        <div class="content-area">
            @yield('content')
        </div>
        
        @hasSection('footer')
            @yield('footer')
        @else
            <div class="footer-gradient">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between align-items-center flex-wrap">
                        <div class="footer-text">Business No: +91 7766967799</div>
                        <div class="footer-text">Email: hro@skillwaala.com</div>
                    </div>
                </div>
            </div>
            <div class="footer-copyright">
                Copyright ©2027 SkillWaala. All Rights Reserved.
            </div>
        @endif
    </div>
    
    @if(session('success'))
    <div class="alert alert-success notification-alert">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error notification-alert">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/trainer.js') }}"></script>
    <script>
        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.notification-alert').forEach(alert => {
                alert.style.transition = 'opacity 0.5s';
                alert.style.opacity = '0';
                setTimeout(() => alert.remove(), 500);
            });
        }, 5000);
    </script>
    @stack('scripts')
</body>
</html>
