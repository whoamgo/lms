@extends('layouts.trainer')

@section('title', 'Quiz Report - ' . $quiz->title)

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.skillspace') }}">SkillSpace</a> / <a href="{{ route('trainer.quizzes.index') }}">Quiz</a> / Report
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 60px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 20px 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; justify-content: space-between; gap: 16px;">
        <div style="display: flex; align-items: center; gap: 16px;">
            <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -30px; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
                @if(Auth::user()->avatar)
                    <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
                @else
                    <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                    </svg>
                @endif
            </div>
            <div>
                <h2 style="font-size: 1.25rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
                <p style="color: #6b7280; margin: 2px 0 0 0; font-size: 0.875rem;">Trainer</p>
            </div>
        </div>
        <div style="display: flex; gap: 12px;">
            <button type="button" class="btn" style="background: #10b981; color: white;" onclick="exportQuizReport({{ $quiz->id }})">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px; margin-right: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                </svg>
                Export Report
            </button>
            <a href="{{ route('trainer.quizzes.index') }}" class="btn" style="background: #f3f4f6; color: #343541;">Back to Quizzes</a>
        </div>
    </div>
</div>

<div style="margin-bottom: 24px;">
    <h1 style="font-size: 1.75rem; font-weight: 600; color: #343541; margin-bottom: 8px;">{{ $quiz->title }}</h1>
    @if($quiz->description)
        <p style="color: #6b7280; font-size: 0.875rem;">{{ $quiz->description }}</p>
    @endif
</div>

<!-- Statistics Cards -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 24px; margin-bottom: 32px;">
    <div style="background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2rem; font-weight: 600; margin-bottom: 8px;">{{ number_format($quiz->views ?? 0) }}</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Total Views</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #10b981 0%, #059669 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2rem; font-weight: 600; margin-bottom: 8px;">{{ $totalAttempts }}</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Total Attempts</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #8b5cf6 0%, #7c3aed 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2rem; font-weight: 600; margin-bottom: 8px;">{{ number_format($averageScore, 1) }}%</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Average Score</div>
    </div>
    
    <div style="background: linear-gradient(135deg, #f59e0b 0%, #d97706 100%); padding: 24px; border-radius: 12px; color: white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
        <div style="font-size: 2rem; font-weight: 600; margin-bottom: 8px;">{{ number_format($passRate, 1) }}%</div>
        <div style="font-size: 0.875rem; opacity: 0.9;">Completion Rate</div>
    </div>
</div>

<!-- Quiz Details -->
<div class="card" style="margin-bottom: 24px;">
    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Quiz Information</h3>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 20px;">
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Quiz Type</label>
            <div style="font-size: 1rem; color: #343541;">
                <span class="badge badge-info">{{ ucfirst($quiz->quiz_type) }}</span>
            </div>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Course</label>
            <div style="font-size: 1rem; color: #343541;">{{ $quiz->course->title ?? 'N/A' }}</div>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Total Questions</label>
            <div style="font-size: 1rem; color: #343541;">{{ $quiz->total_questions }}</div>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Time Limit</label>
            <div style="font-size: 1rem; color: #343541;">{{ $quiz->time_limit ? $quiz->time_limit . ' minutes' : 'No limit' }}</div>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Status</label>
            <div style="font-size: 1rem; color: #343541;">
                <span class="badge badge-{{ $quiz->status === 'published' ? 'success' : ($quiz->status === 'draft' ? 'info' : 'danger') }}">
                    {{ ucfirst($quiz->status) }}
                </span>
            </div>
        </div>
        <div>
            <label style="display: block; font-size: 0.875rem; font-weight: 500; color: #6b7280; margin-bottom: 8px;">Average Time Taken</label>
            <div style="font-size: 1rem; color: #343541;">{{ $averageTime > 0 ? gmdate('H:i:s', $averageTime) : 'N/A' }}</div>
        </div>
    </div>
</div>

<!-- Question Statistics -->
@if(count($questionStats) > 0)
<div class="card" style="margin-bottom: 24px;">
    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Question-wise Statistics</h3>
    <div class="table-container">
        <table class="data-table" id="questionStatsTable">
            <thead>
                <tr>
                    <th>Question</th>
                    <th>Total Answers</th>
                    <th>Correct Answers</th>
                    <th>Accuracy</th>
                </tr>
            </thead>
            <tbody>
                @foreach($questionStats as $stat)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ Str::limit($stat['question']->question, 80) }}</div>
                    </td>
                    <td>{{ $stat['total_answers'] }}</td>
                    <td>{{ $stat['correct_count'] }}</td>
                    <td>
                        <div style="display: flex; align-items: center; gap: 8px;">
                            <div style="flex: 1; background: #e5e7eb; border-radius: 4px; height: 8px; overflow: hidden;">
                                <div style="background: {{ $stat['accuracy'] >= 70 ? '#10b981' : ($stat['accuracy'] >= 50 ? '#f59e0b' : '#ef4444') }}; height: 100%; width: {{ $stat['accuracy'] }}%;"></div>
                            </div>
                            <span style="font-weight: 500; min-width: 50px;">{{ number_format($stat['accuracy'], 1) }}%</span>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

