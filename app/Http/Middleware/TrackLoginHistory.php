<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\LoginHistory;
use Symfony\Component\HttpFoundation\Response;

class TrackLoginHistory
{
    public function handle(Request $request, Closure $next): Response
    {
        if (auth()->check()) {
            $user = auth()->user();
            
            // Update last login
            $user->update(['last_login_at' => now()]);
            
            // Create login history entry if not exists for this session
            if (!$request->session()->has('login_history_id')) {
                $loginHistory = LoginHistory::create([
                    'user_id' => $user->id,
                    'ip_address' => $request->ip(),
                    'user_agent' => $request->userAgent(),
                    'logged_in_at' => now(),
                ]);
                
                $request->session()->put('login_history_id', $loginHistory->id);
            }
        }
        
        return $next($request);
    }
}
