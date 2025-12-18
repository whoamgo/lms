<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Trainer Dashboard - LMS</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700" rel="stylesheet" />
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
        }
        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 24px;
        }
        .header {
            background: white;
            padding: 24px;
            border-radius: 8px;
            margin-bottom: 24px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 24px;
            margin-bottom: 24px;
        }
        .stat-card {
            background: white;
            border-radius: 8px;
            padding: 24px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.1);
        }
        .stat-card h3 {
            font-size: 0.875rem;
            color: #6e6e80;
            margin-bottom: 8px;
        }
        .stat-card .value {
            font-size: 2rem;
            font-weight: 600;
            color: #343541;
        }
        .btn {
            padding: 10px 20px;
            border-radius: 6px;
            border: none;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
        }
        .btn-logout {
            background: transparent;
            color: #6e6e80;
            border: 1px solid #e5e5e6;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Trainer Dashboard</h1>
            <form action="{{ route('trainer.logout') }}" method="POST">
                @csrf
                <button type="submit" class="btn btn-logout">Logout</button>
            </form>
        </div>
        
        <div class="stats-grid">
            <div class="stat-card">
                <h3>Assigned Courses</h3>
                <div class="value">{{ $assignedCourses }}</div>
            </div>
            
            <div class="stat-card">
                <h3>Active Batches</h3>
                <div class="value">{{ $activeBatches }}</div>
            </div>
            
            <div class="stat-card">
                <h3>Upcoming Classes</h3>
                <div class="value">{{ $upcomingClasses }}</div>
            </div>
        </div>
    </div>
</body>
</html>