<!-- Recent Attempts -->
@if($recentAttempts->count() > 0)
<div class="card">
    <h3 style="font-size: 1.125rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Recent Attempts</h3>
    <div class="table-container">
        <table class="data-table" id="attemptsTable">
            <thead>
                <tr>
                    <th>Student</th>
                    <th>Score</th>
                    <th>Percentage</th>
                    <th>Time Taken</th>
                    <th>Status</th>
                    <th>Completed At</th>
                </tr>
            </thead>
            <tbody>
                @foreach($recentAttempts as $attempt)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $attempt->student->name }}</div>
                        <div style="font-size: 0.75rem; color: #6b7280;">{{ $attempt->student->email }}</div>
                    </td>
                    <td>{{ $attempt->score }} / {{ $attempt->total_points }}</td>
                    <td>
                        <span class="badge badge-{{ $attempt->percentage >= 70 ? 'success' : ($attempt->percentage >= 50 ? 'warning' : 'danger') }}">
                            {{ number_format($attempt->percentage, 1) }}%
                        </span>
                    </td>
                    <td>{{ $attempt->time_taken ? gmdate('H:i:s', $attempt->time_taken) : 'N/A' }}</td>
                    <td>
                        <span class="badge badge-{{ $attempt->status === 'completed' ? 'success' : ($attempt->status === 'in_progress' ? 'info' : 'danger') }}">
                            {{ ucfirst(str_replace('_', ' ', $attempt->status)) }}
                        </span>
                    </td>
                    <td>{{ $attempt->completed_at ? $attempt->completed_at->format('M d, Y h:i A') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@else
<div class="card">
    <div style="text-align: center; padding: 48px 24px; color: #6b7280;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; margin: 0 auto 16px; color: #9ca3af;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
        </svg>
        <p>No attempts have been made on this quiz yet.</p>
    </div>
</div>
@endif
@endsection

@push('scripts')
<script>
function exportQuizReport(quizId) {
    // Create a simple CSV export
    const csvContent = generateCSVReport();
    const blob = new Blob([csvContent], { type: 'text/csv;charset=utf-8;' });
    const link = document.createElement('a');
    const url = URL.createObjectURL(blob);
    link.setAttribute('href', url);
    link.setAttribute('download', 'quiz_report_' + quizId + '_' + new Date().toISOString().split('T')[0] + '.csv');
    link.style.visibility = 'hidden';
    document.body.appendChild(link);
    link.click();
    document.body.removeChild(link);
}

function generateCSVReport() {
    let csv = 'Quiz Report: {{ $quiz->title }}\n';
    csv += 'Generated: ' + new Date().toLocaleString() + '\n\n';
    
    csv += 'Statistics\n';
    csv += 'Total Views,' + {{ $quiz->views ?? 0 }} + '\n';
    csv += 'Total Attempts,' + {{ $totalAttempts }} + '\n';
    csv += 'Average Score,' + {{ number_format($averageScore, 2) }} + '%\n';
    csv += 'Completion Rate,' + {{ number_format($passRate, 2) }} + '%\n\n';
    
    @if($recentAttempts->count() > 0)
    csv += 'Recent Attempts\n';
    csv += 'Student,Score,Percentage,Time Taken,Status,Completed At\n';
    @foreach($recentAttempts as $attempt)
    csv += '{{ $attempt->student->name }},' + 
           '{{ $attempt->score }}/{{ $attempt->total_points }},' + 
           '{{ number_format($attempt->percentage, 2) }}%,' + 
           '{{ $attempt->time_taken ? gmdate("H:i:s", $attempt->time_taken) : "N/A" }},' + 
           '{{ ucfirst(str_replace("_", " ", $attempt->status)) }},' + 
           '{{ $attempt->completed_at ? $attempt->completed_at->format("Y-m-d H:i:s") : "N/A" }}\n';
    @endforeach
    @endif
    
    return csv;
}

$(document).ready(function() {
    // Initialize DataTables
    if ($.fn.DataTable.isDataTable('#questionStatsTable')) {
        $('#questionStatsTable').DataTable().destroy();
    }
    if ($('#questionStatsTable').length) {
        $('#questionStatsTable').DataTable({
            pageLength: 10,
            order: [[3, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search...",
            }
        });
    }
    
    if ($.fn.DataTable.isDataTable('#attemptsTable')) {
        $('#attemptsTable').DataTable().destroy();
    }
    if ($('#attemptsTable').length) {
        $('#attemptsTable').DataTable({
            pageLength: 10,
            order: [[5, 'desc']],
            language: {
                search: "",
                searchPlaceholder: "Search...",
            }
        });
    }
});
</script>
@endpush

