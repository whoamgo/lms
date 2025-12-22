@extends('layouts.trainer')

@section('title', 'Edit Batch')

@section('breadcrumbs')
    <a href="{{ route('trainer.dashboard') }}">Home</a> / <a href="{{ route('trainer.active-batches') }}">Active Batch</a> / Edit
@endsection

@section('content')
<div class="profile-banner">
    <div class="profile-banner-gradient"></div>
    <div class="profile-banner-content">
        <div class="profile-avatar">
            @if(Auth::user()->avatar)
                <img src="{{ asset(Auth::user()->avatar) }}" alt="Avatar">
            @else
                <svg fill="none" stroke="white" viewBox="0 0 24 24" style="width: 40px; height: 40px;">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                </svg>
            @endif
        </div>
        <div class="profile-info">
            <h2>{{ Auth::user()->name }}</h2>
            <p>Trainer</p>
        </div>
    </div>
</div>

<div class="card">
    <h2>Edit Batch</h2>
    <form action="{{ route('trainer.batches.update', $batch->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        
        <div class="form-group">
            <label>Batch Name*</label>
            <input type="text" name="name" value="{{ old('name', $batch->name) }}" required>
        </div>
        
        <div class="form-group">
            <label>Course*</label>
            <select name="course_id" required>
                <option value="">--Select Course--</option>
                @foreach($courses as $course)
                    <option value="{{ $course->id }}" {{ old('course_id', $batch->course_id) == $course->id ? 'selected' : '' }}>
                        {{ $course->title }}
                    </option>
                @endforeach
            </select>
        </div>
        
        <div class="form-group">
            <label>Description</label>
            <textarea name="description" rows="4">{{ old('description', $batch->description) }}</textarea>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Start Date</label>
                    <input type="date" name="start_date" value="{{ old('start_date', $batch->start_date ? $batch->start_date->format('Y-m-d') : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>End Date</label>
                    <input type="date" name="end_date" value="{{ old('end_date', $batch->end_date ? $batch->end_date->format('Y-m-d') : '') }}">
                </div>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-6">
                <div class="form-group">
                    <label>Class Time</label>
                    <input type="time" name="class_time" value="{{ old('class_time', $batch->class_time ? \Carbon\Carbon::parse($batch->class_time)->format('H:i') : '') }}">
                </div>
            </div>
            <div class="col-md-6">
                <div class="form-group">
                    <label>Close Time</label>
                    <input type="time" name="close_time" value="{{ old('close_time', $batch->close_time ? \Carbon\Carbon::parse($batch->close_time)->format('H:i') : '') }}">
                </div>
            </div>
        </div>
        
        <div class="form-group">
            <label>Max Students Join*</label>
            <input type="number" name="max_students" value="{{ old('max_students', $batch->max_students ?? 30) }}" min="1" required>
        </div>
        
        <div class="form-group">
            <label>Thumbnail</label>
            @if($batch->thumbnail)
                <div style="margin-bottom: 12px;">
                    <img src="{{ asset($batch->thumbnail) }}" alt="Thumbnail" style="max-width: 200px; border-radius: 8px;">
                </div>
            @endif
            <input type="file" name="thumbnail" accept="image/*">
        </div>
        
        <div style="display: flex; gap: 12px; justify-content: flex-end; margin-top: 24px;">
            <a href="{{ route('trainer.active-batches') }}" class="btn" style="background: #f3f4f6; color: #343541;">Cancel</a>
            <button type="submit" class="btn btn-primary">Update Batch</button>
        </div>
    </form>
</div>
@endsection

