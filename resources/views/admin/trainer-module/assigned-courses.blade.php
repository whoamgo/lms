@extends('layouts.trainer-module')

@section('title', 'Assigned Courses')

@section('content')
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Assigned Courses</h2>
    
    <div class="table-container">
        <table class="data-table" id="coursesTable">
            <thead>
                <tr>
                    <th>Course Title</th>
                    <th>Description</th>
                    <th>Status</th>
                    <th>Enrollments</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $course->title }}</div>
                    </td>
                    <td>
                        <div style="max-width: 300px; overflow: hidden; text-overflow: ellipsis; white-space: nowrap;">
                            {{ $course->description ?? 'N/A' }}
                        </div>
                    </td>
                    <td>
                        <span class="badge badge-{{ $course->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($course->status) }}
                        </span>
                    </td>
                    <td>{{ $course->enrollments->count() }}</td>
                    <td>{{ $course->start_date ? $course->start_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $course->end_date ? $course->end_date->format('M d, Y') : 'N/A' }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
