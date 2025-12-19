<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Student Dashboard') - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <link rel="stylesheet" href="{{ asset('css/student.css') }}">
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
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"></path>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14v9M4 9v5a2 2 0 002 2h12a2 2 0 002-2V9M4 9l8-5 8 5M4 9l8 5 8-5"></path>
                </svg>
            </div>
            <h2>Student</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('student.dashboard') }}" class="{{ request()->routeIs('student.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Dashboard
            </a></li>
            <li><a href="{{ route('student.profile') }}" class="{{ request()->routeIs('student.profile*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                My Profile
            </a></li>
            <li><a href="{{ route('student.enroll-courses') }}" class="{{ request()->routeIs('student.enroll-courses*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Enroll Courses
            </a></li>
            <li><a href="{{ route('student.certificates') }}" class="{{ request()->routeIs('student.certificates*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                My Certificate
            </a></li>
            <li><a href="{{ route('student.attendance') }}" class="{{ request()->routeIs('student.attendance*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Attendance record
            </a></li>
            <li><a href="{{ route('student.recorded-courses') }}" class="{{ request()->routeIs('student.recorded-courses*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                Recorded Course
            </a></li>
        </ul>
        
        <div class="sidebar-separator"></div>
        <div class="sidebar-section-title">Account</div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('student.logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                Logout
            </a></li>
            <li><a href="{{ route('student.support') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Support
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
            <a href="{{ route('student.notifications.index') }}" class="btn btn-sm btn-primary sidebar-view-all-btn">View All</a>
        </div>
        
        <form id="logout-form" action="{{ route('student.logout') }}" method="POST" class="hidden-form">
            @csrf
        </form>
    </div>
    
    <div class="main-content">
        <div class="header">
            <div class="d-flex align-items-center">
                <button class="mobile-menu-toggle d-md-none me-3" id="mobileMenuToggle">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="mobile-menu-icon">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
                <div class="breadcrumbs">
                    @hasSection('breadcrumbs')
                        {!! trim($__env->yieldContent('breadcrumbs')) !!}
                    @else
                        <a href="{{ route('student.dashboard') }}">Home</a>
                    @endif
                </div>
            </div>
            <div class="header-actions">
                <!-- Notification Icon with Dropdown -->
                <div class="notification-icon-wrapper position-relative">
                    <div class="notification-icon" id="notificationIcon">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="notification-icon-svg">
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
                        <div class="notification-dropdown-footer">
                            <a href="{{ route('student.notifications.index') }}" class="btn btn-sm btn-primary">View All Notifications</a>
                        </div>
                    </div>
                </div>
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
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error notification-alert">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    <script src="{{ asset('js/admin.js') }}"></script>
    <script src="{{ asset('js/student.js') }}"></script>
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
