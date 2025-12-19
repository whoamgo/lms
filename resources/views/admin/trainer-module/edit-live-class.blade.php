@extends('layouts.trainer-module')

@section('title', 'Edit Live Class')

@section('content')
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Edit Live Class</h2>
    
    <form method="POST" action="{{ route('admin.trainer-module.update-live-class', $liveClass->id) }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Course*</label>
            <select name="course_id" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $liveClass->course_id) == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Batch (Optional)</label>
            <select name="batch_id">
                <option value="">-- Select Batch --</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}" {{ old('batch_id', $liveClass->batch_id) == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Class Title*</label>
            <input type="text" name="title" value="{{ old('title', $liveClass->title) }}" required>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description', $liveClass->description) }}</textarea>
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label>Scheduled Date & Time*</label>
                <input type="datetime-local" name="scheduled_at" value="{{ old('scheduled_at', $liveClass->scheduled_at->format('Y-m-d\TH:i')) }}" required>
            </div>
            
            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" value="{{ old('duration', $liveClass->duration) }}" min="1">
            </div>
        </div>
        
        <div class="form-group">
            <label>Meeting Link</label>
            <input type="url" name="meeting_link" value="{{ old('meeting_link', $liveClass->meeting_link) }}">
        </div>
        
        <div class="form-group">
            <label>Thumbnail</label>
            @if($liveClass->thumbnail)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset($liveClass->thumbnail) }}" alt="Current thumbnail" style="max-width: 200px; border-radius: 8px; border: 1px solid #e5e5e6;">
                </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*" onchange="handleImageUpload(this, 'thumbnailPreview')">
            <div id="thumbnailPreview"></div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Update Class</button>
            <a href="{{ route('admin.trainer-module.live-classes') }}" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</a>
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
            preview.innerHTML = `<img src="${e.target.result}" style="max-width: 200px; border-radius: 8px; margin-top: 12px; border: 1px solid #e5e5e6;">`;
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endpush
@endsection
