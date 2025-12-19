@extends('layouts.trainer-module')

@section('title', 'Upload Video')

@section('content')
<div class="card">
    <h2 style="font-size: 1.5rem; font-weight: 600; margin-bottom: 24px;">Upload New Video</h2>
    
    <form method="POST" action="{{ route('admin.trainer-module.store-video') }}" enctype="multipart/form-data">
        @csrf
        
        <div class="form-group">
            <label>Course*</label>
            <select name="course_id" required>
                <option value="">-- Select Course --</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Batch (Optional)</label>
            <select name="batch_id">
                <option value="">-- Select Batch --</option>
                @foreach($batches as $batch)
                    <option value="{{ $batch->id }}" {{ old('batch_id') == $batch->id ? 'selected' : '' }}>{{ $batch->name }}</option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Video Title*</label>
            <input type="text" name="title" value="{{ old('title') }}" required placeholder="Enter video title">
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4" placeholder="Enter video description">{{ old('description') }}</textarea>
        </div>
        
        <div class="form-group">
            <label>Video URL*</label>
            <input type="url" name="video_url" value="{{ old('video_url') }}" required placeholder="https://youtube.com/watch?v=... or video URL">
        </div>
        
        <div style="display: grid; grid-template-columns: repeat(2, 1fr); gap: 20px;">
            <div class="form-group">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" value="{{ old('duration') }}" min="1" placeholder="e.g., 30">
            </div>
            
            <div class="form-group">
                <label>Order</label>
                <input type="number" name="order" value="{{ old('order', 0) }}" min="0" placeholder="Display order">
            </div>
        </div>
        
        <div class="form-group">
            <label>Thumbnail</label>
            <input type="file" name="thumbnail" accept="image/*" onchange="handleImageUpload(this, 'thumbnailPreview')">
            <div id="thumbnailPreview"></div>
        </div>
        
        <div style="display: flex; gap: 12px; margin-top: 24px;">
            <button type="submit" class="btn btn-primary">Upload Video</button>
            <a href="{{ route('admin.trainer-module.videos') }}" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</a>
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
