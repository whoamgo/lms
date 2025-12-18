@extends('layouts.admin')

@section('title', 'Website Settings')
 
@section('breadcrumbs')
    <a href="{{ route('admin.dashboard') }}">Home</a> / Settings
@endsection

@section('content')
<br /><br />
<div class="card">
    <h2>Website Settings</h2>
    
    <form method="POST" action="{{ route('admin.settings.update') }}">
        @csrf
        @method('PUT')
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px;">General Settings</h3>
            
            <div class="form-group">
                <label>Site Name</label>
                <input type="text" name="site_name" value="{{ $settings['site_name'] ?? '' }}">
            </div>
            
            <div class="form-group">
                <label>Site Email</label>
                <input type="email" name="site_email" value="{{ $settings['site_email'] ?? '' }}">
            </div>
            
            <div class="form-group">
                <label>Site Phone</label>
                <input type="text" name="site_phone" value="{{ $settings['site_phone'] ?? '' }}">
            </div>
            
            <div class="form-group">
                <label>Site Address</label>
                <textarea name="site_address" rows="3">{{ $settings['site_address'] ?? '' }}</textarea>
            </div>
        </div>
        
        <div style="border: 1px solid #e5e5e6; border-radius: 8px; padding: 24px; margin-bottom: 24px;">
            <h3 style="font-size: 1rem; font-weight: 600; margin-bottom: 20px;">Social Media</h3>
            
            <div class="form-group">
                <label>Facebook URL</label>
                <input type="url" name="facebook_url" value="{{ $settings['facebook_url'] ?? '' }}">
            </div>
            
            <div class="form-group">
                <label>Twitter URL</label>
                <input type="url" name="twitter_url" value="{{ $settings['twitter_url'] ?? '' }}">
            </div>
            
            <div class="form-group">
                <label>LinkedIn URL</label>
                <input type="url" name="linkedin_url" value="{{ $settings['linkedin_url'] ?? '' }}">
            </div>
        </div>
        
        <div style="display: flex; gap: 12px;">
            <button type="submit" class="btn btn-primary">Save Settings</button>
        </div>
    </form>
</div>
@endsection

