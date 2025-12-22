@extends('layouts.admin')

@section('title', 'Edit Instructor')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / <a href="' . route('admin.instructors.index') . '">Trainer Dashboard</a> /Edit Instructor
@endsection

@section('content')
<div class="card">
    <h2>Instructor Management</h2>
    
    <form method="POST" action="{{ route('admin.instructors.update', $instructor->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        @php
            $nameParts = explode(' ', $instructor->name, 2);
            $firstName = $nameParts[0] ?? '';
            $lastName = $nameParts[1] ?? '';
        @endphp
        
        <div class="instructor-form-grid">
            <div>
                <h3 class="form-section-title">Basic information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name*</label>
                        <input type="text" name="first_name" required value="{{ old('first_name', $firstName) }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Last Name*</label>
                        <input type="text" name="last_name" required value="{{ old('last_name', $lastName) }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email Id*</label>
                    <input type="email" name="email" required placeholder="Enter Trainer Email" value="{{ old('email', $instructor->email) }}">
                </div>
                
                <div class="form-group">
                    <label>Password (leave blank to keep current)</label>
                    <input type="password" name="password" placeholder="Enter new password">
                </div>
                
                <div class="form-group">
                    <label>Mo No.</label>
                    <div class="phone-input-group">
                        <select class="phone-country-select">
                            <option>+91</option>
                        </select>
                        <input type="text" name="phone" class="phone-number-input" placeholder="Enter mobile number" value="{{ old('phone', $instructor->phone) }}">
                    </div>
                </div>
                
                <h3 class="form-section-title form-section-title-spaced">Instructor course</h3>
                
                <div class="courses-checkbox-grid">
                    @foreach($courses as $course)
                    <label class="course-checkbox-label">
                        <input type="checkbox" name="courses[]" value="{{ $course->id }}" {{ in_array($course->id, $assignedCourseIds) ? 'checked' : '' }}>
                        <span>{{ $course->title }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden-input" onchange="handleImageUpload(this, 'avatarPreview')">
                    <div class="avatar-upload-area" onclick="document.getElementById('avatar').click()">
                        <div>
                            <div id="avatarPreview">
                                @if($instructor->avatar)
                                    <img src="{{ asset($instructor->avatar) }}" class="image-preview-img instructor-avatar-preview">
                                @else
                                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="avatar-placeholder-icon-large">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                @endif
                            </div>
                            <p class="avatar-upload-text" id="avatarText">Click to upload profile picture</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Instructor</button>
            <a href="{{ route('admin.instructors.index') }}" class="btn btn-dark">Cancel</a>
        </div>
    </form>
</div>

<script>
    function handleImageUpload(input, previewId) {
        const file = input.files[0];
        if (file) {
            if (confirm('Are you sure you want to upload this image?')) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById(previewId);
                    const text = document.getElementById('avatarText');
                    preview.innerHTML = `<img src="${e.target.result}" class="image-preview-img instructor-avatar-preview">`;
                    if (text) text.style.display = 'none';
                };
                reader.readAsDataURL(file);
            } else {
                input.value = '';
            }
        }
    }
</script>
@endsection

