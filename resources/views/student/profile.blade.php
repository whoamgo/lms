@extends('layouts.student')

@section('title', 'My Profile')

@section('breadcrumbs')
    <a href="{{ route('student.dashboard') }}">Home</a> / My Profile
@endsection

@section('content')
<div class="profile-sections">
    <!-- Left Column - Account Management -->
    <div>
        <div class="profile-section-card">
            <div class="profile-section-header">Account Management</div>
            
            <!-- Profile Picture Upload -->
            <div class="profile-avatar-upload">
                <div class="profile-avatar-large">
                    @if($student->avatar)
                        <img src="{{ asset('storage/' . $student->avatar) }}" alt="Avatar">
                    @else
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 60px; height: 60px; color: #9333ea;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                        </svg>
                    @endif
                </div>
                <input type="file" name="avatar" id="avatar" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
                <button type="button" class="file-upload-btn" onclick="document.getElementById('avatar').click()">Browse...</button>
                <div id="avatarFileName" style="font-size: 0.75rem; color: #6b7280; margin-top: 8px;">No file selected.</div>
            </div>
            
            <!-- Password Management -->
            <div class="form-group">
                <label>Old Password</label>
                <input type="password" name="old_password" id="old_password" placeholder="Enter old password">
            </div>
            
            <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" id="new_password" placeholder="Enter new password">
            </div>
            
            <button type="button" class="btn" style="background: #f3f4f6; color: #343541; border: 1px solid #e5e5e6; width: 100%;" onclick="changePassword()">Change Password</button>
        </div>
    </div>
    
    <!-- Right Column - Profile Information -->
    <div>
        <form action="{{ route('student.profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
            @csrf
            @method('PUT')
            <input type="file" name="avatar" id="avatarInput" accept="image/*" style="display: none;" onchange="previewAvatar(this)">
            
            <!-- Profile Information -->
            <div class="profile-section-card">
                <div class="profile-section-header">Profile Information</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>User name</label>
                        <input type="text" name="name" value="{{ old('name', $student->name) }}" required>
                    </div>
                    <div class="form-group">
                        <label>First name</label>
                        <input type="text" name="first_name" value="{{ old('first_name', $student->first_name ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Nick name</label>
                        <input type="text" name="nick_name" value="{{ old('nick_name', $student->nick_name ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Role</label>
                        <input type="text" value="Student" disabled style="background: #f3f4f6;">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Last name</label>
                        <input type="text" name="last_name" value="{{ old('last_name', $student->last_name ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Display Name Publicly as</label>
                        <input type="text" name="display_name" value="{{ old('display_name', $student->display_name ?? $student->name) }}">
                    </div>
                </div>
            </div>
            
            <!-- Contact Info -->
            <div class="profile-section-card">
                <div class="profile-section-header">Contact Info</div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Email Require</label>
                        <input type="email" name="email" value="{{ old('email', $student->email) }}" required>
                    </div>
                    <div class="form-group">
                        <label>Whatsapp</label>
                        <input type="text" name="whatsapp" value="{{ old('whatsapp', $student->whatsapp ?? '') }}">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label>Website</label>
                        <input type="url" name="website" value="{{ old('website', $student->website ?? '') }}">
                    </div>
                    <div class="form-group">
                        <label>Insta / Telegram</label>
                        <input type="text" name="instagram_telegram" value="{{ old('instagram_telegram', $student->instagram_telegram ?? '') }}">
                    </div>
                </div>
            </div>
            
            <!-- About The User -->
            <div class="profile-section-card">
                <div class="profile-section-header">About The User</div>
                
                <div class="form-group">
                    <label>Biographical Info</label>
                    <textarea name="bio" rows="6" placeholder="Tell us about yourself...">{{ old('bio', $student->bio ?? '') }}</textarea>
                </div>
            </div>
            
            <!-- Password Fields (hidden, will be populated by changePassword function) -->
            <input type="hidden" name="old_password" id="form_old_password">
            <input type="hidden" name="new_password" id="form_new_password">
            <input type="hidden" name="new_password_confirmation" id="form_new_password_confirmation">
            
            <!-- Submit Button -->
            <div style="text-align: right; margin-top: 24px;">
                <button type="submit" class="btn btn-purple" style="padding: 12px 32px; font-size: 1rem; font-weight: 600;">Submit</button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
function previewAvatar(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            $('.profile-avatar-large img').attr('src', e.target.result);
            if (!$('.profile-avatar-large img').length) {
                $('.profile-avatar-large').html('<img src="' + e.target.result + '" alt="Avatar">');
            }
            $('#avatarFileName').text(input.files[0].name);
        };
        reader.readAsDataURL(input.files[0]);
        
        // Also update the form input
        if (input.id === 'avatar') {
            $('#avatarInput').prop('files', input.files);
        }
    }
}

function changePassword() {
    const oldPassword = $('#old_password').val();
    const newPassword = $('#new_password').val();
    
    if (!oldPassword || !newPassword) {
        alert('Please fill in both old and new password fields.');
        return;
    }
    
    if (newPassword.length < 8) {
        alert('New password must be at least 8 characters long.');
        return;
    }
    
    // Store in hidden form fields
    $('#form_old_password').val(oldPassword);
    $('#form_new_password').val(newPassword);
    $('#form_new_password_confirmation').val(newPassword);
    
    alert('Password will be changed when you submit the form.');
}
</script>
@endpush

