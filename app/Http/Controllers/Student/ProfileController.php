<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        try {
            $student = Auth::user();
            return view('student.profile', compact('student'));
        } catch (\Exception $e) {
            \Log::error('Student Profile Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while loading your profile.');
        }
    }

    public function update(Request $request)
    {
        try {
            $student = Auth::user();
            
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'first_name' => 'nullable|string|max:255',
                'last_name' => 'nullable|string|max:255',
                'nick_name' => 'nullable|string|max:255',
                'display_name' => 'nullable|string|max:255',
                'email' => 'required|email|unique:users,email,' . $student->id,
                'phone' => 'nullable|string|max:20',
                'whatsapp' => 'nullable|string|max:20',
                'website' => 'nullable|string|max:255',
                'instagram_telegram' => 'nullable|string|max:255',
                'bio' => 'nullable|string',
                'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'old_password' => 'nullable|required_with:new_password',
                'new_password' => ['nullable', 'confirmed', Password::defaults()],
            ]);
            
            // Handle avatar upload
            if ($request->hasFile('avatar')) {
                if ($student->avatar) {
                    $oldPath = str_replace('storage/', '', $student->avatar);
                    if (Storage::disk('public')->exists($oldPath)) {
                        Storage::disk('public')->delete($oldPath);
                    }
                }
                
                $avatar = $request->file('avatar');
                $avatarName = 'avatars/' . time() . '_' . $avatar->getClientOriginalName();
                $avatar->storeAs('public', $avatarName);
                $validated['avatar'] = $avatarName;
            }
            
            // Handle password change
            if ($request->filled('old_password') && $request->filled('new_password')) {
                if (!Hash::check($request->old_password, $student->password)) {
                    return redirect()->back()->withErrors(['old_password' => 'The old password is incorrect.'])->withInput();
                }
                $validated['password'] = Hash::make($request->new_password);
            }
            
            // Remove password fields if not changing
            unset($validated['old_password'], $validated['new_password']);
            
            // Update only fields that exist in fillable
            $fillableFields = ['name', 'email', 'phone', 'address', 'avatar', 'password'];
            $updateData = array_intersect_key($validated, array_flip($fillableFields));
            
            // Store additional profile data in a JSON field or extend the model
            // For now, we'll update basic fields
            $student->update($updateData);
            
            return redirect()->route('student.profile')->with('success', 'Profile updated successfully!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return redirect()->back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Student Profile Update Error: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while updating your profile.')->withInput();
        }
    }
}
