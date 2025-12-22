<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use App\Helpers\LogHelper;
use Illuminate\Support\Facades\DB;

class SettingsController extends Controller
{
    public function index()
    {
        try {
            // Get all settings from database
            $settings = [];
            try {
                if (DB::getSchemaBuilder()->hasTable('settings')) {
                    $settings = DB::table('settings')->pluck('value', 'key')->toArray();
                }
            } catch (\Exception $e) {
                // Table doesn't exist yet, use empty array
            }
            
            // Define default settings structure
            $defaultSettings = $this->getDefaultSettings();
            
            // Merge with existing settings
            foreach ($defaultSettings as $category => $categorySettings) {
                foreach ($categorySettings as $key => $defaultValue) {
                    if (!isset($settings[$key])) {
                        $settings[$key] = $defaultValue;
                    }
                }
            }
            
            return view('admin.settings.index', compact('settings'));
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'settings_index']);
            return redirect()->back()->with('error', 'An error occurred while loading settings.');
        }
    }

    public function update(Request $request)
    {
        try {
            // Validate all inputs
            $validated = $request->validate([
                // General Settings
                'site_name' => 'nullable|string|max:255',
                'site_email' => 'nullable|email|max:255',
                'site_phone' => 'nullable|string|max:50',
                'site_address' => 'nullable|string|max:500',
                'site_logo' => 'nullable|string|max:255',
                'site_logo_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
                'site_favicon' => 'nullable|string|max:255',
                'site_favicon_file' => 'nullable|image|mimes:jpeg,png,jpg,gif,ico,svg|max:1024',
                'site_description' => 'nullable|string|max:1000',
                
                // Social Media
                'facebook_url' => 'nullable|url|max:255',
                'twitter_url' => 'nullable|url|max:255',
                'linkedin_url' => 'nullable|url|max:255',
                'instagram_url' => 'nullable|url|max:255',
                'youtube_url' => 'nullable|url|max:255',
                
                // SEO Settings
                'meta_title' => 'nullable|string|max:255',
                'meta_description' => 'nullable|string|max:500',
                'meta_keywords' => 'nullable|string|max:500',
                'google_analytics_id' => 'nullable|string|max:100',
                
                // Email Settings
                'mail_from_name' => 'nullable|string|max:255',
                'mail_from_address' => 'nullable|email|max:255',
                'mail_host' => 'nullable|string|max:255',
                'mail_port' => 'nullable|integer|min:1|max:65535',
                'mail_username' => 'nullable|string|max:255',
                'mail_password' => 'nullable|string|max:255',
                'mail_encryption' => 'nullable|string|in:tls,ssl',
                
                // Registration Settings
                'allow_registration' => 'nullable|boolean',
                'require_email_verification' => 'nullable|boolean',
                'default_user_role' => 'nullable|string|in:student,trainer',
                
                // System Settings
                'maintenance_mode' => 'nullable|boolean',
                'maintenance_message' => 'nullable|string|max:500',
                'timezone' => 'nullable|string|max:100',
                'date_format' => 'nullable|string|max:50',
                'time_format' => 'nullable|string|max:50',
                
                // Payment Settings (if applicable)
                'currency' => 'nullable|string|max:10',
                'currency_symbol' => 'nullable|string|max:10',
                
                // Notification Settings
                'email_notifications_enabled' => 'nullable|boolean',
                'sms_notifications_enabled' => 'nullable|boolean',
            ]);

            // Handle file uploads
            if ($request->hasFile('site_logo_file')) {
                try {
                    $logoFile = $request->file('site_logo_file');
                    $logoName = 'logo_' . time() . '.' . $logoFile->getClientOriginalExtension();
                    $logoPath = $logoFile->storeAs('settings', $logoName, 'public');
                    
                    if ($logoPath) {
                        $validated['site_logo'] = $logoPath;
                        
                        // Delete old logo if exists
                        $oldLogo = $request->input('site_logo');
                        if (!empty($oldLogo) && $oldLogo !== $logoPath && Storage::disk('public')->exists($oldLogo)) {
                            Storage::disk('public')->delete($oldLogo);
                        }
                    }
                } catch (\Exception $e) {
                    LogHelper::exception($e, 'admin', ['action' => 'upload_logo']);
                }
            }
            
            if ($request->hasFile('site_favicon_file')) {
                try {
                    $faviconFile = $request->file('site_favicon_file');
                    $faviconName = 'favicon_' . time() . '.' . $faviconFile->getClientOriginalExtension();
                    $faviconPath = $faviconFile->storeAs('settings', $faviconName, 'public');
                    
                    if ($faviconPath) {
                        $validated['site_favicon'] = $faviconPath;
                        
                        // Delete old favicon if exists
                        $oldFavicon = $request->input('site_favicon');
                        if (!empty($oldFavicon) && $oldFavicon !== $faviconPath && Storage::disk('public')->exists($oldFavicon)) {
                            Storage::disk('public')->delete($oldFavicon);
                        }
                    }
                } catch (\Exception $e) {
                    LogHelper::exception($e, 'admin', ['action' => 'upload_favicon']);
                }
            }
            
            // Remove file inputs from validated array (they're handled separately)
            unset($validated['site_logo_file'], $validated['site_favicon_file']);
            
            // Update or create each setting
            foreach ($validated as $key => $value) {
                // Handle boolean checkboxes
                if (in_array($key, ['allow_registration', 'require_email_verification', 'maintenance_mode', 'email_notifications_enabled', 'sms_notifications_enabled'])) {
                    $value = $request->has($key) ? '1' : '0';
                }
                
                DB::table('settings')->updateOrInsert(
                    ['key' => $key],
                    ['value' => $value ?? '', 'updated_at' => now()]
                );
            }

            // Clear settings cache if exists
            Cache::forget('settings');

            \App\Models\ActivityLog::log('updated', null, 'Website settings updated');

            return redirect()->route('admin.settings.index')->with('success', 'Settings updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            LogHelper::exception($e, 'admin', ['action' => 'settings_update', 'errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            LogHelper::exception($e, 'admin', ['action' => 'settings_update']);
            return redirect()->back()->with('error', 'An error occurred while updating settings.')->withInput();
        }
    }

    /**
     * Get default settings structure
     */
    private function getDefaultSettings()
    {
        return [
            'general' => [
                'site_name' => 'LMS',
                'site_email' => '',
                'site_phone' => '',
                'site_address' => '',
                'site_logo' => '',
                'site_favicon' => '',
                'site_description' => '',
            ],
            'social' => [
                'facebook_url' => '',
                'twitter_url' => '',
                'linkedin_url' => '',
                'instagram_url' => '',
                'youtube_url' => '',
            ],
            'seo' => [
                'meta_title' => '',
                'meta_description' => '',
                'meta_keywords' => '',
                'google_analytics_id' => '',
            ],
            'email' => [
                'mail_from_name' => '',
                'mail_from_address' => '',
                'mail_host' => '',
                'mail_port' => '587',
                'mail_username' => '',
                'mail_password' => '',
                'mail_encryption' => 'tls',
            ],
            'registration' => [
                'allow_registration' => '1',
                'require_email_verification' => '0',
                'default_user_role' => 'student',
            ],
            'system' => [
                'maintenance_mode' => '0',
                'maintenance_message' => 'We are currently performing maintenance. Please check back soon.',
                'timezone' => 'UTC',
                'date_format' => 'Y-m-d',
                'time_format' => 'H:i:s',
            ],
            'payment' => [
                'currency' => 'USD',
                'currency_symbol' => '$',
            ],
            'notifications' => [
                'email_notifications_enabled' => '1',
                'sms_notifications_enabled' => '0',
            ],
        ];
    }
}
