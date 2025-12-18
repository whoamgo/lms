@extends('layouts.admin')

@section('title', 'Instructor Management')
 

@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / <a href="' . route('admin.instructors.index') . '">Trainer Dashboard</a> /Add Instructor
@endsection

@section('content')
<br /><br />
<div class="card">
    <h2>Instructor Management</h2>
    
    <form method="POST" action="{{ route('admin.instructors.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px;">Basic information</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>First Name*</label>
                        <input type="text" name="first_name" required value="{{ old('first_name') }}">
                    </div>
                    
                    <div class="form-group">
                        <label>Last Name*</label>
                        <input type="text" name="last_name" required value="{{ old('last_name') }}">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Email Id*</label>
                    <input type="email" name="email" required placeholder="Enter Trainer Email" value="{{ old('email') }}">
                </div>
                
                <div class="form-group">
                    <label>Password*</label>
                    <input type="password" name="password" required placeholder="Enter Trainer Password">
                </div>
                
                <div class="form-group">
                    <label>Mo No.</label>
                    <div style="display: flex; gap: 8px;">
                        <select style="width: 100px;">
                            <option>+91</option>
                        </select>
                        <input type="text" name="phone" style="flex: 1;" placeholder="Enter mobile number" value="{{ old('phone') }}">
                    </div>
                </div>
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 32px 0 20px;">Instructor course</h3>
                
                <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 12px;">
                    @foreach($courses as $course)
                    <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                        <input type="checkbox" name="courses[]" value="{{ $course->id }}">
                        <span>{{ $course->title }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            
            <div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="handleImageUpload(this, 'avatarPreview')">
                    <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; background: #f9fafb; text-align: center; min-height: 400px; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="document.getElementById('avatar').click()">
                        <div>
                            <div id="avatarPreview"></div>
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 120px; height: 120px; color: #9ca3af; display: none;" id="avatarIcon">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                            <p style="color: #6b7280; margin-top: 16px;" id="avatarText">Click to upload profile picture</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <script>
                function handleImageUpload(input, previewId) {
                    const file = input.files[0];
                    if (file) {
                        if (confirm('Are you sure you want to upload this image?')) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                const preview = document.getElementById(previewId);
                                const icon = document.getElementById('avatarIcon');
                                const text = document.getElementById('avatarText');
                                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 8px; border: 1px solid #e5e5e6;">`;
                                if (icon) icon.style.display = 'none';
                                if (text) text.style.display = 'none';
                            };
                            reader.readAsDataURL(file);
                        } else {
                            input.value = '';
                        }
                    }
                }
            </script>
        </div>
        
        <div style="margin-top: 24px; display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Save Instructor</button>
            <a href="{{ route('admin.instructors.index') }}" class="btn btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection

