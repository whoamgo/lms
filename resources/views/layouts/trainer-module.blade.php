<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Trainer Module') - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
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
            background: #f7f7f8;
            color: #343541;
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 260px;
            background: #ffffff;
            border-right: 1px solid #e5e5e6;
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
            background: #343541;
            border-radius: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
        }
        .sidebar-header h2 {
            font-size: 1.125rem;
            font-weight: 600;
            color: #343541;
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
            color: #343541;
            text-decoration: none;
            border-radius: 8px;
            transition: all 0.2s;
            font-size: 0.875rem;
        }
        .sidebar-menu li a:hover {
            background: #f7f7f8;
        }
        .sidebar-menu li a.active {
            background: linear-gradient(135deg, #f97316 0%, #ef4444 100%);
            color: white;
        }
        .sidebar-menu li a svg {
            width: 20px;
            height: 20px;
        }
        .main-content {
            margin-left: 260px;
            flex: 1;
            min-height: 100vh;
            padding: 24px;
        }
        .top-bar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 24px;
            gap: 16px;
            flex-wrap: wrap;
        }
        .search-filter-bar {
            display: flex;
            gap: 12px;
            align-items: center;
            flex: 1;
            flex-wrap: wrap;
        }
        .search-input {
            flex: 1;
            min-width: 250px;
            padding: 10px 16px;
            border: 1px solid #e5e5e6;
            border-radius: 8px;
            font-size: 0.875rem;
            background: white;
        }
        .search-input:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
        }
        .filter-select {
            padding: 10px 16px;
            border: 1px solid #e5e5e6;
            border-radius: 8px;
            font-size: 0.875rem;
            background: white;
            cursor: pointer;
        }
        .filter-select:focus {
            outline: none;
            border-color: #2563eb;
        }
        .btn {
            padding: 10px 20px;
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
        .btn-purple {
            background: #9333ea;
            color: white;
        }
        .btn-purple:hover {
            background: #7e22ce;
        }
        .btn-pink {
            background: #ec4899;
            color: white;
        }
        .btn-pink:hover {
            background: #db2777;
        }
        .card {
            background: white;
            border-radius: 12px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .table-container {
            overflow-x: auto;
            margin-top: 24px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        thead {
            background: #f7f7f8;
        }
        th {
            padding: 12px 16px;
            text-align: left;
            font-size: 0.75rem;
            font-weight: 600;
            color: #6b7280;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e5e5e6;
        }
        td {
            padding: 16px;
            border-bottom: 1px solid #e5e5e6;
            font-size: 0.875rem;
            color: #343541;
        }
        .thumbnail-img {
            width: 80px;
            height: 50px;
            object-fit: cover;
            border-radius: 6px;
        }
        .status-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .status-badge svg {
            width: 16px;
            height: 16px;
        }
        .status-upcoming {
            color: #343541;
        }
        .status-live {
            color: #059669;
        }
        .status-completed {
            color: #059669;
        }
        .btn-sm {
            padding: 6px 12px;
            font-size: 0.75rem;
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
            border: 1px solid #e5e5e6;
            border-radius: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
            background: white;
            color: #343541;
        }
        .form-group input:focus,
        .form-group select:focus,
        .form-group textarea:focus {
            outline: none;
            border-color: #2563eb;
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.1);
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
        @media (max-width: 768px) {
            .sidebar {
                transform: translateX(-100%);
                transition: transform 0.3s;
            }
            .main-content {
                margin-left: 0;
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
            <h2>Trainer</h2>
        </div>
        <ul class="sidebar-menu">
            <li><a href="{{ route('admin.trainer-module.dashboard') }}" class="{{ request()->routeIs('admin.trainer-module.dashboard') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Dashboard
            </a></li>
            <li><a href="{{ route('admin.trainer-module.profile') }}" class="{{ request()->routeIs('admin.trainer-module.profile') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                My Profile
            </a></li>
            <li><a href="{{ route('admin.trainer-module.assigned-courses') }}" class="{{ request()->routeIs('admin.trainer-module.assigned-courses') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Assigned Courses
            </a></li>
            <li><a href="{{ route('admin.trainer-module.active-batches') }}" class="{{ request()->routeIs('admin.trainer-module.active-batches') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path></svg>
                Active Batch
            </a></li>
            <li><a href="{{ route('admin.trainer-module.live-classes') }}" class="{{ request()->routeIs('admin.trainer-module.live-classes*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                Upcoming Live Classes
            </a></li>
            <li><a href="{{ route('admin.trainer-module.videos') }}" class="{{ request()->routeIs('admin.trainer-module.videos*') ? 'active' : '' }}">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path></svg>
                Uploaded Videos
            </a></li>
        </ul>
    </div>
    
    <div class="main-content">
        @yield('content')
    </div>
    
    @if(session('success'))
    <div class="alert alert-success" style="position: fixed; top: 80px; right: 24px; z-index: 9999; min-width: 300px; padding: 12px 16px; border-radius: 8px; background: #d1fae5; color: #059669; border: 1px solid #10b981; display: flex; align-items: center; gap: 12px;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
        </svg>
        {{ session('success') }}
    </div>
    @endif

    <script src="{{ asset('js/admin.js') }}"></script>
    @stack('scripts')
</body>
</html>
