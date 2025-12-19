@extends('layouts.trainer')

@section('title', 'Upload New Video')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.videos') }}">Uploaded videos</a> / Upload New Video
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
    
    <form id="uploadVideoForm" method="POST" action="{{ route('trainer.videos.store') }}" enctype="multipart/form-data">
        @csrf
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Basic Information</h3>
            
            <div class="form-group">
                <label>Video Title*</label>
                <input type="text" name="title" id="videoTitle" required placeholder="Enter video title">
            </div>
            
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="videoDescription" rows="4" placeholder="Add brief description of your video"></textarea>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Visibility</h3>
            
            <div style="display: flex; gap: 24px;">
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="private" checked style="width: 18px; height: 18px; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; color: #6b7280;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                    </svg>
                    <span>Private</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="unlisted" style="width: 18px; height: 18px; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; color: #6b7280;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                    </svg>
                    <span>Unlisted</span>
                </label>
                <label style="display: flex; align-items: center; gap: 8px; cursor: pointer;">
                    <input type="radio" name="visibility" value="public" style="width: 18px; height: 18px; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; color: #6b7280;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                    <span>Public</span>
                </label>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Schedule</h3>
            
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px;">
                <div class="form-group">
                    <label>Schedule Date</label>
                    <div style="position: relative;">
                        <input type="date" name="scheduled_at" id="scheduleDate" style="padding-right: 40px;" placeholder="dd/mm/yyyy">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; right: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Time</label>
                    <div style="position: relative;">
                        <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); width: 20px; height: 20px; color: #9ca3af; pointer-events: none; z-index: 1;">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        <input type="time" name="scheduled_time" id="scheduleTime" style="padding-left: 40px;" placeholder="--:--">
                    </div>
                </div>
                
                <div class="form-group">
                    <label>Timezone</label>
                    <div style="position: relative;">
                        <select name="timezone" id="timezone" style="padding-right: 40px; appearance: none;">
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
                <input type="number" name="duration_minutes" id="duration" min="1" placeholder="e.g., 60">
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px; color: #343541;">Upload Files</h3>
            
            <div class="form-group" style="margin-bottom: 24px;">
                <label>Video Thumbnail</label>
                <div style="border: 2px dashed #e5e5e6; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer; position: relative;" onclick="document.getElementById('thumbnail').click()">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 8px;">Video Thumbnail</div>
                    <div style="color: #9ca3af; font-size: 0.75rem;">Click or browse to upload thumbnail</div>
                </div>
                <input type="file" name="thumbnail" id="thumbnail" accept="image/*" style="display: none;" onchange="handleThumbnailUpload(this)">
                <div style="margin-top: 12px;">
                    <button type="button" onclick="document.getElementById('thumbnail').click()" class="btn" style="background: #f3f4f6; color: #343541; border: 1px solid #e5e5e6;">Browse...</button>
                    <span id="thumbnailFileStatus" style="margin-left: 12px; color: #6b7280; font-size: 0.875rem;">No file selected.</span>
                </div>
                <div id="thumbnailPreview" style="margin-top: 12px;"></div>
            </div>
            
            <div class="form-group">
                <label>Upload Video</label>
                <div style="border: 2px dashed #e5e5e6; border-radius: 8px; padding: 40px; text-align: center; background: #f9fafb; cursor: pointer; position: relative;" id="videoDropZone" ondrop="handleDrop(event)" ondragover="handleDragOver(event)" ondragleave="handleDragLeave(event)">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; color: #9ca3af; margin: 0 auto 16px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                    </svg>
                    <div style="color: #6b7280; font-size: 0.875rem; margin-bottom: 8px;">Upload Video</div>
                    <div style="color: #9ca3af; font-size: 0.75rem;">Drag & drop or click to browse video file</div>
                </div>
                <input type="file" name="video_file" id="videoFile" accept="video/*" style="display: none;" onchange="handleVideoFileSelect(this)">
                <div style="margin-top: 12px;">
                    <button type="button" onclick="document.getElementById('videoFile').click()" class="btn" style="background: #f3f4f6; color: #343541; border: 1px solid #e5e5e6;">Browse...</button>
                    <span id="videoFileStatus" style="margin-left: 12px; color: #6b7280; font-size: 0.875rem;">No file selected.</span>
                </div>
                <div class="form-group" style="margin-top: 16px;">
                    <label>Or Enter Video URL</label>
                    <input type="url" name="video_url" id="videoUrl" placeholder="https://youtube.com/watch?v=... or video URL">
                </div>
                <div id="videoProgressContainer" style="margin-top: 12px; display: none;">
                    <div style="background: #f3f4f6; border-radius: 8px; height: 8px; overflow: hidden;">
                        <div id="videoProgressBar" style="background: #2563eb; height: 100%; width: 0%; transition: width 0.3s;"></div>
                    </div>
                    <div id="videoProgressText" style="margin-top: 8px; font-size: 0.875rem; color: #6b7280;">0%</div>
                </div>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <label style="display: flex; align-items: center; justify-content: space-between; cursor: pointer;" onclick="togglePlaylistSection()">
                <div style="display: flex; align-items: center; gap: 12px;">
                    <input type="checkbox" name="create_playlist" id="createPlaylist" style="width: 18px; height: 18px; cursor: pointer;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #6b7280;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
                    </svg>
                    <span style="font-weight: 500; color: #343541;">Create a Playlist</span>
                </div>
                <svg id="playlistChevron" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 20px; height: 20px; color: #6b7280; transition: transform 0.3s;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                </svg>
            </label>
            <div id="playlistSection" style="display: none; margin-top: 16px;">
                <button type="button" class="btn" style="background: #dbeafe; color: #2563eb; border: 1px solid #2563eb; width: 100%;" onclick="openPlaylistModal()">+ Create New Playlist</button>
            </div>
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

