<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin Dashboard') - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.7/js/jquery.dataTables.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: var(--bg-secondary, #f5f5f5);
            color: var(--text-primary, #1a1a1a);
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: var(--sidebar-bg, #ffffff);
            border-right: 1px solid var(--border-color, #e5e5e6);
            height: 100vh;
            position: fixed;
            left: 0;
            top: 0;
            padding: 24px 0;
            overflow-y: auto;
        }
        .sidebar-header {
            padding: 0 20px 24px;
            display: flex;
            align-items: center;
            gap: 12px;
            border-bottom: 1px solid #e5e5e6;
            margin-bottom: 24px;
        }
        .sidebar-header .icon {
            width: 32px;
            height: 32px;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .sidebar-header h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: var(--text-primary, #1a1a1a);
        }
        .sidebar-menu {
            list-style: none;
            padding: 0 12px;
        }
        .sidebar-menu li {
            margin-bottom: 4px;
        }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 16px;
            color: var(--text-secondary, #6b7280);
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .sidebar-menu li a:hover {
            background: var(--bg-secondary, #f3f4f6);
            color: var(--text-primary, #1a1a1a);
        }
        .sidebar-menu li a.active {
            /*background: linear-gradient(135deg, #f5576c 0%, #f093fb 100%);*/
            background: linear-gradient(to right, #ff6600, #fb3233);
            color: white;
        }
        .sidebar-menu li a svg {
            width: 20px;
            height: 20px;
        }
        .sidebar-account {
            padding: 12px 20px;
            margin-top: auto;
            border-top: 1px solid #e5e5e6;
            position: absolute;
            bottom: 0;
            width: 100%;
            background: white;
        }
        .sidebar-account h3 {
            font-size: 0.75rem;
            color: #9ca3af;
            margin-bottom: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        .sidebar-account a {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6b7280;
            text-decoration: none;
            font-size: 0.875rem;
            padding: 8px 0;
        }
        .sidebar-account a:hover {
            color: #1a1a1a;
        }
        .main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
        }
        .topbar {
            background: var(--card-bg, white);
            padding: 16px 24px;
            border-bottom: 1px solid var(--border-color, #e5e5e6);
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .breadcrumbs {
            font-size: 0.875rem;
            color: var(--text-secondary, #6b7280);
        }
        .breadcrumbs a {
            color: #667eea;
            text-decoration: none;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .notification-icon {
            width: 40px;
            height: 40px;
            border-radius: 8px;
            background: var(--bg-secondary, #f3f4f6);
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            position: relative;
        }
        .notification-icon svg {
            width: 20px;
            height: 20px;
            color: var(--text-secondary, #6b7280);
        }
        .admin-banner {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 32px 24px;
            margin: 24px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            gap: 16px;
            color: white;
        }
        .admin-banner .icon {
            width: 64px;
            height: 64px;
            background: rgba(255,255,255,0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .admin-banner h1 {
            font-size: 1.5rem;
            font-weight: 600;
        }
        .content-area {
            padding: 0 24px 24px;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: var(--card-bg, white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            display: flex;
            align-items: center;
            gap: 16px;
        }
        .stat-card .icon {
            width: 56px;
            height: 56px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .stat-card .icon.green {
            background: #d1fae5;
            color: #059669;
        }
        .stat-card .icon.blue {
            background: #dbeafe;
            color: #2563eb;
        }
        .stat-card .icon.yellow {
            background: #fef3c7;
            color: #d97706;
        }
        .stat-card .content h3 {
            font-size: 0.875rem;
            color: #6b7280;
            margin-bottom: 4px;
        }
        .stat-card .content .value {
            font-size: 1.75rem;
            font-weight: 600;
            color: #1a1a1a;
        }
        .card {
            background: var(--card-bg, white);
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
            margin-bottom: 24px;
            color: var(--text-primary, #1a1a1a);
        }
        .card h2 {
            font-size: 1.25rem;
            font-weight: 600;
            margin-bottom: 24px;
        }
        .search-filter-bar {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 300px;
            padding: 12px 16px;
            border: 1px solid #e5e5e6;
            border-radius: 8px;
            font-size: 0.875rem;
        }
        .btn {
            padding: 12px 24px;
            border-radius: 8px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .btn-primary {
            background: #2563eb;
            color: white;
        }
        .btn-primary:hover {
            background: #1d4ed8;
        }
        .btn-secondary {
            background: #f3f4f6;
            color: #1a1a1a;
            border: 1px solid #e5e5e6;
        }
        .btn-secondary:hover {
            background: #e5e7eb;
        }
        .btn-warning {
            background: #fbbf24;
            color: white;
        }
        .btn-warning:hover {
            background: #f59e0b;
        }
        .table-container {
            overflow-x: auto;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: var(--bg-secondary, #f9fafb);
        }
        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--text-secondary, #6b7280);
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 16px;
            border-top: 1px solid var(--border-color, #e5e5e6);
            font-size: 0.875rem;
            color: var(--text-primary, #1a1a1a);
        }
        .badge {
            display: inline-block;
            padding: 4px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 500;
        }
        .badge-success {
            background: #d1fae5;
            color: #059669;
        }
        .badge-danger {
            background: #fee2e2;
            color: #dc2626;
        }
        .badge-info {
            background: #dbeafe;
            color: #2563eb;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            font-size: 0.875rem;
            font-weight: 500;
            color: #374151;
            margin-bottom: 8px;
        }
        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 12px 16px;
            border: 1px solid var(--border-color, #e5e5e6);
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: var(--bg-primary, white);
            color: var(--text-primary, #1a1a1a);
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }
        .form-row {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 20px;
        }
        @media (max-width: 768px) {
            .form-row {
                grid-template-columns: 1fr;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="sidebar">
        <div class="sidebar-header">
            <div class="icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            </div>
            <h2>Admin</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                Dashboard
            </a></li>
            <li><a href="{{ route('admin.student-enroll.index') }}" class="{{ request()->routeIs('admin.student-enroll.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Total Student Enroll
            </a></li>
            <li><a href="{{ route('admin.courses.index') }}" class="{{ request()->routeIs('admin.courses.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Active Courses Count
            </a></li>
            <li><a href="{{ route('admin.community-queries.index') }}" class="{{ request()->routeIs('admin.community-queries.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"></path></svg>
                All Community Query
            </a></li>
            <li><a href="{{ route('admin.instructors.index') }}" class="{{ request()->routeIs('admin.instructors.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                Trainer Dashboard
            </a></li>
            <li><a href="{{ route('admin.hiring.index') }}" class="{{ request()->routeIs('admin.hiring.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 13.255A23.931 23.931 0 0112 15c-3.183 0-6.22-.62-9-1.745M16 6V4a2 2 0 00-2-2h-4a2 2 0 00-2 2v2m4 6h.01M5 20h14a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                Hiring Portal
            </a></li>
            <li><a href="{{ route('admin.assign-course.index') }}" class="{{ request()->routeIs('admin.assign-course.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"></path></svg>
                Assign Course
            </a></li>
            <li><a href="{{ route('admin.trainer-module.dashboard') }}" class="{{ request()->routeIs('admin.trainer-module.*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path></svg>
                Trainer Module
            </a></li>
        </ul>
        <div class="sidebar-account">
            <h3>Account</h3>
            <a href="{{ route('admin.settings.index') }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                Settings
            </a>
            <a href="{{ route('admin.profile.index') }}" style="margin-top: 8px;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                Profile
            </a>
            <form action="{{ route('admin.logout') }}" method="POST" style="margin-top: 8px;">
                @csrf
                <button type="submit" style="background: none; border: none; color: #6b7280; cursor: pointer; display: flex; align-items: center; gap: 8px; font-size: 0.875rem; padding: 8px 0; width: 100%; text-align: left;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
    
    <div class="main-content">
        <div class="topbar">
            <div class="breadcrumbs">
                @hasSection('breadcrumbs')
                    {!! trim($__env->yieldContent('breadcrumbs')) !!}
                @else
                    <a href="{{ route('admin.dashboard') }}">Home</a>
                @endif
            </div>
            <div class="topbar-right" style="display: flex; align-items: center; gap: 16px;">
                <!-- Header Search -->
                <div class="header-search">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <input type="text" id="headerSearch" placeholder="Search menu...">
                </div>
                
                <!-- Theme Toggle -->
                <button style="display:none;" class="theme-toggle" id="themeToggle" type="button">
                    <svg id="lightIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; display: none;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z"></path>
                    </svg>
                     <svg id="darkIcon" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z"></path>
                    </svg>  
                </button>
                
                <!-- Notifications -->
                <div style="position: relative;">
                    <div class="notification-icon" id="notificationIcon" style="cursor: pointer;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"></path>
                        </svg>
                        <span class="notification-badge" id="notificationBadge" style="display: none;">0</span>
                    </div>
                    <div class="notification-dropdown" id="notificationDropdown">
                        <div style="padding: 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                            <h3 style="font-size: 1rem; font-weight: 600;">Notifications</h3>
                            <button onclick="markAllAsRead()" style="background: none; border: none; color: var(--text-secondary); cursor: pointer; font-size: 0.875rem;">Mark all as read</button>
                        </div>
                        <div id="notificationList">
                            <div style="padding: 40px; text-align: center; color: var(--text-secondary);">No notifications</div>
                        </div>
                        <div style="padding: 12px; text-align: center; border-top: 1px solid var(--border-color);">
                            <a href="{{ route('admin.notifications.index') }}" style="color: var(--text-primary); text-decoration: none; font-size: 0.875rem;">View all notifications</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        @yield('admin-banner')
        
        <div class="content-area">
            @yield('content')
        </div>
    </div>
    
    <!-- Success/Error Messages -->
    @if(session('success'))
    <div class="alert alert-success" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    @if(session('error'))
    <div class="alert alert-error" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('error') }}
    </div>
    @endif

    @if($errors->any())
    <div class="alert alert-error" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        <div>
            <strong>Please fix the following errors:</strong>
            <ul style="margin-top: 8px; padding-left: 20px;">
                @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    </div>
    @endif

    <script src="{{ asset('js/admin.js') }}"></script>
    <script>
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
            fetch('{{ route("admin.notifications.recent") }}')
                .then(response => response.json())
                .then(data => {
                    const list = document.getElementById('notificationList');
                    if (data.length === 0) {
                        list.innerHTML = '<div style="padding: 40px; text-align: center; color: var(--text-secondary);">No notifications</div>';
                    } else {
                        list.innerHTML = data.map(notif => `
                            <div class="notification-item ${notif.is_read ? '' : 'unread'}" onclick="window.location.href='{{ url('admin/notifications') }}/${notif.id}'">
                                <div style="font-weight: ${notif.is_read ? '400' : '600'}; margin-bottom: 4px;">${notif.title}</div>
                                <div style="font-size: 0.75rem; color: var(--text-secondary);">${notif.message.substring(0, 50)}...</div>
                            </div>
                        `).join('');
                    }
                });
        }

        function markAllAsRead() {
            fetch('{{ route("admin.notifications.mark-all-read") }}', {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Content-Type': 'application/json'
                }
            }).then(() => {
                loadNotifications();
                updateNotificationBadge();
            });
        }

        // Auto-hide alerts
        setTimeout(() => {
            document.querySelectorAll('.alert').forEach(alert => {
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
    @stack('scripts')
</body>
</html>
