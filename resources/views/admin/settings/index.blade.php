@extends('layouts.admin')

@section('title', 'Website Settings')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Settings
@endsection

@section('content')
<br /><br />
<div class="card">
    <h2>Website Settings</h2>
    
    @if(session('success'))
        <div class="alert alert-success alert-fixed">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="alert alert-error alert-fixed">
            <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" class="alert-icon">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <div class="alert-error-list">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    @endif
    
    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <!-- General Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">General Settings</h3>
            
            <div class="form-group">
                <label>Site Name *</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}" class="form-control" required>
            </div>
            
            <div class="form-group">
                <label>Site Email</label>
                <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Site Phone</label>
                <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Site Address</label>
                <textarea name="site_address" rows="3" class="form-control">{{ $settings['site_address'] ?? '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Site Description</label>
                <textarea name="site_description" rows="3" class="form-control" placeholder="Brief description of your LMS platform">{{ $settings['site_description'] ?? '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Site Logo</label>
                @if(!empty($settings['site_logo']))
                    <div class="settings-image-preview">
                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" alt="Current Logo" class="settings-image-preview">
                        <div class="settings-image-actions">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('site_logo')">Remove Logo</button>
                        </div>
                    </div>
                @endif
                <input type="file" name="site_logo_file" id="site_logo_file" accept="image/*" class="form-control" onchange="previewImage(this, 'logoPreview')">
                <input type="hidden" name="site_logo" id="site_logo" value="{{ $settings['site_logo'] ?? '' }}">
                <div id="logoPreview" class="settings-image-preview" style="display: none;">
                    <img id="logoPreviewImg" src="" alt="Logo Preview" class="settings-image-preview">
                </div>
                <small class="settings-help-text">Recommended size: 200x100px. Supported formats: JPG, PNG, GIF, SVG. Max file size: 2MB</small>
            </div>
            
            <div class="form-group">
                <label>Site Favicon</label>
                @if(!empty($settings['site_favicon']))
                    <div class="settings-image-preview">
                        <img src="{{ asset('storage/' . $settings['site_favicon']) }}" alt="Current Favicon" class="settings-favicon-preview">
                        <div class="settings-image-actions">
                            <button type="button" class="btn btn-sm btn-danger" onclick="removeImage('site_favicon')">Remove Favicon</button>
                        </div>
                    </div>
                @endif
                <input type="file" name="site_favicon_file" id="site_favicon_file" accept="image/*" class="form-control" onchange="previewImage(this, 'faviconPreview')">
                <input type="hidden" name="site_favicon" id="site_favicon" value="{{ $settings['site_favicon'] ?? '' }}">
                <div id="faviconPreview" class="settings-image-preview" style="display: none;">
                    <img id="faviconPreviewImg" src="" alt="Favicon Preview" class="settings-favicon-preview">
                </div>
                <small class="settings-help-text">Recommended size: 32x32px or 16x16px. Supported formats: ICO, PNG, JPG, GIF, SVG. Max file size: 1MB</small>
            </div>
        </div>
        
        <!-- Social Media Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">Social Media</h3>
            
            <div class="form-group">
                <label>Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}" class="form-control" placeholder="https://facebook.com/yourpage">
            </div>
            
            <div class="form-group">
                <label>Twitter/X URL</label>
                <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}" class="form-control" placeholder="https://twitter.com/yourhandle">
            </div>
            
            <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}" class="form-control" placeholder="https://linkedin.com/company/yourcompany">
            </div>
            
            <div class="form-group">
                <label>Instagram URL</label>
                <input type="url" name="instagram_url" value="{{ $settings['instagram_url'] ?? '' }}" class="form-control" placeholder="https://instagram.com/yourhandle">
            </div>
            
            <div class="form-group">
                <label>YouTube URL</label>
                <input type="url" name="youtube_url" value="{{ $settings['youtube_url'] ?? '' }}" class="form-control" placeholder="https://youtube.com/channel/yourchannel">
            </div>
        </div>
        
        <!-- SEO Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">SEO Settings</h3>
            
            <div class="form-group">
                <label>Meta Title</label>
                <input type="text" name="meta_title" value="{{ $settings['meta_title'] ?? '' }}" class="form-control" placeholder="Default page title for SEO">
            </div>
            
            <div class="form-group">
                <label>Meta Description</label>
                <textarea name="meta_description" rows="3" class="form-control" placeholder="Default meta description for SEO">{{ $settings['meta_description'] ?? '' }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Meta Keywords</label>
                <input type="text" name="meta_keywords" value="{{ $settings['meta_keywords'] ?? '' }}" class="form-control" placeholder="keyword1, keyword2, keyword3">
            </div>
            
            <div class="form-group">
                <label>Google Analytics ID</label>
                <input type="text" name="google_analytics_id" value="{{ $settings['google_analytics_id'] ?? '' }}" class="form-control" placeholder="G-XXXXXXXXXX">
            </div>
        </div>
        
        <!-- Email Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">Email Settings</h3>
            
            <div class="form-group">
                <label>Mail From Name</label>
                <input type="text" name="mail_from_name" value="{{ $settings['mail_from_name'] ?? '' }}" class="form-control" placeholder="LMS System">
            </div>
            
            <div class="form-group">
                <label>Mail From Address</label>
                <input type="email" name="mail_from_address" value="{{ $settings['mail_from_address'] ?? '' }}" class="form-control" placeholder="noreply@yourdomain.com">
            </div>
            
            <div class="form-group">
                <label>SMTP Host</label>
                <input type="text" name="mail_host" value="{{ $settings['mail_host'] ?? '' }}" class="form-control" placeholder="smtp.gmail.com">
            </div>
            
            <div class="form-group">
                <label>SMTP Port</label>
                <input type="number" name="mail_port" value="{{ $settings['mail_port'] ?? '587' }}" class="form-control" min="1" max="65535">
            </div>
            
            <div class="form-group">
                <label>SMTP Username</label>
                <input type="text" name="mail_username" value="{{ $settings['mail_username'] ?? '' }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>SMTP Password</label>
                <input type="password" name="mail_password" value="{{ $settings['mail_password'] ?? '' }}" class="form-control">
            </div>
            
            <div class="form-group">
                <label>Mail Encryption</label>
                <select name="mail_encryption" class="form-control">
                    <option value="tls" {{ ($settings['mail_encryption'] ?? 'tls') === 'tls' ? 'selected' : '' }}>TLS</option>
                    <option value="ssl" {{ ($settings['mail_encryption'] ?? '') === 'ssl' ? 'selected' : '' }}>SSL</option>
                </select>
            </div>
        </div>
        
        <!-- Registration Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">Registration Settings</h3>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="allow_registration" value="1" {{ ($settings['allow_registration'] ?? '1') == '1' ? 'checked' : '' }}>
                    Allow User Registration
                </label>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="require_email_verification" value="1" {{ ($settings['require_email_verification'] ?? '0') == '1' ? 'checked' : '' }}>
                    Require Email Verification
                </label>
            </div>
            
            <div class="form-group">
                <label>Default User Role</label>
                <select name="default_user_role" class="form-control">
                    <option value="student" {{ ($settings['default_user_role'] ?? 'student') === 'student' ? 'selected' : '' }}>Student</option>
                    <option value="trainer" {{ ($settings['default_user_role'] ?? '') === 'trainer' ? 'selected' : '' }}>Trainer</option>
                </select>
            </div>
        </div>
        
        <!-- System Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">System Settings</h3>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="maintenance_mode" value="1" {{ ($settings['maintenance_mode'] ?? '0') == '1' ? 'checked' : '' }}>
                    Enable Maintenance Mode
                </label>
            </div>
            
            <div class="form-group">
                <label>Maintenance Message</label>
                <textarea name="maintenance_message" rows="3" class="form-control">{{ $settings['maintenance_message'] ?? 'We are currently performing maintenance. Please check back soon.' }}</textarea>
            </div>
            
            <div class="form-group">
                <label>Timezone</label>
                <select name="timezone" class="form-control">
                    <option value="UTC" {{ ($settings['timezone'] ?? 'UTC') === 'UTC' ? 'selected' : '' }}>UTC</option>
                    <option value="America/New_York" {{ ($settings['timezone'] ?? '') === 'America/New_York' ? 'selected' : '' }}>America/New_York</option>
                    <option value="America/Chicago" {{ ($settings['timezone'] ?? '') === 'America/Chicago' ? 'selected' : '' }}>America/Chicago</option>
                    <option value="America/Denver" {{ ($settings['timezone'] ?? '') === 'America/Denver' ? 'selected' : '' }}>America/Denver</option>
                    <option value="America/Los_Angeles" {{ ($settings['timezone'] ?? '') === 'America/Los_Angeles' ? 'selected' : '' }}>America/Los_Angeles</option>
                    <option value="Europe/London" {{ ($settings['timezone'] ?? '') === 'Europe/London' ? 'selected' : '' }}>Europe/London</option>
                    <option value="Europe/Paris" {{ ($settings['timezone'] ?? '') === 'Europe/Paris' ? 'selected' : '' }}>Europe/Paris</option>
                    <option value="Asia/Dubai" {{ ($settings['timezone'] ?? '') === 'Asia/Dubai' ? 'selected' : '' }}>Asia/Dubai</option>
                    <option value="Asia/Kolkata" {{ ($settings['timezone'] ?? '') === 'Asia/Kolkata' ? 'selected' : '' }}>Asia/Kolkata</option>
                    <option value="Asia/Tokyo" {{ ($settings['timezone'] ?? '') === 'Asia/Tokyo' ? 'selected' : '' }}>Asia/Tokyo</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Date Format</label>
                <select name="date_format" class="form-control">
                    <option value="Y-m-d" {{ ($settings['date_format'] ?? 'Y-m-d') === 'Y-m-d' ? 'selected' : '' }}>YYYY-MM-DD</option>
                    <option value="d/m/Y" {{ ($settings['date_format'] ?? '') === 'd/m/Y' ? 'selected' : '' }}>DD/MM/YYYY</option>
                    <option value="m/d/Y" {{ ($settings['date_format'] ?? '') === 'm/d/Y' ? 'selected' : '' }}>MM/DD/YYYY</option>
                    <option value="d M Y" {{ ($settings['date_format'] ?? '') === 'd M Y' ? 'selected' : '' }}>DD Mon YYYY</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Time Format</label>
                <select name="time_format" class="form-control">
                    <option value="H:i:s" {{ ($settings['time_format'] ?? 'H:i:s') === 'H:i:s' ? 'selected' : '' }}>24 Hour (HH:MM:SS)</option>
                    <option value="h:i:s A" {{ ($settings['time_format'] ?? '') === 'h:i:s A' ? 'selected' : '' }}>12 Hour (HH:MM:SS AM/PM)</option>
                </select>
            </div>
        </div>
        
        <!-- Payment Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">Payment Settings</h3>
            
            <div class="form-group">
                <label>Currency</label>
                <select name="currency" class="form-control">
                    <option value="USD" {{ ($settings['currency'] ?? 'USD') === 'USD' ? 'selected' : '' }}>USD - US Dollar</option>
                    <option value="EUR" {{ ($settings['currency'] ?? '') === 'EUR' ? 'selected' : '' }}>EUR - Euro</option>
                    <option value="GBP" {{ ($settings['currency'] ?? '') === 'GBP' ? 'selected' : '' }}>GBP - British Pound</option>
                    <option value="INR" {{ ($settings['currency'] ?? '') === 'INR' ? 'selected' : '' }}>INR - Indian Rupee</option>
                    <option value="AED" {{ ($settings['currency'] ?? '') === 'AED' ? 'selected' : '' }}>AED - UAE Dirham</option>
                </select>
            </div>
            
            <div class="form-group">
                <label>Currency Symbol</label>
                <input type="text" name="currency_symbol" value="{{ $settings['currency_symbol'] ?? '$' }}" class="form-control" maxlength="10">
            </div>
        </div>
        
        <!-- Notification Settings -->
        <div class="settings-section">
            <h3 class="settings-section-title">Notification Settings</h3>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="email_notifications_enabled" value="1" {{ ($settings['email_notifications_enabled'] ?? '1') == '1' ? 'checked' : '' }}>
                    Enable Email Notifications
                </label>
            </div>
            
            <div class="form-group">
                <label>
                    <input type="checkbox" name="sms_notifications_enabled" value="1" {{ ($settings['sms_notifications_enabled'] ?? '0') == '1' ? 'checked' : '' }}>
                    Enable SMS Notifications
                </label>
            </div>
        </div>
        
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">Save Settings</button>
            <button type="reset" class="btn btn-dark">Reset</button>
        </div>
    </form>
</div>

@push('scripts')
<script>
function previewImage(input, previewId) {
    if (input.files && input.files[0]) {
        // Validate file size
        const maxSize = input.id === 'site_logo_file' ? 2 * 1024 * 1024 : 1 * 1024 * 1024; // 2MB for logo, 1MB for favicon
        if (input.files[0].size > maxSize) {
            alert('File size exceeds the maximum allowed size. Please choose a smaller file.');
            input.value = '';
            return;
        }
        
        const reader = new FileReader();
        const previewDiv = document.getElementById(previewId);
        const previewImg = document.getElementById(previewId + 'Img');
        
        reader.onload = function(e) {
            previewImg.src = e.target.result;
            previewDiv.style.display = 'block';
        };
        
        reader.readAsDataURL(input.files[0]);
    }
}

function removeImage(type) {
    if (confirm('Are you sure you want to remove the ' + (type === 'site_logo' ? 'logo' : 'favicon') + '?')) {
        const hiddenInput = document.getElementById(type);
        const fileInput = document.getElementById(type + '_file');
        const previewDiv = document.getElementById(type === 'site_logo' ? 'logoPreview' : 'faviconPreview');
        
        // Clear values
        hiddenInput.value = '';
        if (fileInput) {
            fileInput.value = '';
        }
        if (previewDiv) {
            previewDiv.style.display = 'none';
        }
        
        // Hide current image display
        const currentImageDiv = fileInput ? fileInput.closest('.form-group').querySelector('div[style*="margin-bottom"]') : null;
        if (currentImageDiv) {
            currentImageDiv.style.display = 'none';
        }
    }
}
</script>
@endpush
@endsection
