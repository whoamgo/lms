@extends('layouts.admin')

@section('title', 'Hiring Portal')
 

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Hiring Portal
@endsection


@section('content')
<br /><br />
<div class="card">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
        <h2>Hiring Portal</h2>
        <button type="button" class="btn btn-primary" onclick="document.getElementById('jobModal').style.display='block'">Add New Job</button>
    </div>
    
    <div class="table-container">
        <table class="data-table" id="hiringTable">
            <thead>
                <tr>
                    <th>Job Title</th>
                    <th>Category</th>
                    <th>Location</th>
                    <th>Salary Range</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach($jobs as $job)
                <tr>
                    <td>{{ $job->job_title }}</td>
                    <td>{{ $job->category }}</td>
                    <td>{{ $job->job_location }}</td>
                    <td>{{ $job->salary_range }}</td>
                    <td>
                        <form action="{{ route('admin.hiring.destroy', $job->id) }}" method="POST" style="display: inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn" style="background: #ef4444; color: white; padding: 6px 12px; font-size: 0.75rem;">Delete</button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal -->
<div id="jobModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: white; border-radius: 12px; padding: 32px; max-width: 600px; width: 90%; max-height: 90vh; overflow-y: auto;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 24px;">
            <h2 style="font-size: 1.5rem; font-weight: 600;">Add New Job</h2>
            <button onclick="document.getElementById('jobModal').style.display='none'" style="background: none; border: none; font-size: 1.5rem; cursor: pointer;">&times;</button>
        </div>
        
        <form method="POST" action="{{ route('admin.hiring.store') }}">
            @csrf
            
            <div class="form-group">
                <label>Job Title*</label>
                <input type="text" name="job_title" required placeholder="Enter job title">
            </div>
            
            <div class="form-group">
                <label>Job Location*</label>
                <input type="text" name="job_location" required placeholder="Enter job location">
            </div>
            
            <div class="form-group">
                <label>Salary Range*</label>
                <input type="text" name="salary_range" required placeholder="Enter salary range">
            </div>
            
            <div class="form-group">
                <label>Category*</label>
                <select name="category" required>
                    <option value="">-- Select Category --</option>
                    <option value="Development">Development</option>
                    <option value="Design">Design</option>
                    <option value="Marketing">Marketing</option>
                    <option value="Teaching">Teaching</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Job Description</label>
                <textarea name="job_description" rows="4" placeholder="Write about the job..."></textarea>
            </div>
            
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="document.getElementById('jobModal').style.display='none'" class="btn btn-secondary">Cancel</button>
                <button type="submit" class="btn btn-warning">Save Job</button>
            </div>
        </form>
    </div>
</div>
@endsection

