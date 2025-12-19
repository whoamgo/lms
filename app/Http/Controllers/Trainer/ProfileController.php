<?php

namespace App\Http\Controllers\Trainer;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class ProfileController extends Controller
{
    public function index()
    {
        $trainer = Auth::user();
        return view('trainer.profile', compact('trainer'));
    }

    public function update(Request $request)
    {
        $trainer = Auth::user();
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $trainer->id,
            'phone' => 'nullable|string',
            'address' => 'nullable|string',
            'password' => 'nullable|string|min:8',
            'avatar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if ($request->hasFile('avatar')) {
            if ($trainer->avatar && file_exists(public_path($trainer->avatar))) {
                unlink(public_path($trainer->avatar));
            }
            
            $avatar = $request->file('avatar');
            $avatarName = time() . '_' . $avatar->getClientOriginalName();
            $avatar->move(public_path('uploads/avatars'), $avatarName);
            $validated['avatar'] = 'uploads/avatars/' . $avatarName;
        }

        if (!empty($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        } else {
            unset($validated['password']);
        }

        $trainer->update($validated);

        \App\Models\ActivityLog::log('updated', $trainer, 'Profile updated');

        return redirect()->route('trainer.profile')->with('success', 'Profile updated successfully!');
    }
}
