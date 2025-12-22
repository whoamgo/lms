@extends('layouts.trainer')

@section('title', 'Add Class')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.live-classes') }}">Upcoming live class</a> / Add Class
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
    <h2 style="display: flex; align-items: center; gap: 8px; margin-bottom: 32px;">
        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: #9333ea;">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
        </svg>
        Upload New Video
    </h2>
    
    <form id="addClassForm" method="POST" action="{{ route('trainer.live-classes.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Basic Information</h3>
            
            <div class="form-group">
                <label>Class Title*</label>
                <input type="text" name="title" id="classTitle" required placeholder="Enter video title">
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="description" rows="4" placeholder="Add brief description of your video"></textarea>
            </div>
        </div>
        
        <input type="hidden" name="course_id" value="">
        <input type="hidden" name="batch_id" value="">
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Visibility</h3>
            
            <div style="display: flex; gap: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="private" checked style="width: 18px; height: 18px; cursor: pointer;">
                    <span>Private</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="unlisted" style="width: 18px; height: 18px; cursor: pointer;">
                    <span>Unlisted</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="public" style="width: 18px; height: 18px; cursor: pointer;">
                    <span>Public</span>
                </label>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Schedule</h3>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Schedule Date*</label>
                    <div style="position: relative;">
                        <input type="date" name="scheduled_date" id="scheduledDate" required style="padding-right: 40px;" placeholder="dd/mm/yyyy">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Time*</label>
                    <div style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none; z-index: 1;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <input type="time" name="scheduled_time" id="scheduledTime" required style="padding-left: 40px;" placeholder="--:-- --">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Timezone*</label>
                    <div style="position: relative;">
                        <select name="timezone" id="timezone" required style="padding-right: 40px; appearance: none;">
                            <option value="UTC +05:30 (India)">UTC +05:30 (India)</option>
                            <option value="UTC +00:00 (GMT)">UTC +00:00 (GMT)</option>
                            <option value="UTC -05:00 (EST)">UTC -05:00 (EST)</option>
                            <option value="UTC +01:00 (CET)">UTC +01:00 (CET)</option>
                        </select>
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9"></path>
                        </svg>
                    </div>
                </div>
            </div>
            
            <div class="form-group" style="margin-top: 20px;">
                <label>Duration (minutes)</label>
                <input type="number" name="duration" id="duration" min="1" placeholder="e.g., 60">
            </div>
            
            <div class="form-group">
                <label>Meeting Link</label>
                <input type="url" name="meeting_link" id="meetingLink" placeholder="https://meet.google.com/...">
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Upload Files</h3>
            
            <div class="form-group">
                <label>Class Thumbnail</label>
                <div style="border: 2px dashed #e5e5e6; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer; position: relative;" onclick="document.getElementById('thumbnail').click()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 8px;">Class Thumbnail</div>
                    <div style="color: #9ca3af; font-size: 0.75rem;">Click or browse to upload thumbnail</div>
                </div>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="display: none;" onchange="handleThumbnailUpload(this)">
                <div style="margin-top: 12px;">
                    <button type="button" onclick="document.getElementById('thumbnail').click()" class="btn" style="background: #f3f4f6; color: #343541; border: 1px solid #e5e5e6;">Browse...</button>
                    <span id="fileStatus" style="margin-left: 12px; color: #6b7280; font-size: 0.875rem;">No file selected.</span>
                </div>
                <div id="thumbnailPreview" style="margin-top: 12px;"></div>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <label style="display: flex; align-items: center; gap: 12px; cursor: pointer;">
                <input type="checkbox" name="create_playlist" id="createPlaylist" style="width: 18px; height: 18px; cursor: pointer;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #6b7280;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 7v10a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-6l-2-2H5a2 2 0 00-2 2z"></path>
                </svg>
                <span style="font-weight: 500; color: #343541;">Create a Playlist</span>
            </label>
        </div>
        
        <div style="display: flex; justify-content: center; margin-top: 32px;">
            <button type="submit" class="btn btn-primary" style="background: #2563eb; color: white; padding: 12px 32px; font-size: 1rem;">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; margin-right: 8px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                Upload
            </button>
        </div>
    </form>
</div>

@push('scripts')
<script>
// Pass route URLs to JavaScript
const LIVE_CLASSES_INDEX_URL = '{{ route("trainer.live-classes") }}';
</script>
<script src="{{ asset('js/trainer-add-class.js') }}"></script>
@endpush
@endsection

