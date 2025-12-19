@extends('layouts.trainer-module')

@section('title', 'Active Batches')

@section('content')
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Active Batches</h2>
    
    <div class="table-container">
        <table class="data-table" id="batchesTable">
            <thead>
                <tr>
                    <th>Batch Name</th>
                    <th>Course</th>
                    <th>Start Date</th>
                    <th>End Date</th>
                    <th>Class Time</th>
                    <th>Students</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($batches as $batch)
                <tr>
                    <td>
                        <div style="font-weight: 500;">{{ $batch->name }}</div>
                    </td>
                    <td>{{ $batch->course->title ?? 'N/A' }}</td>
                    <td>{{ $batch->start_date ? $batch->start_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $batch->end_date ? $batch->end_date->format('M d, Y') : 'N/A' }}</td>
                    <td>{{ $batch->class_time ? $batch->class_time->format('g:i A') : 'N/A' }}</td>
                    <td>{{ $batch->enrollments->count() }}</td>
                    <td>
                        <span class="badge badge-{{ $batch->status === 'active' ? 'success' : 'danger' }}">
                            {{ ucfirst($batch->status) }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
