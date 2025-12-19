@extends('layouts.trainer')

@section('title', 'SkillSpace')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / SkillSpace
@endsection

@section('content')
<div style="position: relative; margin-bottom: 24px;">
    <div style="background: linear-gradient(135deg, #9333ea 0%, #ec4899 100%); height: 80px; border-radius: 12px 12px 0 0;"></div>
    <div style="background: white; padding: 24px; border-radius: 0 0 12px 12px; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; align-items: center; gap: 20px;">
        <div style="width: 80px; height: 80px; background: linear-gradient(135deg, #667eea 0%, #764ba2 100%); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-top: -40px; border: 4px solid white; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar" style="width: 100%; height: 100%; border-radius: 50%; object-fit: cover;">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div>
            <h2 style="font-size: 1.5rem; font-weight: 600; color: #343541; margin: 0;">{{ Auth::user()->name }}</h2>
            <p style="color: #6b7280; margin: 4px 0 0 0;">Trainer</p>
        </div>
    </div>
</div>

<div class="card" style="text-align: center; padding: 48px 24px;">
    <h2 style="font-size: 1.75rem; font-weight: 600; margin-bottom: 48px; color: #343541;">Skillwaala Management Panel</h2>
    
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 32px; max-width: 900px; margin: 0 auto;">
        <a href="{{ route('trainer.quizzes.index') }}" style="text-decoration: none;">
            <div style="background: #2563eb; color: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(37, 99, 235, 0.3); transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; margin: 0 auto 16px; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12"></path>
                </svg>
                <div style="font-size: 1.125rem; font-weight: 600;">Upload Quiz</div>
            </div>
        </a>
        
        <a href="#" style="text-decoration: none;">
            <div style="background: #10b981; color: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(16, 185, 129, 0.3); transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; margin: 0 auto 16px; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                <div style="font-size: 1.125rem; font-weight: 600;">Schedule Workshop</div>
            </div>
        </a>
        
        <a href="{{ route('trainer.satsangs.index') }}" style="text-decoration: none;">
            <div style="background: #f59e0b; color: white; padding: 32px; border-radius: 12px; box-shadow: 0 4px 12px rgba(245, 158, 11, 0.3); transition: transform 0.2s; cursor: pointer;" onmouseover="this.style.transform='translateY(-4px)'" onmouseout="this.style.transform='translateY(0)'">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24" style="width: 48px; height: 48px; margin: 0 auto 16px; display: block;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                </svg>
                <div style="font-size: 1.125rem; font-weight: 600;">Schedule Career Satsang</div>
            </div>
        </a>
    </div>
</div>
@endsection