<!-- Playlist Modal -->
<div id="playlistModal" class="modal" style="display: none;">
    <div class="modal-content" style="max-width: 500px;">
        <button class="modal-close" onclick="closePlaylistModal()">&times;</button>
        <h2 style="display: flex; align-items: center; gap: 8px; margin-bottom: 24px;">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 24px; height: 24px; color: #9333ea;">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3"></path>
            </svg>
            Create New Playlist
        </h2>
        <form id="playlistForm">
            <div class="form-group">
                <label>Title (Required)*</label>
                <input type="text" name="title" id="playlistTitle" required placeholder="Enter playlist title">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" id="playlistDescription" rows="4" placeholder="Add playlist description"></textarea>
            </div>
            <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
                <button type="button" onclick="closePlaylistModal()" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</button>
                <button type="submit" class="btn" style="background: #f97316; color: white;">
                    <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 18px; height: 18px; margin-right: 8px;">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    Create
                </button>
            </div>
        </form>
    </div>
</div>

@push('styles')
<style>
.modal {
    display: none;
    position: fixed;
    z-index: 1000;
    left: 0;
    top: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(0,0,0,0.5);
    align-items: center;
    justify-content: center;
}
.modal.active {
    display: flex;
}
.modal-content {
    background: white;
    border-radius: 12px;
    padding: 32px;
    max-width: 500px;
    width: 90%;
    max-height: 90vh;
    overflow-y: auto;
    position: relative;
}
.modal-close {
    position: absolute;
    top: 16px;
    right: 16px;
    background: none;
    border: none;
    font-size: 1.5rem;
    cursor: pointer;
    color: #6b7280;
    width: 32px;
    height: 32px;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 50%;
    transition: background 0.2s;
}
.modal-close:hover {
    background: #f3f4f6;
}
#videoDropZone.drag-over {
    border-color: #2563eb;
    background: #eff6ff;
}
</style>
@endpush

@push('scripts')
<script>
const VIDEOS_INDEX_URL = '{{ route("trainer.videos") }}';
const PLAYLIST_STORE_URL = '{{ route("trainer.videos.playlist.store") }}';
</script>
<script src="{{ asset('js/trainer-upload-video.js') }}"></script>
@endpush
@endsection
