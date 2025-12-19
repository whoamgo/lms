@extends('layouts.student')

@section('title', 'Attendance Record')

@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}">Home</a> / Attendance record
@endsection

@section('content')
<!-- Welcome Banner -->
<div class="welcome-banner">
    <div class="welcome-banner-content">
        <div class="profile-avatar" style="margin-top: 0; width: 60px; height: 60px;">
            @if(Auth::user()->avatar)
                <img src="{{ asset('storage/' . Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h1>Welcome, {{ Auth::user()->name }}!</h1>
            <p>Student</p>
        </div>
    </div>
</div>

<!-- Course Category Filters -->
<div style="margin-top: 24px; display: flex; gap: 12px; flex-wrap: wrap;">
    <button class="course-filter-btn {{ $courseFilter === 'all' ? 'active' : '' }}" 
            onclick="filterByCourse('all')">
        All Courses
    </button>
    @foreach($enrolledCourses as $course)
        <button class="course-filter-btn {{ $courseFilter == $course->id ? 'active' : '' }}" 
                onclick="filterByCourse('{{ $course->id }}')">
            {{ $course->title }}
        </button>
    @endforeach
</div>

<!-- Student Attendance Dashboard -->
<div style="margin-top: 32px;">
    <h2 style="font-size: 1.5rem; font-weight: 600; color: #343541; margin-bottom: 24px;">Student Attendance Dashboard</h2>
    
    <div style="display: grid; grid-template-columns: 1fr 1.5fr; gap: 24px; margin-bottom: 32px;">
        <!-- Stats Cards -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
            <div class="card" style="background: linear-gradient(135deg, #fdba74 0%, #fb923c 100%); color: white; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 8px;">{{ $recorded }}</div>
                <div style="font-size: 0.875rem; opacity: 0.9;">Recorded</div>
            </div>
            <div class="card" style="background: linear-gradient(135deg, #86efac 0%, #4ade80 100%); color: white; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 8px;">{{ $presentDays }}</div>
                <div style="font-size: 0.875rem; opacity: 0.9;">Present Days</div>
            </div>
            <div class="card" style="background: linear-gradient(135deg, #fdba74 0%, #fb923c 100%); color: white; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 8px;">{{ $absentDays }}</div>
                <div style="font-size: 0.875rem; opacity: 0.9;">Absent Days</div>
            </div>
            <div class="card" style="background: linear-gradient(135deg, #93c5fd 0%, #60a5fa 100%); color: white; padding: 24px; text-align: center;">
                <div style="font-size: 2rem; font-weight: 700; margin-bottom: 8px;">{{ $attendancePercentage }}%</div>
                <div style="font-size: 0.875rem; opacity: 0.9;">Attendance</div>
            </div>
        </div>
        
        <!-- Attendance Chart -->
        <div class="card">
            <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 20px;">
                <div>
                    <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541; margin-bottom: 4px;">
                        {{ $startDate->format('M Y') }} Attendance Overview
                    </h3>
                    <div style="display: flex; gap: 16px; margin-top: 8px;">
                        <span style="font-size: 0.875rem; color: #6b7280;">Monthly</span>
                    </div>
                </div>
                <div style="display: flex; gap: 8px;">
                    <select id="yearSelect" class="form-select" style="padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                        @foreach($years as $y)
                            <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                        @endforeach
                    </select>
                    <select id="monthSelect" class="form-select" style="padding: 6px 12px; border: 1px solid #d1d5db; border-radius: 6px; font-size: 0.875rem;">
                        @foreach($months as $m => $monthName)
                            <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ $monthName }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            
            <div style="height: 200px; position: relative;">
                <canvas id="attendanceChart"></canvas>
            </div>
            
            <div style="display: flex; gap: 20px; justify-content: center; margin-top: 16px;">
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 12px; height: 12px; background: #4ade80; border-radius: 2px;"></div>
                    <span style="font-size: 0.75rem; color: #6b7280;">Present Days</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 12px; height: 12px; background: #fb923c; border-radius: 2px;"></div>
                    <span style="font-size: 0.75rem; color: #6b7280;">Absent Days</span>
                </div>
                <div style="display: flex; align-items: center; gap: 8px;">
                    <div style="width: 12px; height: 12px; background: #ef4444; border-radius: 2px;"></div>
                    <span style="font-size: 0.75rem; color: #6b7280;">Recorded</span>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Date Range Filters -->
    <div style="display: flex; gap: 12px; margin-bottom: 32px; flex-wrap: wrap;">
        <button class="date-range-btn {{ $dateRange === 'this_month' ? 'active' : '' }}" 
                onclick="filterByDateRange('this_month')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            This Month ({{ now()->format('d/m/Y') }})
        </button>
        <button class="date-range-btn {{ $dateRange === 'last_month' ? 'active' : '' }}" 
                onclick="filterByDateRange('last_month')">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Last Month ({{ now()->subMonth()->format('d/m/Y') }})
        </button>
        <button class="date-range-btn {{ $dateRange === 'custom' ? 'active' : '' }}" 
                onclick="toggleCustomRange()">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 16px; height: 16px;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            Custom Range
        </button>
        <div id="customRangeInputs" style="display: {{ $dateRange === 'custom' ? 'flex' : 'none' }}; gap: 8px; align-items: center;">
            <input type="text" id="startDate" placeholder="dd/mm/yyyy" 
                   value="{{ $dateRange === 'custom' && request('start_date') ? request('start_date') : '' }}"
                   class="form-control date-input" style="width: 140px; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px;"
                   onkeyup="formatDateInput(this)">
            <input type="text" id="endDate" placeholder="dd/mm/yyyy"
                   value="{{ $dateRange === 'custom' && request('end_date') ? request('end_date') : '' }}"
                   class="form-control date-input" style="width: 140px; padding: 8px 12px; border: 1px solid #d1d5db; border-radius: 6px;"
                   onkeyup="formatDateInput(this)">
            <button onclick="applyCustomRange()" class="btn btn-purple" style="padding: 8px 16px;">Apply</button>
        </div>
    </div>
