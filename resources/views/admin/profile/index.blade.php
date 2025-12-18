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
        
        <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 24px;">
            <div>
                <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px;">Basic Information</h3>
                
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
                
                <h3 style="font-size: 1rem; font-weight: 600; margin: 32px 0 20px;">Change Password</h3>
                
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
                    <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="handleImageUpload(this, 'avatarPreview')">
                    <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; background: #f9fafb; text-align: center; min-height: 400px; display: flex; align-items: center; justify-content: center; cursor: pointer;" onclick="document.getElementById('avatar').click()">
                        <div>
                            <div id="avatarPreview">
                                @if($admin->avatar)
                                    <img src="{{ asset($admin->avatar) }}" style="max-width: 200px; border-radius: 8px; border: 1px solid #e5e5e6; margin-bottom: 16px;">
                                @else
                                    <div style="width: 120px; height: 120px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 16px;">
                                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: white;">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>
                            <button type="button" class="btn btn-secondary">Upload Photo</button>
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
                                preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 8px; border: 1px solid #e5e5e6; margin-bottom: 16px;">`;
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
            <button type="submit" class="btn btn-primary">Update Profile</button>
        </div>
    </form>
</div>
@endsection

