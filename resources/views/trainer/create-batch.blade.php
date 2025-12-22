@extends('layouts.trainer')

@section('title', 'Create Batch')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.active-batches') }}">Active Batch</a> / Create Batch
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 60px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 20px 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 16px;">
        <div style="width: 60px; height: 60px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -30px; border: 3px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 30px; height: 30px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h2 style="font-size: 1.25rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
            <p style="color: #6b7280; margin: 2px 0 0 0; font-size: 0.875rem;">Trainer</p>
        </div>
    </div>
</div>

<div class="card">
    <h2 style="margin-bottom: 8px;">Create Batch</h2>
    <p style="color: #6b7280; margin-bottom: 32px; font-size: 0.875rem;">Fill in the details to create a new Batch</p>
    
    <form method="POST" action="{{ route('trainer.batches.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Basic Information</h3>
            
            <div class="form-group">
                <label>Batch Title*</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Enter course title">
            </div>
            
            <div class="form-group">
                <label>Add Course*</label>
                <select name="course_id" required>
                    <option value="">-- Select Course --</option>
                    @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label>Batch Description</label>
                <textarea name="description" rows="6" placeholder="Write about the course...">{{ old('description') }}</textarea>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Start Date*</label>
                    <input type="date" name="start_date" value="{{ old('start_date') }}" required>
                </div>
                <div class="form-group">
                    <label>End Date*</label>
                    <input type="date" name="end_date" value="{{ old('end_date') }}" required>
                </div>
            </div>
            
            <div class="form-row">
                <div class="form-group">
                    <label>Class Time</label>
                    <input type="time" name="class_time" value="{{ old('class_time') }}">
                </div>
                <div class="form-group">
                    <label>Close Time</label>
                    <input type="time" name="close_time" value="{{ old('close_time') }}">
                </div>
            </div>
            
            <div class="form-group">
                <label>Max Students Join*</label>
                <input type="number" name="max_students" value="{{ old('max_students', 30) }}" min="1" required placeholder="Enter maximum students">
            </div>
            
            <div class="form-group">
                <label>Upload Thumbnail</label>
                <div style="border: 2px dashed #e5e5e6; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer; position: relative;" onclick="document.getElementById('thumbnail').click()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                    </svg>
                    <button type="button" class="btn" style="background: linear-gradient(135deg, #f97316 0%, #ef4444 100%); color: white; border: none;">Upload Thumbnail</button>
                </div>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="display: none;" onchange="handleImageUpload(this, 'thumbnailPreview')">
                <div id="thumbnailPreview"></div>
            </div>
        </div>
        
        <div style="display: flex; justify-content: flex-end; gap: 12px; margin-top: 24px;">
            <a href="{{ route('trainer.active-batches') }}" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</a>
            <button type="submit" class="btn" style="background: linear-gradient(135deg, #f97316 0%, #ef4444 100%); color: white; border: none;">Done</button>
        </div>
    </form>
</div>

@push('scripts')
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
@endpush
@endsection

