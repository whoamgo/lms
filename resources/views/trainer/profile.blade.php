@extends('layouts.trainer')

@section('title', 'My Profile')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / My Profile
@endsection

@section('content')
<div class="card">
    <h2>My Profile</h2>
    
    <form method="POST" action="{{ route('trainer.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div style="display: flex; gap: 32px; margin-bottom: 32px;">
            <div style="flex: 1;">
                <div class="form-group">
                    <label>Full Name*</label>
                    <input type="text" name="name" value="{{ old('name', $trainer->name) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Email*</label>
                    <input type="email" name="email" value="{{ old('email', $trainer->email) }}" required>
                </div>
                
                <div class="form-group">
                    <label>Phone</label>
                    <input type="text" name="phone" value="{{ old('phone', $trainer->phone) }}">
                </div>
                
                <div class="form-group">
                    <label>Address</label>
                    <textarea name="address" rows="3">{{ old('address', $trainer->address) }}</textarea>
                </div>
                
                <div class="form-group">
                    <label>New Password (leave blank to keep current)</label>
                    <input type="password" name="password">
                </div>
            </div>
            
            <div style="width: 200px;">
                <div class="form-group">
                    <label>Profile Picture</label>
                    @if($trainer->avatar)
                        <img src="{{ asset($trainer->avatar) }}" alt="Avatar" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-bottom: 12px; border: 3px solid #e5e5e6;">
                    @else
                        <div style="width: 150px; height: 150px; border-radius: 50%; background: #e5e5e6; display: flex; align-items: center; justify-content: center; margin-bottom: 12px;">
                            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 64px; height: 64px; color: #9ca3af;">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </div>
                    @endif
                    <input type="file" name="avatar" accept="image/*" onchange="handleImageUpload(this, 'avatarPreview')">
                    <div id="avatarPreview"></div>
                </div>
            </div>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Update Profile</button>
            <a href="{{ route('trainer.dashboard') }}" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</a>
        </div>
    </form>
</div>

@push('scripts')
<script>
function handleImageUpload(input, previewId) {
    const file = input.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            const preview = document.getElementById(previewId);
            preview.innerHTML = `<img src="${e.target.result}" style="width: 150px; height: 150px; border-radius: 50%; object-fit: cover; margin-top: 12px; border: 3px solid #e5e5e6;">`;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
