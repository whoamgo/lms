@extends('layouts.admin')

@section('title', 'Trainer Dashboard')
 

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Trainer Dashboard
@endsection
@section('content')
<br /><br />
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2>Instructor Management</h2>
        <a href="{{ route('admin.instructors.create') }}" class="btn btn-primary">Add New Instructor</a>
    </div>
    
    <div class="table-container">
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Assigned Courses</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($instructors as $instructor)
                <tr>
                    <td>{{ $instructor->name }}</td>
                    <td>{{ $instructor->email }}</td>
                    <td>{{ $instructor->phone ?? 'N/A' }}</td>
                    <td>{{ $instructor->assignedCourses->count() }} courses</td>
                    <td>
                        <form method="POST" action="{{ route('admin.instructors.toggle-status', $instructor->id) }}" style="display: inline;">
                            @csrf
                            @method('PUT')
                            <label class="toggle-switch">
                                <input type="checkbox" {{ $instructor->status === 'active' ? 'checked' : '' }} onchange="this.form.submit()">
                                <span class="toggle-slider"></span>
                            </label>
                        </form>
                    </td>
                    <td>
                        <a href="{{ route('admin.instructors.edit', $instructor->id) }}" class="btn btn-secondary" style="padding: 6px 12px; font-size: 0.75rem;">Edit</a>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="6" style="text-align: center; padding: 40px; color: #6b7280;">No instructors found</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 24px;">
        {{ $instructors->links() }}
    </div>
</div>
@endsection