</div>

<!-- Calendar View -->
<div class="card" style="margin-top: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <div>
            <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541; margin-bottom: 4px;">Calendar View</h3>
            <p style="font-size: 0.875rem; color: #6b7280;">This Month</p>
        </div>
    </div>
    
    <div id="attendanceCalendar" style="display: grid; grid-template-columns: repeat(7, 1fr); gap: 8px;">
        <!-- Calendar will be generated by JavaScript -->
    </div>
</div>

<!-- Daily Attendance Details -->
<div class="card" style="margin-top: 32px;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h3 style="font-size: 1.125rem; font-weight: 600; color: #343541;">Daily Attendance Details</h3>
        <span style="font-size: 0.875rem; color: #6b7280;">Recent records</span>
    </div>
    
    <div class="table-responsive">
        <table class="table" id="attendanceTable">
            <thead>
                <tr>
                    <th>Date</th>
                    <th>Day</th>
                    <th>Status</th>
                    <th>Check-in</th>
                    <th>Check-Out</th>
                    <th>Total Hours</th>
                    <th>Remark</th>
                </tr>
            </thead>
            <tbody id="attendanceTableBody">
                @forelse($attendances as $attendance)
                    <tr>
                        <td>{{ $attendance->created_at->format('d M Y') }}</td>
                        <td>{{ $attendance->created_at->format('D') }}</td>
                        <td>
                            @if($attendance->status === 'present')
                                <span style="color: #4ade80;">• Present</span>
                            @elseif($attendance->status === 'absent')
                                <span style="color: #ef4444;">• Absent</span>
                            @elseif($attendance->status === 'late')
                                <span style="color: #fb923c;">• Late</span>
                            @else
                                <span style="color: #fb923c;">• Recorded</span>
                            @endif
                        </td>
                        <td>
                            @if($attendance->marked_at)
                                {{ $attendance->marked_at->format('h:i A') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($attendance->marked_at && $attendance->liveClass)
                                @php
                                    $checkOut = $attendance->marked_at->copy()->addHours(8)->addMinutes(30);
                                @endphp
                                {{ $checkOut->format('h:i A') }}
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($attendance->marked_at)
                                8h 30m
                            @else
                                -
                            @endif
                        </td>
                        <td>
                            @if($attendance->status === 'present')
                                On Time
                            @elseif($attendance->status === 'late')
                                Late
                            @elseif($attendance->status === 'absent')
                                Absent
                            @else
                                Weekend
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center; padding: 40px; color: #6b7280;">
                            No attendance records found.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    @if(isset($hasMore) && $hasMore)
        <div style="text-align: right; margin-top: 16px;">
            <button onclick="loadMoreAttendance()" class="btn btn-purple" id="loadMoreBtn">Load More</button>
        </div>
    @endif
</div>

<!-- Bottom Footer Bar -->
<div style="display: flex; justify-content: space-between; align-items: center; margin-top: 32px; padding: 16px; background: #f9fafb; border-radius: 8px;">
    <div style="font-size: 0.875rem; color: #6b7280;">
        Month: {{ $startDate->format('M Y') }}
    </div>
    <div style="display: flex; gap: 24px; font-size: 0.875rem; color: #6b7280;">
        <span>Subject: -</span>
        <span>Status: -</span>
    </div>
</div>
@endsection

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.css" rel="stylesheet">
<style>
.course-filter-btn {
    padding: 10px 20px;
    border: 2px solid #e5e7eb;
    background: white;
    border-radius: 20px;
    font-size: 0.875rem;
    font-weight: 500;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s;
}

.course-filter-btn:hover {
    border-color: #9333ea;
    color: #9333ea;
}

.course-filter-btn.active {
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    border-color: #9333ea;
    color: white;
}

.date-range-btn {
    display: flex;
    align-items: center;
    gap: 8px;
    padding: 10px 16px;
    border: 1px solid #d1d5db;
    background: white;
    border-radius: 6px;
    font-size: 0.875rem;
    color: #6b7280;
    cursor: pointer;
    transition: all 0.3s;
}

.date-range-btn:hover {
    border-color: #9333ea;
    color: #9333ea;
}

.date-range-btn.active {
    background: linear-gradient(135deg, #9333ea 0%, #7c3aed 100%);
    border-color: #9333ea;
    color: white;
}

.calendar-day {
    aspect-ratio: 1;
    display: flex;
    align-items: center;
    justify-content: center;
    border: 1px solid #e5e7eb;
    border-radius: 6px;
    font-size: 0.875rem;
    font-weight: 500;
    cursor: pointer;
    transition: all 0.2s;
}

.calendar-day:hover {
    background: #f9fafb;
}

.calendar-day.present {
    background: #dcfce7;
    color: #166534;
    border-color: #4ade80;
}

.calendar-day.absent {
    background: #fee2e2;
    color: #991b1b;
    border-color: #ef4444;
}

.calendar-day.late,
.calendar-day.recorded {
    background: #fef3c7;
    color: #92400e;
    border-color: #fbbf24;
}

.calendar-day-header {
    text-align: center;
    font-size: 0.75rem;
    font-weight: 600;
    color: #6b7280;
    padding: 8px;
}

@media (max-width: 768px) {
    .stats-grid {
        grid-template-columns: 1fr 1fr;
    }
    
    .attendance-dashboard {
        grid-template-columns: 1fr;
    }
    
    #attendanceCalendar {
        gap: 4px;
    }
    
    .calendar-day {
        font-size: 0.75rem;
        padding: 4px;
    }
}
</style>
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
// Chart Data
const weeklyData = @json($weeklyData);
if (weeklyData.length > 0) {
    const ctx = document.getElementById('attendanceChart');
    if (ctx) {
        const attendanceChart = new Chart(ctx.getContext('2d'), {
            type: 'bar',
            data: {
                labels: weeklyData.map(w => w.week),
                datasets: [
                    {
                        label: 'Present Days',
                        data: weeklyData.map(w => w.present),
                        backgroundColor: '#4ade80',
                        borderRadius: 4,
                    },
                    {
                        label: 'Absent Days',
                        data: weeklyData.map(w => w.absent),
                        backgroundColor: '#fb923c',
                        borderRadius: 4,
                    },
                    {
                        label: 'Recorded',
                        data: weeklyData.map(w => w.recorded),
                        backgroundColor: '#ef4444',
                        borderRadius: 4,
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: false
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        ticks: {
                            stepSize: 1
                        }
                    }
                }
            }
        });
    }
}

// Calendar Generation
const calendarData = @json($calendarData);
const startDateStr = '{{ $startDate->format('Y-m-d') }}';
const startDate = new Date(startDateStr + 'T00:00:00');

function generateCalendar() {
    const calendar = document.getElementById('attendanceCalendar');
    if (!calendar) return;
    
    calendar.innerHTML = '';
    
    // Add day headers
    const days = ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'];
    days.forEach(day => {
        const header = document.createElement('div');
        header.className = 'calendar-day-header';
        header.textContent = day;
        calendar.appendChild(header);
    });
    
    // Get first day of month and number of days
    const firstDay = new Date(startDate.getFullYear(), startDate.getMonth(), 1);
    const lastDay = new Date(startDate.getFullYear(), startDate.getMonth() + 1, 0);
    const firstDayOfWeek = firstDay.getDay();
    const daysInMonth = lastDay.getDate();
    
    // Add empty cells for days before month starts
    for (let i = 0; i < firstDayOfWeek; i++) {
        const empty = document.createElement('div');
        calendar.appendChild(empty);
    }
    
    // Add calendar days
    for (let day = 1; day <= daysInMonth; day++) {
        const dayDiv = document.createElement('div');
        dayDiv.className = 'calendar-day';
        dayDiv.textContent = day;
        
        // Find attendance status for this day
        const dayData = calendarData.find(d => {
            const dDate = new Date(d.date + 'T00:00:00');
            return dDate.getDate() === day && dDate.getMonth() === startDate.getMonth();
        });
        
        if (dayData && dayData.status) {
            dayDiv.classList.add(dayData.status);
            if (dayData.status === 'late') {
                dayDiv.classList.add('recorded');
            }
        }
        
        calendar.appendChild(dayDiv);
    }
}

// Generate calendar when page loads
document.addEventListener('DOMContentLoaded', function() {
    generateCalendar();
});

// Filter Functions
function filterByCourse(courseId) {
    const url = new URL(window.location.href);
    url.searchParams.set('course', courseId);
    window.location.href = url.toString();
}

function filterByDateRange(range) {
    const url = new URL(window.location.href);
    url.searchParams.set('range', range);
    if (range !== 'custom') {
        url.searchParams.delete('start_date');
        url.searchParams.delete('end_date');
    }
    window.location.href = url.toString();
}

function toggleCustomRange() {
    const inputs = document.getElementById('customRangeInputs');
    const isVisible = inputs.style.display === 'flex';
    inputs.style.display = isVisible ? 'none' : 'flex';
    
    if (!isVisible) {
        // Activate custom range button
        document.querySelectorAll('.date-range-btn').forEach(btn => {
            btn.classList.remove('active');
        });
        event.target.closest('.date-range-btn').classList.add('active');
    }
}

function applyCustomRange() {
    const startDate = document.getElementById('startDate').value;
    const endDate = document.getElementById('endDate').value;
    
    if (!startDate || !endDate) {
        alert('Please select both start and end dates');
        return;
    }
    
    // Validate date format (dd/mm/yyyy)
    const dateRegex = /^(\d{2})\/(\d{2})\/(\d{4})$/;
    if (!dateRegex.test(startDate) || !dateRegex.test(endDate)) {
        alert('Please enter dates in dd/mm/yyyy format');
        return;
    }
    
    const url = new URL(window.location.href);
    url.searchParams.set('range', 'custom');
    url.searchParams.set('start_date', startDate);
    url.searchParams.set('end_date', endDate);
    // Remove year and month params when using custom range
    url.searchParams.delete('year');
    url.searchParams.delete('month');
    window.location.href = url.toString();
}

// Date input formatting helper
function formatDateInput(input) {
    let value = input.value.replace(/\D/g, '');
    if (value.length >= 2) {
        value = value.substring(0, 2) + '/' + value.substring(2);
    }
    if (value.length >= 5) {
        value = value.substring(0, 5) + '/' + value.substring(5, 9);
    }
    input.value = value;
}

// Year/Month Select Change
const yearSelect = document.getElementById('yearSelect');
const monthSelect = document.getElementById('monthSelect');

if (yearSelect) {
    yearSelect.addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('year', this.value);
        url.searchParams.set('month', monthSelect.value);
        url.searchParams.set('range', 'this_month');
        url.searchParams.delete('start_date');
        url.searchParams.delete('end_date');
        window.location.href = url.toString();
    });
}

