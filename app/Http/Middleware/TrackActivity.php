<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\ActivityLog;
use Symfony\Component\HttpFoundation\Response;

class TrackActivity
{
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);
        
        if (auth()->check() && $request->method() !== 'GET') {
            $action = strtolower($request->method());
            $route = $request->route()->getName();
            
            ActivityLog::log($action, null, "Accessed route: {$route}");
        }
        
        return $response;
    }
}
