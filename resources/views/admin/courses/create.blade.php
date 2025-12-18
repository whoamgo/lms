@extends('layouts.admin')

@section('title', 'Create Course')
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / <a href="' . route('admin.courses.index') . '">Active Courses</a> /  Create Course
@endsection


@section('content')
<div class="card">
    <h2>Fill in the details to create a new course</h2>
    
    <form method="POST" action="{{ route('admin.courses.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px;">Basic Information</h3>
            
            <div class="form-group">
                <label>Course Title*</label>
                <input type="text" name="title" required placeholder="Enter course title" value="{{ old('title') }}">
            </div>
            
            <div class="form-group">
                <label>Course Description</label>
                <textarea name="description" rows="6" placeholder="Write about the course...">{{ old('description') }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Upload Thumbnail</label>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="display: none;" onchange="handleImageUpload(this, 'thumbnailPreview')">
                <div style="border: 2px dashed #e5e5e6; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer;" onclick="document.getElementById('thumbnail').click()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <button type="button" class="btn" style="background: #f59e0b; color: white;">Upload Thumbnail</button>
                </div>
                <div class="image-preview" id="thumbnailPreview"></div>
            </div>
            
            <script>
                function handleImageUpload(input, previewId) {
                    const file = input.files[0];
                    if (file) {
                        if (confirm('Are you sure you want to upload this image?')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const preview = document.getElementById(previewId);
                                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 8px; margin-top: 12px; border: 1px solid #e5e5e6;">`;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            input.value = '';
                        }
                    }
                }
            </script>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Status*</label>
                    <select name="status" required>
                        <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                        <option value="active" {{ old('status') === 'active' ? 'selected' : '' }}>Active</option>
                        <option value="completed" {{ old('status') === 'completed' ? 'selected' : '' }}>Completed</option>
                    </select>
                </div>
                
                <div class="form-group">
                    <label>Price</label>
                    <input type="number" name="price" step="0.01" min="0" placeholder="0.00" value="{{ old('price') }}">
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}">
                </div>
                
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}">
                </div>
            </div>
            
            <div class="form-group">
                <label>Duration (Days)</label>
                <input type="number" name="duration_days" min="1" placeholder="Enter duration in days" value="{{ old('duration_days') }}">
            </div>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Create Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