if (monthSelect) {
    monthSelect.addEventListener('change', function() {
        const url = new URL(window.location.href);
        url.searchParams.set('year', yearSelect.value);
        url.searchParams.set('month', this.value);
        url.searchParams.set('range', 'this_month');
        url.searchParams.delete('start_date');
        url.searchParams.delete('end_date');
        window.location.href = url.toString();
    });
}

// Load More
let currentPage = {{ $page ?? 1 }};
let isLoading = false;

function loadMoreAttendance() {
    if (isLoading) return;
    
    isLoading = true;
    const btn = document.getElementById('loadMoreBtn');
    if (btn) {
        btn.disabled = true;
        btn.textContent = 'Loading...';
    }
    
    currentPage++;
    
    const url = new URL(window.location.href);
    url.searchParams.set('page', currentPage);
    
    fetch(url.toString(), {
        headers: {
            'X-Requested-With': 'XMLHttpRequest',
            'Accept': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
        }
    })
    .then(response => {
        if (!response.ok) {
            throw new Error('Network response was not ok');
        }
        return response.json();
    })
    .then(data => {
        if (data.html) {
            const tbody = document.getElementById('attendanceTableBody');
            // Create a temporary container to parse HTML
            const temp = document.createElement('tbody');
            temp.innerHTML = data.html;
            
            // Append new rows
            const newRows = temp.querySelectorAll('tr');
            newRows.forEach(row => {
                tbody.appendChild(row);
            });
            
            // Check if there are more records
            if (!data.hasMore) {
                if (btn) {
                    btn.style.display = 'none';
                }
            }
        } else {
            // No more records
            if (btn) {
                btn.style.display = 'none';
            }
        }
        
        isLoading = false;
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Load More';
        }
    })
    .catch(error => {
        console.error('Error loading more attendance:', error);
        isLoading = false;
        if (btn) {
            btn.disabled = false;
            btn.textContent = 'Load More';
        }
        alert('Error loading more records. Please try again.');
    });
}
</script>
@endpush
