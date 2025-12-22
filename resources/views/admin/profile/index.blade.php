@extends('layouts.admin')

@section('title', 'Admin Profile')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Profile
@endsection


@section('content')
<br /><br />
<div class="card">
    <h2>Admin Profile Management</h2>
    
    <form method="POST" action="{{ route('admin.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="profile-form-grid">
            <div>
                <h3 class="form-section-title">Basic Information</h3>
                
                <div class="form-group">
                    <label>Full Name*</label>
                    <input type="text" name="name" required value="{{ $admin->name }}">
                </div>
                
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" required value="{{ $admin->email }}">
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ $admin->phone ?? '' }}">
                </div>
                
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3">{{ $admin->address ?? '' }}</textarea>
                </div>
                
                <h3 class="form-section-title form-section-title-spaced">Change Password</h3>
                
                <div class="form-group">
                    <label>Current Password</label>
                    <input type="password" name="current_password">
                </div>
                
                <div class="form-group">
                    <label>New Password</label>
                    <input type="password" name="password">
                </div>
                
                <div class="form-group">
                    <label>Confirm New Password</label>
                    <input type="password" name="password_confirmation">
                </div>
            </div>
            
            <div>
                <div class="form-group">
                    <label>Profile Picture</label>
                    <input type="file" name="avatar" id="avatar" accept="image/*" class="hidden-input" onchange="handleImageUpload(this, 'avatarPreview')">
                    <div class="avatar-upload-area" onclick="document.getElementById('avatar').click()">
                        <div>
                            <div id="avatarPreview">
                                @if($admin->avatar)
                                    <img src="{{ asset($admin->avatar) }}" class="avatar-preview-img">
                                @else
                                    <div class="avatar-placeholder-large">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="avatar-placeholder-icon">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-dark">Upload Photo</button>
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
                                preview.innerHTML = `<img src="${e.target.result}" class="avatar-preview-img">`;
                            };
                            reader.readAsDataURL(file);
                        } else {
                            input.value = '';
                        }
                    }
                }
            </script>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>
@endsection

