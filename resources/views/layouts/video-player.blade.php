<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Video Player') - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: #1a1a1a;
            color: #ffffff;
            overflow-x: hidden;
        }
        .video-player-container {
            display: flex;
            height: 100vh;
            flex-direction: column;
        }
        .video-header {
            background: #f97316;
            padding: 16px 24px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            z-index: 100;
        }
        .back-btn {
            background: rgba(255, 255, 255, 0.2);
            border: none;
            color: white;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            font-weight: 500;
            transition: background 0.2s;
        }
        .back-btn:hover {
            background: rgba(255, 255, 255, 0.3);
        }
        .course-title {
            font-size: 1rem;
            font-weight: 600;
            color: white;
        }
        .video-main-content {
            display: flex;
            flex: 1;
            overflow: hidden;
        }
        .video-player-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            background: #0f0f0f;
            padding: 24px;
            overflow-y: auto;
        }
        .video-wrapper {
            width: 100%;
            background: #000;
            border-radius: 12px;
            /*overflow: hidden;*/
            margin-bottom: 24px;
            position: relative;
        }
        .video-wrapper video,
        .video-wrapper iframe {
            width: 100%;
            height: auto;
            min-height: 500px;
            display: block;
        }
        .video-info {
            color: #e5e5e5;
        }
        .video-title-section {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 16px;
        }
        .video-title {
            font-size: 1.25rem;
            font-weight: 600;
            color: #ffffff;
            display: flex;
            align-items: center;
            gap: 12px;
        }
        .completed-badge {
            background: #10b981;
            color: white;
            padding: 4px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 500;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .video-actions {
            display: flex;
            gap: 12px;
            margin-bottom: 24px;
        }
        .action-btn {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: #e5e5e5;
            padding: 10px 20px;
            border-radius: 8px;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 8px;
            font-size: 0.875rem;
            transition: all 0.2s;
        }
        .action-btn:hover {
            background: #3a3a3a;
            border-color: #4a4a4a;
        }
        .video-description {
            background: #1a1a1a;
            padding: 20px;
            border-radius: 12px;
            margin-bottom: 24px;
        }
        .description-title {
            font-size: 1rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #ffffff;
        }
        .learning-objectives {
            margin-top: 20px;
        }
        .learning-objectives h4 {
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 12px;
            color: #f97316;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .learning-objectives ul {
            list-style: none;
            padding: 0;
        }
        .learning-objectives li {
            padding: 8px 0;
            padding-left: 24px;
            position: relative;
            color: #d1d5db;
            font-size: 0.875rem;
        }
        .learning-objectives li:before {
            content: "•";
            position: absolute;
            left: 8px;
            color: #f97316;
            font-weight: bold;
        }
        .playlist-sidebar {
            width: 400px;
            background: #1a1a1a;
            border-left: 1px solid #2a2a2a;
            display: flex;
            flex-direction: column;
            overflow-y: auto;
        }
        .playlist-header {
            padding: 20px;
            border-bottom: 1px solid #2a2a2a;
        }
        .playlist-btn {
            background: #2a2a2a;
            border: 1px solid #3a3a3a;
            color: #e5e5e5;
            padding: 8px 16px;
            border-radius: 6px;
            cursor: pointer;
            font-size: 0.875rem;
            font-weight: 500;
        }
        .course-progress {
            margin-top: 20px;
        }
        .progress-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 12px;
        }
        .progress-title {
            font-size: 0.875rem;
            font-weight: 600;
            color: #ffffff;
        }
        .progress-bar {
            width: 100%;
            height: 8px;
            background: #2a2a2a;
            border-radius: 4px;
            overflow: hidden;
        }
        .progress-fill {
            height: 100%;
            background: #10b981;
            transition: width 0.3s;
        }
        .lesson-list {
            padding: 20px;
        }
        .lesson-item {
            display: flex;
            align-items: center;
            padding: 12px;
            border-radius: 8px;
            margin-bottom: 8px;
            cursor: pointer;
            transition: background 0.2s;
            position: relative;
        }
        .lesson-item:hover {
            background: #2a2a2a;
        }
        .lesson-item.active {
            background: #2563eb;
        }
        .lesson-status {
            margin-right: 12px;
            display: flex;
            align-items: center;
        }
        .lesson-status.completed {
            color: #10b981;
        }
        .lesson-status.locked {
            color: #6b7280;
        }
        .lesson-info {
            flex: 1;
            min-width: 0;
        }
        .lesson-title {
            font-size: 0.875rem;
            font-weight: 500;
            color: #ffffff;
            margin-bottom: 4px;
        }
        .lesson-duration {
            font-size: 0.75rem;
            color: #9ca3af;
        }
        .lesson-play-btn {
            margin-left: 12px;
            color: #9ca3af;
            cursor: pointer;
        }
        .lesson-item.active .lesson-play-btn {
            color: #ffffff;
        }
        .lesson-status {
            width: 24px;
            height: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }
        
        .lesson-status.completed svg {
            color: #10b981;
        }
        
        .lesson-status.locked svg {
            color: #ef4444;
        }
        
        @media (max-width: 1024px) {
            .video-main-content {
                flex-direction: column;
            }
            .playlist-sidebar {
                width: 100%;
                max-height: 400px;
                border-left: none;
                border-top: 1px solid #2a2a2a;
            }
        }
        
        @media (max-width: 768px) {
            .video-header {
                padding: 12px 16px;
            }
            
            .course-title {
                font-size: 0.875rem;
            }
            
            .video-player-section {
                padding: 16px;
            }
            
            .video-wrapper video,
            .video-wrapper iframe {
                min-height: 300px;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div class="video-player-container">
        @yield('content')
    </div>
    @stack('scripts')
</body>
</html>
